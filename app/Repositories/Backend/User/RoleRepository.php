<?php

namespace App\Repositories\Backend\User;

use App\Repositories\Repository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param $query
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @return mixed
     */
    public function allRoles()
    {
        return $this->model->get(['name', 'id', 'created_at']);
    }


    /**
     * Find many role
     *
     * @param array $roles Array of role id
     *
     * @return mixed
     */
    public function findMany(array $roles)
    {
        return $this->model->findMany($roles);
    }

    /**
     * @return Collection|static[]
     */
    public function getPermissions()
    {
        return Permission::all(['id', 'name']);
    }

    /**
     * @param $input
     * @param $role_id
     *
     * @return bool|mixed|null
     */
    public function assignPermissionToRole($input, $role_id)
    {
        try {
            $role = $this->find($role_id);

            // if empty detach all permission
            if (empty($input['permissions'])) {
                $role->permissions()->detach();
                $role->forgetCachedPermissions();

                return $role;
            }

            $role->permissions()->sync($input['permissions']);
            $role->forgetCachedPermissions();

            return $role;
        } catch (ModelNotFoundException $e) {
            \Log::debug('Role not found');
            return null;
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }

        return false;
    }

    /**
     * @param $filter
     * @return Builder
     */
    public function allRolesList($filter)
    {
        $query = $this->getQuery();
        if (isset($filter['name']) && $filter['name'] != '') {
            $query->where('name', $filter['name']);
        }
        if (isset($filter['role_id']) && $filter['role_id'] != '') {
            $query->whereIn('id', $filter['role_id']);
        }
        if (isset($filter['search_text']) && $filter['search_text'] != '') {
            $query->where('name', 'LIKE', "%{$filter['search_text']}%");
        }
        return $query;
    }

    /**
     * @param $input
     * @param $role_id
     * @return bool|mixed|null
     */
    public function assignServiceToRole($input, $role_id)
    {
        try {
            $role = $this->find($role_id);
            // if empty detach all service
            if (empty($input['services'])) {
                $role->services()->detach();
                return $role;
            }
            $role->services()->sync($input['services']);
            return $role;
        } catch (ModelNotFoundException $e) {
            \Log::debug('Role not found');
            return null;
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $filters
     * @return mixed
     */
    public function roleFilter($filters)
    {
        $query = $this->model->newQuery();

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->where('name', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('id', '=', $filters['id']);
        }

        if (isset($filters['role_id']) && $filters['role_id']) {
            $query->where('id', '=', $filters['role_id']);
        }

        if (isset($filters['role_id_in']) && $filters['role_id_in']) {
            $query->whereIn('id', $filters['role_id_in']);
        }

        if (isset($filters['role_name']) && $filters['role_name']) {
            $query->orWhere('name', '=', $filters['role_name']);
        }

        return $query;
    }
}
