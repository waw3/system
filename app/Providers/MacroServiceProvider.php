<?php namespace App\Providers;

use Response, Route, File, Exception, Html, Form;
use Illuminate\Support\{Collection, HtmlString, ViewErrorBag};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Builder;
use Collective\Html\HtmlServiceProvider;;
use App\Macros\Helpers\FormMacros;


/**
 * Class MacroServiceProvider.
 */
class MacroServiceProvider extends HtmlServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Macros must be loaded after the HTMLServiceProvider's
        // register method is called. Otherwise, csrf tokens
        // will not be generated
        parent::register();

//         dd('start');

        $this->app->singleton('form', function ($app) {
            $form = new FormMacros($app['html'], $app['url'], $app['view'], $app['session.store']->token());
            return $form->setSessionStore($app['session.store']);
        });

        // Html Macros
        $htmlMacros = File::getRequire(__DIR__.'/../Macros/HtmlMacros.php');
        collect($htmlMacros)->each(function ($item, $key) {
            if (Html::hasMacro($key) === false) {
                Html::macro($key, $item);
            }
        });

        // Request Macros
        $requestMacros = File::getRequire(__DIR__.'/../Macros/RequestMacros.php');
        collect($requestMacros)->each(function ($item, $key) {
            if (Request::hasMacro($key) === false) {
                Request::macro($key, $item);
            }
        });

        // Route Macros
        $routeMacros = File::getRequire(__DIR__.'/../Macros/RouteMacros.php');
        collect($routeMacros)->each(function ($item, $key) {


            if($key=='permission'){
                dd($key);
            }

            if (! Route::hasMacro($key)) {
                Route::macro($key, $item);
            }
        });

        // Response Macros
        $responseMacros = File::getRequire(__DIR__.'/../Macros/ResponseMacros.php');
        collect($responseMacros)->each(function ($item, $key) {
            Response::macro($key, $item);
        });

        // Form Macros
        $formMacros = File::getRequire(__DIR__.'/../Macros/FormMacros.php');
        collect($formMacros)->each(function ($item, $key) {
            if (Form::hasMacro($key) === false) {
                Form::macro($key, $item);
            }
        });

        // Collection Macros
        $collectionMacros = File::getRequire(__DIR__.'/../Macros/CollectionMacros.php');
        collect($collectionMacros)->each(function ($item, $key) {
            if (Collection::hasMacro($key) === false) {
                Collection::macro($key, $item);
            }
        });

        // Blueprint Macros
        $blueprintMacros = File::getRequire(__DIR__.'/../Macros/BlueprintMacros.php');
        collect($blueprintMacros)->each(function ($item, $key) {
            if (Blueprint::hasMacro($key) === false) {
                Blueprint::macro($key, $item);
            }
        });

        // Eloquent Builder Macros
        $builderMacros = File::getRequire(__DIR__.'/../Macros/EloquentBuilderMacros.php');
        collect($builderMacros)->each(function ($item, $key) {
             Builder::macro($key, $item);
/*
            if (Builder::hasMacro($key) === false) {

            }
*/
        });

    }
}
