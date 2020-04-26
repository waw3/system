<?php

namespace Modules\Plugins\Vendor\Forms;

use Assets;
use Modules\Base\Forms\FormAbstract;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\RealEstate\Repositories\Interfaces\CurrencyInterface;
use Modules\Plugins\Vendor\Http\Requests\PackageRequest;
use Modules\Plugins\Vendor\Models\Package;

class PackageForm extends FormAbstract
{
    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;

    /**
     * PackageForm constructor.
     * @param CurrencyInterface $currencyRepository
     */
    public function __construct(CurrencyInterface $currencyRepository)
    {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {

        Assets::addScripts(['input-mask']);

        $currencies = $this->currencyRepository->pluck('currencies.title', 'currencies.id');

        $this
            ->setupModel(new Package)
            ->setValidatorClass(PackageRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('price', 'text', [
                'label'      => trans('modules.plugins.vendor::package.price'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                'attr' => [
                    'id' => 'price-number',
                    'placeholder' => trans('modules.plugins.vendor::package.price'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('usd_price', 'text', [
                'label' => 'Manual Currency exchange to USD',
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                'attr' => [
                    'id' => 'usd_price-number',
                    'placeholder' => trans('modules.plugins.vendor::package.usd_price'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('currency_id', 'customSelect', [
                'label'      => trans('modules.plugins.vendor::package.currency'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => $currencies,
            ])
            ->add('rowClose1', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen2', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('percent_save', 'text', [
                'label'      => trans('modules.plugins.vendor::package.percent_save'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
                'attr'       => [
                    'id'          => 'percent-save-number',
                    'placeholder' => trans('modules.plugins.vendor::package.percent_save'),
                    'class'       => 'form-control input-mask-number',
                ],
            ])
            ->add('number_of_listings', 'text', [
                'label' => trans('modules.plugins.vendor::package.number_of_listings'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'attr' => [
                    'id' => 'price-number',
                    'placeholder' => trans('modules.plugins.vendor::package.number_of_listings'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('account_limit', 'text', [
                'label' => trans('modules.plugins.vendor::package.account_limit'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'attr' => [
                    'id' => 'percent-save-number',
                    'placeholder' => trans('modules.plugins.vendor::package.account_limit_placeholder'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('rowClose2', 'html', [
                'html' => '</div>',
            ])
            ->add('is_default', 'onOff', [
                'label'         => trans('modules.base::forms.is_default'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('order', 'number', [
                'label'         => trans('modules.base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'placeholder' => trans('modules.base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
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
