<?php

namespace App\Services\Backend\Event;

use App\Repositories\Backend\Event\EventRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventService {
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CompanyService constructor.
     * @param EventRepository $eventRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct( EventRepository $eventRepository, FileUploadService $fileUploadService ) {
        $this->eventRepository = $eventRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createEvent( $input ) {
        try {
            return $this->eventRepository->firstOrCreate( $input );
        } catch ( ModelNotFoundException $e ) {
            Log::error( 'Events Table not found' );
        } catch ( Exception $e ) {
            Log::error( $e->getMessage() );
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateEvent( $input, $id ) {
        try {
            $event = $this->eventRepository->find( $id );
            $this->eventRepository->update( $input, $id );
            return $event;
        } catch ( ModelNotFoundException $e ) {
            Log::error( 'Event not found' );
        } catch ( Exception $e ) {
            Log::error( $e->getMessage() );
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteEvent( $id ) {
        return $this->eventRepository->delete( $id );
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllEvent( $input ) {
        return $this->eventRepository->filterData( $input );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function eventById( $id ) {
        return $this->eventRepository->findBy( 'id', $id );
    }

    /**
     * @param $input
     * @return string|null
     */
    public function eventImage( $input ): ?string{
        $data['image'] = $input->file( 'event_image' );
        $data['image_name'] = 'event_image_' . $input['event_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['event_image'];
        $data['width'] = UtilityService::$eventImageSize['width'];
        $data['height'] = UtilityService::$eventImageSize['height'];
        return $this->fileUploadService->savePhoto( $data );
    }

    /**
     * @param $input
     * @return false|mixed
     */
    public function event_custom_insert( $input ) {
        $date_range = explode( ' - ', $input['event_schedule'] );

        $event_start = $date_range[0] ?? null;
        $event_end = $date_range[1] ?? null;
        if ( $event_start == $event_end ) {
            $currentDate = strtotime( $event_start );
            $futureDate = $currentDate + ( 60 * 5 );
            $event_end = date( "Y-m-d H:i:s", $futureDate );
        }

        $output['company_id'] = $input['company_id'];
        $output['branch_id'] = $input['branch_id'];
        $output['event_type'] = $input['event_type'];
        $output['event_title'] = $input['event_title'];
        $output['event_description'] = ( $input['event_description'] );
        $output['event_link'] = $input['event_link'];
        $output['event_start'] = $event_start;
        $output['event_end'] = $event_end;
        $output['event_duration'] = $input['event_schedule'];
        $output['event_featured'] = $input['event_featured'];
        $output['event_status'] = $input['event_status'];
        $output['created_by'] = Auth::id();
        $output['created_at'] = Carbon::now();

        return $this->createEvent( $output );
    }

    /**
     * @param $input
     * @param $id
     * @return false|mixed
     */
    public function event_custom_update( $input, $id ) {
        $date_range = explode( ' - ', $input['event_schedule'] );

        $event_start = $date_range[0] ?? null;
        $event_end = $date_range[1] ?? null;
        if ( $event_start == $event_end ) {
            $currentDate = strtotime( $event_start );
            $futureDate = $currentDate + ( 60 * 5 );
            $event_end = date( "Y-m-d H:i:s", $futureDate );
        }

        $output['company_id'] = $input['company_id'];
        $output['branch_id'] = $input['branch_id'];
        $output['event_type'] = $input['event_type'];
        $output['event_title'] = $input['event_title'];
        $output['event_description'] = ( $input['event_description'] );
        $output['event_link'] = $input['event_link'];
        $output['event_start'] = $event_start;
        $output['event_end'] = $event_end;
        $output['event_duration'] = $input['event_schedule'];
        $output['event_featured'] = $input['event_featured'];
        $output['event_status'] = $input['event_status'];
        $output['updated_by'] = Auth::id();
        $output['updated_at'] = date( 'Y-m-d H:i:s' );
        return $this->updateEvent( $output, $id );
    }

    /**
     * @param array $input
     * @param string $prefix
     * @return array
     */
    public function dateRangeForEventPicker( array $input, string $prefix = '' ): array
    {
        return [
            $prefix . 'start_date'        => (
                isset( $input[$prefix . 'start_date'] ) ? $input[$prefix . 'start_date'] . ' 00:00:01' : Carbon::now()->format( 'Y-m-d' ) . ' 00:00:01'
            ),
            $prefix . 'end_date'          => (
                isset( $input[$prefix . 'end_date'] ) ? $input[$prefix . 'end_date'] . ' 23:59:59' : Carbon::now()->format( 'Y-m-d' ) . ' 23:59:59'
            ),
            $prefix . 'date_range'        => Carbon::now()->format( 'F d, Y' ) . ' - ' . Carbon::now()->format( 'F d, Y' ),
            $prefix . 'filter_search_btn' => ( isset( $input[$prefix . 'filter_search_btn'] ) ? $input[$prefix . 'filter_search_btn'] : 'not_clicked' ),
        ];
    }

}
