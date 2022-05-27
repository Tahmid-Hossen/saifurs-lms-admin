<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CustomHtmlService;
use App\Services\PushNotificationService;
use App\Services\ShortMessageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UpdatePasswordController extends Controller
{
    /*
     * Ensure the user is signed in to access this page
     */
    /**
     * @var ShortMessageService
     */
    private $shortMessageService;
    /**
     * @var PushNotificationService
     */
    private $pushNotificationService;

    /**
     * UpdatePasswordController constructor.
     * @param ShortMessageService $shortMessageService
     * @param PushNotificationService $pushNotificationService
     */
    public function __construct(ShortMessageService $shortMessageService, PushNotificationService $pushNotificationService)
    {
        $this->middleware('auth');
        $this->shortMessageService = $shortMessageService;
        $this->pushNotificationService = $pushNotificationService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function edit($id)
    {
        return view('auth.passwords.change-password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse|RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        if (strcmp($request->password, $request->password_confirmation) == 0) {
            $this->validate($request, [
                'old' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);

            $user = User::find($id);
            $hashedPassword = $user->password;

            if (Hash::check($request->old, $hashedPassword)) {
                //Change the password
                $user->fill([
                    'password' => Hash::make($request->password),
                    'force_reset' => 0
                ])->save();

                $text = strtoupper(config('app.short_name')) . ":\nDear User, your password has been changed.";
                //TODO SMS
                //$this->shortMessageService->sendSms($text, $user->mobile_number);
                //TODO adjust reset sms charge method
                //adjustResetSmsCharge($user->id);
/*                $FCMToken = isset($user->fcm_token)?$user->fcm_token:null;
                if(isset($FCMToken)):
                    $this->pushNotificationService->sendAutoNotification($FCMToken, 'Password Change', $text);
                endif;*/
                $returnValue['message'] = 'Your password has been changed successfully. ';
                $returnValue['status'] = true;
                flash('Your password has been changed successfully.')->success();
            } else {
                $returnValue['message'] = 'Sorry, Current password does not match!';
                $returnValue['status'] = false;
                flash('Sorry, Current password does not match!')->error();
            }
        } else {
            $returnValue['message'] = 'Sorry, Your Password and confirm Password does not match!';
            $returnValue['status'] = false;
            flash('Sorry, Your Password and confirm Password does not match!')->error();
        }

        if (in_array('auth:api', $request->route()->action['middleware'])) {
            return response()->json($returnValue, 200);
        } else {
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function resetPasswordPin($id, Request $request)
    {
        $passPin = CustomHtmlService::passwordPinGenerate();

        $user = User::find($id);
        $isSuperAdmin = $user->roles()->first() ? $user->roles()->first()->name == "Super Admin" : false;
        if (!$isSuperAdmin) {
            $user->password = Hash::make($passPin['default_password']);
            $user->save();
        }

        $text = strtoupper(config('app.short_name')) . ":\nDear User, Your password has been reset successfully.\nNew Password:  " . $request->password . "\n Thank you.";
        //TODO SMS will have problem
        $this->shortMessageService->sendSms($text, $user->mobile_number);
        //TODO adjust reset sms charge method
        //adjustResetSmsCharge($user->id);
/*        $FCMToken = isset($user->fcm_token)?$user->fcm_token:null;
        if(isset($FCMToken)):
            $this->pushNotificationService->sendAutoNotification($FCMToken, 'Password Reset', $text);
        endif;*/
        $returnValue['message'] = 'User password is successfully reset.';
        flash('User password is successfully reset.', 'success');

        if (in_array('auth:api', $request->route()->action['middleware'])) {
            $return = response()->json($returnValue, 200);
        } else {
            $return = redirect()->route('user-details.index');
        }
        return $return;
    }
}
