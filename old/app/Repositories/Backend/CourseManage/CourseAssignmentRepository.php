<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\CourseAssignment;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class CourseAssignmentRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return CourseAssignment::class;
    }

    public function courseAssignmentFilterData($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->leftJoin('users AS instructors', 'instructors.id', '=', 'course_assignments.instructor_id');
        $query->leftJoin('user_details AS instructor_details', 'instructor_details.user_id', '=', 'instructors.id');
        $query->leftJoin('users AS students', 'students.id', '=', 'course_assignments.student_id');
        $query->leftJoin('user_details AS student_details', 'student_details.user_id', '=', 'instructors.id');
        $query->leftJoin('course', 'course.id', '=', 'course_assignments.course_id');
        $query->leftJoin('companies', 'companies.id', '=', 'course_assignments.company_id');
        $query->leftJoin('branches', 'branches.id', '=', 'course_assignments.branch_id');

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->where('instructors.name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('instructors.mobile_number', 'like', "%{$filters['search_text']}%");
            $query->orWhere('instructors.email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('instructor_details.first_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('instructor_details.last_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('students.name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('students.mobile_number', 'like', "%{$filters['search_text']}%");
            $query->orWhere('students.email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('student_details.first_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('student_details.last_name', 'like', "%{$filters['search_text']}%");
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
            $query->orWhere('course_assignments.course_assignment_name', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_assignments.id', '=', $filters['id']);
        }
        if (isset($filters['course_assignment_id']) && $filters['course_assignment_id']) {
            $query->where('course_assignments.id', '=', $filters['course_assignment_id']);
        }
        if (isset($filters['course_assignment_name']) && $filters['course_assignment_name']) {
            $query->where('course_assignments.course_assignment_name', '=', $filters['course_assignment_name']);
        }
        if (isset($filters['course_assignment_review']) && $filters['course_assignment_review']) {
            $query->where('course_assignments.course_assignment_review', '=', $filters['course_assignment_review']);
        }
        if (isset($filters['course_assignment_status']) && $filters['course_assignment_status']) {
            $query->where('course_assignments.course_assignment_status', '=', $filters['course_assignment_status']);
        }

        if (isset($filters['student_id']) && $filters['student_id']) {
            $query->where('course_assignments.student_id', '=', $filters['student_id']);
        }

        if (isset($filters['instructor_id']) && $filters['instructor_id']) {
            $query->where('course_assignments.instructor_id', '=', $filters['instructor_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course_assignments.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['course_chapter_id']) && $filters['course_chapter_id']) {
            $query->where('course_assignments.course_chapter_id', '=', $filters['course_chapter_id']);
        }


        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_assignments.company_id', '=', $filters['company_id']);
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
            $query->where('course_assignments.branch_id', '=', $filters['branch_id']);
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

        if (isset($filters['course_assignment_order_by_id']) && $filters['course_assignment_order_by_id']) {
            $query->orderBy('course_assignments.id', $filters['course_assignment_order_by_id']);
        }

        $query->select([
            'companies.*', 'branches.*',
            'instructors.name AS instructor_name', 'instructors.mobile_number AS instructor_mobile_number', 'instructors.email AS instructor_email',
            'instructor_details.first_name AS instructor_detail_first_name', 'instructor_details.last_name AS instructor_last_name',
            \DB::raw('IFNULL(IF(instructor_details.user_detail_photo REGEXP "https?", instructor_details.user_detail_photo, CONCAT("'.url('/').'",instructor_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS instructor_detail_photo'),
            'students.name AS student_name', 'students.mobile_number AS student_mobile_number', 'students.email AS student_email',
            'student_details.first_name AS student_detail_first_name', 'student_details.last_name AS student_last_name',
            \DB::raw('IFNULL(IF(student_details.user_detail_photo REGEXP "https?", student_details.user_detail_photo, CONCAT("'.url('/').'",student_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS student_detail_photo'),
            'course_assignments.*',
            \DB::raw('IFNULL(IF(course_assignments.course_assignment_document REGEXP "https?", course_assignments.course_assignment_document, CONCAT("'.url('/').'",course_assignments.course_assignment_document)), CONCAT("'.url('/').'","/assets/img/default.png")) AS course_assignment_document'),
            \DB::raw('CONVERT_TZ(course_assignments.created_at, "+00:00", "+06:00") AS created_at')
        ]);
        return $query;
    }
}
