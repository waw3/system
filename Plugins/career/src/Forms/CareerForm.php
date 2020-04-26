<?php

namespace Modules\Plugins\Career\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Career\Http\Requests\CareerRequest;
use Modules\Plugins\Career\Models\Career;

class CareerForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Career)
            ->setValidatorClass(CareerRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('location', 'text', [
                'label' => trans('modules.plugins.career::career.location'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 120,
                ],
            ])
            ->add('salary', 'text', [
                'label' => trans('modules.plugins.career::career.salary'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'editor', [
                'label'      => trans('modules.base::forms.description'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'rows'            => 4,
                    'placeholder'     => trans('modules.base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
            ->add('status', 'select', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
