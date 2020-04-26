<?php

namespace Modules\Plugins\Gallery\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Gallery\Http\Requests\GalleryRequest;
use Modules\Plugins\Gallery\Models\Gallery;

class GalleryForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Gallery)
            ->setValidatorClass(GalleryRequest::class)
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
            ->add('order', 'number', [
                'label'         => trans('modules.base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'placeholder' => trans('modules.base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('modules.base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('modules.base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->setBreakFieldPoint('status');
    }
}
