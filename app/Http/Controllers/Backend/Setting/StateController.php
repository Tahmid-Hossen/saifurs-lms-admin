<?php


namespace App\Http\Controllers\Backend\Setting;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\StateRequest;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\Setting\StateService;
use App\Services\Backend\User\UserService;
use App\Support\Configs\Constants;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Services\UtilityService;
use Illuminate\View\View;

class StateController extends Controller
{
    /**
     * @var StateService
     */
    private $stateService;
    /**
     * @var CountryService
     */
    private $countryService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * StateController constructor.
     * @param StateService $stateService
     * @param CountryService $countryService
     * @param UserService $userService
     */
    public function __construct(StateService $stateService, CountryService $countryService, UserService $userService)
    {
        $this->stateService = $stateService;
        $this->countryService = $countryService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|RedirectResponse|View
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $countries = $this->countryService->ShowAllCountry(array())->get();
            $request['country_id'] = 18;
            $request['country_status'] = Constants::$user_active_status;
            $provinces = $this->stateService->ShowAllState($request)->paginate($request->display_item_per_page);
            return view('backend.setting.states.index', compact('provinces', 'countries', 'request'));
        } catch (\Exception $e) {
            flash('State table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|RedirectResponse|View
     */
    public function create()
    {
        try {
            $countries = $this->countryService->ShowAllCountry(array())->get();
            return view('backend.setting.states.create', compact('countries'));
        } catch (\Exception $e) {
            flash('Something wrong with State Data!')->error();
            return Redirect::to('/states');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StateRequest $request
     * @return RedirectResponse
     */
    public function store(StateRequest $request)
    {
        try {
            DB::beginTransaction();
            $province = $this->stateService->storeState($request->all());
            if ($province) {
                flash('State created successfully')->success();
            } else {
                flash('Failed to create State')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create State')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('states.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|RedirectResponse|Response|View
     */
    public function show($id)
    {
        try {
            $state = $this->stateService->showStateByID($id);
            return view('backend.setting.states.show', compact('state'));
        } catch (\Exception $e) {
            flash('State data not found!')->error();
            return redirect()->route('states.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|RedirectResponse|Response|View
     */
    public function edit($id)
    {
        try {
            $countries = $this->countryService->ShowAllCountry(array())->get();
            $state = $this->stateService->showStateByID($id);
            return view('backend.setting.states.edit', compact('state', 'countries'));
        } catch (\Exception $e) {
            flash('State data not found!')->error();
            return redirect()->route('states.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(StateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $province = $this->stateService->updateState($request->all(), $id);
            if ($province) {
                flash('State update successfully')->success();
            } else {
                flash('Failed to update Users')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update State')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('states.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $province = $this->stateService->showStateByID($id);
            if ($province) {
                $province->city()->delete();
                $province->delete();
                flash('State deleted successfully')->success();
            }else{
                flash('State not found!')->error();
            }
        }else{
            flash('You Entered Wrong PIN!')->error();
        }
        return redirect()->route('states.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStateList(Request $request){
        $provinceArray = array();
        $request['country_id'] = isset($request['country_id'])?$request['country_id']:18;
        $request['country_status'] = Constants::$user_active_status;
        $request['state_status'] = Constants::$user_active_status;
        $provinces = $this->stateService->ShowAllState($request->all())->get();
        if(count($provinces)>0):
            $provinceArray[] = $this->stateService->stateDummyText();
            foreach($provinces as $province):
                $provinceArray[] = $province;
            endforeach;
            $message = response()->json(['status' => 200, 'data'=>$provinceArray]);
        else:
            $message = response()->json(['status' => 404, 'message'=>'Data Not Found']);
        endif;
        return $message;
    }
}
