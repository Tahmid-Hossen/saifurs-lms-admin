<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\Course;
use App\Repositories\Repository;

class CourseRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Course::class;
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
    public function course($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course.company_id');
        $query->leftJoin('branches', 'branches.id', '=', 'course.branch_id');
        $query->leftJoin('course_category', 'course_category.id', '=', 'course.course_category_id');
        $query->leftJoin('course_sub_category', 'course_sub_category.id', '=', 'course.course_sub_category_id');
        $query->leftJoin('course_child_category', 'course_child_category.id', '=', 'course.course_child_category_id');
        $query->joinSub('select course_classes.id as course_class_id,course_classes.course_id,count(course_classes.course_id) noOfClass from course_classes group by course_id', 'totalClasses', 'course.id', '=', 'totalClasses.course_id', 'left');

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->Where(function ($queryString) use ($filters) {
                $queryString->Where('course.course_title', 'like', "%{$filters['search_text']}%");
                $queryString->Where('course.course_option', 'like', "%{$filters['search_text']}%");
                $queryString->Where('course.course_type', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course.course_slug', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course.course_description', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course.course_status', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course.course_featured', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course.course_seo_title', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('branches.branch_name', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course_category.course_category_title', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course_sub_category.course_sub_category_title', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course_child_category.course_child_category_title', 'like', "%{$filters['search_text']}%");
                $queryString->orWhere('course.course_position', 'like', "%{$filters['search_text']}%");
            });
         }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course.id', '=', $filters['course_id']);
        }

        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $query->where('course.branch_id', '=', $filters['branch_id']);
        }

        if (isset($filters['course_category_id']) && $filters['course_category_id']) {
            $query->where('course.course_category_id', '=', $filters['course_category_id']);
        }

        if (isset($filters['course_sub_category_id']) && $filters['course_sub_category_id']) {
            $query->where('course.course_sub_category_id', '=', $filters['course_sub_category_id']);
        }

        if (isset($filters['course_child_category_id']) && $filters['course_child_category_id']) {
            $query->where('course.course_child_category_id', '=', $filters['course_child_category_id']);
        }

        if (isset($filters['course_title']) && $filters['course_title']) {
            $query->where('course.course_title', '=', $filters['course_title']);
        }

        if(isset($filters['course_option']) && $filters['course_option']) {
            $query->where('course.course_option', '=', $filters['course_option']);
        }

        if(isset($filters['course_type']) && $filters['course_type']) {
            $query->where('course.course_type', '=', $filters['course_type']);
        }

        if(isset($filters['course_type_is_not']) && $filters['course_type_is_not']) {
            $query->where(function ($queryString) use ($filters) {
                $queryString->where('course.course_type', '!=', $filters['course_type_is_not']);
                $queryString->orWhereNull('course.course_type');
            });
        }

        if(isset($filters['course_option_is_not']) && $filters['course_option_is_not']) {
            $query->where('course.course_option', '!=', $filters['course_option_is_not']);
        }

        if (isset($filters['course_title_wild_card']) && $filters['course_title_wild_card']) {
            $query->where(\DB::raw('LOWER(course.course_title)'), 'like', "%".strtolower($filters['course_title_wild_card'])."%");
        }

        if (isset($filters['course_slug']) && $filters['course_slug']) {
            $query->where('course.course_slug', '=', $filters['course_slug']);
        }

        if (isset($filters['course_description']) && $filters['course_description']) {
            $query->where('course.course_description', '=', $filters['course_description']);
        }


        if (isset($filters['course_status']) && $filters['course_status']) {
            $query->where('course.course_status', '=', $filters['course_status']);
        }

        if (isset($filters['course_featured']) && $filters['course_featured']) {
            $query->where('course.course_featured', '=', $filters['course_featured']);
        }

        if (isset($filters['course_category_title']) && $filters['course_category_title']) {
            $query->where('course_category.course_category_title', '=', $filters['course_category_title']);
        }

        if (isset($filters['course_content_type']) && $filters['course_content_type']) {
            $query->where('course.course_content_type', '=', $filters['course_content_type']);
        }

        if (isset($filters['course_category_slug']) && $filters['course_category_slug']) {
            $query->where('course_category.course_category_slug', '=', $filters['course_category_slug']);
        }

        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course.created_at', array($filters['created_at'], $filters['created_at']));
        }

        if (isset($filters['course_sorting']) && $filters['course_sorting']) {
            $query->orderBy('course.id', $filters['course_sorting']);
        }

        if (isset($filters['course_a_to_z_sorting']) && $filters['course_a_to_z_sorting']) {
            $query->orderBy('course.course_title', $filters['course_a_to_z_sorting']);
        }

        if (isset($filters['course_regular_price_sorting']) && $filters['course_regular_price_sorting']) {
/*            $query->orderBy(\DB::raw('IFNULL(course.course_discount, course.course_regular_price)'), $filters['course_regular_price_sorting']);*/
            $query->orderBy(\DB::raw('IFNULL(IF(course.course_discount = 0, course.course_regular_price, course.course_discount), course.course_regular_price)'), $filters['course_regular_price_sorting']);
        }

        if (isset($filters['is_batch']) && $filters['is_batch'] == true) {
            $query->leftjoinSub('SELECT course_batches.course_id, course_batch_status, count( course_batches.course_id ) noOfBatches FROM course_batches GROUP BY course_id', 'totalBatches',
                function($join){
                    $join->on('totalBatches.course_id','=','course.id');
                    //$join->on('totalBatches.course_batch_status','=','ACTIVE');
                });
            $query->where('totalBatches.noOfBatches', '>=', 1);
            $query->where('totalBatches.course_batch_status', '=', 'ACTIVE');
            $select[] = 'totalBatches.course_id AS batch_course_id';
            $select[] = 'totalBatches.noOfBatches AS noOfBatches';
        }

        if (isset($filters['is_instructor']) && $filters['is_instructor'] == true) {
            $query->leftJoin('course_batches', 'course_batches.course_id', '=', 'course.id');
            $query->leftJoin('users AS instructors', 'instructors.id', '=', 'course_batches.instructor_id');
            $query->leftJoin('user_details AS instructor_details', 'instructor_details.user_id', '=', 'instructors.id');
            if (isset($filters['instructor_id']) && $filters['instructor_id']) {
                $query->where('course_batches.instructor_id', $filters['instructor_id']);
            }
            $select[] = 'instructors.name AS instructor_name';
            $select[] = 'instructors.mobile_number AS instructor_mobile_number';
            $select[] = 'instructors.email AS instructor_email';
            $select[] = 'instructor_details.first_name AS instructor_detail_first_name';
            $select[] = 'instructor_details.last_name AS instructor_last_name';
            $select[] = \DB::raw('IFNULL(IF(instructor_details.user_detail_photo REGEXP "https?", instructor_details.user_detail_photo, CONCAT("'.url('/').'",instructor_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS instructor_detail_photo');
        }
//WHERE course_chapters.deleted_at IS NULL AND course_classes.deleted_at IS NULL
        if (isset($filters['is_student']) && $filters['is_student'] == true) {
            $query->leftJoin('course_batches', 'course_batches.course_id', '=', 'course.id');
            $query->leftJoin('course_batch_students', 'course_batch_students.course_batch_id', '=', 'course_batches.id');
            $query->leftJoin('users AS students', 'students.id', '=', 'course_batch_students.student_id');
            $query->leftJoin('user_details AS student_details', 'student_details.user_id', '=', 'students.id');
            $query->leftjoinSub('SELECT course_classes.course_id, course_progresses.student_id, count( course_progresses.student_id ) noOfClassProgress FROM course_progresses LEFT JOIN course_classes ON course_classes.id = course_progresses.course_class_id GROUP BY course_id, student_id', 'totalClassesProgress',
                function($join){
                    $join->on('totalClassesProgress.course_id','=','course.id');
                    $join->on('students.id','=','totalClassesProgress.student_id');
                });
            if (isset($filters['student_id']) && $filters['student_id']) {
                $query->where('course_batch_students.student_id', $filters['student_id']);
            }
            $select[] = 'students.name AS student_name';
            $select[] = 'students.mobile_number AS student_mobile_number';
            $select[] = 'students.email AS student_email';
            $select[] = 'student_details.first_name AS student_detail_first_name';
            $select[] = 'student_details.last_name AS student_last_name';
            $select[] = \DB::raw('IFNULL(IF(student_details.user_detail_photo REGEXP "https?", student_details.user_detail_photo, CONCAT("'.url('/').'",student_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS student_detail_photo');
            $select[] = \DB::raw('IFNULL(totalClassesProgress.noOfClassProgress, 0) AS noOfClassProgress');

        }

        $query->whereNull('companies.deleted_at');

        $query->orderBy( 'course.id', 'desc' );
        $select[] = 'companies.company_name';
        $select[] = \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo');
        $select[] = 'course_category.course_category_title';
        $select[] = \DB::raw('IFNULL(IF(course_category.course_category_image REGEXP "https?", course_category.course_category_image, CONCAT("'.url('/').'",course_category.course_category_image)), CONCAT("'.url('/').'","/assets/img/default.png")) AS course_category_image');
        $select[] = 'course_sub_category.course_sub_category_title';
        $select[] = \DB::raw('IFNULL(IF(course_sub_category.course_sub_category_image REGEXP "https?", course_sub_category.course_sub_category_image, CONCAT("'.url('/').'",course_sub_category.course_sub_category_image)), CONCAT("'.url('/').'","/assets/img/default.png")) AS course_sub_category_image');
        $select[] = 'course_child_category.course_child_category_title';
        $select[] = \DB::raw('IFNULL(IF(course_child_category.course_child_category_image REGEXP "https?", course_child_category.course_child_category_image, CONCAT("'.url('/').'",course_child_category.course_child_category_image)), CONCAT("'.url('/').'","/assets/img/default.png")) AS course_child_category_image');
        $select[] = 'course.*';
        $select[] = \DB::raw('course.id AS course_id');
        $select[] = \DB::raw('IFNULL(IF(course.course_image REGEXP "https?", course.course_image, CONCAT("'.url('/').'",course.course_image)), CONCAT("'.url('/').'","/assets/img/default.png")) AS course_image');
        $select[] = \DB::raw('IFNULL(course.course_regular_price, "0.00") AS course_regular_price');
        $select[] = \DB::raw('IFNULL(totalClasses.noOfClass, 0) AS noOfClass');


        $query->select($select);


        return $query;
    }

    public function manageTags(Course $course, array $pivot): Course
    {
        try {
            $course->tags()->sync($pivot);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return $course;
    }

    public function update(array $data, $id) : Course
    {
        $course = $this->model->find($id);
        $course->fill($data);
        $course->save();
        return $course;
    }

}
