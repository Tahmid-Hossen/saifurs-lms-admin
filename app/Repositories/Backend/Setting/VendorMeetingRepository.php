<?php


namespace App\Repositories\Backend\Setting;


use App\Models\Backend\Setting\VendorMeeting;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class VendorMeetingRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return VendorMeeting::class;
    }

    /**
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function vendorMeetingFilterData($filter): \Illuminate\Database\Eloquent\Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->leftJoin('vendors', 'vendors.id', '=', 'vendor_meetings.vendor_id');
        $query->leftJoin('course', 'course.id', '=', 'vendor_meetings.course_id');
        $query->leftJoin('companies', 'companies.id', '=', 'vendor_meetings.company_id');
        $query->leftJoin('branches', 'branches.id', '=', 'vendor_meetings.branch_id');
        $query->leftJoin('course_classes', 'course_classes.id', '=', 'vendor_meetings.course_class_id');
        $query->leftJoin('course_chapters', 'course_chapters.id', '=', 'vendor_meetings.course_chapter_id');
        $query->leftJoin('course_batches', 'course_batches.id', '=', 'vendor_meetings.course_batch_id');
        $query->leftJoin('users AS instructors', 'instructors.id', '=', 'vendor_meetings.instructor_id');
        $query->leftJoin('user_details AS instructor_details', 'instructor_details.user_id', '=', 'instructors.id');


        if (isset($filter['search_text']) && $filter['search_text']) {
            $query->where('vendors.vendor_name', 'like', "%{$filter['search_text']}%");
            $query->orWhere('vendors.vendor_status', 'like', "%{$filter['search_text']}%");
            $query->orWhere('vendor_meetings.vendor_meeting_owner_id', 'like', "%{$filter['search_text']}%");
            $query->orWhere('vendor_meetings.vendor_meeting_title', 'like', "%{$filter['search_text']}%");
            $query->orWhere('vendor_meetings.vendor_meeting_status', 'like', "%{$filter['search_text']}%");
            $query->where('course.course_title', 'like', "%{$filter['search_text']}%");
            $query->orWhere('companies.company_name', 'like', "%{$filter['search_text']}%");
            $query->orWhere('branches.branch_name', 'like', "%{$filter['search_text']}%");
            $query->where('course_classes.class_name', 'like', "%{$filter['search_text']}%");
            $query->orWhere('course_classes.class_type', 'like', "%{$filter['search_text']}%");
            $query->where('course_chapters.chapter_title', 'like', "%{$filter['search_text']}%");
            $query->orWhere('course_chapters.chapter_seo_title', 'like', "%{$filter['search_text']}%");
            $query->orWhere('course_batches.course_batch_name', 'like', "%{$filter['search_text']}%");
        }

        if (isset($filter['id']) && $filter['id']) {
            $query->where('vendor_meetings.id', '=', $filter['id']);
        }

        if (isset($filter['vendor_meeting_id']) && $filter['vendor_meeting_id']) {
            $query->where('vendor_meetings.id', '=', $filter['vendor_meeting_id']);
        }

        if (isset($filter['vendor_meeting_title']) && $filter['vendor_meeting_title']) {
            $query->where(DB::raw('LOWER(vendor_meetings.vendor_meeting_title)'), '=', strtolower($filter['vendor_meeting_title']));
        }

        if (isset($filter['vendor_status']) && $filter['vendor_status']) {
            $query->where('vendor_meetings.vendor_status', '=', $filter['vendor_status']);
        }

        if(
            isset($filter['vendor_meeting_start_time']) && $filter['vendor_meeting_start_time'] != '0000-00-00' && $filter['vendor_meeting_start_time'] != '' &&
            isset($filter['vendor_meeting_end_time']) && $filter['vendor_meeting_end_time'] != '0000-00-00' && $filter['vendor_meeting_end_time'] != ''
        ){
            $query->where('vendor_meetings.vendor_meeting_start_time', '<=', $filter['vendor_meeting_start_time']);
            $query->where('vendor_meetings.vendor_meeting_end_time', '<=', $filter['vendor_meeting_end_time']);
        }

        if(
            isset($filter['vendor_meeting_start_time']) && $filter['vendor_meeting_start_time'] != '0000-00-00' && $filter['vendor_meeting_start_time'] != ''
        ){
            $query->whereBetween('vendor_meetings.vendor_meeting_start_time', array($filter['vendor_meeting_start_time'].'00:00:01', $filter['vendor_meeting_start_time'].'23:59:59'));
        }

        if(
            isset($filter['vendor_meeting_end_time']) && $filter['vendor_meeting_end_time'] != '0000-00-00' && $filter['vendor_meeting_end_time'] != ''
        ){
            $query->whereBetween('vendor_meetings.vendor_meeting_end_time', array($filter['vendor_meeting_end_time'].'00:00:01', $filter['vendor_meeting_end_time'].'23:59:59'));
        }

        if (isset($filter['company_id']) && $filter['company_id']) {
            $query->where('vendor_meetings.company_id', '=', $filter['company_id']);
        }

        if (isset($filter['branch_id']) && $filter['branch_id']) {
            $query->where('vendor_meetings.branch_id', '=', $filter['branch_id']);
        }

        if (isset($filter['vendor_id']) && $filter['vendor_id']) {
            $query->where('vendor_meetings.vendor_id', '=', $filter['vendor_id']);
        }

        if (isset($filter['course_id']) && $filter['course_id']) {
            $query->where('vendor_meetings.course_id', '=', $filter['course_id']);
        }

        if (isset($filter['course_batch_id']) && $filter['course_batch_id']) {
            $query->where('vendor_meetings.course_batch_id', '=', $filter['course_batch_id']);
        }

        if (isset($filter['course_chapter_id']) && $filter['course_chapter_id']) {
            $query->where('vendor_meetings.course_chapter_id', '=', $filter['course_chapter_id']);
        }

        if (isset($filter['course_class_id']) && $filter['course_class_id']) {
            $query->where('vendor_meetings.course_class_id', '=', $filter['course_class_id']);
        }

        if (isset($filter['instructor_id']) && $filter['instructor_id']) {
            $query->where('vendor_meetings.instructor_id', '=', $filter['instructor_id']);
        }
        $query->whereNull('vendor_meetings.deleted_at');
        $query->whereNull('instructors.deleted_at');
        $query->whereNull('vendors.deleted_at');
        $query->whereNull('companies.deleted_at');
        $query->whereNull('course.deleted_at');

        $query->select(
            [
                'companies.company_name', \DB::raw('CONCAT("'.url('/').'",companies.company_logo) AS company_logo'),
                'branches.branch_name',
                'course.course_title', \DB::raw('CONCAT("'.url('/').'",course.course_image) AS course_image'),
                'course_chapters.chapter_title', \DB::raw('CONCAT("'.url('/').'",course_chapters.chapter_image) AS chapter_image'),
                'course_classes.*', \DB::raw('CONCAT("'.url('/').'",course_classes.class_image) AS class_image'),
                'course_batches.course_batch_name', \DB::raw('CONCAT("'.url('/').'",course_batches.course_batch_logo) AS course_batch_logo'),
                'instructors.name AS instructor_name', 'instructors.mobile_number AS instructor_mobile_number', 'instructors.email AS instructor_email',
                'instructor_details.first_name AS instructor_detail_first_name', 'instructor_details.last_name AS instructor_last_name',
                \DB::raw('IFNULL(IF(instructor_details.user_detail_photo REGEXP "https?", instructor_details.user_detail_photo, CONCAT("'.url('/').'",instructor_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS instructor_detail_photo'),
                'vendors.vendor_name', \DB::raw('CONCAT("'.url('/').'",vendors.vendor_logo) AS vendor_logo'),
                'vendor_meetings.*',
                \DB::raw('CONCAT("'.url('/').'",vendor_meetings.vendor_meeting_logo) AS vendor_meeting_logo'),
                \DB::raw('CONVERT_TZ(vendor_meetings.created_at, "+00:00", "+06:00") AS created_at'),
                \DB::raw('CONVERT_TZ(vendor_meetings.vendor_meeting_start_time, "+00:00", "+06:00") AS vendor_meeting_start_time'),
                \DB::raw('CONVERT_TZ(vendor_meetings.vendor_meeting_end_time, "+00:00", "+06:00") AS vendor_meeting_end_time')

            ]
        );
        return $query;
    }
}
