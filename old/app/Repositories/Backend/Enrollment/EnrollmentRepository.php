<?php


namespace App\Repositories\Backend\Enrollment;


use App\Models\Backend\Enrollment\Enrollment;
use App\Repositories\Repository;

class EnrollmentRepository extends Repository
{

    /**
     * Specify Model Learn name
     *
     * @return mixed
     */
    public function model()
    {
        return Enrollment::class;
    }

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param       $query
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @param $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function enrollment($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'enrollments.company_id');
        $query->leftJoin('users', 'users.id', '=', 'enrollments.user_id');
        $query->leftJoin('course', 'course.id', '=', 'enrollments.course_id');
        $query->leftJoin('course_batches', 'course_batches.course_id', '=', 'course.id');
        //$query->leftJoin('course_classes', 'course_classes.course_id', '=', 'course.id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('enrollments.enroll_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('enrollments.enroll_details', 'like', "%{$filters['search_text']}%");
            //  $query->orWhere('enrollments.order_id', 'like', "%{$filters['search_text']}%");
             $query->orWhere('enrollments.enroll_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('users.name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_batches.course_batch_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course.course_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_name', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('enrollments.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('enrollments.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['user_id']) && $filters['user_id']) {
            $query->where('enrollments.user_id', '=', $filters['user_id']);
        }

        if (isset($filters['batch_id']) && $filters['batch_id']) {
            $query->where('enrollments.batch_id', '=', $filters['batch_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('enrollments.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['class_id']) && $filters['class_id']) {
            $query->where('enrollments.class_id', '=', $filters['class_id']);
        }

        if (isset($filters['enroll_title']) && $filters['enroll_title']) {
            $query->where('enrollments.enroll_title', '=', $filters['enroll_title']);
        }

        if (isset($filters['enroll_details']) && $filters['enroll_details']) {
            $query->where('enrollments.enroll_details', '=', $filters['enroll_details']);
        }

        if (isset($filters['enroll_status']) && $filters['enroll_status']) {
            $query->where('enrollments.enroll_status', '=', $filters['enroll_status']);
        }


        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('enrollments.created_at', array($filters['created_at'], $filters['created_at']));
        }

         $query
            ->orderBy('enrollments.id', 'desc')
            ->select([
                'companies.*', 'enrollments.*'
            ]);


        return $query;
    }

}
