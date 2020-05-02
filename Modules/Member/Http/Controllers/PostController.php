<?php

namespace Modules\Member\Http\Controllers;

use Assets;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Blog\Models\Post;
use Modules\Blog\Repositories\Interfaces\PostInterface;
use Modules\Blog\Repositories\Interfaces\TagInterface;
use Modules\Blog\Services\StoreCategoryService;
use Modules\Blog\Services\StoreTagService;
use Modules\Member\Forms\PostForm;
use Modules\Member\Http\Requests\PostRequest;
use Modules\Member\Models\Member;
use Modules\Member\Repositories\Interfaces\MemberActivityLogInterface;
use Modules\Member\Repositories\Interfaces\MemberInterface;
use Modules\Member\Tables\PostTable;
use Exception;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RvMedia;
use SeoHelper;
use Validator;

class PostController extends Controller
{
    /**
     * @var MemberInterface
     */
    protected $memberRepository;

    /**
     * @var PostInterface
     */
    protected $postRepository;

    /**
     * @var MemberActivityLogInterface
     */
    protected $activityLogRepository;

    /**
     * PublicController constructor.
     * @param Repository $config
     * @param MemberInterface $memberRepository
     * @param PostInterface $postRepository
     * @param MemberActivityLogInterface $memberActivityLogRepository
     */
    public function __construct(
        Repository $config,
        MemberInterface $memberRepository,
        PostInterface $postRepository,
        MemberActivityLogInterface $memberActivityLogRepository
    ) {
        $this->memberRepository = $memberRepository;
        $this->postRepository = $postRepository;
        $this->activityLogRepository = $memberActivityLogRepository;

        Assets::setConfig($config->get('modules.member.assets'));
    }

    /**
     * @param Request $request
     * @param PostTable $postTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Response
     * @throws \Throwable
     */
    public function index(PostTable $postTable)
    {
        SeoHelper::setTitle(__('Posts'));

        return $postTable->render('modules.member::table.base');
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     * @throws \Throwable
     */
    public function create(FormBuilder $formBuilder)
    {
        SeoHelper::setTitle(__('Write a post'));

        return $formBuilder->create(PostForm::class)->renderForm();
    }

    /**
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {

        $validator = Validator::make($request->all(), ['image_input' => 'image|mimes:jpg,jpeg,png']);

        if ($validator->fails()) {
            return redirect()->back();
        }

        if ($request->hasFile('image_input')) {
            $result = RvMedia::handleUpload($request->file('image_input'), 0, 'members');
            if ($result['error'] == false) {
                $file = $result['data'];
                $request->merge(['image' => $file->url]);
            }
        }

        /**
         * @var Post $post
         */
        $post = $this->postRepository->createOrUpdate(array_merge($request->except('status'), [
            'author_id'   => auth()->guard('member')->user()->getKey(),
            'author_type' => Member::class,
            'status'      => BaseStatusEnum::PENDING,
        ]));

        event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'create_post',
            'reference_name' => $post->name,
            'reference_url'  => route('public.member.posts.edit', $post->id),
        ]);

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('public.member.posts.index'))
            ->setNextUrl(route('public.member.posts.edit', $post->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     *
     * @throws \Throwable
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $post = $this->postRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth()->guard('member')->user()->getKey(),
            'author_type' => Member::class,
        ]);

        if (!$post) {
            abort(404);
        }

        event(new BeforeEditContentEvent($request, $post));

        SeoHelper::setTitle(trans('modules.blog::posts.edit') . ' "' . $post->name . '"');

        return $formBuilder
            ->create(PostForm::class, ['model' => $post])
            ->renderForm();
    }

    /**
     * @param int $id
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(
        $id,
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        $validator = Validator::make($request->all(), ['image_input' => 'image|mimes:jpg,jpeg,png']);

        if ($validator->fails()) {
            return redirect()->back();
        }

        $post = $this->postRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth()->guard('member')->user()->getKey(),
            'author_type' => Member::class,
        ]);

        if (!$post) {
            abort(404);
        }

        if ($request->hasFile('image_input')) {
            $result = RvMedia::handleUpload($request->file('image_input'), 0, 'members');
            if ($result['error'] == false) {
                $file = $result['data'];
                $request->merge(['image' => $file->url]);
            }
        }

        $post->fill($request->except('status'));

        $this->postRepository->createOrUpdate($post);

        event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'update_post',
            'reference_name' => $post->name,
            'reference_url'  => route('public.member.posts.edit', $post->id),
        ]);

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('public.member.posts.index'))
            ->setMessage(trans('modules.base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function delete($id, BaseHttpResponse $response)
    {
        $post = $this->postRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth()->guard('member')->user()->getKey(),
            'author_type' => Member::class,
        ]);

        if (!$post) {
            abort(404);
        }

        $this->postRepository->delete($post);

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'delete_post',
            'reference_name' => $post->name,
        ]);

        return $response->setMessage(__('Delete post successfully!'));
    }

    /**
     * Get list tags in db
     *
     * @param TagInterface $tagRepository
     * @return array
     */
    public function getAllTags(TagInterface $tagRepository)
    {
        return $tagRepository->pluck('name');
    }
}
