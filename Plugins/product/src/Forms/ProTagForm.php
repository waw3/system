<?php

namespace Modules\Plugins\Product\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Product\Http\Requests\ProTagRequest;
use Modules\Plugins\Product\Models\ProTag;
use Throwable;

class ProTagForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new ProTag)
            ->setValidatorClass(ProTagRequest::class)
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
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('modules.base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
