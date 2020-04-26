<?php

namespace Modules\Plugins\RealEstate\Http\Controllers;

use Assets;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\RealEstate\Http\Requests\UpdateSettingsRequest;
use Modules\Plugins\RealEstate\Repositories\Interfaces\CurrencyInterface;
use Modules\Plugins\RealEstate\Services\StoreCurrenciesService;
use Modules\Setting\Supports\SettingStore;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class RealEstateController extends BaseController
{

    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;

    /**
     * RealEstateController constructor.
     * @param CurrencyInterface $currencyRepository
     */
    public function __construct(CurrencyInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @return Factory|View
     */
    public function getSettings()
    {
        page_title()->setTitle(trans('modules.plugins.real-estate::real-estate.settings'));

        Assets::addScripts(['jquery-ui'])
            ->addScriptsDirectly([
                'vendor/core/plugins/real-estate/js/currencies.js',
            ])
            ->addStylesDirectly([
                'vendor/core/plugins/real-estate/css/currencies.css',
            ]);

        $currencies = $this->currencyRepository
            ->getAllCurrencies()
            ->toArray();

        return view('modules.plugins.real-estate::settings.index', compact('currencies'));
    }

    /**
     * @param UpdateSettingsRequest $request
     * @param BaseHttpResponse $response
     * @param StoreCurrenciesService $service
     * @param SettingStore $settingStore
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function postSettings(
        UpdateSettingsRequest $request,
        BaseHttpResponse $response,
        StoreCurrenciesService $service,
        SettingStore $settingStore
    ) {
        foreach ($request->except(['_token', 'currencies', 'deleted_currencies']) as $settingKey => $settingValue) {
            $settingStore->set($settingKey, $settingValue);
        }

        $settingStore->save();
        $currencies = json_decode($request->input('currencies'), true) ?: [];
        $deletedCurrencies = json_decode($request->input('deleted_currencies', []), true) ?: [];

        $service->execute($currencies, $deletedCurrencies);

        return $response
            ->setNextUrl(route('real-estate.settings'))
            ->setMessage(trans('modules.base::notices.update_success_message'));
    }
}
