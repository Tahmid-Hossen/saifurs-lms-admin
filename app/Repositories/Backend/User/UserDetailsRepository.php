<?php
/**
 * Created by PhpStorm.
 * User: MN
 * Date: 11/25/2018
 * Time: 3:57 PM
 */

namespace App\Repositories\Backend\User;


use App\Models\Backend\User\UserDetail;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UserDetailsRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return UserDetail::class;
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
     * @return Builder
     */
    public function userDetails($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('users', 'users.id', '=', 'user_details.user_id');
        $query->leftJoin('countries', 'countries.id', '=', 'user_details.country_id');
        $query->leftJoin('states', 'states.id', '=', 'user_details.state_id');
        $query->leftJoin('cities', 'cities.id', '=', 'user_details.city_id');
        $query->leftJoin('companies', 'companies.id', '=', 'user_details.company_id');
        $query->leftJoin('branches', 'branches.id', '=', 'user_details.branch_id');
        $query->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'user_details.user_id');
        $query->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id');

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->where('countries.country_iso', 'like', "%{$filters['search_text']}%");
            $query->orWhere('countries.country_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('countries.country_iso3', 'like', "%{$filters['search_text']}%");
            $query->orWhere('countries.country_num_code', 'like', "%{$filters['search_text']}%");
            $query->orWhere('countries.country_phone_code', 'like', "%{$filters['search_text']}%");
            $query->orWhere('countries.country_status', 'like', "%{$filters['search_text']}%");
            $query->orWhere('states.state_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('states.state_status', 'like', "%{$filters['search_text']}%");
            $query->orWhere('cities.city_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('cities.city_status', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_email', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_address', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('companies.company_mobile', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_address', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_mobile', 'like', "%{$filters['search_text']}%");
            $query->orWhere('branches.branch_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('roles.name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('user_details.mobile_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('user_details.home_phone', 'like', "%{$filters['search_text']}%");
            $query->orWhere('user_details.first_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('user_details.last_name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('user_details.national_id', 'like', "%{$filters['search_text']}%");
            $query->orWhere('user_details.police_station', 'like', "%{$filters['search_text']}%");
            $query->orWhere('users.name', 'like', "%{$filters['search_text']}%");
            $query->orWhere('users.username', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('user_details.user_id', '=', $filters['id']);
        }

        if (isset($filters['user_id']) && $filters['user_id']) {
            $query->where('user_details.user_id', '=', $filters['user_id']);
        }

        if (isset($filters['mobile_phone']) && $filters['mobile_phone']) {
            $query->where('user_details.mobile_phone', '=', $filters['mobile_phone']);
        }

        if (isset($filters['home_phone']) && $filters['home_phone']) {
            $query->where('user_details.home_phone', '=', $filters['home_phone']);
        }

        if (isset($filters['first_name']) && $filters['first_name']) {
            $query->where('user_details.first_name', '=', $filters['first_name']);
        }

        if (isset($filters['last_name']) && $filters['last_name']) {
            $query->where('user_details.last_name', '=', $filters['last_name']);
        }

        if (isset($filters['national_id']) && $filters['national_id']) {
            $query->where('user_details.national_id', '=', $filters['national_id']);
        }

        if (isset($filters['gender']) && $filters['gender']) {
            $query->where('user_details.gender', '=', $filters['gender']);
        }

        if (isset($filters['married_status']) && $filters['married_status']) {
            $query->where('user_details.married_status', '=', $filters['married_status']);
        }

        if (isset($filters['post_code']) && $filters['post_code']) {
            $query->where('user_details.post_code', '=', $filters['post_code']);
        }

        if (isset($filters['police_station']) && $filters['police_station']) {
            $query->where('user_details.police_station', '=', $filters['police_station']);
        }

        if (isset($filters['city_id']) && $filters['city_id']) {
            $query->where('user_details.city_id', '=', $filters['city_id']);
        }

        if (isset($filters['shipping_city_id']) && $filters['shipping_city_id']) {
            $query->where('user_details.shipping_city_id', '=', $filters['shipping_city_id']);
        }

        if (isset($filters['city_name']) && $filters['city_name']) {
            $query->where('cities.city_name', '=', $filters['city_name']);
        }

        if (isset($filters['state_id']) && $filters['state_id']) {
            $query->where('user_details.state_id', '=', $filters['state_id']);
        }

        if (isset($filters['shipping_state_id']) && $filters['shipping_state_id']) {
            $query->where('user_details.shipping_state_id', '=', $filters['shipping_state_id']);
        }

        if (isset($filters['state_name']) && $filters['state_name']) {
            $query->where('states.state_name', '=', $filters['state_name']);
        }

        if (isset($filters['country_id']) && $filters['country_id']) {
            $query->where('user_details.country_id', '=', $filters['country_id']);
        }

        if (isset($filters['country_name']) && $filters['country_name']) {
            $query->orWhere('countries.country_name', '=', $filters['country_name']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('user_details.company_id', '=', $filters['company_id']);
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
            $query->where('user_details.branch_id', '=', $filters['branch_id']);
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

        if (isset($filters['role_id']) && $filters['role_id']) {
            $query->where('roles.id', '=', $filters['role_id']);
        }

        if (isset($filters['role_id_in']) && $filters['role_id_in']) {
            $query->whereIn('roles.id', $filters['role_id_in']);
        }

        if (isset($filters['role_name']) && $filters['role_name']) {
            $query->orWhere('roles.role_name', '=', $filters['role_name']);
        }

        if (isset($filters['identity_card']) && $filters['identity_card']) {
            $query->where('user_details.identity_card', '=', $filters['identity_card']);
        }

        if (isset($filters['user_details_status']) && $filters['user_details_status']) {
            $query->where('user_details.user_details_status', '=', $filters['user_details_status']);
        }

        if (isset($filters['user_details_verified']) && $filters['user_details_verified']) {
            $query->where('user_details.user_details_verified', '=', $filters['user_details_verified']);
        }

        if (isset($filters['name']) && $filters['name']) {
            $query->where('users.name', 'like', "%{$filters['name']}%");
        }

        if (isset($filters['username']) && $filters['username']) {
            $query->where('users.username', '=', $filters['username']);
        }

        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('user_details.created_at', array($filters['created_at'], $filters['created_at']));
        }

        if(isset($filters['is_course_student']) && $filters['is_course_student'] == true):
            $query->leftJoin('course_batch_students', 'course_batch_students.student_id', '=', 'user_details.user_id');
            $query->leftJoin('course_batches', 'course_batches.id', '=', 'course_batch_students.course_batch_id');
            $query->leftJoin('course', 'course.id', '=', 'course_batches.course_id');
            if (isset($filters['course_id']) && $filters['course_id']) {
                $query->where('course.id', '=', $filters['course_id']);
            }
            if (isset($filters['batch_id']) && $filters['batch_id']) {
                $query->where('course_batches.id', '=', $filters['batch_id']);
            }
            if (isset($filters['student_id']) && $filters['student_id']) {
                $query->where('course_batch_students.student_id', '=', $filters['student_id']);
            }
            if (isset($filters['instructor_id']) && $filters['instructor_id']) {
                $query->where('course_batches.instructor_id', '=', $filters['instructor_id']);
            }
            $query->whereNull('course_batches.deleted_at');
        endif;
        if(isset($filters['is_course_instructor']) && $filters['is_course_instructor'] == true):
            $query->leftJoin('course_batches', 'course_batches.instructor_id', '=', 'user_details.user_id');
            $query->leftJoin('course', 'course.id', '=', 'course_batches.course_id');
            if (isset($filters['course_id']) && $filters['course_id']) {
                $query->where('course.id', '=', $filters['course_id']);
            }
            if (isset($filters['instructor_id']) && $filters['instructor_id']) {
                $query->where('course_batches.instructor_id', '=', $filters['instructor_id']);
            }
            $query->whereNull('course_batches.deleted_at');
        endif;
        $query->select([
            'users.name', 'users.username',
            'countries.*',
            \DB::raw('IFNULL(IF(countries.country_logo REGEXP "https?", countries.country_logo, CONCAT("'.url('/').'",countries.country_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS country_logo'),
            'states.state_name', 'cities.city_name',
            'companies.*',
            \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
            'branches.*',
            'user_details.*',
            \DB::raw('IFNULL(IF(user_details.user_detail_photo REGEXP "https?", user_details.user_detail_photo, CONCAT("'.url('/').'",user_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS user_detail_photo')
        ]);

        return $query;
    }
}
