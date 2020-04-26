<?php

namespace Modules\Plugins\AuditLog\Tables;

use Modules\Plugins\AuditLog\Models\AuditHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Plugins\AuditLog\Repositories\Interfaces\AuditLogInterface;
use Modules\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Throwable;
use Yajra\DataTables\DataTables;

class AuditLogTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = false;

    /**
     * AuditLogTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param AuditLogInterface $auditLogRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, AuditLogInterface $auditLogRepository)
    {
        $this->repository = $auditLogRepository;
        $this->setOption('id', 'table-audit-logs');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasPermission('audit-log.destroy')) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return JsonResponse
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('action', function ($history) {
                return view('modules.plugins.audit-log::activity-line', compact('history'))->render();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions(null, 'audit-log.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by table.
     *
     * @return \Illuminate\Database\Query\Builder|Builder
     *
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->with(['user'])
            ->select('audit_histories.*');

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
    }

    /**
     * @return array
     */
    public function columns()
    {
        return [
            'id'         => [
                'name'  => 'audit_histories.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'action'     => [
                'name'  => 'audit_histories.action',
                'title' => trans('modules.plugins.audit-log::history.action'),
                'class' => 'text-left',
            ],
            'user_agent' => [
                'name'  => 'audit_histories.user_agent',
                'title' => trans('modules.plugins.audit-log::history.user_agent'),
                'class' => 'text-left',
            ],
        ];
    }

    /**
     * @return array
     *
     * @throws Throwable
     */
    public function buttons()
    {
        $buttons = [
            'empty' => [
                'link' => route('audit-log.empty'),
                'text' => Html::tag('i', '', ['class' => 'fa fa-trash'])->toHtml() . ' ' . __('Delete all records'),
            ],
        ];

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, AuditHistory::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('audit-log.deletes'), 'audit-log.destroy', parent::bulkActions());
    }
}
