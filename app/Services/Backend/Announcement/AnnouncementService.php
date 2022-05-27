<?php

namespace App\Services\Backend\Announcement;

use App\Repositories\Backend\Announcement\AnnouncementRepository;
use App\Support\Configs\Constants;
use Exception;
use Auth;
use Carbon\Carbon;

class AnnouncementService {
    /**
     * @var AnnouncementRepository
     */
    private $announcementRepository;

    /**
     * UserDetailsService constructor.
     * @param AnnouncementRepository $announcementRepository
     */
    public function __construct( AnnouncementRepository $announcementRepository ) {
        $this->announcementRepository = $announcementRepository;
    }

    public function returnArray( $object, $id, $columName ) {
        $arr = [];
        foreach ( $object as $obj ) {
            $arr[$obj->$id] = $obj->$columName;
        }
        return $arr;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createAnnouncement( $input ) {
        try {
            return $this->announcementRepository->create( $input );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateAnnouncement( $input, $id ) {
        try {
            $announcements = $this->announcementRepository->find( $id );
            $this->announcementRepository->update( $input, $id );
            return $announcements;

        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
        }
        return false;
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllAnnouncement( $input ) {
        return $this->announcementRepository->filterData( $input );
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showAnnouncementByID($id)
    {
        return $this->announcementRepository->find($id);
    }

    /**
     * @param $input
     * @return false|mixed
     */
    public function announcement_custom_insert( $input ) {
        $output['company_id'] = $input['company_id'];
        $output['course_id'] = $input['course_id'];
        $output['announcement_title'] = $input['announcement_title'];
        $output['announcement_details'] = ( $input['announcement_details'] );
        $output['announcement_date'] = ($input['announcement_date']??null);
        $output['announcement_type'] = ($input['announcement_type']??\Utility::$announcementType['general']);
        $output['announcement_status'] = isset($input['announcement_status']) ? $input['announcement_status'] : Constants::$user_active_status;
        $output['created_by'] = Auth::id();
        $output['created_at'] = Carbon::now();
        return $this->createAnnouncement( $output );
    }

    /**
     * @param $inputUpdate
     * @param $id
     * @return bool|mixed
     */
    public function announcement_custom_update( $input, $id ) {
        $output['company_id'] = $input['company_id'];
        $output['course_id'] = $input['course_id'];
        $output['announcement_title'] = $input['announcement_title'];
        $output['announcement_details'] = ( $input['announcement_details'] );
        $output['announcement_date'] = ($input['announcement_date']??null);
        $output['announcement_type'] = ($input['announcement_type']??\Utility::$announcementType['general']);
        $output['announcement_status'] = isset($input['announcement_status']) ? $input['announcement_status'] : Constants::$user_active_status;
        $output['updated_by'] = Auth::id();
        $output['updated_at'] = Carbon::now();
        return $this->updateAnnouncement( $output, $id );
    }
}
