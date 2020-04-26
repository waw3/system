<?php

namespace Modules\Plugins\Payment\Tables;

use Auth;
use Modules\Plugins\Payment\Repositories\Interfaces\PaymentInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Modules\Plugins\Payment\Models\Payment;

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

        if (!Auth::user()->hasAnyPermission(['payment.show', 'payment.destroy'])) {
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
            ->editColumn('charge_id', function ($item) {
                return anchor_link(route('payment.show', $item->id), $item->charge_id);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('payment_channel', function ($item) {

                if ($item->payment_channel->label() == 'Direct'){
                    return $item->payment_channel->label(). ' '.'Bank Transfer';
                }else{
                    return $item->payment_channel->label();
                }

            })
            ->editColumn('amount', function ($item) {
                return $item->amount . ' ' . $item->currency;
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('payment.show', 'payment.destroy', $item);
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
            'payments.charge_id',
            'payments.amount',
            'payments.currency',
            'payments.payment_channel',
            'payments.created_at',
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
                'name'  => 'payments.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'charge_id' => [
                'name'  => 'payments.charge_id',
                'title' => __('Charge ID'),
                'class' => 'text-left',
            ],
            'amount' => [
                'name'  => 'payments.amount',
                'title' => __('Amount'),
                'class' => 'text-left',
            ],
            'payment_channel' => [
                'name'  => 'payments.payment_channel',
                'title' => __('Payment channel'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'payments.created_at',
                'title' => trans('modules.base::tables.created_at'),
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
        return apply_filters(BASE_FILTER_TABLE_BUTTONS, [], Payment::class);
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
            'payments.charge_id' => [
                'title'    => __('Charge ID'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'payments.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
