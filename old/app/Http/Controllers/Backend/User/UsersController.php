<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Backend\User\UserRequest;
use App\Services\Backend\User\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UsersController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $filters = $request->all();

        $users = $this->userService->getAllUser($filters);
        $roles = $this->userService->getAllRoles();
        return View('backend.user.users.index', compact('users', 'roles', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = $this->userService->getAllRoles();

        return view('backend.user.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = $this->userService->createUser($request->all());

        if ($user) {
            flash('User created successfully');
        } else {
            flash('Failed to create User', 'error');
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Factory|RedirectResponse|View
     */
    public function show($id)
    {
        $user = $this->userService->findUser($id);
        if (!$user) {
            flash('User not found!', 'error');

            return redirect()->route('users.index');
        }

        return view('backend.user.users.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse|Response
     */
    public function edit($id)
    {
        $user = $this->userService->findUser($id);

        if (!$user) {
            flash('User not found!', 'error');
            return redirect()->route('users.index');
        }

        $roles = $this->userService->getAllRoles();
        $userRoles = $user->roles()->pluck('id')->toArray();

        return view('backend.user.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $is_updated = $this->userService->updateUser($request->except('_token', '_method'), $id);

        if ($is_updated) {
            flash('User updated successfully.');
        } else {
            flash('Failed to update user!', 'error');
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse|Response
     */
    public function destroy($id)
    {
        $user = $this->userService->findUser($id);

        if (!$user) {
            flash('User not found!', 'error');
        }

        $user->delete();
        flash('User deleted successfully');

        return redirect()->route('users.index');
    }

    /**
     * @param $id
     *
     * @return RedirectResponse|View|mixed
     */
    public function roles($id)
    {
        $user = $this->userService->findUser($id);
        if (!$user) {
            flash('User not found!', 'error');

            return redirect()->route('users.index');
        }

        $roles = $this->userService->getAllRoles();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('backend.user.users.roles', compact('user', 'roles', 'userRoles'));
    }

    /**
     * @param Request $request
     * @param                          $id
     *
     * @return RedirectResponse
     */
    public function saveRoles(Request $request, $id)
    {
        $is_assigned = $this->userService->assignRolesToUser($request->only('roles'), $id);

        if ($is_assigned) {
            flash('User Role(s) updated');
        } else {
            flash('Failed to update role', 'error');
        }

        return redirect()->route('users.show', $id);
    }

    /**
     * @param $id
     *
     * @return array|Factory|RedirectResponse|View|mixed
     */
    public function permissions($id)
    {
        $user = $this->userService->findUser($id);

        if (!$user) {
            flash('User not found!', 'error');

            return redirect()->route('users.index');
        }

        $permissions = $this->userService->getAllPermissions();
        $userPermissions = $user->permissions->pluck('id')->toArray();

        return view('backend.user.users.permissions', compact('user', 'permissions', 'userPermissions'));
    }

    /**
     * @param Request $request
     * @param                          $id
     *
     * @return RedirectResponse
     */
    public function savePermissions(Request $request, $id)
    {
        $is_assigned = $this->userService->assignPermissionToUser($request->only('permissions'), $id);

        if ($is_assigned) {
            flash('Permission(s) assigned successfully');
        } else {
            flash('Failed to update permission');
        }

        return redirect()->route('users.show', $id);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function findHaveEmail(Request $request)
    {
        $input = $request->except('_token');
        $count = $this->userService->emailIsHave($input["email"], $input["user_id"]);
        $return["findUser"] = $count;
        if ($count > 0) {
            $return["message"] = ('Email already have, please provide another email address!');
            $return["message_type"] = ('alert alert-danger alert-dismissible');
        } else {
            $return["message"] = '';
            $return["message_type"] = '';
        }
        return json_encode($return);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findHaveMobile(Request $request): JsonResponse
    {
        $input = $request->except('_token');
        $mobile_number = isset($input["mobile_number"]) ? $input["mobile_number"] : (isset($input["mobile_phone"]) ? $input["mobile_phone"] : null);
        $count = $this->userService->mobileIsHave($mobile_number, $input["user_id"]);
        $return["findUser"] = $count;
        if ($count > 0) {
            $return["message"] = ('username already have, please provide another username!');
            $return["message_type"] = ('alert alert-danger alert-dismissible');
        } else {
            $return["message"] = '';
            $return["message_type"] = '';
        }
        return response()->json($return);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findUserNameHave(Request $request): JsonResponse
    {
        $input = $request->except('_token');
        $username = isset($input["username"]) ? $input["username"] : null;
        $count = $this->userService->userNameIsHave($username, $input["user_id"]);
        $return["findUser"] = $count;
        if ($count > 0) {
            $return["message"] = ('username already have, please provide another username!');
            $return["message_type"] = ('alert alert-danger alert-dismissible');
        } else {
            $return["message"] = '';
            $return["message_type"] = '';
        }
        return response()->json($return);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findHaveUserName(Request $request): JsonResponse
    {
        $input = $request->except('_token');
        $exiting_user_id = $input['user_id'] ?? null;
        $filter['username'] = $input["username"] ?? null;

        if (!is_null($exiting_user_id)) {
            $filter['user_id'] = $exiting_user_id;
        }

        $users = $this->userService->checkSponsor($filter);

        $return["findUser"] = $users->first();
        $return["countUser"] = $users->count();
        if ($users->count() > 0) {
            $return["message"] = ('Username already have, please provide another username!');
            $return["message_type"] = ('alert alert-danger alert-dismissible');
        } else {
            $return["message"] = '';
            $return["message_type"] = '';
        }
        return response()->json($return);

        /*if (!is_null($exiting_user_id)) {
            if ($return['countUser'] > 1)
                return response()->json(['status' => '200', 'data' => false]);
            else
                return response()->json(['status' => '200', 'data' => true]);
        } else {
            if ($return['countUser'] > 0)
                return response()->json(['status' => '200', 'data' => false]);
            else
                return response()->json(['status' => '200', 'data' => true]);
        }*/
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findUserHaveId(Request $request): JsonResponse
    {
        $user_id = $request->input('user_id');

        $return = $this->userService->findUser($user_id);
/*
        if ($count > 0) {
            $return["message"] = ('username already have, please provide another username!');
            $return["message_type"] = ('alert alert-danger alert-dismissible');
        } else {
            $return["message"] = '';
            $return["message_type"] = '';
        }*/
        return response()->json($return);
    }
}
