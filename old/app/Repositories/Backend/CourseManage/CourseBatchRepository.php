<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\CourseBatch;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Exception;

class CourseBatchRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return CourseBatch::class;
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function courseBatchFilterData($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->leftJoin('companies', 'companies.id', '=', 'course_batches.company_id');
        $query->leftJoin('branches', 'branches.id', '=', 'course_batches.branch_id');
        $query->leftJoin('course', 'course.id', '=', 'course_batches.course_id');
        $query->leftJoin('users AS instructors', 'instructors.id', '=', 'course_batches.instructor_id');
        $query->leftJoin('user_details AS instructor_details', 'instructor_details.user_id', '=', 'instructors.id');
        //$query->leftJoin('course_batch_students', 'course_batch_students.course_batch_id', '=', 'course_batches.id');
        /*$query->leftJoin('users AS students', 'students.id', '=', 'course_batch_students.student_id');
        $query->leftJoin('user_details AS student_details', 'student_details.user_id', '=', 'instructors.id');*/

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->where('instructors.name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('instructors.mobile_number', 'like', "%{$filters['search_text']}%");
            $query->orWhere('instructors.email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('instructor_details.first_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('instructor_details.last_name', 'like', "%{$filters['search_text']}%");
            /*$query->orWhere('students.name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('students.mobile_number', 'like', "%{$filters['search_text']}%");
            $query->orWhere('students.email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('student_details.first_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('student_details.last_name', 'like', "%{$filters['search_text']}%");*/
            $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_address', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_mobile', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_address', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_mobile', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('course.course_title', 'like', "%{$filters['search_text']}%");
            $query->orWhere('course.course_short_description', 'like', "%{$filters['search_text']}%");
            $query->orWhere('course.course_description', 'like', "%{$filters['search_text']}%");
            $query->orWhere('course_batches.course_batch_name', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_batches.id', '=', $filters['id']);
        }
        if (isset($filters['course_batch_id']) && $filters['course_batch_id']) {
            $query->where('course_batches.id', '=', $filters['course_batch_id']);
        }
        if (isset($filters['course_batch_name']) && $filters['course_batch_name']) {
            $query->where('course_batches.course_batch_name', '=', $filters['course_batch_name']);
        }
        if (isset($filters['student_id']) && $filters['student_id']) {
            $query->where('course_batch_students.student_id', '=', $filters['student_id']);
        }

        if (isset($filters['instructor_id']) && $filters['instructor_id']) {
            $query->where('course_batches.instructor_id', '=', $filters['instructor_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course_batches.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_batches.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['company_name']) && $filters['company_name']) {
            $query->orWhere('companies.company_name', '=', $filters['company_name']);
        }

        if (isset($filters['company_email']) && $filters['company_email']) {
            $query->orWhere('companies.company_email', '=', $filters['company_email']);
        }

        if (isset($filters['company_phone']) && $filters['company_phone']) {
            $query->orWhere('companies.company_phone', '=', $filters['company_phone']);
        }

        if (isset($filters['company_mobile']) && $filters['company_mobile']) {
            $query->orWhere('companies.company_mobile', '=', $filters['company_mobile']);
        }

        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $query->where('course_batches.branch_id', '=', $filters['branch_id']);
        }

        if (isset($filters['course_batch_status']) && $filters['course_batch_status']) {
            $query->where('course_batches.course_batch_status', '=', $filters['course_batch_status']);
        }

        if (isset($filters['branch_name']) && $filters['branch_name']) {
            $query->orWhere('branches.branch_name', '=', $filters['branch_name']);
        }

        if (isset($filters['branch_phone']) && $filters['branch_phone']) {
            $query->orWhere('branches.branch_phone', '=', $filters['branch_phone']);
        }

        if (isset($filters['branch_mobile']) && $filters['branch_mobile']) {
            $query->orWhere('branches.branch_mobile', '=', $filters['branch_mobile']);
        }

        $query->whereNull('course.deleted_at');

        if (isset($filters['course_batch_order_by_id']) && $filters['course_batch_order_by_id']) {
            $query->orderBy('course_batches.id', $filters['course_batch_order_by_id']);
        }

        $query->select([
            'companies.*',
            \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
            'branches.*',
            'instructors.name AS instructor_name', 'instructors.mobile_number AS instructor_mobile_number', 'instructors.email AS instructor_email',
            'instructor_details.first_name AS instructor_detail_first_name', 'instructor_details.last_name AS instructor_last_name',
            \DB::raw('IFNULL(IF(instructor_details.user_detail_photo REGEXP "https?", instructor_details.user_detail_photo, CONCAT("'.url('/').'",instructor_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS instructor_detail_photo'),
            /*'students.name AS student_name', 'students.mobile_number AS student_mobile_number', 'students.email AS student_email',
            'student_details.first_name AS student_detail_first_name', 'student_details.last_name AS student_last_name',*/
            'course_batches.*',
            \DB::raw('IFNULL(IF(course_batches.course_batch_logo REGEXP "https?", course_batches.course_batch_logo, CONCAT("'.url('/').'",course_batches.course_batch_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS course_batch_logo'),
            \DB::raw('CONVERT_TZ(course_batches.created_at, "+00:00", "+06:00") AS created_at')
        ]);
        return $query;
    }

    /**
     * @param CourseBatch $courseBatch
     * @param array $pivot
     * @return CourseBatch|int
     */
    public function manageCourseBatchToStudent(CourseBatch $courseBatch, array $pivot)
    {
        try {
            if (!isset($pivot['student_id']) || empty($pivot['student_id'])) {
                $courseBatch->student()->detach();
            }
            $courseBatch->student()->sync($pivot['student_id']);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return $courseBatch;
    }
}
