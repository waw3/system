<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\Product\Http\Requests\PaymentRequest;
use Modules\Plugins\Product\Repositories\Interfaces\PaymentInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Modules\Plugins\Product\Tables\PaymentTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Forms\PaymentForm;
use Modules\Base\Forms\FormBuilder;

class PaymentController extends BaseController
{
    /**
     * @var PaymentInterface
     */
    protected $paymentRepository;

    /**
     * PaymentController constructor.
     * @param PaymentInterface $paymentRepository
     */
    public function __construct(PaymentInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param PaymentTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(PaymentTable $table)
    {
        page_title()->setTitle(trans('modules.plugins.product::payment.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::payment.create'));

        return $formBuilder->create(PaymentForm::class)->renderForm();
    }

    /**
     * Create new item
     *
     * @param PaymentRequest $request
     * @return BaseHttpResponse
     */
    public function store(PaymentRequest $request, BaseHttpResponse $response)
    {
        $payment = $this->paymentRepository->createOrUpdate($request->input());

 

        event(new CreatedContentEvent(PAYMENT_MODULE_SCREEN_NAME, $request, $payment));

        return $response
            ->setPreviousUrl(route('payment.index'))
            ->setNextUrl(route('payment.edit', $payment->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * Show edit form
     *
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $payment = $this->paymentRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $payment));

        page_title()->setTitle(trans('modules.plugins.product::payment.edit') . ' "' . $payment->name . '"');

        return $formBuilder->create(PaymentForm::class, ['model' => $payment])->renderForm();
    }

    /**
     * @param $id
     * @param PaymentRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, PaymentRequest $request, BaseHttpResponse $response)
    {
        $payment = $this->paymentRepository->findOrFail($id);

        $payment->fill($request->input());

        $this->paymentRepository->createOrUpdate($payment);
        

        event(new UpdatedContentEvent(PAYMENT_MODULE_SCREEN_NAME, $request, $payment));

        return $response
            ->setPreviousUrl(route('payment.index'))
            ->setMessage(trans('modules.base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $payment = $this->paymentRepository->findOrFail($id);

            $this->paymentRepository->delete($payment);

            event(new DeletedContentEvent(PAYMENT_MODULE_SCREEN_NAME, $request, $payment));

            return $response->setMessage(trans('modules.base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $payment = $this->paymentRepository->findOrFail($id);
            $this->paymentRepository->delete($payment);
            event(new DeletedContentEvent(PAYMENT_MODULE_SCREEN_NAME, $request, $payment));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
