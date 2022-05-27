<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\CourseQuestion;
use App\Repositories\Repository;

class CourseQuestionRepository extends Repository
{

    /**
     * Specify Model Question name
     *
     * @return mixed
     */
    public function model()
    {
        return CourseQuestion::class;
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
    public function courseQuestion($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course_questions.company_id');
/*        $query->leftJoin('course_category', 'course_category.id', '=', 'course_questions.course_category_id');
        $query->leftJoin('course_sub_category', 'course_sub_category.id', '=', 'course_questions.course_sub_category_id');
        $query->leftJoin('course_child_category', 'course_child_category.id', '=', 'course_questions.course_child_category_id');*/
        $query->leftJoin('course', 'course.id', '=', 'course_questions.course_id');
        $query->leftJoin('branches', 'branches.id', '=', 'course_questions.branch_id');
        $query->leftJoin('course_chapters', 'course_chapters.id', '=', 'course_questions.chapter_id');
        $query->leftJoin('course_classes', 'course_classes.id', '=', 'course_questions.class_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_questions.question', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_slug', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_featured', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_seo_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_position', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('branches.branch_name', 'like', "%{$filters['search_text']}%");
/*             $query->orWhere('course_category.course_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_sub_category.course_sub_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_child_category.course_child_category_title', 'like', "%{$filters['search_text']}%");*/
             $query->orWhere('course.course_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_chapters.chapter_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_name', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_questions.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_questions.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $query->where('course_questions.branch_id', '=', $filters['branch_id']);
        }

        if (isset($filters['course_category_id']) && $filters['course_category_id']) {
            $query->where('course_questions.course_category_id', '=', $filters['course_category_id']);
        }

        if (isset($filters['course_sub_category_id']) && $filters['course_sub_category_id']) {
            $query->where('course_questions.course_sub_category_id', '=', $filters['course_sub_category_id']);
        }

        if (isset($filters['course_child_category_id']) && $filters['course_child_category_id']) {
            $query->where('course_questions.course_child_category_id', '=', $filters['course_child_category_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course_questions.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['chapter_id']) && $filters['chapter_id']) {
            $query->where('course_questions.chapter_id', '=', $filters['chapter_id']);
        }

        if (isset($filters['class_id']) && $filters['class_id']) {
            $query->where('course_questions.class_id', '=', $filters['class_id']);
        }

        if (isset($filters['question_name']) && $filters['question_name']) {
            $query->where('course_questions.question_name', '=', $filters['question_name']);
        }

        if (isset($filters['question_slug']) && $filters['question_slug']) {
            $query->where('course_questions.question_slug', '=', $filters['question_slug']);
        }

        if (isset($filters['question_status']) && $filters['question_status']) {
            $query->where('course_questions.question_status', '=', $filters['question_status']);
        }

        if (isset($filters['question_featured']) && $filters['question_featured']) {
            $query->where('course_questions.question_featured', '=', $filters['question_featured']);
        }


        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_questions.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('course.deleted_at');

         $query
            ->orderBy('course_questions.id', 'desc')
            ->select([
                'companies.*', 'course_questions.*',
                \DB::raw('CONVERT_TZ(course_questions.created_at, "+00:00", "+06:00") AS created_at')
            ]);


        return $query;
    }

    public function update(array $data, $id) : CourseQuestion
    {
        $course_question = $this->model->find($id);
        $course_question->fill($data);
        $course_question->save();
        return $course_question;
    }

}
