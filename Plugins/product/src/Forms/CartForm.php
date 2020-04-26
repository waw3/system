<?php

namespace Modules\Plugins\Product\Forms;




use Assets;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Plugins\Product\Models\Orderstatus;
use Modules\Plugins\Product\Http\Requests\OrderstatusRequest;
use Modules\Plugins\Product\Http\Requests\CartRequest;
use Modules\Plugins\Product\Models\Cart;
use Modules\Plugins\Product\Forms\Fields\ProCategoryMultiField;
use Modules\Plugins\Product\Http\Requests\ProductRequest;
use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\FeaturesInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Modules\Plugins\Product\Repositories\Interfaces\OrderstatusInterface;
use Modules\Plugins\Product\Repositories\Interfaces\PaymentInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ShippingInterface;
use Throwable;


class CartForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {

        Assets::addScripts(['bootstrap-tagsinput', 'typeahead', 'datetimepicker','colorpicker'])
            ->addStyles(['bootstrap-tagsinput','colorpicker'])
            ->addScriptsDirectly('vendor/core/plugins/product/js/features.js')
            ->addScriptsDirectly('vendor/core/libraries/bootstrap-datepicker/js/bootstrap-datepicker.min.js')
            ->addScriptsDirectly('vendor/core/plugins/product/js/colors.js')
            ->addStylesDirectly('vendor/core/plugins/product/css/features.css')
            ->addStylesDirectly('vendor/core/plugins/product/css/colors.css');


        /*Status Oder*/
        $selectedOrderstatus = [];
        if ($this->getModel()) {
            $selectedOrderstatus = $this->getModel()->orderstatus()->pluck('orderstatuses_id')->all();
        }

        $orderstatus = app(OrderstatusInterface::class)->allBy([], [], ['orderstatuses.id', 'orderstatuses.name']);
        /*Status Paymen*/
        $selectedPayment = [];
        if ($this->getModel()) {
            $selectedPayment = $this->getModel()->payment()->pluck('payments_id')->all();
        }

        $payments = app(PaymentInterface::class)->allBy([], [], ['payments.id', 'payments.name']);


        /*Status Shipping*/
        $selectedShipping = [];
        if ($this->getModel()) {
            $selectedShipping = $this->getModel()->shipping()->pluck('shippings_id')->all();
        }

        $shippings = app(ShippingInterface::class)->allBy([], [], ['shippings.id', 'shippings.name']);



        $products = app(ProductInterface::class)->allBy([], [], ['products.id', 'products.name']);


        $this
            ->setupModel(new Cart)
            ->setValidatorClass(CartRequest::class)
            ->withCustomFields()
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('address', 'text', [
                'label'      => trans('modules.base::forms.address'),
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('email', 'text', [
                'label'      => trans('modules.base::forms.email'),
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('phone', 'text', [
                'label'      => trans('modules.base::forms.phone'),
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('rowClose1', 'html', [
                'html' => '</div>',
            ])

            ->add('rowOpen2', 'html', [
                'html' => '<div class="row">',
            ])
            ->addMetaBoxes([
                    'product'            => [
                        'title'   => trans('Product'),
                        'content' => view('modules.plugins.product::products.form-products',
                            [
                                'object'   => $this->getModel(),
                                'products' =>   $products,
                            ])->render(),
                        'priority' => 0,
                    ],
                ])
             ->addMetaBoxes([

                'orderstatuses' => [
                    'title'    => trans('modules.plugins.product::orderstatus.form.status'),
                    'content'  => view('modules.plugins.product::orderstatus.form-orderstatus',
                        compact(['selectedOrderstatus', 'orderstatus'],['selectedPayment', 'payments'],['selectedShipping', 'shippings']))->render(),
                    'priority' => 1,

                ],
                /*'orderstatuses' => [
                    'title'    => trans('modules.plugins.product::orderstatus.form.orderstatus'),
                    'content'  => view('modules.plugins.product::orderstatus.form-orderstatus',
                        compact(['selectedOrderstatus', 'orderstatus']))->render(),
                    'priority' => 1,

                ],
                'payments' => [
                    'title'    => trans('modules.plugins.product::payment.form.paymentstatus'),
                    'content'  => view('modules.plugins.product::payments.form-payments',
                        compact('selectedPayment', 'payments'))->render(),
                    'priority' => 2,

                ],
                'shippings' => [
                    'title'    => trans('modules.plugins.product::shipping.form.shippingstatus'),
                    'content'  => view('modules.plugins.product::shippings.form-shippings',
                        compact('selectedShipping', 'shippings'))->render(),
                    'priority' => 3,

                ],*/
            ])




            ->add('rowClose2', 'html', [
                'html' => '</div>',
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
