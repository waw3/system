<?php

namespace Modules\Plugins\RealEstate\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\RealEstate\Http\Requests\FeatureRequest;
use Modules\Plugins\RealEstate\Models\Feature;
use Throwable;

class FeatureForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Feature)
            ->setValidatorClass(FeatureRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.plugins.real-estate::feature.form.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.plugins.real-estate::feature.form.name'),
                    'data-counter' => 120,
                ],
            ]);
    }
}
