<?php


namespace App\Http\Controllers\Backend\Setting;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\CountryRequest;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Services\UtilityService;

class CountryController extends Controller
{
    /**
     * @var CountryService
     */
    private $countryService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * CountryController constructor.
     * @param CountryService $countryService
     * @param UserService $userService
     */
    public function __construct(CountryService $countryService, UserService $userService)
    {

        $this->countryService = $countryService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $request['country_status'] = 'ACTIVE';
            $countries = $this->countryService->ShowAllCountry($request)->paginate($request->display_item_per_page);
            return view('backend.setting.countries.index', compact('countries', 'request'));
        } catch (\Exception $e) {
            flash('Country table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        try {
            return view('backend.setting.countries.create');
        } catch (\Exception $e) {
            flash('Something wrong with Country Data!')->error();
            return Redirect::to('/countries');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        try {
            DB::beginTransaction();
            $country = $this->countryService->storeCountry($request->all());
            if ($country) {
                // Country Flag
                $request['country_id'] = $country->id;
                if ($request->hasFile('country_logo')) {
                    $image_url = $this->countryService->countryFlag($request);
                    $country->country_logo = $image_url;
                    $country->save();
                }
                flash('countries created successfully')->success();
            } else {
                flash('Failed to create Countries')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create countries')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('countries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $country = $this->countryService->showCountryByID($id);
            return view('backend.setting.countries.show', compact('country'));
        } catch (\Exception $e) {
            flash('countries data not found!')->error();
            return redirect()->route('countries.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $country = $this->countryService->showCountryByID($id);
            return view('backend.setting.countries.edit', compact('country'));
        } catch (\Exception $e) {
            flash('countries data not found!')->error();
            return redirect()->route('countries.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CountryRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $country = $this->countryService->updateCountry($request->all(), $id);
            if ($country) {
                // Country Flag
                $request['country_id'] = $id;
                if ($request->hasFile('country_logo')) {
                    $image_url = $this->countryService->countryFlag($request);
                    $country->country_logo = $image_url;
                    $country->save();
                }
                flash('Countries update successfully')->success();
            } else {
                flash('Failed to update Countries')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update countries')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('countries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $country = $this->countryService->showCountryByID($id);
            if ($country) {
                $country->state()->city()->delete();
                $country->state()->delete();
                $country->delete();
                flash('country deleted successfully')->success();
            }else{
                flash('country not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('countries.index');
    }
}
