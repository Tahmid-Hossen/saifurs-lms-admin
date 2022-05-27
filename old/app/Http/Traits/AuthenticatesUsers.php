<?php

namespace App\Http\Traits;

use App\Services\UtilityService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return Application|Factory|View|Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return RedirectResponse|void|Response
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

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        if ($request->get('request_form') == 'web') {
            if (UtilityService::$login_method == 0):
                $this->validate($request, [$this->email() => 'required', 'password' => 'required',]);
            elseif (UtilityService::$login_method == 1):
                $this->validate($request, [$this->username() => 'required', 'password' => 'required',]);
            else:
                $this->validate($request, [$this->mobileNumber() => 'required', 'password' => 'required',]);
            endif;
        } else {
            if ($request->has('email')):
                $this->validate($request, [$this->email() => 'required', 'password' => 'required',]);
            elseif ($request->has('username')):
                $this->validate($request, [$this->username() => 'required', 'password' => 'required',]);
            elseif ($request->has('mobile_number ')):
                $this->validate($request, [$this->mobileNumber() => 'required', 'password' => 'required',]);
            endif;
        }
    }

    /**
     * Get the login email to be used by the controller.
     *
     * @return string
     */
    public function email()
    {
        return 'email';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the login mobile number to be used by the controller.
     *
     * @return string
     */
    public function mobileNumber()
    {
        return 'mobile_number';
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        if ($request->get('request_form') == 'web') {
            if (UtilityService::$login_method == 0):
                return $request->only($this->email(), 'password');
            elseif (UtilityService::$login_method == 1):
                return $request->only($this->username(), 'password');
            else:
                return $request->only($this->mobileNumber(), 'password');
            endif;
        } else {
            if ($request->has('email')):
                return $request->only($this->email(), 'password');
            elseif ($request->has('username')):
                return $request->only($this->username(), 'password');
            elseif ($request->has('mobile_number ')):
                return $request->only($this->mobileNumber(), 'password');
            endif;
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        if ($request->get('request_form') == 'web') {
            if (UtilityService::$login_method == 0):
                $credentials = $request->only($this->email(), 'password');
            elseif (UtilityService::$login_method == 1):
                $credentials = $request->only($this->username(), 'password');
            else:
                $credentials = $request->only($this->mobileNumber(), 'password');
            endif;
        } else {
            if ($request->has('email')):
                $credentials = $request->only($this->email(), 'password');
            elseif ($request->has('username')):
                $credentials = $request->only($this->username(), 'password');
            elseif ($request->has('mobile_number ')):
                $credentials = $request->only($this->mobileNumber(), 'password');
            endif;
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->get('request_form') == 'web') {
            if (UtilityService::$login_method == 0):
                return redirect()->back()
                    ->withInput($request->only($this->email(), 'remember'))
                    ->withErrors([$this->email() => Lang::get('auth.failed')]);
            elseif (UtilityService::$login_method == 1):
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([$this->username() => Lang::get('auth.failed')]);
            else:
                return redirect()->back()
                    ->withInput($request->only($this->mobileNumber(), 'remember'))
                    ->withErrors([$this->mobileNumber() => Lang::get('auth.failed')]);
            endif;
        } else {
            if ($request->has('email')):
                return redirect()->back()
                    ->withInput($request->only($this->email(), 'remember'))
                    ->withErrors([$this->email() => Lang::get('auth.failed')]);
            elseif ($request->has('username')):
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([$this->username() => Lang::get('auth.failed')]);
            elseif ($request->has('mobile_number ')):
                return redirect()->back()
                    ->withInput($request->only($this->mobileNumber(), 'remember'))
                    ->withErrors([$this->mobileNumber() => Lang::get('auth.failed')]);
            endif;
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}
