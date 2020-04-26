<?php

namespace Modules\Plugins\Member\Forms;

use Assets;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Member\Http\Requests\MemberCreateRequest;
use Modules\Plugins\Member\Models\Member;

class MemberForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {
        Assets::addScriptsDirectly(['/vendor/core/plugins/member/js/member-admin.js']);

        $this
            ->setupModel(new Member)
            ->setValidatorClass(MemberCreateRequest::class)
            ->withCustomFields()
            ->add('first_name', 'text', [
                'label'      => __('First Name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('last_name', 'text', [
                'label'      => __('Last Name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('email', 'text', [
                'label'      => trans('modules.plugins.member::member.form.email'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('Ex: example@gmail.com'),
                    'data-counter' => 60,
                ],
            ])
            ->add('is_change_password', 'checkbox', [
                'label'      => trans('modules.plugins.member::member.form.change_password'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class' => 'hrv-checkbox',
                ],
                'value'      => 1,
            ])
            ->add('password', 'password', [
                'label'      => trans('modules.plugins.member::member.form.password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ($this->getModel()->id ? ' hidden' : null),
                ],
            ])
            ->add('password_confirmation', 'password', [
                'label'      => trans('modules.plugins.member::member.form.password_confirmation'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ($this->getModel()->id ? ' hidden' : null),
                ],
            ]);
    }
}
