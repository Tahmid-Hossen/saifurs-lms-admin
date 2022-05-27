<?php

namespace App\Http\Controllers\Backend\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Event\EventRequest;
use App\Models\User;
use App\Notifications\EventsNotification;
use App\Services\Backend\Event\EventService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\PushNotificationService;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
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
     * @var PushNotificationService
     */
    private $pushNotificationService;

    /**
     * @param CompanyService $companyService
     * @param BranchService $branchService
     * @param UserService $userService
     * @param EventService $eventService
     * @param PushNotificationService $pushNotificationService
     */
    public function __construct(
        CompanyService          $companyService,
        BranchService           $branchService,
        UserService             $userService,
        EventService            $eventService,
        PushNotificationService $pushNotificationService
    )
    {
        $this->middleware('auth');
        $this->eventService = $eventService;
        $this->companyService = $companyService;
        $this->branchService = $branchService;
        $this->userService = $userService;
        $this->pushNotificationService = $pushNotificationService;
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
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : \Utility::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $requestData['event_current_status'][0] = 'running';
            $requestData['event_current_status'][1] = 'upcoming';

            $datas = $this->eventService->showAllEvent($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.events.index', [
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
            return view('backend.events.create', [
                'companies' => $companies,
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
    public function store(EventRequest $request): RedirectResponse
    {
        try {
            $event = $this->eventService->event_custom_insert($request->except('event_image', '_token'));
            if ($event) {
                $request['event_id'] = $event->id;
                if ($request->hasFile('event_image')) {
                    $image_url = $this->eventService->eventImage($request);
                    $event->event_image = $image_url;
                    $event->save();
                    /*$users = User::get();
                    foreach ($users as $user) {
                        $user->notify(new EventsNotification($event));
                        if (isset($user->fcm_token)):
                            $this->pushNotificationService->sendAutoNotification($user->fcm_token, 'S@ifurs',
                                'Saifur’s has created an event for' . $request->event_title .
                                ' on ' .
                                date('d M, Y h:i:s A', strtotime($event->event_start)));
                        endif;
                    }*/
                    flash('An Event has been Successfully Managed')->success();
                }
            } else {
                flash('Failed to Manage an Event')->error();
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Failed to Manage an Event')->error();
            return back()->with($request->all());
        }
        return redirect(route('events.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $event = $this->eventService->eventById($id);
            return view('backend.events.show', ['event' => $event]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Event\'s data not found!')->error();
            return redirect(route('events.index'));
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
            return view('backend.events.edit', [
                'event' => $event,
                'companies' => $companies,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Events table not found!')->error();
            return redirect(route('events.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(EventRequest $request, $id)
    {
        try {
            $event = $this->eventService->event_custom_update($request->except('event_image', '_token'), $id);
            if ($event) {
                $request['event_id'] = $event->id;
                $old_image = $request['existing_image'];
                if ($request->hasFile('event_image')) {
                    $image_url = $this->eventService->eventImage($request);
                    $event->event_image = $image_url;
                    $event->save();
                } else {
                    $event->event_image = $old_image;
                    $event->save();
                }
                flash('An Event has been updated successfully')->success();
                return redirect(route('events.index'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Failed to Update an Event')->error();
            return back()->withInput($request->all());
        }
        return redirect(route('events.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
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
        return redirect(route('events.index'));
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
            return view('backend.events.pdf', [
                'events' => $events,
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

    public function excel(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $events = $this->eventService->showAllEvent($requestData)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.events.excel', [
                'events' => $events,
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

    public function eventMarkedAsRead($id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications->find($id);
            $notification->markAsRead();
            $event_id = $notification->data['id'];
            return redirect(route('events.show', $event_id));
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Notification For this Event is Not Found', 'error');
            return redirect(back('events.index'));
        }

    }

    public function archive(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : \Utility::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $requestData['event_current_status'][0] = 'expired';
            $datas = $this->eventService->showAllEvent($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.events.archive', [
                'datas' => $datas,
                'request' => $request,
                'companies' => $companies,
                'branches' => $branches,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Events table not found!')->error();
            return redirect(route('dashboard'));
        }
    }
}
