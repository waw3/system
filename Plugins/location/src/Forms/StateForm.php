<?php

namespace Modules\Plugins\Location\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Location\Repositories\Interfaces\CountryInterface;
use Modules\Plugins\Location\Http\Requests\StateRequest;
use Modules\Plugins\Location\Models\State;
use Throwable;

class StateForm extends FormAbstract
{

    /**
     * @var CountryInterface
     */
    protected $countryRepository;

    /**
     * StateForm constructor.
     * @param CountryInterface $countryRepository
     */
    public function __construct(CountryInterface $countryRepository)
    {
        parent::__construct();

        $this->countryRepository = $countryRepository;
    }

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {

        $countries = $this->countryRepository->pluck('countries.name', 'countries.id');

        $this
            ->setupModel(new State)
            ->setValidatorClass(StateRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('abbreviation', 'text', [
                'label' => __('Abbreviation'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => __('E.g: CA'),
                    'data-counter' => 2,
                ],
            ])
            ->add('country_id', 'customSelect', [
                'label'      => trans('modules.plugins.location::state.country'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => [0 => trans('modules.plugins.location::state.select_country')] + $countries,
            ])
            ->add('order', 'number', [
                'label'         => trans('modules.base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'placeholder' => trans('modules.base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('is_default', 'onOff', [
                'label'         => trans('modules.base::forms.is_default'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
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
