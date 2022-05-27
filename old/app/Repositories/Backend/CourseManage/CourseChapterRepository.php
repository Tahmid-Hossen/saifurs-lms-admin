<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\CourseChapter;
use App\Repositories\Repository;

class CourseChapterRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return CourseChapter::class;
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
    public function courseChapter($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course_chapters.company_id');
        $query->leftJoin('course', 'course.id', '=', 'course_chapters.course_id');
        $query->leftJoin('branches', 'branches.id', '=', 'course_chapters.branch_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_chapters.chapter_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_chapters.chapter_slug', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_chapters.chapter_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_chapters.chapter_featured', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_chapters.chapter_position', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('branches.branch_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course.course_title', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_chapters.id', '=', $filters['id']);
        }

        if (isset($filters['course_chapter_id']) && $filters['course_chapter_id']) {
            $query->where('course_chapters.id', '=', $filters['course_chapter_id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_chapters.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $query->where('course_chapters.branch_id', '=', $filters['branch_id']);
        }

        if (isset($filters['course_category_id']) && $filters['course_category_id']) {
            $query->where('course_chapters.course_category_id', '=', $filters['course_category_id']);
        }

        if (isset($filters['course_sub_category_id']) && $filters['course_sub_category_id']) {
            $query->where('course_chapters.course_sub_category_id', '=', $filters['course_sub_category_id']);
        }

        if (isset($filters['course_child_category_id']) && $filters['course_child_category_id']) {
            $query->where('course_chapters.course_child_category_id', '=', $filters['course_child_category_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course_chapters.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['chapter_title_wild_card']) && $filters['chapter_title_wild_card']) {
            $query->where('course_chapters.chapter_title', 'like', "%{$filters['chapter_title_wild_card']}%");
        }

        if (isset($filters['chapter_title']) && $filters['chapter_title']) {
            $query->where('course_chapters.chapter_title', '=', $filters['chapter_title']);
        }

        if (isset($filters['chapter_slug']) && $filters['chapter_slug']) {
            $query->where('course_chapters.chapter_slug', '=', $filters['chapter_slug']);
        }


        if (isset($filters['chapter_status']) && $filters['chapter_status']) {
            $query->where('course_chapters.chapter_status', '=', $filters['chapter_status']);
        }

        if (isset($filters['chapter_featured']) && $filters['chapter_featured']) {
            $query->where('course_chapters.chapter_featured', '=', $filters['chapter_featured']);
        }


        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_chapters.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('course.deleted_at');

        if (isset($filters['course_chapter_by_id']) && $filters['course_chapter_by_id']) {
            $query->orderBy('course_chapters.id', $filters['course_chapter_by_id']);
        }

         $query
            ->orderBy('course_chapters.id', 'desc')
            ->select([
                'companies.company_name',
                \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
                'course_chapters.*',
                \DB::raw('IFNULL(IF(course_chapters.chapter_image REGEXP "https?", course_chapters.chapter_image, CONCAT("'.url('/').'",course_chapters.chapter_image)), CONCAT("'.url('/').'","/assets/img/default.png")) AS chapter_image'),
                \DB::raw('IFNULL(IF(course_chapters.chapter_file REGEXP "https?", course_chapters.chapter_file, CONCAT("'.url('/').'",course_chapters.chapter_file)), CONCAT("'.url('/').'","/assets/img/default.png")) AS chapter_file'),
                \DB::raw('CONVERT_TZ(course_chapters.created_at, "+00:00", "+06:00") AS created_at')
            ]);


        return $query;
    }

    /**
     * @param array $data
     * @param $id
     * @return CourseChapter
     */
    public function update(array $data, $id) : CourseChapter
    {
        $course_chapter = $this->model->find($id);
        $course_chapter->fill($data);
        $course_chapter->save();
        return $course_chapter;
    }


}
