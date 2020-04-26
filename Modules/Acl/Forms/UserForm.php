<?php

namespace Modules\Acl\Forms;

use Modules\Acl\Http\Requests\CreateUserRequest;
use Modules\Acl\Models\User;
use Modules\Acl\Repositories\Interfaces\RoleInterface;
use Modules\Base\Forms\FormAbstract;
use Throwable;

class UserForm extends FormAbstract
{
    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * UserForm constructor.
     * @param RoleInterface $roleRepository
     * @throws Throwable
     */
    public function __construct(RoleInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        parent::__construct();
    }

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $roles = $this->roleRepository->pluck('name', 'id');

        $defaultRole = $this->roleRepository->getFirstBy(['is_default' => 1]);

        $this
            ->setupModel(new User)
            ->setValidatorClass(CreateUserRequest::class)
            ->setWrapperClass('form-body row')
            ->withCustomFields()
            ->add('first_name', 'text', [
                'label'      => trans('modules.acl::users.info.first_name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 30,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
            ])
            ->add('last_name', 'text', [
                'label'      => trans('modules.acl::users.info.last_name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 30,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
            ])
            ->add('username', 'text', [
                'label'      => trans('modules.acl::users.username'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 30,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
            ])
            ->add('email', 'text', [
                'label'      => trans('modules.acl::users.email'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.acl::users.email_placeholder'),
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
            ])
            ->add('password', 'password', [
                'label'      => trans('modules.acl::users.password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
            ])
            ->add('password_confirmation', 'password', [
                'label'      => trans('modules.acl::users.password_confirmation'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
            ])
            ->add('role_id', 'customSelect', [
                'label'         => trans('modules.acl::users.role'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'class' => 'form-control roles-list',
                ],
                'choices'       => ['' => trans('modules.acl::users.select_role')] + $roles,
                'default_value' => $defaultRole ? $defaultRole->id : null,
                'wrapper'       => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-12',
                ],
            ]);
    }
}
