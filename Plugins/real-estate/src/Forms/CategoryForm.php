<?php

namespace Modules\Plugins\RealEstate\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\RealEstate\Http\Requests\CategoryRequest;
use Modules\Plugins\RealEstate\Models\Category;
use Throwable;

class CategoryForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Category)
            ->setValidatorClass(CategoryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('order', 'number', [
                'label'         => trans('modules.base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'placeholder' => trans('modules.base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('is_default', 'onOff', [
                'label'         => trans('modules.base::forms.is_default'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
