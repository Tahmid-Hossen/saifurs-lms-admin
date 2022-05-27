<?php


namespace App\Repositories\Backend\Course;


use App\Models\Backend\Course\CourseCategory;
use App\Repositories\Repository;

class CourseCategoryRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return CourseCategory::class;
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
    public function courseCategory($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course_category.company_id');
        $query->leftJoin('branches', 'branches.id', '=', 'course_category.branch_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_category.course_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_category.course_category_slug', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_category.course_category_details', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_category.course_category_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_category.course_category_featured', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_category.course_category_seo_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('branches.branch_name', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_category.id', '=', $filters['id']);
        }

        if (isset($filters['course_category_id']) && $filters['course_category_id']) {
            $query->where('course_category.id', '=', $filters['course_category_id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_category.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $query->where('course_category.branch_id', '=', $filters['branch_id']);
        }

        if (isset($filters['course_category_title_wild_card']) && $filters['course_category_title_wild_card']) {
            $query->where('course_category.course_category_title', 'like', "%{$filters['course_category_title_wild_card']}%");
        }

        if (isset($filters['course_category_title']) && $filters['course_category_title']) {
            $query->where('course_category.course_category_title', '=', $filters['course_category_title']);
        }

        if (isset($filters['course_category_slug']) && $filters['course_category_slug']) {
            $query->where('course_category.course_category_slug', '=', $filters['course_category_slug']);
        }

        if (isset($filters['course_category_details']) && $filters['course_category_details']) {
            $query->where('course_category.course_category_details', '=', $filters['course_category_details']);
        }


        if (isset($filters['course_category_status']) && $filters['course_category_status']) {
            $query->where('course_category.course_category_status', '=', $filters['course_category_status']);
        }

        if (isset($filters['course_category_featured']) && $filters['course_category_featured']) {
            $query->where('course_category.course_category_featured', '=', $filters['course_category_featured']);
        }


        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_category.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('companies.deleted_at');

        //  $query
        //      ->orderBy('course_category.id', 'desc')
        //      ->select([
        //      'companies.*', \DB::raw('CONCAT("'.url('/').'",companies.company_logo) AS company_logo'),
        //      'course_category.*', \DB::raw('CONCAT("'.url('/').'",course_category.course_category_image) AS course_category_image')
         $query
            ->orderBy('course_category.id', 'desc')
            ->select([
             'companies.company_name',
             \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
             'course_category.*',
             \DB::raw('IFNULL(IF(course_category.course_category_image REGEXP "https?", course_category.course_category_image, CONCAT("'.url('/').'",course_category.course_category_image)), CONCAT("'.url('/').'","/assets/img/default.png")) AS course_category_image')
         ]);


        return $query;
    }

    public function update(array $data, $id) : CourseCategory
    {
        $course_category = $this->model->find($id);
        $course_category->fill($data);
        $course_category->save();
        return $course_category;
    }

}
