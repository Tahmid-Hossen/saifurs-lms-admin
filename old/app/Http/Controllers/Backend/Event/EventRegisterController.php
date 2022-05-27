<?php

namespace App\Http\Controllers\Backend\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Event\EventRequest;
use App\Services\Backend\Event\EventRegisterService;
use App\Services\Backend\Event\EventService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventRegisterController extends Controller
{
    /**
     * @var EventService
     */
    private $eventService;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var EventRegisterService
     */
    private $eventRegisterService;

    /**
     * EventRegisterController constructor.
     * @param CompanyService $companyService
     * @param BranchService $branchService
     * @param UserService $userService
     * @param EventService $eventService
     * @param EventRegisterService $eventRegisterService
     */
    public function __construct(CompanyService $companyService,
                                BranchService $branchService,
                                UserService $userService,
                                EventService $eventService,
                                EventRegisterService $eventRegisterService
    )
    {
        $this->middleware('auth');
        $this->eventService = $eventService;
        $this->companyService = $companyService;
        $this->branchService = $branchService;
        $this->userService = $userService;
        $this->eventRegisterService = $eventRegisterService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {

        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $datas = $this->eventService->showAllEvent($requestData)->paginate(\Utility::$displayRecordPerPage);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();

            return view('backend.events-users.index', [
                'datas' => $datas,
                'request' => $request,
                'companies' => $companies,
                'branches' => $branches,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Events table not found!')->error();
            return redirect(route('events.index'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();

            return view('backend.events-users.create', [
                'companies' => $companies,
                'events' => $this->eventService->showAllEvent(['status' => 'ACTIVE'])->get(),
                'users' => $this->userService->getUserDropDown()
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Events table not found!')->error();
            return redirect(route('events.index'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $this->eventRegisterService->storeEventRegister($request->only('event_id', 'invitation'));
            flash('An Event has been Successfully Managed')->success();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Failed to Manage an Event')->error();
            return back()->with($request->all());
        }

        return redirect(route('events-registration.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        try {
            $event = $this->eventService->eventById($id);
            return view('backend.events-users.show', ['event' => $event]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Event\'s data not found!')->error();
            return redirect(route('events-registration.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $event = $this->eventService->eventById($id);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            return view('backend.events-users.edit', [
                'eventDetail' => $event,
                'companies' => $companies,
                'users' => $this->userService->getUserDropDown(),
                'events' => $this->eventService->showAllEvent(['status' => 'ACTIVE'])->get(),
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Events table not found!')->error();
            return redirect(route('events-registration.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $event = $this->eventRegisterService->updateEventRegister($request->only('event_id', 'invitation'), $id);
            flash('An Event register has been updated successfully')->success();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Failed to Update an Event')->error();
            return back()->withInput($request->all());
        }
        return redirect()->route('events-registration.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public
    function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            $event = $this->eventService->eventByID($id);
            if ($event) {
                $event->delete();
                flash('An Event has been deleted successfully')->success();
            } else {
                flash('An Event is not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect(route('events-registration.index'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $events = $this->eventService->showAllEvent($requestData)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.events-users.pdf', [
                'events' => $events,
                'request' => $request,
                'companies' => $companies,
                'branches' => $branches,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Events table not found!')->error();
            return redirect(route('events-registration.index'));
        }
    }

    public
    function excel(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $events = $this->eventService->showAllEvent($requestData)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.events-users.excel', [
                'events' => $events,
                'request' => $request,
                'companies' => $companies,
                'branches' => $branches,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Events table not found!')->error();
            return redirect(route('events-registration.index'));
        }
    }

    public
    function eventMarkedAsRead($id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications->find($id);
            $notification->markAsRead();
            $event_id = $notification->data['id'];
            return redirect(route('events-registration.show', $event_id));
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Notification For this Event is Not Found', 'error');
            return redirect(back('events-registration.index'));
        }

    }
}
