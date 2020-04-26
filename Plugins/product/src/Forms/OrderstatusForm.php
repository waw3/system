<?php

namespace Modules\Plugins\Product\Forms;


use Assets;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Product\Models\Orderstatus;
use Modules\Plugins\Product\Http\Requests\OrderstatusRequest;
use Modules\Plugins\Product\Forms\Fields\ProCategoryMultiField;
use Modules\Plugins\Product\Http\Requests\ProductRequest;
use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\FeaturesInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Modules\Plugins\Product\Repositories\Interfaces\OrderstatusInterface;
use Throwable;

class OrderstatusForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {

      


        $this
            ->setupModel(new Orderstatus)
            ->setValidatorClass(OrderstatusRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
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
            ->setBreakFieldPoint('status');
    }
}
