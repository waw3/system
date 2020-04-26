<?php

namespace Modules\Plugins\Product\Tables;

use Auth;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Repositories\Interfaces\CartInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Modules\Plugins\Product\Models\Cart;

class CartTable extends TableAbstract
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
     * CartTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlDevTool
     * @param CartInterface $cartRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlDevTool, CartInterface $cartRepository)
    {
        $this->repository = $cartRepository;
        $this->setOption('id', 'table-plugins-cart');
        parent::__construct($table, $urlDevTool);

        if (!Auth::user()->hasAnyPermission(['cart.edit', 'cart.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('cart.edit')) {
                    return $item->name;
                }
                return anchor_link(route('cart.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            /*->editColumn('author_id', function ($item) {
                return $item->author ? $item->author->getFullName() : null;
            })*/
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('cart.edit', 'cart.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by table.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model->select([
            'carts.id',
            'carts.name',
          /*  'carts.author_id',
            'carts.author_type',*/
            'carts.created_at',
            'carts.status',
        ]);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
    }

    /**
     * @return array
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'carts.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'carts.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
           
            
            'created_at' => [
                'name'  => 'carts.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'carts.status',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     * @since 2.1
     * @throws \Throwable
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('cart.create'), 'cart.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Cart::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('cart.deletes'), 'cart.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'carts.name' => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'carts.status' => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'carts.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
