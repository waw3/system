<?php

namespace Modules\Acl\Tables;

use Modules\Acl\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Acl\Repositories\Interfaces\RoleInterface;
use Modules\Acl\Repositories\Interfaces\UserInterface;
use Modules\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Throwable;
use Yajra\DataTables\DataTables;

class RoleTable extends TableAbstract
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
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * RoleTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param RoleInterface $roleRepository
     * @param UserInterface $userRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        RoleInterface $roleRepository,
        UserInterface $userRepository
    ) {
        $this->repository = $roleRepository;
        $this->userRepository = $userRepository;
        $this->setOption('id', 'table-roles');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['roles.edit', 'roles.destroy'])) {
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
                if (!Auth::user()->hasPermission('roles.edit')) {
                    return $item->name;
                }

                return anchor_link(route('roles.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('created_by', function ($item) {
                return $item->author->getFullName();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('roles.edit', 'roles.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by the table.
     *
     * @return \Illuminate\Database\Query\Builder|Builder
     *
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->with('author')
            ->select([
                'roles.id',
                'roles.name',
                'roles.description',
                'roles.created_at',
                'roles.created_by',
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
            'id'          => [
                'name'  => 'roles.id',
                'title' => trans('modules.base::tables.id'),
                'width' => '20px',
            ],
            'name'        => [
                'name'  => 'roles.name',
                'title' => trans('modules.base::tables.name'),
            ],
            'description' => [
                'name'  => 'roles.description',
                'title' => trans('modules.base::tables.description'),
                'class' => 'text-left',
            ],
            'created_at'  => [
                'name'  => 'roles.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'created_by'  => [
                'name'  => 'roles.created_by',
                'title' => trans('modules.acl::permissions.created_by'),
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
        $buttons = $this->addCreateButton(route('roles.create'), 'roles.create');

        return apply_filters('base_filter_datatables_buttons', $buttons, Role::class);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('roles.deletes'), 'roles.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'roles.name' => [
                'title'    => trans('modules.base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
        ];
    }
}
