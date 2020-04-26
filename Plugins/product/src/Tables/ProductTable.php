<?php

namespace Modules\Plugins\Product\Tables;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Exports\ProductExport;
use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Modules\Table\Abstracts\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Throwable;
use Yajra\DataTables\DataTables;

class ProductTable extends TableAbstract
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
    protected $procategoryRepository;

    /**
     * @var string
     */
    protected $exportClass = ProductExport::class;

    /**
     * @var int
     */
    protected $defaultSortColumn = 6;

    /**
     * ProductTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param ProductInterface $productRepository
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        ProductInterface $productRepository,
        ProCategoryInterface $procategoryRepository
    ) {
        $this->repository = $productRepository;
        $this->setOption('id', 'table-products');
        $this->procategoryRepository = $procategoryRepository;
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->hasAnyPermission(['products.edit', 'products.destroy'])) {
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
                if (Auth::check() && !Auth::user()->hasPermission('products.edit')) {
                    return $item->name;
                }

                return anchor_link(route('products.edit', $item->id), $item->name);
            })
            ->editColumn('imagedl', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return get_object_image($item->imagedl, 'thumb');
                }
                return Html::image(get_object_image($item->imagedl, 'thumb'), $item->name, ['width' => 50]);
            })
            
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('updated_at', function ($item) {
                return implode(', ', $item->procategories->pluck('name')->all());
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
                return table_actions('products.edit', 'products.destroy', $item);
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
            ->with(['procategories'])
            ->select([
                'products.id',
                'products.name',
                'products.imagedl',
                'products.created_at',
                'products.status',
                'products.updated_at',
                'products.author_id',
                'products.author_type',
            ]);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
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
                'name'  => 'products.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'imagedl'      => [
                'name'  => 'products.imagedl',
                'title' => trans('modules.base::tables.image'),
                'width' => '70px',
            ],
            'name'       => [
                'name'  => 'products.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'updated_at' => [
                'name'      => 'products.updated_at',
                'title'     => trans('modules.plugins.product::products.categories'),
                'width'     => '150px',
                'class'     => 'no-sort',
                'orderable' => false,
            ],
            'author_id'  => [
                'name'      => 'products.author_id',
                'title'     => trans('modules.plugins.product::products.author'),
                'width'     => '150px',
                'class'     => 'no-sort',
                'orderable' => false,
            ],
            'created_at' => [
                'name'  => 'products.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status'     => [
                'name'  => 'products.status',
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
        $buttons = $this->addCreateButton(route('products.create'), 'products.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Product::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('products.deletes'), 'products.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'products.name'       => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'products.status'     => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'products.created_at' => [
                'title'    => trans('modules.base::tables.created_at'),
                'type'     => 'date',
                'validate' => 'required',
            ],
            'procategory'         => [
                'title'    => __('Product Category'),
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
        return $this->procategoryRepository->pluck('procategories.name', 'procategories.id');
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
            case 'products.created_at':
                $value = Carbon::createFromFormat('Y/m/d', $value)->toDateString();
                return $query->whereDate($key, $operator, $value);
            case 'procategory':
                return $query->join('product_categories', 'product_categories.product_id', '=', 'products.id')
                    ->join('procategories', 'product_categories.pro_category_id', '=', 'procategories.id')
                    ->where('product_categories.pro_category_id', $operator, $value);
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    /**
     * @param Product $item
     * @param string $inputKey
     * @param string $inputValue
     * @return false|Model
     */
    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'procategory') {
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
        return ['excel', 'reload','pdf'];
    }
}
