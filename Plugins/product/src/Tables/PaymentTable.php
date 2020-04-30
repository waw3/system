<?php

namespace Modules\Plugins\Product\Tables;

use Auth;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Repositories\Interfaces\PaymentInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Modules\Plugins\Product\Models\Payment;

class PaymentTable extends TableAbstract
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
     * PaymentTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlDevTool
     * @param PaymentInterface $paymentRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlDevTool, PaymentInterface $paymentRepository)
    {
        $this->repository = $paymentRepository;
        $this->setOption('id', 'table-plugins-payment');
        parent::__construct($table, $urlDevTool);

        if (!Auth::user()->hasAnyPermission(['payment.edit', 'payment.destroy'])) {
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
                if (!Auth::user()->hasPermission('payment.edit')) {
                    return $item->name;
                }
                return anchor_link(route('payment.edit', $item->id), $item->name);
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
                return table_actions('payment.edit', 'payment.destroy', $item);
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
            'payments.id',
            'payments.name',
            'payments.created_at',
            'payments.status',
        ]);

        return $this->applyScopes(apply_filters('base_filter_datatables_query', $query, $model));
    }

    /**
     * @return array
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'payments.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'payments.name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'payments.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'payments.status',
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
        $buttons = $this->addCreateButton(route('payment.create'), 'payment.create');

        return apply_filters('base_filter_datatables_buttons', $buttons, Payment::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('payment.deletes'), 'payment.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'payments.name' => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'payments.status' => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'payments.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
