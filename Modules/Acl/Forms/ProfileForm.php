<?php

namespace Modules\Acl\Forms;

use Modules\Acl\Http\Requests\UpdateProfileRequest;
use Modules\Acl\Models\User;
use Modules\Base\Forms\FormAbstract;
use Throwable;

class ProfileForm extends FormAbstract
{
    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new User)
            ->setFormOption('template', 'modules.base::forms.form-no-wrap')
            ->setFormOption('id', 'profile-form')
            ->setFormOption('class', 'row')
            ->setValidatorClass(UpdateProfileRequest::class)
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
            ->setActionButtons(view('modules.acl::users.profile.actions')->render());
    }
}
