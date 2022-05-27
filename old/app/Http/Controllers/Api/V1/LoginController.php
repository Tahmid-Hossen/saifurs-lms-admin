<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\ApiUserLoginEvent;
use App\Events\ApiUserLogoutEvent;
use App\Http\Controllers\Controller;
use App\Http\Traits\AuthenticatesUsers;
use App\Models\User;
use App\Services\Backend\User\UserService;
use App\Services\PushNotificationService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    public function __construct(
        UserService             $userService,
        PushNotificationService $pushNotificationService
    )
    {
        $this->middleware('guest')->except('v1.api-logout');
        $this->userService = $userService;
        $this->pushNotificationService = $pushNotificationService;
    }

    /**
     *
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     * @return array|bool
     */
    protected function credentials(Request $request)
    {
        try {
            if ($request->get('request_form') == 'web') {
                if (UtilityService::$login_method == 0):
                    $input = $request->only($this->email(), 'password');
                elseif (UtilityService::$login_method == 1):
                    $input = $request->only($this->username(), 'password');
                else:
                    $input = $request->only($this->mobileNumber(), 'password');
                endif;
            } else {
                if ($request->has('email')):
                    $input = $request->only($this->email(), 'password');
                elseif ($request->has('username')):
                    $input = $request->only($this->username(), 'password');
                elseif ($request->has('mobile_number ')):
                    $input = $request->only($this->mobileNumber(), 'password');
                endif;
            }

            $input['active'] = Constants::$user_active_status;
            return $input;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        /**
         * @var User $authUser
         */
        $authUser = Auth::user();

        //TODO Logout Event Param Not Working
        //ApiUserLogoutEvent::dispatch($authUser);

        Auth::logout();
        Session::flush();
        $returnValue['message'] = 'Invalid Token';
        $returnValue['status'] = true;
        $returnValue['status_code'] = 401;
        return response()->json($returnValue, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request['user_ip'] = $request->has('user_ip') ? $request->input('user_ip') : $request->ip();
        $loginMethod = array();
        $wrong_pin_password = 0;
        $is_wrong_pin_password = false;
        $loginMethod['status'] = Constants::$user_active_status;

        /**
         * @var bool $remember_me
         */
        $remember_me = $request->has('remember');

        if ($request->get('request_form') == 'web') {

            if (UtilityService::$login_method == 0):
                $loginMethod = array_merge(['email' => $request->email, 'password' => $request->password], $loginMethod);

            elseif (UtilityService::$login_method == 1):
                $loginMethod = array_merge(['username' => $request->username, 'password' => $request->password], $loginMethod);

            elseif (UtilityService::$login_method == 2):
                $loginMethod = array_merge(['mobile_number' => $request->mobile_number, 'password' => $request->password], $loginMethod);
            endif;

        } else {

            if ($request->has('email') && !empty($request->email) && $request->email != '' && $request->email != 'null'):
                $loginMethod = array_merge(['email' => $request->email, 'password' => $request->password], $loginMethod);

            elseif ($request->has('username') && !empty($request->username) && $request->username != '' && $request->username != 'null'):
                $loginMethod = array_merge(['username' => $request->username, 'password' => $request->password], $loginMethod);

            elseif ($request->has('mobile_number') && !empty($request->mobile_number) && $request->mobile_number != '' && $request->mobile_number != 'null'):
                $loginMethod = array_merge(['mobile_number' => $request->mobile_number, 'password' => $request->password], $loginMethod);
            endif;
        }

        $request['user'] = $user = $this->userService->allUsers($loginMethod)->first();
        $old_wrong_password = $user->wrong_password ?? 0;
        $password_retry_limit = 5;
        if (Auth::attempt($loginMethod, $remember_me)) {
            \DB::table('oauth_access_tokens')->where('user_id', '=', $request['user']->id)->update(['revoked' => 1]);

            /**
             * @var User $user
             */
            $user = Auth::user();

            $request['user'] = $data['user'] = $user;
            $data['user_detail_photo'] = $data['user']->userDetails->user_detail_photo_full_link ?? null;
            $data['user']['userDetails']['state_name'] = $user->userDetails->state->state_name ?? null;
            $data['user']['userDetails']['city_name'] = $user->userDetails->city->city_name ?? null;
            $data['user']['userDetails']['shipping_state_name'] = $user->userDetails->ship_state->state_name ?? null;
            $data['user']['userDetails']['shipping_city_name'] = $user->userDetails->ship_city->city_name ?? null;

            $data['role_id'] = isset($user->roles[0]) ? $user->roles[0]->id : null;
            $data['role_name'] = isset($user->roles[0]) ? $user->roles[0]->name : null;
            $data['user']['userDetails']->makeHidden(['state', 'city', 'ship_state', 'ship_city']);
            $data['user'] = collect($user)->forget(['roles', 'state'])->all();
            if (in_array($data['role_id'], array(3))):
                $request['user_login_status'] = 'This user are not login';
                //$request['user_blocked_ip'] = 'ACTIVE';
                $data['status'] = false;
                $data['message'] = 'This user are not login. Please contact support.';
                $jsonReturn = response()->json($data);
            else:
                $data['message'] = 'Authorised';
                $data['token'] = $user->createToken('alesha-tech-lms')->accessToken;
                Session::put('previous_token', $data['token']);
                $data['status'] = true;
                $request['user_login_status'] = 'logged in';

                ApiUserLoginEvent::dispatch($user);

                $jsonReturn = response()->json($data);
            endif;
        } else {
            $loginMethod['status'] = '';
            $request['user'] = $user = $this->userService->allUsers($loginMethod)->first();
            $old_wrong_password = isset($user->wrong_password) ? $user->wrong_password : 0;
            $password_retry_limit = 5;
            $request['user_login_status'] = ' Sorry, You entered wrong mobile number or invalid password!';
            $is_wrong_pin_password = true;
            $wrong_pin_password = 1 + $old_wrong_password;
            $message = ' Sorry, You entered wrong username or password! You already attempt ' . $wrong_pin_password . ' times out of ' . $password_retry_limit . ' .';
            if ($password_retry_limit == $wrong_pin_password):
                $message .= ' Please contacts support.';
            elseif ($wrong_pin_password > $password_retry_limit):
                $message = 'Sorry, Your Account is INACTIVE!. Please contact support!';
            endif;
            $jsonReturn = response()->json(['status' => false, 'message' => $message], 200);
        }

        if ($user) {
            if (($wrong_pin_password > $old_wrong_password) && ($is_wrong_pin_password == true)):
                $user->wrong_password = $wrong_pin_password;
                if ($wrong_pin_password >= $password_retry_limit):
                    $user->status = Constants::$user_default_status;
                    $user->userDetails->user_details_status = Constants::$user_default_status;
                endif;
            endif;
            $user->fcm_token = !empty($request['fcm_token']) ? $request['fcm_token'] : $user->fcm_token;
            $user->save();
        }

        return $jsonReturn;
    }
}
