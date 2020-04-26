<?php

namespace Modules\Acl\Forms;

use Assets;
use Modules\Acl\Http\Requests\RoleCreateRequest;
use Modules\Acl\Models\Role;
use Modules\Base\Forms\FormAbstract;
use Illuminate\Support\Arr;
use Throwable;

class RoleForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        Assets::addStyles(['jquery-ui', 'jqueryTree'])
            ->addScripts(['jquery-ui', 'jqueryTree'])
            ->addScriptsDirectly('vendor/core/js/role.js');

        $flags = $this->getAvailablePermissions();
        $children = $this->getPermissionTree($flags);
        $active = [];

        if ($this->getModel()) {
            $active = array_keys($this->getModel()->permissions);
        }

        $this
            ->setupModel(new Role)
            ->setValidatorClass(RoleCreateRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'textarea', [
                'label'      => trans('modules.base::forms.description'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('modules.base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('is_default', 'onOff', [
                'label'      => trans('modules.base::forms.is_default'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->addMetaBoxes([
                'permissions' => [
                    'title'   => trans('modules.acl::permissions.permission_flags'),
                    'content' => view('modules.acl::roles.permissions', compact('active', 'flags', 'children'))->render(),
                ],
            ])
            ->setActionButtons(view('modules.acl::roles.actions', ['role' => $this->getModel()])->render());
    }

    /**
     * @return array
     */
    protected function getAvailablePermissions(): array
    {
        $permissions = [];

        $configuration = config(strtolower('cms-permissions'));
        if (!empty($configuration)) {
            foreach ($configuration as $config) {
                $permissions[$config['flag']] = $config;
            }
        }

        $types = ['Modules', 'Plugins'];

        foreach ($types as $type) {
            $permissions = array_merge($permissions, $this->getAvailablePermissionForEachType($type));
        }

        return $permissions;
    }

    /**
     * @param string $type
     * @return array
     */
    protected function getAvailablePermissionForEachType($type)
    {
        $permissions = [];



        foreach (scan_folder(base_path($type)) as $module) {

            if($type == 'Plugins')
                $type = 'Modules.Plugins';

            $configuration = config(strtolower($type . '.' . $module . '.permissions'));
            if (!empty($configuration)) {
                foreach ($configuration as $config) {
                    $permissions[$config['flag']] = $config;
                }
            }
        }

        return $permissions;
    }

    /**
     * @param array $permissions
     * @return array
     */
    protected function getPermissionTree($permissions): array
    {
        $sortedFlag = $permissions;
        sort($sortedFlag);
        $children['root'] = $this->getChildren('root', $sortedFlag);

        foreach (array_keys($permissions) as $key) {
            $childrenReturned = $this->getChildren($key, $permissions);
            if (count($childrenReturned) > 0) {
                $children[$key] = $childrenReturned;
            }
        }

        return $children;
    }

    /**
     * @param int $parentId
     * @param array $allFlags
     * @return mixed
     */
    protected function getChildren($parentId, $allFlags)
    {
        $newFlagArray = [];
        foreach ($allFlags as $flagDetails) {
            if (Arr::get($flagDetails, 'parent_flag', 'root') == $parentId) {
                $newFlagArray[] = $flagDetails['flag'];
            }
        }
        return $newFlagArray;
    }
}
