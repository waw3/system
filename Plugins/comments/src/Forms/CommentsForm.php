<?php

namespace Modules\Plugins\Comments\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Comments\Http\Requests\CommentsRequest;
use Modules\Plugins\Comments\Models\Comments;

class CommentsForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Comments)
            ->setValidatorClass(CommentsRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('dob', 'text', [
                'label'      => 'Date of birth',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'data-counter' => 10,
                    'class' => 'form-control datepicker',
                    'data-date-format' => mconfig('base.config.date_format.js.date')
                ],
            ])
            ->add('content', 'editor', [
                'label'      => trans('modules.base::forms.content'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'row' => 4,
                    'placeholder'  => trans('modules.base::forms.description_placeholder'),
                    'with-short-code' => true
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('modules.base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->setBreakFieldPoint('status');
    }
}
