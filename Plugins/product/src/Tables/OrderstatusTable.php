<?php

namespace Modules\Plugins\Product\Tables;

use Auth;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Repositories\Interfaces\OrderstatusInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Modules\Plugins\Product\Models\Orderstatus;

class OrderstatusTable extends TableAbstract
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
     * OrderstatusTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlDevTool
     * @param OrderstatusInterface $orderstatusRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlDevTool, OrderstatusInterface $orderstatusRepository)
    {
        $this->repository = $orderstatusRepository;
        $this->setOption('id', 'table-plugins-orderstatus');
        parent::__construct($table, $urlDevTool);

        if (!Auth::user()->hasAnyPermission(['orderstatus.edit', 'orderstatus.destroy'])) {
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
                if (!Auth::user()->hasPermission('orderstatus.edit')) {
                    return $item->name;
                }
                return anchor_link(route('orderstatus.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('orderstatus.edit', 'orderstatus.destroy', $item);
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
            'orderstatuses.id',
            'orderstatuses.name',
            'orderstatuses.created_at',
            'orderstatuses.status',
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
                'name'  => 'orderstatuses.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'orderstatuses.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'orderstatuses.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'orderstatuses.status',
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
        $buttons = $this->addCreateButton(route('orderstatus.create'), 'orderstatus.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Orderstatus::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('orderstatus.deletes'), 'orderstatus.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'orderstatuses.name' => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'orderstatuses.status' => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'orderstatuses.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
