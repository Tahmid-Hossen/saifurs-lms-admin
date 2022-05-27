<?php


namespace App\Http\Controllers\Backend\Setting;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\CityRequest;
use App\Services\Backend\Setting\CityService;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\Setting\StateService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CityController extends Controller
{
    /**
     * @var CityService
     */
    private $cityService;
    /**
     * @var CountryService
     */
    private $countryService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * CityController constructor.
     * @param CityService $cityService
     * @param CountryService $countryService
     * @param UserService $userService
     * @param StateService $stateService
     */
    public function __construct(
        CityService $cityService,
        CountryService $countryService,
        UserService $userService,
        StateService $stateService
    )
    {
        $this->cityService = $cityService;
        $this->countryService = $countryService;
        $this->userService = $userService;
        $this->stateService = $stateService;
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
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $countries = $this->countryService->ShowAllCountry(array())->get();
            $request['country_id'] = 18;
            $request['country_status'] = Constants::$user_active_status;
            $provinces = $this->stateService->ShowAllState(array('country_id'=>18))->get();
            $cities = $this->cityService->ShowAllCity($request)->paginate($request->display_item_per_page);
            return view('backend.setting.cities.index', compact('cities', 'countries', 'request', 'provinces'));
        } catch (Exception $e) {
            flash('City table not found!')->error();
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
            $provinces = $this->stateService->ShowAllState(array('country_id'=>18))->get();
            return view('backend.setting.cities.create', compact('countries', 'provinces'));
        } catch (Exception $e) {
            flash('Something wrong with City Data!')->error();
            return Redirect::to('/cities');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function store(CityRequest $request)
    {
        try {
            DB::beginTransaction();
            $city = $this->cityService->storeCity($request->except('country_id'));
            if ($city) {
                flash('City created successfully')->success();
            } else {
                flash('Failed to create City')->error();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            flash('Failed to create City')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('cities.index');
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
            $city = $this->cityService->showCityByID($id);
            return view('backend.setting.cities.show', compact('city'));
        } catch (Exception $e) {
            flash('City data not found!')->error();
            return redirect()->route('cities.index');
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
            $city = $this->cityService->showCityByID($id);
            $countries = $this->countryService->ShowAllCountry(array())->get();
            $provinces = $this->stateService->ShowAllState(array('country_id'=>18))->get();
            return view('backend.setting.cities.edit', compact('city', 'countries', 'provinces'));
        } catch (Exception $e) {
            flash('City data not found!')->error();
            return redirect()->route('cities.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityRequest $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function update(CityRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $city = $this->cityService->updateCity($request->except('country_id'), $id);
            if ($city) {
                flash('City update successfully')->success();
            } else {
                flash('Failed to update City')->error();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            flash('Failed to update City')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('cities.index');
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
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            $city = $this->cityService->showCityByID($id);
            if ($city) {
                $city->delete();
                flash('City deleted successfully')->success();
            } else {
                flash('City not found!')->error();
            }
        } else {
            flash('You Entered Wrong PIN!')->error();
        }
        return redirect()->route('cities.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCityList(Request $request)
    {
        $cityArray = array();
        $request['country_id'] = isset($request['country_id'])?$request['country_id']:18;
        $request['country_status'] = Constants::$user_active_status;
        $cities = $this->cityService->ShowAllCity($request->all())->get();
        if (count($cities) > 0):
            $cityArray[] = $this->cityService->cityDummyText();
            foreach($cities as $city):
                $cityArray[] = $city;
            endforeach;
            $message = response()->json(['status' => 200, 'data' => $cityArray]);
        else:
            $message = response()->json(['status' => 404, 'message' => 'Data not Found']);
        endif;
        return $message;
    }
}
