<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\ApiEmailVerifyEvent;
use App\Events\ApiUserOtpEvent;
use App\Events\ApiUserRegistrationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\UserDetailsApiRequest;
use App\Http\Requests\Backend\User\UserDetailsRequest;
use App\Http\Requests\Backend\User\UserDetailsUpdateApiRequest;
use App\Models\User;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\OneTimePasswordService;
use App\Services\Backend\User\UserDetailsService;
use App\Services\Backend\User\UserService;
use App\Services\CustomHtmlService;
use App\Services\PushNotificationService;
use App\Services\ShortMessageService;
use App\Services\UtilityService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserDetailController extends Controller
{
    /**
     * @var UserDetailsService
     */
    private $userDetailsService;
    /**
     * @var UserService
     */
    private $userService;

    private $countryService;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var OneTimePasswordService
     */
    private $oneTimePasswordService;
    /**
     * @var PushNotificationService
     */
    private $pushNotificationService;
    /**
     * @var ShortMessageService
     */
    private $shortMessageService;

    /**
     * UserDetailController constructor.
     * @param UserDetailsService $userDetailsService
     * @param UserService $userService
     * @param CountryService $countryService
     * @param CompanyService $companyService
     * @param OneTimePasswordService $oneTimePasswordService
     * @param PushNotificationService $pushNotificationService
     * @param ShortMessageService $shortMessageService
     */
    public function __construct(
        UserDetailsService      $userDetailsService,
        UserService             $userService,
        CountryService          $countryService,
        CompanyService          $companyService,
        OneTimePasswordService  $oneTimePasswordService,
        PushNotificationService $pushNotificationService,
        ShortMessageService     $shortMessageService
    )
    {
        $this->userDetailsService = $userDetailsService;
        $this->userService = $userService;
        $this->countryService = $countryService;
        $this->companyService = $companyService;
        $this->oneTimePasswordService = $oneTimePasswordService;
        $this->pushNotificationService = $pushNotificationService;
        $this->shortMessageService = $shortMessageService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $request['user_detail_start_date'] = isset($request['user_detail_start_date']) ? $request['user_detail_start_date'] . ' 00:00:01' : Carbon::now()->subDay(29)->format('Y-m-d') . ' 00:00:01';
            $request['user_detail_end_date'] = isset($request['user_detail_end_date']) ? ($request['user_detail_end_date'] . ' 23:59:59') : (Carbon::now()->format('Y-m-d') . ' 23:59:59');
            $request['date_range'] = Carbon::now()->subDay(29)->format('F d, Y') . ' - ' . Carbon::now()->format('F d, Y');
            $data['userDetails'] = $this->userDetailsService->userDetails($request->all())->paginate(UtilityService::$displayRecordPerPage);
            $data['companies'] = $this->companyService->showAllCompany($request->all())->get();
            $data['request'] = $request;
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'User Profile table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        try {
            $data['countries'] = $this->countryService->ShowAllCountry(array('id' => 18))->get();
            $data['companies'] = $this->companyService->showAllCompany(array())->get();
            $data['roles'] = $this->userService->getAllRoles();
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'User Profile table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserDetailsRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(UserDetailsRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->user_custom_insert($request->all());
            if ($user) {
                $request['user_id'] = $user->id;
                $userDetail = $this->userDetailsService->user_detail_custom_insert($request->all());
                $request['user_detail_id'] = $userDetail->id;
                if ($request->hasFile('user_detail_photo')) {
                    $image_url = $this->userDetailsService->userDetailPhoto($request);
                    $userDetail->user_detail_photo = $image_url;
                    $userDetail->save();
                }
                $data['userDetail'] = $userDetail;
                $data['status'] = true;
                $data['message'] = 'User Registration Successful!';
                $jsonReturn = response()->json($data, 200);
            } else {
                $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to User Registration!'], 200);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to User Registration!!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $data['userDetails'] = $this->userDetailsService->userDetailsById($id);
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'User Profile table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        try {
            $data['countries'] = $this->countryService->ShowAllCountry(array('id' => 18))->get();
            $data['userDetails'] = $this->userDetailsService->userDetailsById($id);
            $data['companies'] = $this->companyService->showAllCompany(array())->get();
            $data['roles'] = $this->userService->getAllRoles();
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'User Profile table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserDetailsRequest $request
     * @param $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(UserDetailsRequest $request, $id): JsonResponse
    {
        $user_id = $request['user_id'];
        try {
            DB::beginTransaction();
            $user = $this->userService->user_custom_update($request->all(), $user_id);
            if ($user) {
                $userDetail = $this->userDetailsService->user_details_custom_update($request->all(), $id);
                $request['user_detail_id'] = $userDetail->id;
                if ($request->hasFile('user_detail_photo')) {
                    $image_url = $this->userDetailsService->userDetailPhoto($request);
                    $userDetail->user_detail_photo = $image_url;
                    $userDetail->save();
                }
                $data['userDetail'] = $userDetail;
                $data['status'] = true;
                $data['message'] = 'User profiles update successfully';
                $jsonReturn = response()->json($data, 200);
            } else {
                $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to update User profiles!'], 200);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to update User profiles!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user_get = $this->userService->whoIS($_REQUEST);
            if (isset($user_get) && $user_get->id == auth()->user()->id) {
                $userDetails = $this->userDetailsService->userDetailsById($id);
                if ($userDetails) {
                    $userDetails->delete();
                    $jsonReturn = response()->json(['status' => true, 'message' => 'User profile deleted successfully'], 200);
                } else {
                    $jsonReturn = response()->json(['status' => false, 'message' => 'User profile not found!'], 200);
                }
            } else {
                $jsonReturn = response()->json(['status' => false, 'message' => 'You Entered Wrong Password!'], 200);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to delete User profiles!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function showForApi(): JsonResponse
    {
        try {
            $data['userDetail'] = $this->userDetailsService->userDetailsById(auth()->user()->userDetails->id);
            $data['userDetail']['username'] = isset(auth()->user()->username) ? auth()->user()->username : null;
            $data['userDetail']['email'] = isset(auth()->user()->email) ? auth()->user()->email : null;
            $data['userDetail']['profile_id'] = $data['userDetail']->id;
            $data['userDetail']['user_detail_photo'] = $data['userDetail']->user_detail_photo_full_link;
            $data['userDetail']['company_name'] = $data['userDetail']->company->company_name ?? null;
            $data['userDetail']['branch_name'] = $data['userDetail']->branch->branch_name ?? null;
            $data['userDetail']['country_name'] = $data['userDetail']->country->country_name ?? null;
            $data['userDetail']['state_name'] = $data['userDetail']->state->state_name ?? null;
            $data['userDetail']['city_name'] = $data['userDetail']->city->city_name ?? null;
            $data['userDetail']['shipping_address'] = $data['userDetail']->shipping_address ?? null;
            $data['userDetail']['shipping_post_code'] = $data['userDetail']->shipping_post_code ?? null;
            $data['userDetail']['shipping_city_name'] = $data['userDetail']->ship_city->city_name ?? null;
            $data['userDetail']['shipping_state_name'] = $data['userDetail']->ship_state->state_name ?? null;
            $data['userDetail']->makeHidden('ship_city');
            $data['userDetail']->makeHidden('ship_state');
            $data['message'] = 'User profiles Show successfully';
            $data['status'] = true;
            $data['userDetail'] = collect($data['userDetail'])->forget(['company', 'branch', 'country', 'state', 'city'])->all();
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to found User profiles!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * User Password Check
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function pinPasswordCheck(Request $request): JsonResponse
    {
        try {
            $authorization = $this->userService->pinPasswordCheck($request->all());
            $jsonReturn = response()->json($authorization, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Something wrong for check password!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * API User Logout
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function userApiLogout(Request $request): JsonResponse
    {
        try {
            DB::table('oauth_access_tokens')->where('user_id', '=', Auth::user()->id)->update(['revoked' => 1]);
            Session::flush();
            $returnValue['message'] = 'Logout Successfully';
            $returnValue['status'] = true;
            $returnValue['status_code'] = 401;
            $FCMToken = isset(Auth::user()->fcm_token) ? Auth::user()->fcm_token : null;
            /*            if (isset($FCMToken)):
                            $this->pushNotificationService->sendAutoNotification($FCMToken, 'Logout', 'Logout Successfully!!');
                        endif;*/
            $jsonReturn = response()->json($returnValue, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Something wrong for logout!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * One Time Password Generate
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function oneTimePassword(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $userCheck = $this->userService->getUserByMobile($request->all());
            if (isset($userCheck)):
                $otp = $this->oneTimePasswordService->generate($request->mobile_number, 4, 1);
                $text = '#Your ' . config('app.short_name') . ' OTP code is ' . $otp->token;


                ApiUserOtpEvent::dispatch([
                    'mobile_number' => $request->mobile_number,
                    'line' => $text]);

                $data['status'] = true;
                $data['users'] = $userCheck;
                $data['message'] = 'We have sent a 4 digit pin to your phone.';
                $data['sms'] = $text;
                DB::commit();
            else:
                $data['status'] = false;
                $data['users'] = null;
                $data['message'] = 'This mobile number are invalid';
            endif;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to create One Time Password!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * One Time Password Generate For User Registration
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function oneTimePasswordForRegistration(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $userCheck = $this->userService->getUserByMobile($request->all());
            if (isset($userCheck)):
                $data['status'] = false;
                $data['users'] = $userCheck;
                $data['message'] = 'This account already exists with this Mobile Number!';
            else:

                $otp = $this->oneTimePasswordService->generate($request->mobile_number, 4, 1);

                $text = '#Your ' . config('app.short_name') . ' OTP code is ' . $otp->token;

                $smsData = ['mobile_number' => $request->mobile_number, 'line' => $text];

                ApiUserOtpEvent::dispatch($smsData);

                $data['status'] = true;
                $data['users'] = null;
                $data['message'] = 'We have sent a 4 digit pin to your phone.';
                $data['sms'] = $text;
                DB::commit();
            endif;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to create One Time Password!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * One Time Password Verify
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function oneTimePasswordVerify(Request $request): JsonResponse
    {
        Db::beginTransaction();
        try {
            $otp = $this->oneTimePasswordService->validate($request->mobile_number, $request->otp_number);
            $jsonReturn = response()->json($otp, 200);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to verify One Time Password!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Reset User Password
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function resetPasswordPinByPost(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $passPin = CustomHtmlService::passwordPinGenerate();
            $user = User::where('mobile_number', '=', $request->mobile_number)->first();
            if (isset($user)):
                //TODO OFF SUPER ADMIN PASSWORD RESET
                $isSuperAdmin = $user->roles()->first() ? $user->roles()->first()->name == "Super Admin" : false;
                if (!$isSuperAdmin) {
                    $user->password = Hash::make($passPin['default_password']);

                    //ask user to reset password with temp password
                    $user->force_reset = 1;
                    $user->save();
                    $text = strtoupper(config('app.short_name')) . ":\nDear User, Your password has been reset successfully.\nYour Username: " . $user->username. "\nNew Password:  " . $passPin['default_password'] . "\nThank you.";

                    //TODO SMS SERVICE
                    ApiUserOtpEvent::dispatch([
                        'mobile_number' => $user->mobile_number,
                        'line' => $text
                    ]);

                    DB::commit();
                    $returnValue['status'] = true;
                    $returnValue['message'] = 'User password is successfully reset.';
                    $returnValue['password'] = $passPin['default_password'];
                    $returnValue['sms'] = $text;
                    $returnValue['users'] = $user;
                } else {
                    $returnValue['status'] = false;
                    $returnValue['message'] = 'Failed to reset User password!';
                }
            else:
                $returnValue['status'] = false;
                $returnValue['message'] = 'Mobile Number Not Found.';
            endif;
        } catch (\Exception $e) {
            DB::rollback();
            $returnValue['status'] = false;
            $returnValue['message'] = 'Failed to reset User password!.';
        }
        return response()->json($returnValue, 200);
    }

    /**
     * Store a newly created resource in storage for Student.
     *
     * @param UserDetailsApiRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
	 
	 public function storeStudent(Request $request): JsonResponse
    {
		
		 /*$user = $this->userService->user_custom_insert($request->all());
		 //$user = User::create($request->all());
		 if ($user) {
			$data['user'] = $user;
			$data['token'] = $user->createToken('alesha-tech-lms')->accessToken;
			$data['status'] = true;
			$data['message'] = 'User Registration Successful!';
			$jsonReturn = response()->json($data, 200);
		}	
		else{
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to User Registration!'], 200);
		}*/
				
        \Log::info('request data' . json_encode($request->all()));
        try {
            DB::beginTransaction();
            $request['country_id'] = 18;
            //$request['company_id'] = 1;
            $request['user_details_verified'] = 'IN-ACTIVE';
            $request['shipping_address'] = $request->mailing_address;
            $request['shipping_state_id'] = $request->state_id;
            $request['shipping_city_id'] = $request->city_id;
            $request['shipping_post_code'] = $request->post_code;
            $request['roles'] = array(5);
            //Android Int to null Exception
            //$request['branch_id'] = (isset($request->branch_id) && $request->branch_id == -1) ? NULL : $request->branch_id;
            $user = $this->userService->user_custom_insert($request->all());
			
           
            if ($user) {				                
			     
				\Log::info('user detailss ' . json_encode($user));
				$request['user_id'] = $user->id;
                $userDetail = $this->userDetailsService->user_detail_custom_insert($request->all());
                $request['user_detail_id'] = $userDetail->id;
                if ($request->hasFile('user_detail_photo')) {
                    $image_url = $this->userDetailsService->userDetailPhoto($request);
                    $userDetail->user_detail_photo = $image_url;
                    $userDetail->save();
                }
				
				
                $data['user'] = $user;
                $data['token'] = $user->createToken('alesha-tech-lms')->accessToken;
                $data['userDetail'] = $userDetail;
                $data['status'] = true;
                $data['message'] = 'User Registration Successful!';
                $jsonReturn = response()->json($data, 200);
				
				\Log::info('json datas ' . $jsonReturn);
            } else {
                \Log::info(('Failed to User Registration!'));
                $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to User Registration!'], 200);
            }
            DB::commit();
            //ApiUserRegistrationEvent::dispatch($user);
        } catch (\Exception $e) {
            DB::rollback();
            //\Log::info('user details data:' . json_encode($user));
            \Log::error('exception-message:' . $e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to User Registration!'], 200);
        }
        return $jsonReturn;
    }
	
    /*public function storeStudent(UserDetailsApiRequest $request): JsonResponse
    {
        \Log::info('request data' . json_encode($request->all()));
        try {
            DB::beginTransaction();
            $request['country_id'] = 18;
            //$request['company_id'] = 1;
            $request['user_details_verified'] = 'IN-ACTIVE';
            $request['shipping_address'] = $request->mailing_address;
            $request['shipping_state_id'] = $request->state_id;
            $request['shipping_city_id'] = $request->city_id;
            $request['shipping_post_code'] = $request->post_code;
            $request['roles'] = array(5);
            //Android Int to null Exception
            $request['branch_id'] = (isset($request->branch_id) && $request->branch_id == -1) ? NULL : $request->branch_id;
            $user = $this->userService->user_custom_insert($request->all());
            \Log::info('user details ' . json_encode($user));
            if ($user) {
                $request['user_id'] = $user->id;
                $userDetail = $this->userDetailsService->user_detail_custom_insert($request->all());
                $request['user_detail_id'] = $userDetail->id;
                if ($request->hasFile('user_detail_photo')) {
                    $image_url = $this->userDetailsService->userDetailPhoto($request);
                    $userDetail->user_detail_photo = $image_url;
                    $userDetail->save();
                }
                $data['user'] = $user;
                $data['token'] = $user->createToken('alesha-tech-lms')->accessToken;
                $data['userDetail'] = $userDetail;
                $data['status'] = true;
                $data['message'] = 'User Registration Successful!';
                $jsonReturn = response()->json($data, 200);
            } else {
                \Log::info(('Failed to User Registration!'));
                $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to User Registration!'], 200);
            }
            DB::commit();
            ApiUserRegistrationEvent::dispatch($user);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::info('user details data:' . json_encode($user));
            \Log::error('exception-message:' . $e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to User Registration!'], 200);
        }
        return $jsonReturn;
    }*/

    /**
     * Update the specified resource in storage for Student.
     *
     * @param UserDetailsUpdateApiRequest $request
     * @param $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function updateStudent(UserDetailsUpdateApiRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user_detail = $this->userDetailsService->userDetailsById($id);
            if (isset($user_detail)):
                $request['country_id'] = $user_detail->country_id;
                //$request['company_id'] = 1;
                //$request['user_details_verified'] = 'IN-ACTIVE';
                $request['user_id'] = $user_detail->user_id;
                $request['roles'] = array(5);
                $request['branch_id'] = (isset($request->branch_id) && $request->branch_id == -1) ? NULL : $request->branch_id;
                $user = $this->userService->user_custom_update($request->all(), $user_detail->user_id);
                if ($user):
                    $userDetail = $this->userDetailsService->user_details_custom_update($request->all(), $id);
                    $user_detail->fresh();
                    $request['user_detail_id'] = $userDetail->id;
                    //$request['user_detail_photo_old'] = $userDetail->user_detail_photo;
                    if ($request->hasFile('user_detail_photo')):
                        $image_url = $this->userDetailsService->userDetailPhoto($request);
                        $userDetail->user_detail_photo = $image_url;
                        $userDetail->save();
                    endif;
                    $data['userDetail'] = $userDetail;
                    $data['status'] = true;
                    $data['message'] = 'You have successfully updated your profile!';
                    $jsonReturn = response()->json($data, 200);
                else:
                    $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to update User profiles!'], 200);
                endif;
            else:
                $jsonReturn = response()->json(['status' => false, 'message' => 'Student profile data not found!'], 200);
            endif;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to update User profiles!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profilePhoto(Request $request): JsonResponse
    {
        Log::error('User Profile Request Variable: ' . ($request));
        try {
            DB::beginTransaction();
            $request['user_id'] = auth()->user()->id;
            //Android Int to null Exception
            $request['branch_id'] = (isset($request->branch_id) && $request->branch_id == -1) ? NULL : $request->branch_id;
            $userDetail = $this->userDetailsService->userDetails($request)->first();
            if ($userDetail) {
                $request['user_detail_id'] = $userDetail->id;
                // Profile Photo
                if ($request->hasFile('user_detail_photo')):
                    $request['user_detail_photo_old'] = $userDetail->user_detail_photo;
                    $image_url = $this->userDetailsService->userDetailPhoto($request);
                    $userDetail->user_detail_photo = $image_url;
                    $userDetail->save();
                endif;
                $userDetail->save();
            }
            $userDetail = $this->userDetailsService->userDetailsById($userDetail->id);
            $userDetail->fresh();
            $userDetail->user_detail_photo_full_link = $userDetail->user_detail_photo;
            $data['profile'] = $userDetail;
            $data['status'] = true;
            $data['message'] = 'User profiles image create/update successfully';
            $jsonReturn = response()->json($data, 200);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to create/update User profiles imag!'], 200);
        }
        /*        $FCMToken = isset(Auth::user()->fcm_token) ? Auth::user()->fcm_token : null;
                if (isset($FCMToken)):
                    $this->pushNotificationService->sendAutoNotification($FCMToken, 'PROFILE', $data['message']);
                endif;*/
        return $jsonReturn;
    }

    /**
     * Search Email
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function findHaveEmail(Request $request): JsonResponse
    {
        try {
            $input = $request->except('_token');
            $count = $this->userService->getUserByEmail($input["email"]);
            if (isset($count)) {
                //$jsonReturn = response()->json(['status' => false, 'message' => 'Email already have, please provide another email address!']);
                $jsonReturn = response()->json(['status' => false, 'message' => 'This account already exists with this email!']);
            } else {
                $jsonReturn = response()->json(['status' => true, 'message' => 'Data not Found']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to search email!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Search Mobile Number
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function findHaveMobile(Request $request): JsonResponse
    {
        try {
            $input = $request->except('_token');
            $mobile_number = isset($input["mobile_number"]) ? $input["mobile_number"] : (isset($input["mobile_phone"]) ? $input["mobile_phone"] : null);
            $existingUser = $this->userService->getUserByMobile($mobile_number);
            //if a model found
            if ($existingUser instanceof User) {
                //$jsonReturn = response()->json(['status' => false, 'message' => 'Mobile Number already have, please provide another Mobile Number!']);
                $jsonReturn = response()->json(['status' => false, 'message' => 'This account already exists with this mobile number!']);
            } else {
                $jsonReturn = response()->json(['status' => true, 'message' => 'Mobile number is unique']);
            }
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to search mobile number!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Search Username
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function findHaveUserName(Request $request): JsonResponse
    {
        try {
            $input = $request->except('_token');
            $users = $this->userService->checkSponsor(array('username' => $input["username"]))->count();
            if ($users > 0) {
                //$jsonReturn = response()->json(['status' => false, 'message' => 'username already have, please provide another username!']);
                $jsonReturn = response()->json(['status' => false, 'message' => 'This account already exists with this username!']);
            } else {
                $jsonReturn = response()->json(['status' => true, 'message' => 'Data not Found']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to search user name!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function otpByEmail(Request $request): JsonResponse
    {
        $userCheck = $this->userService->getUserByEmail($request->email);

        if ($userCheck) {
            $otp = $this->oneTimePasswordService->generate($userCheck->mobile_number, 6, 5);
            if ($otp->status == true) {
                ApiEmailVerifyEvent::dispatch($userCheck, $otp->token);

                $jsonReturn = response()->json(['status' => true, 'message' => $otp->token]);

            } else {
                $jsonReturn = response()->json(['status' => false, 'message' => 'OTP Generation Failed'], 404);
            }
        } else {
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to create Email OTP!'], 200);
        }

        return $jsonReturn;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function emailOTPVerify(Request $request): JsonResponse
    {
        $jsonReturn = ['status' => false, 'message' => 'Failed to verify One Time Password!'];
        try {
            if ($userCheck = $this->userService->getUserByEmail($request->all())) {
                $otp = $this->oneTimePasswordService->validate($userCheck->mobile_number, $request->otp_number);
                \Log::info(json_encode($otp));
                if ($otp->status == true) {
                    \Log::info($userCheck);
                    $userCheck->email_verified_at = \Carbon\Carbon::now();
                    $userCheck->save();
                    $jsonReturn = ['status' => true, 'message' => 'Email Verification Successful'];
                } else {
                    $jsonReturn = $otp;
                }
            } else {
                $jsonReturn = ['status' => false, 'message' => 'Invalid User/Email Address'];
            }

        } catch (\Exception $e) {
            $jsonReturn = ['status' => false, 'message' => 'Failed to verify One Time Password!'];
        } finally {
            return response()->json($jsonReturn, 200);
        }
    }
}
