<?php

namespace Modules\Plugins\Vendor\Http\Controllers;

use Assets;
use Modules\Plugins\Vendor\Http\Resources\TransactionResource;
use Modules\Plugins\Payment\Enums\PaymentMethodEnum;
use Modules\Plugins\Vendor\Models\Vendor;
use Modules\Plugins\Vendor\Models\Package;
use Modules\Plugins\Vendor\Repositories\Interfaces\TransactionInterface;
use Modules\Plugins\Vendor\Http\Resources\ActivityLogResource;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Payment\Http\Requests\AfterMakePaymentRequest;
use Modules\Plugins\Payment\Repositories\Interfaces\PaymentInterface;
use Modules\Plugins\Payment\Services\Gateways\PayPal\PayPalPaymentService;
use Modules\Plugins\Vendor\Http\Resources\PackageResource;
use Modules\Plugins\Vendor\Http\Resources\VendorResource;
use Modules\Plugins\Vendor\Repositories\Interfaces\PackageInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Media\Http\Requests\MediaFileRequest;
use Modules\Media\Repositories\Interfaces\MediaFileInterface;
use Modules\Media\Services\ThumbnailService;
use Modules\Media\Services\UploadsManager;
use Modules\Plugins\Vendor\Http\Requests\AvatarRequest;
use Modules\Plugins\Vendor\Http\Requests\SettingRequest;
use Modules\Plugins\Vendor\Http\Requests\UpdatePasswordRequest;
use Modules\Plugins\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Modules\Plugins\Vendor\Repositories\Interfaces\VendorInterface;
use Exception;
use File;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use RvMedia;
use SeoHelper;
use Illuminate\Support\Facades\Validator;

class PublicController extends Controller
{
    /**
     * @var VendorInterface
     */
    protected $accountRepository;

    /**
     * @var VendorActivityLogInterface
     */
    protected $activityLogRepository;

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * PublicController constructor.
     * @param Repository $config
     * @param VendorInterface $accountRepository
     * @param VendorActivityLogInterface $accountActivityLogRepository
     * @param MediaFileInterface $fileRepository
     */
    public function __construct(
        Repository $config,
        VendorInterface $accountRepository,
        VendorActivityLogInterface $accountActivityLogRepository,
        MediaFileInterface $fileRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->activityLogRepository = $accountActivityLogRepository;
        $this->fileRepository = $fileRepository;

        Assets::setConfig($config->get('modules.plugins.vendor.assets'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getDashboard()
    {
        $user = auth()->guard('vendor')->user();

        SeoHelper::setTitle(auth()->guard('vendor')->user()->getFullName());

        return view('modules.plugins.vendor::dashboard.index', compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getSettings()
    {
        SeoHelper::setTitle(trans('modules.plugins.vendor::vendor.account_settings'));

        $user = auth()->guard('vendor')->user();

        return view('modules.plugins.vendor::settings.index', compact('user'));
    }

    /**
     * @param SettingRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse
     */
    public function postSettings(SettingRequest $request, BaseHttpResponse $response)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');

        if ($year && $month && $day) {
            $request->merge(['dob' => implode('-', [$year, $month, $day])]);

            $validator = Validator::make($request->input(), [
                'dob' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return redirect()->route('public.vendor.settings');
            }
        }

        $this->accountRepository->createOrUpdate($request->except('email'),
            ['id' => auth()->guard('vendor')->user()->getKey()]);

        $this->activityLogRepository->createOrUpdate(['action' => 'update_setting']);

        return $response
            ->setNextUrl(route('public.vendor.settings'))
            ->setMessage(trans('modules.plugins.vendor::vendor.update_profile_success'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getSecurity()
    {
        SeoHelper::setTitle(trans('modules.plugins.vendor::vendor.security'));

        return view('modules.plugins.vendor::settings.security');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPackages()
    {
        SeoHelper::setTitle(trans('modules.plugins.vendor::vendor.packages'));

        return view('modules.plugins.vendor::settings.package');
    }

    /**
     * @return Factory|View
     */
    public function getTransactions()
    {
        SeoHelper::setTitle(trans('modules.plugins.vendor::vendor.transactions'));

        return view('modules.plugins.vendor::settings.transactions');
    }

    /**
     * @param PackageInterface $packageRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetPackages(PackageInterface $packageRepository, BaseHttpResponse $response)
    {
        $account = $this->accountRepository->findOrFail(Auth::guard('vendor')->user()->getAuthIdentifier(), ['packages']);

        $packages = $packageRepository->getModel()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->get();

        $packages = $packages->filter(function ($package) use ($account) {
            return $package->account_limit === null || $account->packages->where('id', $package->id)->count() < $package->account_limit;
        });

        return $response->setData([
            'packages' => PackageResource::collection($packages),
            'account' => new VendorResource($account),
        ]);
    }

    /**
     * @param Request $request
     * @param PackageInterface $packageRepository
     * @param BaseHttpResponse $response
     */
    public function ajaxSubscribePackage(
        Request $request,
        PackageInterface $packageRepository,
        BaseHttpResponse $response,
        TransactionInterface $transactionRepository
    )
    {
        $package = $packageRepository->findOrFail($request->input('id'));

        if (auth('vendor')->user()->packages()->where('package_id', $package->id)->count() > $package->account_limit) {
            abort(403);
        }

        if ($package->price) {
            if (setting('payment_paypal_status') != 1 && setting('payment_stripe_status') != 1) {
                return $response->setError()->setMessage(trans('modules.plugins.vendor::package.setup_payment_gateway'));
            }

            return $response->setData(['next_page' => route('public.vendor.package.subscribe', $package->id)]);
        }

        $this->savePayment($package, null, $transactionRepository);

        $account = $this->accountRepository->findOrFail(Auth::guard('vendor')->user()->getAuthIdentifier());

        return $response
            ->setData(new VendorResource($account))
            ->setMessage(trans('modules.plugins.vendor::package.add_credit_success'));
    }

    /**
     * @param $id
     * @param PackageInterface $packageRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSubscribePackage($id, PackageInterface $packageRepository)
    {
        $package = DB::table('packages')->find($id);
        //   dump($package);
        SeoHelper::setTitle(trans('modules.plugins.vendor::package.subscribe_package', ['name' => $package->name]));

        return view('modules.plugins.vendor::checkout', compact('package'));
    }

    /**
     * @param int $packageId
     * @param AfterMakePaymentRequest $request
     * @param PayPalPaymentService $payPalService
     * @param \Modules\Plugins\Vendor\Repositories\Interfaces\PackageInterface $packageRepository
     * @param \Modules\Plugins\Vendor\Repositories\Interfaces\TransactionInterface $transactionRepository
     * @return RedirectResponse
     */
    public function getPackageSubscribeCallback(
        $packageId,
        AfterMakePaymentRequest $request,
        PayPalPaymentService $payPalService,
        PackageInterface $packageRepository,
        TransactionInterface $transactionRepository
    ) {
        $package = $packageRepository->findOrFail($packageId);

        if ($request->input('type') == PaymentMethodEnum::PAYPAL) {
            $paymentStatus = $payPalService->getPaymentStatus($request);
            if ($paymentStatus == true) {
                $payPalService->afterMakePayment($request);

                $this->savePayment($package, $request->input('paymentId'), $transactionRepository);

                return redirect()->to(route('public.vendor.packages'))
                    ->with('success_msg', trans('modules.plugins.vendor::package.add_credit_success'));
            }

            return redirect()->to(route('public.vendor.packages'))
                ->with('error_msg', $payPalService->getErrorMessage());
        }

        $this->savePayment($package, $request->input('paymentId'), $transactionRepository);

        return redirect()->to(route('public.vendor.packages'))
            ->with('success_msg', trans('modules.plugins.vendor::package.add_credit_success'));
    }

    /**
     * @param Vendor $account
     * @param Package $package
     * @param string $paymentId
     * @param TransactionInterface $transactionRepository
     */
    protected function savePayment(Package $package, ?string $paymentId, TransactionInterface $transactionRepository)
    {
        $account = auth('vendor')->user();
        $account->credits += $package->number_of_listings;
        $account->save();

        $account->packages()->attach($package);

        $payment = app(PaymentInterface::class)->getFirstBy(['charge_id' => $paymentId]);

        $transactionRepository->createOrUpdate([
            'user_id' => 0,
            'account_id' => auth('vendor')->user()->id,
            'credits' => $package->number_of_listings,
            'payment_id' => $payment ? $payment->id : null,
        ]);

        return true;
    }

    /**
     * @param UpdatePasswordRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postSecurity(UpdatePasswordRequest $request, BaseHttpResponse $response)
    {
        $this->accountRepository->update(['id' => auth()->guard('vendor')->user()->getKey()], [
            'password' => bcrypt($request->input('password')),
        ]);

        $this->activityLogRepository->createOrUpdate(['action' => 'update_security']);

        return $response->setMessage(trans('modules.plugins.vendor::dashboard.password_update_success'));
    }

    /**
     * @param AvatarRequest $request
     * @param UploadsManager $uploadManager
     * @param ImageManager $imageManager
     * @param ThumbnailService $thumbnailService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postAvatar(
        AvatarRequest $request,
        UploadsManager $uploadManager,
        ImageManager $imageManager,
        ThumbnailService $thumbnailService,
        BaseHttpResponse $response
    ) {
        try {
            $fileUpload = $request->file('avatar_file');

            $file_ext = $fileUpload->getClientOriginalExtension();

            $folderPath = 'vendors';

            $fileName = $this->fileRepository->createName(File::name($fileUpload->getClientOriginalName()), 0);

            $fileName = $this->fileRepository->createSlug($fileName, $file_ext, Storage::path($folderPath));

            $account = $this->accountRepository->findOrFail(Auth::guard('vendor')->user()->getKey());

            $image = $imageManager->make($request->file('avatar_file')->getRealPath());
            $avatarData = json_decode($request->input('avatar_data'));
            $image->crop((int)$avatarData->height, (int)$avatarData->width, (int)$avatarData->x, (int)$avatarData->y);
            $path = $folderPath . '/' . $fileName;

            $uploadManager->saveFile($path, $image->stream()->__toString());

            $readable_size = explode('x', RvMedia::getSize('thumb'));

            $thumbnailService
                ->setImage($fileUpload->getRealPath())
                ->setSize($readable_size[0], $readable_size[1])
                ->setDestinationPath($folderPath)
                ->setFileName(File::name($fileName) . '-' . RvMedia::getSize('thumb') . '.' . $file_ext)
                ->save();

            $data = $uploadManager->fileDetails($path);

            $file = $this->fileRepository->getModel();
            $file->name = $fileName;
            $file->url = $data['url'];
            $file->size = $data['size'];
            $file->mime_type = $data['mime_type'];
            $file->folder_id = 0;
            $file->user_id = 0;
            $file->options = [];
            $file = $this->fileRepository->createOrUpdate($file);

            $this->fileRepository->forceDelete(['id' => $account->avatar_id]);

            $account->avatar_id = $file->id;

            $this->accountRepository->createOrUpdate($account);

            $this->activityLogRepository->createOrUpdate([
                'action' => 'changed_avatar',
            ]);

            return $response
                ->setMessage(trans('modules.plugins.vendor::dashboard.update_avatar_success'))
                ->setData(['url' => Storage::url($data['url'])]);
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getActivityLogs(BaseHttpResponse $response)
    {
        $activities = $this->activityLogRepository->getAllLogs(auth()->guard('vendor')->user()->getKey());

        return $response->setData(ActivityLogResource::collection($activities))->toApiResponse();
    }

    /**
     * @param MediaFileRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postUpload(MediaFileRequest $request, BaseHttpResponse $response)
    {
        $validator = Validator::make($request->all(), [
            'file.0' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return $response->setError()->setMessage($validator->getMessageBag()->first());
        }

        $result = RvMedia::handleUpload(Arr::first($request->file('file')), 0, 'vendors');

        if ($result['error']) {
            return $response->setError();
        }

        return $response->setData($result['data']);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function postUploadFromEditor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response('<script>alert("' . trans('modules.media::media.can_not_detect_file_type') . '")</script>')
                ->header('Content-Type', 'text/html');
        }

        $result = RvMedia::handleUpload($request->file('upload'), 0, 'vendors');

        if ($result['error'] == false) {
            $file = $result['data'];
            return response('<script>parent.setImageValue("' . get_image_url($file->url) . '"); </script>')
                ->header('Content-Type', 'text/html');
        }

        return response('<script>alert("' . Arr::get($result, 'message') . '")</script>')
            ->header('Content-Type', 'text/html');
    }

    /**
     * @param \Modules\Plugins\Vendor\Repositories\Interfaces\TransactionInterface $transactionRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetTransactions(TransactionInterface $transactionRepository, BaseHttpResponse $response)
    {
        $transactions = $transactionRepository->advancedGet([
            'condition' => [
                'account_id' => auth('vendor')->user()->id,
            ],
            'paginate'  => [
                'per_page'      => 10,
                'current_paged' => 1,
            ],
            'order_by'  => ['created_at' => 'DESC'],
            'with'      => ['payment', 'user'],
        ]);

        return $response->setData(TransactionResource::collection($transactions))->toApiResponse();
    }
}
