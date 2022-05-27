<?php

namespace App\Repositories\Backend\Blog;

use App\Models\Backend\Blog\Blog;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class BlogRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return Blog::class;
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function blogFilterData($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->leftJoin('companies', 'companies.id', '=', 'blogs.company_id');
        $query->leftJoin('users', 'users.id', '=', 'blogs.user_id');
        $query->leftJoin('user_details', 'users.id', '=', 'user_details.user_id');

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->where('companies.company_name', 'like', "%{$filters['search_text']}%");
            $query->where('users.name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('blogs.blog_title', 'like', "%{$filters['search_text']}%");
            $query->orWhere('blogs.blog_description', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('blogs.id', '=', $filters['id']);
        }
        if (isset($filters['blog_id']) && $filters['blog_id']) {
            $query->where('blogs.id', '=', $filters['blog_id']);
        }
        if (isset($filters['blog_title']) && $filters['blog_title']) {
            $query->where('blogs.blog_title', '=', $filters['blog_title']);
        }
        if (isset($filters['blog_type']) && $filters['blog_type']) {
            $query->where('blogs.blog_type', '=', $filters['blog_type']);
        }
        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('blogs.company_id', '=', $filters['company_id']);
        }
        if (isset($filters['company_name']) && $filters['company_name']) {
            $query->where('companies.company_name', '=', $filters['company_name']);
        }
        // if (isset($filters['user_id']) && $filters['user_id']) {
        //     $query->where('blogs.user_id', 'like', "%{$filters['user_id']}%");
        // }
        // if (isset($filters['user_name']) && $filters['user_name']) {
        //     $query->where('users.name', '=', $filters['user_name']);
        // }

        if (isset($filters['blog_status']) && $filters['blog_status']) {
            $query->where('blogs.blog_status', '=', $filters['blog_status']);
        }

        if (isset($filters['year']) && $filters['year']) {
            $query->whereYear('blogs.blog_publish_date', '=', $filters['year']);
        }
        if (isset($filters['datemonth']) && $filters['datemonth']) {
            $query->whereMonth('blogs.blog_publish_date', '=', $filters['datemonth']);
        }
        if(
            isset($filter['blog_publish_start_date_time']) && $filter['blog_publish_start_date_time'] != '0000-00-00' && $filter['blog_publish_start_date_time'] != '' &&
            isset($filter['blog_publish_end_date_time']) && $filter['blog_publish_end_date_time'] != '0000-00-00' && $filter['blog_publish_end_date_time'] != ''
        ){
            $query->whereBetween('blogs.blog_publish_date', array($filter['blog_publish_start_date_time'], $filter['blog_publish_end_date_time']));
        }

        if(
            isset($filter['blog_publish_start_date']) && $filter['blog_publish_start_date'] != '0000-00-00' && $filter['blog_publish_start_date'] != '' &&
            isset($filter['blog_publish_end_date']) && $filter['blog_publish_end_date'] != '0000-00-00' && $filter['blog_publish_end_date'] != ''
        ){
            $query->whereBetween(\DB::raw('DATE(blogs.blog_publish_date)'), array($filter['blog_publish_start_date'], $filter['blog_publish_end_date']));
        }

        if(
            isset($filter['blog_publish_start_date']) && $filter['blog_publish_start_date'] != '0000-00-00' && $filter['blog_publish_start_date'] != '' &&
            empty($filter['blog_publish_end_date'])
        ){
            $query->whereBetween(\DB::raw('DATE(blogs.blog_publish_date)'), array($filter['blog_publish_start_date'], $filter['blog_publish_start_date']));
        }

        if(
            isset($filter['blog_publish_end_date']) && $filter['blog_publish_end_date'] != '0000-00-00' && $filter['blog_publish_end_date'] != '' &&
            empty($filter['blog_publish_start_date'])
        ){
            $query->whereBetween(\DB::raw('DATE(blogs.blog_publish_date)'), array($filter['blog_publish_end_date'], $filter['blog_publish_end_date']));
        }

        if(isset($filter['blog_publish_date']) && $filter['blog_publish_date'] != '0000-00-00' && $filter['blog_publish_date'] != ''){
            $query->whereBetween(\DB::raw('DATE(blogs.blog_publish_date)'), array($filter['blog_publish_date'], $filter['blog_publish_date']));
        }
        
        $query->select([
            'companies.company_name',
            \DB::raw('IFNULL(IF(companies.company_logo REGEXP "http", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
            'users.name', 'users.email', 'users.mobile_number', 'user_details.first_name', 'user_details.last_name',
            \DB::raw('IFNULL(IF(user_details.user_detail_photo REGEXP "http", user_details.user_detail_photo, CONCAT("'.url('/').'",user_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS user_detail_photo'),
            'blogs.*',
            \DB::raw('IFNULL(IF(blogs.blog_logo REGEXP "http", blogs.blog_logo, CONCAT("'.url('/public/').'",blogs.blog_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS blog_logo')
        ]);
        return $query;
    }

}

