<?php

namespace Modules\Plugins\Member\Tables;

use Modules\Plugins\Member\Models\Member;
use Illuminate\Support\Facades\Auth;
use Modules\Plugins\Member\Repositories\Interfaces\MemberInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;

class MemberTable extends TableAbstract
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
     * MemberTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param MemberInterface $memberRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, MemberInterface $memberRepository)
    {
        $this->repository = $memberRepository;
        $this->setOption('id', 'table-members');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['member.edit', 'member.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('first_name', function ($item) {
                if (!Auth::user()->hasPermission('member.edit')) {
                    return $item->getFullName();
                }

                return anchor_link(route('member.edit', $item->id), $item->getFullName());
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('member.edit', 'member.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by the table.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     *
     * @since 2.1
     */
    public function query()
    {
        $model = app(MemberInterface::class)->getModel();
        $query = $model
            ->select([
                'members.id',
                'members.first_name',
                'members.last_name',
                'members.email',
                'members.created_at',
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
                'name'  => 'members.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'first_name' => [
                'name'  => 'members.first_name',
                'title' => trans('modules.base::tables.name'),
                'class' => 'text-left',
            ],
            'email'      => [
                'name'  => 'members.email',
                'title' => trans('modules.base::tables.email'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'members.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     *
     * @since 2.1
     * @throws \Throwable
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('member.create'), 'member.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Member::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('member.deletes'), 'member.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'members.first_name' => [
                'title'    => __('First name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'members.last_name' => [
                'title'    => __('Last name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'members.email'      => [
                'title'    => trans('modules.base::tables.email'),
                'type'     => 'text',
                'validate' => 'required|max:120|email',
            ],
            'members.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
