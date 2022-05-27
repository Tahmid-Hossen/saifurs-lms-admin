<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\Event\EventRequest;
use App\Models\User;
use App\Notifications\EventsNotification;
use App\Services\Backend\Event\EventService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Support\Configs\Constants;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController
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

    public function __construct(
        CompanyService $companyService,
        BranchService $branchService,
        UserService $userService,
        EventService $eventService
    ) {
        $this->eventService = $eventService;
        $this->companyService = $companyService;
        $this->branchService = $branchService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request ): JsonResponse
    {
        try {
            $request->display_item_per_page = $request->display_item_per_page ?? \Utility::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $request['event_status'] = Constants::$user_active_status;

            $requestData = array_merge( $companyWiseUser, $request->all() );
            $requestData['event_current_status'][0] = 'running';
            $requestData['event_current_status'][1] = 'upcoming';

            $events = $this->eventService->showAllEvent( $requestData )->paginate( $request->display_item_per_page );
            if(isset($events)):
                $eventArray = array();
                foreach ($events as $event):
                    $eventArray[] = $event;
                    if(!empty($event['event_duration'])):
                    $date_range = explode( ' - ', $event['event_duration'] );
                    $event_start = $date_range[0] ?? null;
                    $event_end = $date_range[1] ?? null;

                    $event->event_start = $event_start;
                    $event->event_end = $event_end;
                    endif;
                    $event_current_status = explode('_', $event->event_current_status);
                    $event->event_current_status = $event_current_status[1];
                    $event->event_image = $event->event_image_full_path;
                    $event->user_list_id = $event->eventUserList->pluck('id');
                    $event->makeHidden('eventUserList');
                endforeach;
                //$data['companies'] = $this->companyService->showAllCompany( $companyWiseUser )->get();
                //$data['branches'] = $this->branchService->showAllBranch( $companyWiseUser )->get();
                $paginate_properties = json_decode($events->toJSON());
                $data['events']['current_page'] = $paginate_properties->current_page;
                $data['events']['data'] = $eventArray;
                $data['events']['first_page_url'] = $paginate_properties->first_page_url;
                $data['events']['from'] = $paginate_properties->from;
                $data['events']['last_page'] = $paginate_properties->last_page;
                $data['events']['last_page_url'] = $paginate_properties->last_page_url;
                $data['events']['next_page_url'] = $paginate_properties->next_page_url;
                $data['events']['path'] = $paginate_properties->path;
                $data['events']['per_page'] = $paginate_properties->per_page;
                $data['events']['prev_page_url'] = $paginate_properties->prev_page_url;
                $data['events']['to'] = $paginate_properties->to;
                $data['events']['total'] = $paginate_properties->total;
                $data['request'] = $request->all();
                $data['status'] = true;
            else:
                $data['status'] = false;
                $data['message'] = 'Event Data Not Found';
            endif;
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Events table not found!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(EventRequest $request ): JsonResponse
    {
        try {
            DB::beginTransaction();
            $event = $this->eventService->event_custom_insert( $request->except( 'event_image', '_token' ) );
            if ( $event ) {
                $request['event_id'] = $event->id;
                if ( $request->hasFile( 'event_image' ) ) {
                    $image_url = $this->eventService->eventImage( $request );
                    $event->event_image = $image_url;
                    $event->save();
                    $users = User::get();
                    foreach ( $users as $user ) {
                        $user->notify( new EventsNotification( $event ) );
                    }
                    $data['event'] = $event;
                    $data['status'] = true;
                    $data['message'] = 'An Event has been Successfully Managed';
                }
                DB::commit();
            } else {
                DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to Manage an Event';
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to Manage an Event!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id ): JsonResponse
    {
        try {
            $event = $this->eventService->eventById( $id );
            $event->event_image = $event->event_image_full_path;
            $event->user_list_id = $event->eventUserList->pluck('id');
            $event->makeHidden('eventUserList');
            $data['event'] = $event;
            if(!empty($event['event_duration'])):
                $date_range = explode( ' - ', $event['event_duration'] );
                $event_start = $date_range[0] ?? null;
                $event_end = $date_range[1] ?? null;

                $data['event']->event_start = $event_start;
                $data['event']->event_end = $event_end;
            endif;
            $data['status'] = true;
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Event\'s data not found!!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventRequest $request
     * @param $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(EventRequest $request, $id ): JsonResponse
    {
        try {
            DB::beginTransaction();
            $event = $this->eventService->event_custom_update( $request->except( 'event_image', '_token' ), $id );
            if ( $event ) {
                $request['event_id'] = $event->id;
                $old_image = $request['existing_image'];
                if ( $request->hasFile( 'event_image' ) ) {
                    $image_url = $this->eventService->eventImage( $request );
                    $event->event_image = $image_url;
                    $event->save();
                } else {
                    $event->event_image = $old_image;
                    $event->save();
                }
                $data['event'] = $event;
                $data['status'] = true;
                $data['message'] = 'An Event has been updated successfully';
            }
            DB::commit();
        } catch ( \Exception $e ) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to Update an Event!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function destroy($id ): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user_get = $this->userService->whoIS( $_REQUEST );
            if ( isset( $user_get ) && isset( $user_get->id ) && $user_get->id == auth()->user()->id ) {
                $event = $this->eventService->eventByID( $id );
                if ( $event ) {
                    $event->delete();
                    $data['status'] = true;
                    $data['message'] = 'An Event has been deleted successfully';
                } else {
                    DB::rollback();
                    $data['status'] = false;
                    $data['message'] = 'An Event is not found!';
                }
            } else {
                $data['status'] = false;
                $data['message'] = 'You Entered Wrong Password!';
            }
            DB::commit();
        } catch ( \Exception $e ) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'An Event is not found!!';
        }
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function eventMarkedAsRead($id ): JsonResponse
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications->find( $id );
            $notification->markAsRead();
            $event_id = $notification->data['id'];
            $data['event'] = $this->eventService->eventById( $event_id );
            $data['status'] = true;
            $data['message'] = 'Notification For this Event read successfully';
        } catch ( Exception $exception ) {
            \Log::error( $exception->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Notification For this Event is Not Found!!';
        }
        return response()->json($data,200);
    }
}
