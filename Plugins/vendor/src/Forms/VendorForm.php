<?php

namespace Modules\Plugins\Vendor\Forms;

use Assets;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Vendor\Http\Requests\VendorCreateRequest;
use Modules\Plugins\Vendor\Models\Vendor;
use Throwable;

class VendorForm extends FormAbstract
{

    /**
     * @var string
     */
    protected $template = 'modules.plugins.vendor::admin.form';

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        Assets::addStylesDirectly('vendor/core/plugins/vendor/css/account-admin.css')
            ->addScriptsDirectly(['/vendor/core/plugins/vendor/js/account-admin.js']);

        $this
            ->setupModel(new Vendor)
            ->setValidatorClass(VendorCreateRequest::class)
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
                'label'      => trans('modules.plugins.vendor::vendor.form.email'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => __('Ex: example@gmail.com'),
                    'data-counter' => 60,
                ],
            ])
            ->add('is_change_password', 'checkbox', [
                'label'      => trans('modules.plugins.vendor::vendor.form.change_password'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class' => 'hrv-checkbox',
                ],
                'value'      => 1,
            ])
            ->add('password', 'password', [
                'label'      => trans('modules.plugins.vendor::vendor.form.password'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ($this->getModel()->id ? ' hidden' : null),
                ],
            ])
            ->add('password_confirmation', 'password', [
                'label'      => trans('modules.plugins.vendor::vendor.form.password_confirmation'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 60,
                ],
                'wrapper'    => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ($this->getModel()->id ? ' hidden' : null),
                ],
            ]);

        if ($this->getModel()->id) {
            $this->addMetaBoxes([
                'credits' => [
                    'title'   => null,
                    'content' => view('modules.plugins.vendor::admin.credits', ['account' => $this->model, 'transactions' => $this->model->transactions()->orderBy('created_at', 'DESC')->get()])->render(),
                    'wrap'    => false,
                ],
            ]);
        }
    }
}
