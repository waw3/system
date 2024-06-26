<?php

namespace Modules\Acl\Http\Controllers\Auth;

use Assets, BaseController;
use Modules\Acl\Repositories\Interfaces\ActivationInterface;
use Modules\Acl\Repositories\Interfaces\UserInterface;
use BaseHttpResponse;
use Illuminate\Contracts\View\Factory;
use Modules\Acl\Traits\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * @var BaseHttpResponse
     */
    protected $response;

    /**
     * Create a new controller instance.
     *
     * @param BaseHttpResponse $response
     */
    public function __construct(BaseHttpResponse $response)
    {
        $this->middleware('guest', ['except' => 'logout']);

        $this->redirectTo = mconfig('base.config.admin_dir');
        $this->response = $response;
    }

    /**
     * @return Factory|View
     */
    public function showLoginForm()
    {
        page_title()->setTitle(trans('modules.acl::auth.login_title'));

        Assets::addScripts(['jquery-validation'])
            ->addScriptsDirectly('vendor/core/js/login.js')
            ->removeStyles([
                'select2',
                'fancybox',
                'spectrum',
                'simple-line-icons',
                'custom-scrollbar',
                'datepicker',
            ])
            ->removeScripts([
                'select2',
                'fancybox',
                'cookie',
            ]);

        return view('modules.acl::auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return BaseHttpResponse|Response
     * @throws ValidationException
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        $user = app(UserInterface::class)->getFirstBy(['username' => $request->input($this->username())]);
        if (!empty($user)) {
            if (!app(ActivationInterface::class)->completed($user)) {
                return $this->response
                    ->setError()
                    ->setMessage(trans('modules.acl::auth.login.not_active'));
            }
        }

        if ($this->attemptLogin($request)) {
            app(UserInterface::class)->update(['id' => $user->id], ['last_login' => now(config('app.timezone'))]);
            if (!session()->has('url.intended')) {
                session()->flash('url.intended', url()->current());
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @return string
     *
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return BaseHttpResponse
     */
    public function logout(Request $request)
    {
        do_action('action_after_logout_system', $request, $request->user());

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->response
            ->setNextUrl(route('access.login'))
            ->setMessage(trans('modules.acl::auth.login.logout_success'));
    }
}
