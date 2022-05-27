<?php

namespace App\Http\Controllers\Auth;

use App\Events\ApiUserLoginEvent;
use App\Events\ApiUserLogoutEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserLoggedInNotification;
use App\Providers\RouteServiceProvider;
use App\Services\Backend\User\UserService;
use App\Services\PushNotificationService;
use App\Services\ShortMessageService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use UserAgentParser\Exception\NoResultFoundException;
use UserAgentParser\Exception\PackageNotLoadedException;

class LoginController extends Controller
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
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var PushNotificationService
     */
    private $pushNotificationService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     * @param PushNotificationService $pushNotificationService
     */
    public function __construct(UserService $userService, PushNotificationService $pushNotificationService)
    {
        Session::put('backUrl', url()->previous());
        $this->middleware('guest')->except('logout');
        $this->userService = $userService;
        $this->pushNotificationService = $pushNotificationService;
    }

    /**
     * @return RedirectResponse
     */
    public function logout()
    {
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        ApiUserLogoutEvent::dispatch(Auth::user());
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request)
    {
        $request['user_ip'] = $request->has('user_ip') ? $request->input('user_ip') : $request->ip();
        $loginMethod = array();
        $wrong_pin_password = 0;
        $is_wrong_pin_password = false;
        $loginMethod['status'] = Constants::$user_active_status;

        /**
         * @var boolean
         */
        $remember_me = $request->has('remember');

        if (UtilityService::$login_method == 0):
            $loginMethod = array_merge(['email' => $request->email, 'password' => $request->password], $loginMethod);

        elseif (UtilityService::$login_method == 1):
            $loginMethod = array_merge(['username' => $request->username, 'password' => $request->password], $loginMethod);

        elseif (UtilityService::$login_method == 2):
            $loginMethod = array_merge(['mobile_number' => $request->mobile_number, 'password' => $request->password], $loginMethod);
        endif;

        //$request['user'] = $user = $this->userService->getUserByMobile($loginMethod);
        $request['user'] = $suspiciousUser = $this->userService->allUsers($loginMethod)->first();
        //->first();

        $old_wrong_password = isset($suspiciousUser->wrong_password) ? $suspiciousUser->wrong_password : 0;
        $wrong_pin_password = 0;
        //Wrong PIN
        $is_wrong_pin_password = true;

        //$password_retry_limit = SystemSetting::where('system_setting_variable', 'password_retry_limit')->first();
        $password_retry_limit = 5;
        if (auth()->attempt($loginMethod, $remember_me)) {
            /**
             * @var User $authenticateUser
             */
            $authenticateUser = Auth::user();

            /**
             * Permission Control
             */
            if ($authenticateUser->can('backend.signin')):

                \DB::table('oauth_access_tokens')->where('user_id', '=', $authenticateUser->id)->update(['revoked' => 1]);
                $request['user'] = $data['user'] = $authenticateUser;

                /*session()->put('locale', $user->default_language);
                session()->put('default_currency', $user->default_currency);
                session()->put('default_country_id', $user->default_country_id);*/

                session()->put('role_id', $authenticateUser->roles[0]->id);
                $data['message'] = 'Authorised';
                $data['token'] = $authenticateUser->createToken('alesha-tech-lms')->accessToken;

                session()->put('previous_token', $data['token']);

                $data['status'] = true;
                $request['user_login_status'] = 'logged in';
                $data['preview_url'] = session()->get('backUrl');
                //$jsonReturn = response()->json($data,200);
                $message = $request['user_login_status'];
                $errorStatus = 'success';
                $route = 'dashboard';
                $is_wrong_pin_password = false;
                ApiUserLoginEvent::dispatch(Auth::user());
                return redirect()->route('dashboard');

            else:
                Auth::logout();
                Session::flush();
                Session::regenerate();
                $request['user_login_status'] = 'not permitted';
                $message = $request['user_login_status'];
                //$jsonReturn = response()->json(['status' => false, 'message'=>'Unauthorised! You are not permitted to login this site!):'],200);
                $errorStatus = 'error';
                $route = 'login';
                $is_wrong_pin_password = false;
                flash('Unauthorised! You are not permitted to login this site!')->error();
                return redirect()->route('login');
            endif;
        } else {
            $loginMethod['status'] = '';

            /*            $request['user'] = $user = $this->userService->allUsers($loginMethod)->first();
                        $old_wrong_password = isset($user->wrong_password) ? $user->wrong_password : 0;
                        $password_retry_limit = 5;*/

            //Wrong PIN
            $is_wrong_pin_password = true;

            $request['user_login_status'] = 'You Entered Wrong PASSWORD!';
            $wrong_pin_password = 1 + $old_wrong_password;
            $message = 'Sorry, You entered wrong password! You already attempt ' . $wrong_pin_password . ' times out of ' . $password_retry_limit . ' .';
            //if($password_retry_limit->system_setting_value == $wrong_pin_password):
            if ($password_retry_limit == $wrong_pin_password):
                $message .= ' Please contacts support.';
            elseif ($wrong_pin_password > $password_retry_limit):
                $message = 'Sorry, Your Account is INACTIVE!. Please contact support!';
            endif;
            $errorStatus = 'error';
            //$jsonReturn = response()->json(['status' => false, 'message'=>$message],200);
            $route = 'login';
            //return redirect()->route('login');
        }

        if ($suspiciousUser instanceof User) {
            if (($wrong_pin_password > $old_wrong_password) && ($is_wrong_pin_password == true)):
                $suspiciousUser->wrong_password = $wrong_pin_password;
                if ($wrong_pin_password >= $password_retry_limit):
                    $suspiciousUser->status = Constants::$user_default_status;
                    $suspiciousUser->userDetails->user_details_status = Constants::$user_default_status;
                endif;
                $suspiciousUser->save();
            endif;
            $route = 'login';
            //return redirect()->route('login');
        }
        //return $jsonReturn;
        flash($message, $errorStatus);
        return redirect()->route($route);
    }

    /**
     *
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     * @return array|RedirectResponse
     */
    protected function credentials(Request $request)
    {
        try {
            if (UtilityService::$login_method == 0):
                $input = $request->only($this->email(), 'password');
            elseif (UtilityService::$login_method == 1):
                $input = $request->only($this->username(), 'password');
            else:
                $input = $request->only($this->mobileNumber(), 'password');
            endif;
            $input['status'] = Constants::$user_active_status;
            return $input;
        } catch (Exception $e) {
            return Redirect::to('/backend');
        }
    }
}
