<?php

namespace Modules\Acl\Tables;

use Modules\Acl\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Acl\Enums\UserStatusEnum;
use Modules\Acl\Repositories\Interfaces\ActivationInterface;
use Modules\Acl\Repositories\Interfaces\UserInterface;
use Modules\Acl\Services\ActivateUserService;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Table\Abstracts\TableAbstract;
use Exception;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Throwable;
use Yajra\DataTables\DataTables;

class UserTable extends TableAbstract
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
     * @var ActivateUserService
     */
    protected $service;

    /**
     * UserTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param UserInterface $userRepository
     * @param ActivateUserService $service
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        UserInterface $userRepository,
        ActivateUserService $service
    ) {
        $this->repository = $userRepository;
        $this->service = $service;
        $this->setOption('id', 'table-users');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['users.edit', 'users.destroy'])) {
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
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('username', function ($item) {
                if (!Auth::user()->hasPermission('users.edit')) {
                    return $item->username;
                }

                return anchor_link(route('user.profile.view', $item->id), $item->username);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, mconfig('base.config.date_format.date'));
            })
            ->editColumn('role_name', function ($item) {
                if (!Auth::user()->hasPermission('users.edit')) {
                    return $item->role_name;
                }

                return view('modules.acl::users.partials.role', ['item' => $item])->render();
            })
            ->editColumn('super_user', function ($item) {
                return $item->super_user ? trans('modules.base::base.yes') : trans('modules.base::base.no');
            })
            ->editColumn('status', function ($item) {
                if (app(ActivationInterface::class)->completed($item)) {
                    return UserStatusEnum::ACTIVATED()->toHtml();
                }

                return UserStatusEnum::DEACTIVATED()->toHtml();
            })
            ->removeColumn('role_id');

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {

                $action = null;
                if (Auth::user()->isSuperUser()) {
                    $action = Html::link(route('users.make-super', $item->id), trans('modules.acl::users.make_super'),
                        ['class' => 'btn btn-info'])->toHtml();

                    if ($item->super_user) {
                        $action = Html::link(route('users.remove-super', $item->id), trans('modules.acl::users.remove_super'),
                            ['class' => 'btn btn-danger'])->toHtml();
                    }
                }

                return apply_filters('user_table_actions',
                    $action . view('modules.acl::users.partials.actions', ['item' => $item])->render(), $item);
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
        $query = $model->leftJoin('role_users', 'users.id', '=', 'role_users.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_users.role_id')
            ->select([
                'users.id',
                'users.username',
                'users.email',
                'roles.name as role_name',
                'roles.id as role_id',
                'users.updated_at',
                'users.created_at',
                'users.super_user',
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
            'username'   => [
                'name'  => 'users.username',
                'title' => trans('modules.acl::users.username'),
                'class' => 'text-left',
            ],
            'email'      => [
                'name'  => 'users.email',
                'title' => trans('modules.acl::users.email'),
                'class' => 'text-left',
            ],
            'role_name'  => [
                'name'       => 'role_name',
                'title'      => trans('modules.acl::users.role'),
                'searchable' => false,
            ],
            'created_at' => [
                'name'  => 'users.created_at',
                'title' => trans('modules.base::tables.created_at'),
                'width' => '100px',
            ],
            'status'     => [
                'name'  => 'users.updated_at',
                'title' => trans('modules.base::tables.status'),
                'width' => '100px',
            ],
            'super_user' => [
                'name'  => 'users.super_user',
                'title' => trans('modules.acl::users.is_super'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     * @throws Throwable
     * @since 2.1
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('users.create'), 'users.create');

        return apply_filters('base_filter_datatables_buttons', $buttons, User::class);
    }

    /**
     * @return string
     */
    public function htmlDrawCallbackFunction(): ?string
    {
        return parent::htmlDrawCallbackFunction() . '$(".editable").editable();';
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('users.deletes'), 'users.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        $filters = $this->getBulkChanges();
        Arr::forget($filters, 'users.status');

        return $filters;
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'users.username'   => [
                'title'    => trans('modules.acl::users.username'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'users.email'      => [
                'title'    => trans('modules.base::tables.email'),
                'type'     => 'text',
                'validate' => 'required|max:120|email',
            ],
            'users.status'     => [
                'title'    => trans('modules.base::tables.status'),
                'type'     => 'select',
                'choices'  => UserStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', UserStatusEnum::values()),
            ],
            'users.created_at' => [
                'title' => trans('modules.base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getOperationsHeading()
    {
        return [
            'operations' => [
                'title'      => trans('modules.base::tables.operations'),
                'width'      => '350px',
                'class'      => 'text-right',
                'orderable'  => false,
                'searchable' => false,
                'exportable' => false,
                'printable'  => false,
            ],
        ];
    }

    /**
     * @param array $ids
     * @param string $inputKey
     * @param string|null $inputValue
     * @return bool
     * @throws Exception
     */
    public function saveBulkChanges(array $ids, string $inputKey, ?string $inputValue): bool
    {
        if (app()->environment('demo')) {
            throw new Exception(trans('modules.base::system.disabled_in_demo_mode'));
        }

        if ($inputKey === 'users.status') {
            foreach ($ids as $id) {
                if ($inputValue == UserStatusEnum::DEACTIVATED && Auth::user()->getKey() == $id) {
                    throw new Exception(trans('modules.acl::users.lock_user_logged_in'));
                }

                $user = $this->repository->findOrFail($id);

                if ($inputValue == UserStatusEnum::ACTIVATED) {
                    $this->service->activate($user);
                } else {
                    app(ActivationInterface::class)->remove($user);
                }
                event(new UpdatedContentEvent('user', request(), $user));
            }

            return true;
        }

        return parent::saveBulkChanges($ids, $inputKey, $inputValue);
    }
}
