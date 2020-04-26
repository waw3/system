<?php

namespace Modules\Plugins\Product\Forms;

use Assets;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;

use Modules\Plugins\Product\Forms\Fields\ProCategoryMultiField;
use Modules\Plugins\Product\Http\Requests\ProductRequest;
use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\FeaturesInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Throwable;



class ProductForm extends FormAbstract
{


    /**
     * @var string
     */
    protected $template = 'modules.base::forms.form-tabs';

    protected $featuresRepository;

    /**
     * @return mixed|void
     * @throws Throwable
     */


    public function buildForm()
    {
        Assets::addScripts(['bootstrap-tagsinput', 'typeahead', 'datetimepicker','colorpicker'])
            ->addStyles(['bootstrap-tagsinput','colorpicker'])
            ->addScriptsDirectly('vendor/core/js/tags.js')
            ->addScriptsDirectly('vendor/core/plugins/product/js/features.js')
            ->addScriptsDirectly('vendor/core/libraries/bootstrap-datepicker/js/bootstrap-datepicker.min.js')
            ->addScriptsDirectly('vendor/core/plugins/product/js/colors.js')
            ->addStylesDirectly('vendor/core/plugins/product/css/features.css')
            ->addStylesDirectly('vendor/core/plugins/product/css/colors.css');



        $selectedProCategories = [];
        if ($this->getModel()) {
            $selectedProCategories = $this->getModel()->procategories()->pluck('pro_category_id')->all();
        }

        if (empty($selectedProCategories)) {
            $selectedProCategories = app(ProCategoryInterface::class)
                ->getModel()
                ->where('is_default', 1)
                ->pluck('id')
                ->all();
        }


        $protags = null;

        if ($this->getModel()) {
            $protags = $this->getModel()->protags()->pluck('name')->all();
            $protags = implode(',', $protags);
        }

        if (!$this->formHelper->hasCustomField('procategoryMulti')) {
            $this->formHelper->addCustomField('procategoryMulti', ProCategoryMultiField::class);
        }


        $selectedFeatures = [];
        if ($this->getModel()) {
            $selectedFeatures = $this->getModel()->features()->pluck('features_id')->all();

        }

        $features = app(FeaturesInterface::class)->allBy([], [], ['features.id', 'features.name']);






        $this
            ->setupModel(new Product)
            ->setValidatorClass(ProductRequest::class)
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

            ->add('is_featured', 'onOff', [
                'label'         => trans('modules.base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('content', 'editor', [
                'label'      => trans('modules.base::forms.content'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'            => 4,
                    'placeholder'     => trans('modules.base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('modules.base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('format_type', 'customRadio', [
                'label'      => trans('modules.plugins.product::products.form.format_type'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_product_formats(true),
            ])

            ->add('procategories[]', 'procategoryMulti', [
                'label'      => trans('modules.plugins.product::products.form.procategories'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_procategories_with_children(),
                'value'      => old('procategories', $selectedProCategories),
            ])

            ->add('imagedl', 'mediaImage', [
                'label'      => trans('modules.base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])


            ->add('pricecost', 'text', [
                'label'      => trans('modules.plugins.product::sell.form.pricecost'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('pricesell', 'text', [
                'label'      => trans('modules.plugins.product::sell.form.pricesell'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])

            /*->add('pricetime', 'date', [
                'label'      => trans('modules.plugins.product::sell.form.pricetime'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])*/

            ->add('pricetime', 'text', [
                'label'      => trans('modules.plugins.product::sell.form.pricetime'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'      => trans('modules.plugins.product::sell.form.change'),
                    'class'            => 'form-control datepicker',
                    'data-date-format' => mconfig('base.config.date_format.js.date'),
                ],
            ])


            ->addMetaBoxes([

               'image'    => [
                    'title'    => trans('modules.plugins.product::features.form.images'),
                    'content'  => view('modules.plugins.product::features.form-images',
                        ['object' => $this->getModel()])->render(),
                    'priority' => 0,
                ],
                'features' => [
                    'title'    => trans('modules.plugins.product::features.form.features'),
                    'content'  => view('modules.plugins.product::features.form-features',
                        compact('selectedFeatures', 'features'))->render(),
                    'priority' => 1,
                ],
                'color'            => [
                    'title'   => trans('modules.plugins.product::features.form.colors'),
                    'content' => view('modules.plugins.product::colors.form-colors',
                        ['object'           => $this->getModel()])->render(),
                    'priority' => 2,
                ],
                'size'            => [
                    'title'   => trans('modules.plugins.product::features.form.sizes'),
                    'content' => view('modules.plugins.product::sizes.form-sizes',
                        ['object'           => $this->getModel()])->render(),
                    'priority' => 3,
                    'src'      => [
                        'local' => '/vendor/core/libraries/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
                    ],
                ],
                'timesale'            => [
                    'title'   => trans('modules.plugins.product::sell.form.timesale'),
                    'content' => view('modules.plugins.product::timesale.form-timesales',
                        ['object'           => $this->getModel()])->render(),
                    'priority' => 4,

                ],
            ])


            ->setBreakFieldPoint('status');
    }
}
