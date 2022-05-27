<?php

namespace App\Services\Backend\User;

use App\Models\User;
use App\Repositories\Backend\User\PermissionRepository;
use App\Repositories\Backend\User\RoleRepository;
use App\Repositories\Backend\User\UserRepository;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Get all users
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getAllUser(array $filters)
    {
        $with = ['roles'];

        return $this->userRepository
            ->getUserWith($with, $filters)
            ->paginate(UtilityService::$displayRecordPerPage);
    }


    /**
     * Get all roles
     *
     * @return mixed
     */
    public function getAllRoles()
    {
        return $this->roleRepository->all(['name', 'id']);
    }

    /**
     * @return mixed
     */
    public function getAllPermissions()
    {
        return $this->permissionRepository->all(['name', 'id']);
    }

    /**
     * @param array $data
     * @param       $id
     *
     * @return bool|int|null
     */
    public function assignRolesToUser(array $data, $id)
    {
        try {
            $user = $this->userRepository->find($id);

            return $this->manageUserRole($user, $data);
        } catch (ModelNotFoundException $e) {
            return null;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Manage role assignment to user
     *
     * @param User $user
     * @param array $data
     *
     * @return User|int
     */
    protected function manageUserRole(User $user, array $data)
    {
        if (!isset($data['roles']) || empty($data['roles'])) {
            return $user->roles()->detach();
        }

        $roles = $this->roleRepository->findMany($data['roles']);

        return $user->syncRoles($roles);
    }

    /**
     * @param array $data
     * @param       $id
     *
     * @return bool|mixed|null
     */
    public function assignPermissionToUser(array $data, $id)
    {
        try {
            $user = $this->userRepository->find($id);

            // if empty detach all permission
            if (empty($data['permissions'])) {
                $user->permissions()->detach();
                $user->forgetCachedPermissions();

                return $user;
            }

            $user->permissions()->sync($data['permissions']);
            $user->forgetCachedPermissions();

            return $user;
        } catch (ModelNotFoundException $e) {
           \Log::debug('Role not found');
            return null;
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }

        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showAllUsersByRoleID($id)
    {
        return User::whereHas('roles', function ($query) use ($id) {
            $query->where('id', '=', $id);
        })->get();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function showAllUsersByRoleName($name)
    {
        return User::whereHas('roles', function ($query) use ($name) {
            $query->where('name', '=', $name);
        })->get();
    }

    public function showAllUser($input)
    {
        // dd($input);
        return $this->userRepository->user($input);
    }

    /**
     * @return array
     */
    public function findCurrentUserRole()
    {
        $role = array();
        foreach (auth()->user()->roles as $thisRoles) {
            $role [] = $thisRoles['name'];
        }

        return $role;
    }

    /**
     * @param $email
     * @param $id
     * @return int
     */
    public function emailIsHave($email, $id)
    {
        return $this->userRepository->findUserByEmail($email, $id);
    }

    /**
     * @param $email
     * @param $id
     * @return mixed
     */
    public function emailIsHaveNotThisUser($email, $id)
    {
        return $this->userRepository->findUserByEmailNotThis($email, $id);
    }

    /**
     * @param $email
     * @return UserRepository
     */
    public function getUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }

    /**
     * @param $title
     * @param $id
     * @param $roleID
     * @return mixed
     */
    public function showUserListByRole($title, $id, $roleID)
    {
        return $this->userRepository->customLists($title, $id, $roleID)->toArray();
    }

    /**
     * @param $filter
     * @return Builder
     */
    public function checkSponsor($filter)
    {
        $with = ['roles'];
        $sponsorUsername = $this->userRepository->getUserWith($with, $filter);
        return $sponsorUsername;
    }

    /**
     * @return array
     */
    public function user_role_display(): array
    {
        $user_array = array();
        $users = auth()->user();
        $user_details = $this->findUser($users->id);
        if ($users->getRoleNames()->first() == 'Super Admin'):
        elseif ($users->getRoleNames()->first() == 'Admin'):
            //$user_array['user_id'] = $users->id;
            $user_array['company_id'] = $users->userDetails->company_id;
        elseif ($users->getRoleNames()->first() == 'Management'):
            $user_array['user_id'] = $users->id;
            $user_array['company_id'] = $users->userDetails->company_id;
        elseif ($users->getRoleNames()->first() == 'Accountant'):
            $user_array['user_id'] = $users->id;
            $user_array['company_id'] = $users->userDetails->company_id;
        elseif ($users->getRoleNames()->first() == 'Reporter'):
            $user_array['user_id'] = $users->id;
            $user_array['company_id'] = $users->userDetails->company_id;
            $user_array['branch_id'] = $users->userDetails->branch_id;
        elseif ($users->getRoleNames()->first() == 'Instructor'):
            $user_array['user_id'] = $users->id;
            $user_array['instructor_id'] = $users->id;
            $user_array['company_id'] = $users->userDetails->company_id;
        elseif ($users->getRoleNames()->first() == 'Student'):
            $user_array['user_id'] = $users->id;
            $user_array['student_id'] = $users->id;
            $user_array['is_student'] = true;
            $user_array['company_id'] = $users->userDetails->company_id;
        elseif ($users->getRoleNames()->first() == 'Member'):
            $user_array['user_id'] = $users->id;
            $user_array['company_id'] = $users->userDetails->company_id;
        endif;


        return $user_array;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findUser($id)
    {
        try {
            return $this->userRepository->findWith($id, ['roles', 'permissions']);
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * @param $input
     * @return false|mixed
     */
    public function user_custom_insert($input)
    {
        $user['mobile_number'] = $input['mobile_phone'];
        $user['username'] = $input['username'];
        $user['email'] = isset($input['email'])?$input['email']:null;
        $user['name'] = $input['name'];
        $user['status'] = $input['status'];
        $user['password'] = $input['password'];
        $user['roles'] = $input['roles'];
        return $this->createUser($user);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function createUser(array $data)
    {
        try {
            $data['plain_password'] = $data['password'];
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                $data['password'] = bcrypt('123456');
            }
            $data['status'] = ($data['status']) ? $data['status'] : Constants::$user_default_status;
            $user = $this->userRepository->create($data);
            $this->manageUserRole($user, $data);
            return $user;
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function user_custom_update($input, $id)
    {
        $user['mobile_number'] = $input['mobile_phone'];
        $user['username'] = $input['username'];
        $user['email'] = $input['email'];
        $user['name'] = $input['name'];
        $user['status'] = $input['status'];
        $user['roles'] = $input['roles'];
        return $this->updateUser($user, $id);
    }

    /**
     * @param array $data
     * @param       $id
     *
     * @return bool
     */
    public function updateUser(array $data, $id)
    {
        try {
            $user = $this->userRepository->find($id);
            $this->userRepository->update($data, $id);
            $this->manageUserRole($user, $data);

            return $user;
        } catch (ModelNotFoundException $e) {
           \Log::error('User not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }

        return false;
    }

    /**
     * @param $userName
     * @param $id
     * @return int
     */
    public function userNameIsHave($userName, $id)
    {
        return $this->userRepository->findUserByUsername($userName, $id);
    }

    /**
     * @param $mobile
     * @param $id
     * @return int
     */
    public function mobileIsHave($mobile, $id)
    {
        return $this->userRepository->findUserByMobile($mobile, $id);
    }

    /**
     * @param $mobile
     * @param $id
     * @return mixed
     */
    public function mobileIsHaveNotThisUser($mobile, $id)
    {
        return $this->userRepository->findUserByMobileNotThis($mobile, $id);
    }

    /**
     * @param $mobile
     * @return UserRepository
     */
    public function getUserByMobile($mobile)
    {
        return $this->userRepository->getUserByMobile($mobile);
    }

    /**
     * @param $input
     * @return array|JsonResponse
     */
    public function pinPasswordCheck($input)
    {
        $authUser['mobile_number'] = auth()->user()->mobile_number;
        if (isset($input['password'])):
            $authUser['password'] = $input['password'];
        else:
            $authUser['pin'] = $input['pin'];
        endif;
        $user_get = $this->whoIS($authUser);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            $data['status'] = true;
            $data['message'] = 'Authorization';
        } else {
            $data['status'] = false;
            if (isset($input->password)):
                $data['message'] = 'You Entered Wrong PASSWORD!';
            else:
                $data['message'] = 'You Entered Wrong PIN!';
            endif;
        }

        return $data;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function whoIS(array $data)
    {
        if (UtilityService::$delete_method == 1):
            if (UtilityService::$login_method == 1):
                $input['username'] = isset($data['username']) ? $data['username'] : auth()->user()->username;
            elseif (UtilityService::$login_method == 0):
                $input['email'] = isset($data['email']) ? $data['email'] : auth()->user()->email;
            else:
                $input['mobile_number'] = isset($data['mobile_number']) ? $data['mobile_number'] : auth()->user()->mobile_number;
            endif;
        else:
            if (UtilityService::$login_method == 1):
                $input['username'] = auth()->user()->username;
            elseif (UtilityService::$login_method == 0):
                $input['email'] = auth()->user()->email;
            else:
                $input['mobile_number'] = auth()->user()->mobile_number;
            endif;
        endif;
        $authCheck = false;
        if (isset($data['password']) && !empty($data['password'])): $authCheck = $this->passwordCheck($data); endif;
        if (isset($data['pin']) && !empty($data['pin'])): $authCheck = $this->pinCheck($data); endif;
        if ($authCheck == true) : return $this->allUsers($input)->first();
        else: return $authCheck; endif;
    }

    /**
     * @param $data
     * @return bool
     */
    public function passwordCheck($data)
    {
        return Hash::check($data['password'], Auth::user()->password);
    }

    /**
     * @param array $filters
     * @return Builder
     */
    public function allUsers(array $filters)
    {
        $with = ['roles'];

        return $this->userRepository->getUserWith($with, $filters);
    }

    /**
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getAllRoleByFilter(array $filters): \Illuminate\Database\Eloquent\Builder
    {
        return $this->roleRepository->roleFilter($filters);
    }

    /**
     * only to user for dropdown purpose
     * @return string[]
     */
    public function getUserDropDown(): array
    {
        $users = [];
        foreach ($this->getAllUser(['company_id' => 1]) as $user) {
            $users[$user->id] = $user->name;
        }

        return $users;
    }

    /**
     * @return array
     */
    public function user_role_display_for_api(): array
    {
        $user_array = array();
        if (Auth::guard('api')->check()):
            $users = auth()->guard('api')->user();
            $user_details = $this->findUser($users->id);
            if ($users->getRoleNames()->first() == 'Super Admin'):
            elseif ($users->getRoleNames()->first() == 'Admin'):
                $user_array['user_id'] = $users->id;
                $user_array['company_id'] = $users->userDetails->company_id;
            elseif ($users->getRoleNames()->first() == 'Management'):
                $user_array['user_id'] = $users->id;
                $user_array['company_id'] = $users->userDetails->company_id;
            elseif ($users->getRoleNames()->first() == 'Accountant'):
                $user_array['user_id'] = $users->id;
                $user_array['company_id'] = $users->userDetails->company_id;
            elseif ($users->getRoleNames()->first() == 'Reporter'):
                $user_array['user_id'] = $users->id;
                $user_array['company_id'] = $users->userDetails->company_id;
                $user_array['branch_id'] = $users->userDetails->branch_id;
            elseif ($users->getRoleNames()->first() == 'Instructor'):
                $user_array['user_id'] = $users->id;
                $user_array['instructor_id'] = $users->id;
                $user_array['company_id'] = $users->userDetails->company_id;
            elseif ($users->getRoleNames()->first() == 'Student'):
                $user_array['user_id'] = $users->id;
                $user_array['student_id'] = $users->id;
                $user_array['is_student'] = true;
                $user_array['company_id'] = $users->userDetails->company_id;
            elseif ($users->getRoleNames()->first() == 'Member'):
                $user_array['user_id'] = $users->id;
                $user_array['company_id'] = $users->userDetails->company_id;
            endif;
        endif;

        return $user_array;
    }
}
