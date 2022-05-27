<?php

namespace App\Repositories\Backend\Announcement;

use App\Models\Backend\Announcement\Announcement;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AnnouncementRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Announcement::class;
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function filterData($filters)
    {
        $query = $this->model->sortable()->newQuery();

        $query->join('companies',  'announcements.company_id', '=','companies.id');
        $query->join('course',  'announcements.course_id', '=','course.id');
        if (!empty($filters['announcement_type']) && $filters['announcement_type']=='assignment' && !empty($filters['student_id'])) {
            $query->leftjoinSub('select id AS course_assignment_id, course_id,announcement_id,student_id,count(student_id) noOfAssignment, created_at as assignment_created_at from course_assignments group by announcement_id,student_id', 'totalAssignment',
                function ($join) use ($filters) {
                    $join->on('course.id', '=', 'totalAssignment.course_id');
                    $join->on('announcements.id', '=', 'totalAssignment.announcement_id');
                    $join->on('totalAssignment.student_id', \DB::raw($filters['student_id']));
                });
            /*if (isset($filters['student_id']) && $filters['student_id']) {
                $query->where('totalAssignment.student_id', $filters['student_id']);
            }*/
            $select[] = \DB::raw('IFNULL(totalAssignment.noOfAssignment, 0) AS noOfAssignment');
            $select[] = \DB::raw('IFNULL(totalAssignment.assignment_created_at, 0) AS assignment_created_at');
            $select[] = ('totalAssignment.course_assignment_id');

        }
        if (!empty($filters['announcement_title'])) {
            $query->where('announcements.announcement_title', 'like', "%{$filters['announcement_title']}%");
        }

        if (!empty($filters['course_id'])) {
            $query->where('announcements.course_id', 'like', "%{$filters['course_id']}%");
        }

        if (!empty($filters['course_title'])) {
            $query->where('course.course_title', 'like', "%{$filters['course_title']}%");
        }

        if (!empty($filters['announcement_type'])) {
            $query->where('announcements.announcement_type', '=', $filters['announcement_type']);
        }
        if(
            isset($filters['announcement_start_date']) && $filters['announcement_start_date'] != '0000-00-00' && $filters['announcement_start_date'] != '' &&
            isset($filters['announcement_end_date']) && $filters['announcement_end_date'] != '0000-00-00' && $filters['announcement_end_date'] != ''
        ){
            $query->whereBetween(DB::raw('DATE(announcements.announcement_date)'), array($filters['announcement_start_date'], $filters['announcement_end_date']));
        }

        if(
            isset($filters['announcement_start_date']) && $filters['announcement_start_date'] != '0000-00-00' && $filters['announcement_start_date'] != '' &&
            empty($filters['announcement_end_date'])
        ){
            $query->whereBetween(DB::raw('DATE(announcements.announcement_date)'), array($filters['announcement_start_date'], $filters['announcement_start_date']));
        }

        if(
            isset($filters['announcement_end_date']) && $filters['announcement_end_date'] != '0000-00-00' && $filters['announcement_end_date'] != '' &&
            empty($filters['announcement_start_date'])
        ){
            $query->whereBetween(DB::raw('DATE(announcements.announcement_date)'), array($filters['announcement_end_date'], $filters['announcement_end_date']));
        }

        if(isset($filters['announcement_date']) && $filters['announcement_date'] != '0000-00-00' && $filters['announcement_date'] != ''){
            $query->whereBetween(DB::raw('DATE(announcements.announcement_date)'), array($filters['announcement_date'], $filters['announcement_date']));
        }
        if (!empty($filters['announcement_status'])) {
            $query->where('announcements.announcement_status', '=', $filters['announcement_status']);
        }
        if (!empty($filters['announcement_order_by_current_status'])) {
            $query->orderBy('announcement_current_status', $filters['announcement_order_by_current_status']);
        }

        if (!empty($filters['announcement_order_by_date'])) {
            $query->orderBy(\DB::raw('IFNULL(announcements.announcement_date, now())'), $filters['announcement_order_by_date']);
        }
        if (!empty($filters['announcement_order_by_id'])) {
            $query->orderBy('announcements.id', $filters['announcement_order_by_id']);
        }

        $select[] = 'announcements.*';
        $select[] = \DB::raw('LOWER(announcements.announcement_type) as announcement_types');
        $select[] = \DB::raw('IFNULL(announcements.announcement_date, DATE_FORMAT(NOW(), "%Y-%m-%d 23:59:59")) as announcement_date');
        $select[] = \DB::raw('(CASE WHEN  IFNULL(announcements.announcement_date, now()) > NOW() THEN "2_Upcoming"
                    WHEN IFNULL(announcements.announcement_date, now()) <= NOW() && IFNULL(announcements.announcement_date, now()) >= NOW() THEN "1_Running"
                    ELSE "3_Expired"
                    END) AS announcement_current_status');

        $query->select($select);

        $query->whereNull('course.deleted_at');
        $query->whereNull('companies.deleted_at');

        return $query;
    }
}
