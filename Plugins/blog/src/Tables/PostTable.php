<?php

namespace Modules\Plugins\Blog\Tables;

use Html, Throwable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Blog\Exports\PostExport;
use Modules\Plugins\Blog\Models\Post;
use Modules\Plugins\Blog\Repositories\Interfaces\CategoryInterface;
use Modules\Plugins\Blog\Repositories\Interfaces\PostInterface;
use Modules\Table\Abstracts\TableAbstract;
use Carbon\Carbon;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;

class PostTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @var string
     */
    protected $exportClass = PostExport::class;

    /**
     * @var int
     */
    protected $defaultSortColumn = 6;

    /**
     * PostTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PostInterface $postRepository
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, PostInterface $postRepository, CategoryInterface $categoryRepository)
    {


        $this->repository = $postRepository;
        $this->setOption('id', 'table-posts');
        $this->categoryRepository = $categoryRepository;
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->hasAnyPermission(['posts.edit', 'posts.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return JsonResponse
     *
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (Auth::check() && !Auth::user()->hasPermission('posts.edit')) {
                    return $item->name;
                }

                return anchor_link(route('posts.edit', $item->id), $item->name);
            })
            ->editColumn('image', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return get_object_image($item->image, 'thumb');
                }
                return Html::image(get_object_image($item->image, 'thumb'), $item->name, ['width' => 50]);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('updated_at', function ($item) {
                return implode(', ', $item->categories->pluck('name')->all());
            })
            ->editColumn('author_id', function ($item) {
                return $item->author ? $item->author->getFullName() : null;
            })
            ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('posts.edit', 'posts.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by the table.
     *
     * @return Builder|\Illuminate\Database\Eloquent\Builder
     *
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->with(['categories'])
            ->select([
                'posts.id',
                'posts.name',
                'posts.image',
                'posts.created_at',
                'posts.status',
                'posts.updated_at',
                'posts.author_id',
                'posts.author_type',
            ]);

        return $this->applyScopes(apply_filters('base_filter_datatables_query', $query, $model));
    }

    /**
     * @return array
     *
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id'         => [
                'name'  => 'posts.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'image'      => [
                'name'  => 'posts.image',
                'title' => trans('modules.base::tables.image'),
                'width' => '70px',
            ],
            'name'       => [
                'name'  => 'posts.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'updated_at' => [
                'name'      => 'posts.updated_at',
                'title'     => trans('modules.plugins.blog::posts.categories'),
                'width'     => '150px',
                'class'     => 'no-sort',
                'orderable' => false,
            ],
            'author_id'  => [
                'name'      => 'posts.author_id',
                'title'     => trans('modules.plugins.blog::posts.author'),
                'width'     => '150px',
                'class'     => 'no-sort',
                'orderable' => false,
            ],
            'created_at' => [
                'name'  => 'posts.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status'     => [
                'name'  => 'posts.status',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     *
     * @throws Throwable
     * @since 2.1
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('posts.create'), 'posts.create');

        return apply_filters('base_filter_datatables_buttons', $buttons, Post::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('posts.deletes'), 'posts.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'posts.name'       => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'posts.status'     => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'posts.created_at' => [
                'title'    => trans('modules.base::tables.created_at'),
                'type'     => 'date',
                'validate' => 'required',
            ],
            'category'         => [
                'title'    => __('Category'),
                'type'     => 'select-search',
                'validate' => 'required',
                'callback' => 'getCategories',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categoryRepository->pluck('categories.name', 'categories.id');
    }

    /**
     * @param Builder $query
     * @param string $key
     * @param string $operator
     * @param string $value
     * @return $this|Builder|string|static
     */
    public function applyFilterCondition($query, string $key, string $operator, ?string $value)
    {
        switch ($key) {
            case 'posts.created_at':
                $value = Carbon::createFromFormat('Y/m/d', $value)->toDateString();
                return $query->whereDate($key, $operator, $value);
            case 'category':
                return $query->join('post_categories', 'post_categories.post_id', '=', 'posts.id')
                    ->join('categories', 'post_categories.category_id', '=', 'categories.id')
                    ->where('post_categories.category_id', $operator, $value);
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    /**
     * @param Post $item
     * @param string $inputKey
     * @param string $inputValue
     * @return false|Model
     */
    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'category') {
            $item->categories()->sync([$inputValue]);
            return $item;
        }

        return parent::saveBulkChangeItem($item, $inputKey, $inputValue);
    }

    /**
     * @return array
     */
    public function getDefaultButtons(): array
    {
        return ['excel', 'reload'];
    }
}
