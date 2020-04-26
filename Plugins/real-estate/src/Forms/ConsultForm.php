<?php

namespace Modules\Plugins\RealEstate\Forms;

use Modules\Plugins\RealEstate\Models\Consult;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\RealEstate\Enums\ConsultStatusEnum;
use Modules\Plugins\RealEstate\Http\Requests\ConsultRequest;
use Throwable;

class ConsultForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Consult)
            ->setValidatorClass(ConsultRequest::class)
            ->withCustomFields()
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => ConsultStatusEnum::labels(),
            ])
            ->addMetaBoxes([
                'information' => [
                    'title'      => trans('modules.plugins.real-estate::consult.consult_information'),
                    'content'    => view('modules.plugins.real-estate::info', ['consult' => $this->getModel()])->render(),
                    'attributes' => [
                        'style' => 'margin-top: 0',
                    ],
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
