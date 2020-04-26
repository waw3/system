<?php

namespace Modules\Acl\Http\Controllers;

use Modules\Acl\Forms\RoleForm;
use Modules\Base\Forms\FormBuilder;
use BaseHttpResponse;
use Modules\Acl\Events\RoleAssignmentEvent;
use Modules\Acl\Events\RoleUpdateEvent;
use Modules\Acl\Tables\RoleTable;
use Modules\Acl\Http\Requests\RoleCreateRequest;
use Modules\Acl\Repositories\Interfaces\RoleInterface;
use Modules\Acl\Repositories\Interfaces\UserInterface;
use BaseController;
use Modules\Base\Supports\Helper;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class RoleController extends BaseController
{
    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * RoleController constructor.
     * @param RoleInterface $roleRepository
     * @param UserInterface $userRepository
     */
    public function __construct(RoleInterface $roleRepository, UserInterface $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Show list roles
     *
     * @param RoleTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(RoleTable $dataTable)
    {
        page_title()->setTitle(trans('modules.acl::permissions.role_permission'));

        return $dataTable->renderTable();
    }

    /**
     * Delete a role
     *
     * @param int $id
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function destroy($id, BaseHttpResponse $response)
    {
        $role = $this->roleRepository->findOrFail($id);

        $role->delete();

        Helper::executeCommand('cache:clear');

        return $response->setMessage(trans('modules.acl::permissions.delete_success'));
    }

    /**
     * Delete many roles
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $role = $this->roleRepository->findOrFail($id);
            $role->delete();
        }

        Helper::executeCommand('cache:clear');

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $role = $this->roleRepository->findOrFail($id);

        page_title()->setTitle(trans('modules.acl::permissions.details') . ' - ' . e($role->name));

        return $formBuilder->create(RoleForm::class, ['model' => $role])->renderForm();
    }

    /**
     * @param int $id
     * @param RoleCreateRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function update($id, RoleCreateRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->roleRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $role = $this->roleRepository->findOrFail($id);

        $role->name = $request->input('name');
        $role->permissions = $this->cleanPermission($request->input('flags'));
        $role->description = $request->input('description');
        $role->updated_by = $request->user()->getKey();
        $role->is_default = $request->input('is_default');
        $this->roleRepository->createOrUpdate($role);

        Helper::executeCommand('cache:clear');

        event(new RoleUpdateEvent($role));

        return $response
            ->setPreviousUrl(route('roles.index'))
            ->setNextUrl(route('roles.edit', $id))
            ->setMessage(trans('modules.acl::permissions.modified_success'));
    }

    /**
     * Return a correctly type casted permissions array
     * @param array $permissions
     * @return array
     */
    protected function cleanPermission($permissions)
    {
        if (!$permissions) {
            return [];
        }

        $cleanedPermissions = [];
        foreach ($permissions as $permissionName) {
            $cleanedPermissions[$permissionName] = true;
        }

        return $cleanedPermissions;
    }

    /**
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.acl::permissions.create_role'));

        return $formBuilder->create(RoleForm::class)->renderForm();
    }

    /**
     * @param RoleCreateRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(RoleCreateRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->roleRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $role = $this->roleRepository->createOrUpdate([
            'name'        => $request->input('name'),
            'slug'        => $this->roleRepository->createSlug($request->input('name'), 0),
            'permissions' => $this->cleanPermission($request->input('flags')),
            'description' => $request->input('description'),
            'is_default'  => $request->input('is_default'),
            'created_by'  => $request->user()->getKey(),
            'updated_by'  => $request->user()->getKey(),
        ]);

        return $response
            ->setPreviousUrl(route('roles.index'))
            ->setNextUrl(route('roles.edit', $role->id))
            ->setMessage(trans('modules.acl::permissions.create_success'));
    }

    /**
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getDuplicate($id, BaseHttpResponse $response)
    {
        $baseRole = $this->roleRepository->findOrFail($id);

        $role = $this->roleRepository->createOrUpdate([
            'name'        => $baseRole->name . ' (Duplicate)',
            'slug'        => $this->roleRepository->createSlug($baseRole->slug, 0),
            'permissions' => $baseRole->permissions,
            'description' => $baseRole->description,
            'created_by'  => $baseRole->created_by,
            'updated_by'  => $baseRole->updated_by,
        ]);

        return $response
            ->setPreviousUrl(route('roles.edit', $baseRole->id))
            ->setNextUrl(route('roles.edit', $role->id))
            ->setMessage(trans('modules.acl::permissions.duplicated_success'));
    }

    /**
     * @return array
     */
    public function getJson()
    {
        $pl = [];
        foreach ($this->roleRepository->all() as $role) {
            $pl[] = [
                'value' => $role->id,
                'text'  => $role->name,
            ];
        }

        return $pl;
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     */
    public function postAssignMember(Request $request, BaseHttpResponse $response)
    {
        $user = $this->userRepository->findOrFail($request->input('pk'));
        $role = $this->roleRepository->findOrFail($request->input('value'));

        $user->roles()->sync([$role->id]);

        event(new RoleAssignmentEvent($role, $user));

        return $response;
    }
}
