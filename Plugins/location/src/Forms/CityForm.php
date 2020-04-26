<?php

namespace Modules\Plugins\Location\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Location\Http\Requests\CityRequest;
use Modules\Plugins\Location\Models\City;
use Modules\Plugins\Location\Repositories\Interfaces\CountryInterface;
use Modules\Plugins\Location\Repositories\Interfaces\StateInterface;
use Throwable;

class CityForm extends FormAbstract
{

    /**
     * @var CountryInterface
     */
    protected $countryRepository;

    /**
     * @var StateInterface
     */
    protected $stateRepository;

    /**
     * StateForm constructor.
     * @param CountryInterface $countryRepository
     * @param StateInterface $stateRepository
     */
    public function __construct(CountryInterface $countryRepository, StateInterface $stateRepository)
    {
        parent::__construct();

        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
    }

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $countries = $this->countryRepository->pluck('countries.name', 'countries.id');
        $states = $this->stateRepository->pluck('states.name', 'states.id');

        $this
            ->setupModel(new City)
            ->setValidatorClass(CityRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('modules.base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('slug', 'text', [
                'label'      => trans('modules.plugins.location::city.state'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('modules.plugins.location::city.state'),
                    'data-counter' => 120,
                ],
            ])
            ->add('state_id', 'customSelect', [
                'label'      => trans('modules.plugins.location::city.state'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => [0 => trans('modules.plugins.location::city.select_state')] + $states,
            ])
            ->add('country_id', 'customSelect', [
                'label'      => trans('modules.plugins.location::city.country'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => [0 => trans('modules.plugins.location::city.select_country')] + $countries,
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('modules.base::forms.is_featured'),
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
            ->add('image', 'mediaImage', [
                'label'      => trans('modules.base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->setBreakFieldPoint('status');
    }
}
