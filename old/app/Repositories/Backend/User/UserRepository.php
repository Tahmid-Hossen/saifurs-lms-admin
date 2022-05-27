<?php

namespace App\Repositories\Backend\User;


use App\Models\User;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{
    public static $allowedFields = [
        'name', 'mobile_number', 'status', 'default_language'
    ];

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param       $query
     */
    public function filterData(array $filter, $query)
    {
        // will implement later
    }

    /**
     * @param array $with
     * @param array $filters
     *
     * @return Builder
     */
    public function getUserWith(array $with, array $filters)
    {
        $query = $this->model->sortable()->newQuery();

        if (isset($filters['id']) && $filters['id']) {
            $query->where('id', '=', $filters['id']);
        }

        if (isset($filters['user_id']) && $filters['user_id']) {
            $query->where('id', '=', $filters['user_id']);
        }

        if (isset($filters['parent_id']) && $filters['parent_id']) {
            $query->orWhere('parent_id', '=', $filters['parent_id']);
        }

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->where('name', 'like', "%{$filters['search_text']}%");
            $query->where('username', 'like', "%{$filters['search_text']}%");
            $query->orWhere('mobile_number', 'like', "%{$filters['search_text']}%");
            $query->orWhere('email', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['username']) && $filters['username']) {
            $query->where('username', '=', $filters['username']);
        }

        if (isset($filters['mobile_number']) && $filters['mobile_number']) {
            $query->where('mobile_number',  '=', $filters['mobile_number']);
        }

        if (isset($filters['email']) && $filters['email']) {
            $query->where('email',  '=', $filters['email']);
        }

        /*if (isset($filters['password']) && $filters['password']) {
            $query->where('password', $filters['password']);
        }

        if (isset($filters['pin']) && $filters['pin']) {
            $query->where('pin', $filters['pin']);
        }*/

        if (isset($filters['name']) && $filters['name']) {
            $query->where('name', 'like', "%{$filters['name']}%");
        }

        if (isset($filters['email']) && $filters['email']) {
            $query->where('email', 'like', "%{$filters['email']}%");
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->join('user_details', 'users.id', '=', 'user_details.user_id');
            $query->where('user_details.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['default_country_id']) && $filters['default_country_id']) {
            $query->where('default_country_id', $filters['default_country_id']);
        }

        if (isset($filters['role_id']) && $filters['role_id']) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->whereIn('role_id', $filters['role_id']);
            });
        } else {
            $query->with($with);
        }

        return $query;
    }

    /**
     * @param array $data
     * @param        $id
     * @param string $attribute
     *
     * @return mixed
     */
    /*public function update(array $data, $id, $attribute = "id")
    {
        $allowedData = [];

        foreach ($data as $key => $val) {
            if (in_array($key, self::$allowedFields)) {
                $allowedData[$key] = $val;
            }
        }

        return $this->model->where($attribute, '=', $id)->update($allowedData);
    }*/

    /**
     * @param $email
     * @param $id
     * @return int
     */
    public function findUserByEmail($email, $id)
    {
        $query = $this->model->sortable()->newQuery();

        if (isset($email) && $email) {
            $query->where('email', '=', $email);
        }
        if (isset($id) && $id) {
            $query->where('id', '!=', $id);
        }
        return $query->count();
    }

    /**
     * @param $email
     * @param $id
     * @return Model|null|static
     */
    public function findUserByEmailNotThis($email, $id)
    {
        $query = $this->model->sortable()->newQuery();

        if (isset($email) && $email) {
            $query->where('email', '=', $email);
        }
        if (isset($id) && $id) {
            $query->where('id', '!=', $id);
        }
        return $query->first();
    }

    /**
     * @param $email
     * @return Model|null|static
     */
    public function getUserByEmail($email)
    {
        $query = $this->model->sortable()->newQuery();

        if (isset($email) && $email) {
            $query->where('email', '=', $email);
        }
        return $query->first();
    }

    /**
     * @param $title
     * @param $id
     * @param $roleID
     * @return mixed
     */
    public function customLists($title, $id, $roleID)
    {
        return User::where('status', 'ACTIVE')->whereHas('roles', function ($q) use ($roleID) {
            $q->where('role_id', $roleID);
        })->pluck($title, $id);
    }

    /**
     * @return mixed
     */
    public function getAllUserForSelect()
    {
        return User::where('status', 'ACTIVE')->pluck('name', 'id');
    }

    /**
     * @param $userName
     * @param $id
     * @return int
     */
    public function findUserByUsername($userName, $id)
    {
        $query = $this->model->sortable()->newQuery();

        if (isset($userName) && $userName) {
            $query->where('username', '=', $userName);
        }
        if (isset($id) && $id) {
            $query->where('id', '!=', $id);
        }
        return $query->count();
    }

    /**
     * @param $mobile
     * @param $id
     * @return int
     */
    public function findUserByMobile($mobile, $id)
    {
        $query = $this->model->sortable()->newQuery();

        if (isset($mobile) && $mobile) {
            $query->where('mobile_number', '=', $mobile);
        }
        if (isset($id) && $id) {
            $query->where('id', '!=', $id);
        }
        return $query->count();
    }

    /**
     * @param $mobile
     * @param $id
     * @return Model|null|static
     */
    public function findUserByMobileNotThis($mobile, $id)
    {
        $query = $this->model->sortable()->newQuery();

        if (isset($mobile) && $mobile) {
            $query->where('mobile', '=', $mobile);
        }
        if (isset($id) && $id) {
            $query->where('id', '!=', $id);
        }
        return $query->first();
    }

    /**
     * @param $mobile
     * @return Model|null|static
     */
    public function getUserByMobile($mobile)
    {
        $query = $this->model->sortable()->newQuery();

        if (isset($mobile) && $mobile) {
            $query->where('mobile_number', '=', $mobile);
        }
        return $query->first();
    }

    public function user($filters)
    {
        $query = $this->model->sortable()->newQuery();

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('users.name', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('users.id', '=', $filters['id']);
        }

        if (isset($filters['name']) && $filters['name']) {
            $query->where('users.name', '=', $filters['name']);
        }

         $query
            ->orderBy('users.id', 'desc')
            ->select([
               'users.*'
            ]);

        return $query;
    }

}
