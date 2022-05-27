<?php


namespace App\Repositories\Backend\Course;


use App\Models\Backend\Course\CourseChildCategory;
use App\Repositories\Repository;

class CourseChildCategoryRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return CourseChildCategory::class;
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
    public function courseChildCategory($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course_child_category.company_id');
        $query->leftJoin('course_category', 'course_category.id', '=', 'course_child_category.course_category_id');
        $query->leftJoin('course_sub_category', 'course_sub_category.id', '=', 'course_child_category.course_sub_category_id');
        $query->leftJoin('branches', 'branches.id', '=', 'course_child_category.branch_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_child_category.course_child_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_child_category.course_child_category_slug', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_child_category.course_child_category_details', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_child_category.course_child_category_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_child_category.course_child_category_featured', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_child_category.course_child_category_seo_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('branches.branch_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_category.course_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_sub_category.course_sub_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_child_category.course_child_category_position', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_child_category.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_child_category.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $query->where('course_child_category.branch_id', '=', $filters['branch_id']);
        }

        if (isset($filters['course_category_id']) && $filters['course_category_id']) {
            $query->where('course_child_category.course_category_id', '=', $filters['course_category_id']);
        }

        if (isset($filters['course_sub_category_id']) && $filters['course_sub_category_id']) {
            $query->where('course_child_category.course_sub_category_id', '=', $filters['course_sub_category_id']);
        }

        if (isset($filters['course_child_category_title_wild_card']) && $filters['course_child_category_title_wild_card']) {
            $query->where('course_child_category.course_child_category_title', 'like', "%{$filters['course_child_category_title_wild_card']}%");
        }

        if (isset($filters['course_child_category_title']) && $filters['course_child_category_title']) {
            $query->where('course_child_category.course_child_category_title', '=', $filters['course_child_category_title']);
        }

        if (isset($filters['course_child_category_slug']) && $filters['course_child_category_slug']) {
            $query->where('course_child_category.course_child_category_slug', '=', $filters['course_child_category_slug']);
        }

        if (isset($filters['course_child_category_details']) && $filters['course_child_category_details']) {
            $query->where('course_child_category.course_child_category_details', '=', $filters['course_child_category_details']);
        }


        if (isset($filters['course_child_category_status']) && $filters['course_child_category_status']) {
            $query->where('course_child_category.course_child_category_status', '=', $filters['course_child_category_status']);
        }

        if (isset($filters['course_child_category_featured']) && $filters['course_child_category_featured']) {
            $query->where('course_child_category.course_child_category_featured', '=', $filters['course_child_category_featured']);
        }


        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_child_category.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('course_category.deleted_at');
        $query->whereNull('course_sub_category.deleted_at');

        $query->orderBy('course_child_category.id', 'desc');
        $query->select([
                'companies.*', 'course_child_category.*'
        ]);


        return $query;
    }

    public function update(array $data, $id) : CourseChildCategory
    {
        $course_child_category = $this->model->find($id);
        $course_child_category->fill($data);
        $course_child_category->save();
        return $course_child_category;
    }

}
