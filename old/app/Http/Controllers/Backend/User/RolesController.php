<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Backend\User\RoleRequest;
use App\Repositories\Backend\User\RoleRepository;
use App\Services\UtilityService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

use Illuminate\Support\Arr;

class RolesController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $repository;

    /**
     * RolesController constructor.
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        //$this->middleware('role:Admin');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->except('_token');
        $roles = $this->repository->allRolesList($input)->paginate(UtilityService::$displayRecordPerPage);

        return view('backend.user.roles.index')->withRoles($roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.user.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     *
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $role = $this->repository->create($request->except('_token'));

        if ($role) {
            flash('Role created successfully');
            return redirect()->route('roles.index');
        }

        flash('Failed to create role!', 'error');

        return redirect()->back()->withInput($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
        //$roles = [];
        $role = $this->repository->findWith($id, ['permissions']);
/*        /**
Important TODO recursive
         * Hafiz
         *
        $permissionNestedArray = [];
        foreach ($role->permissions as $permission):
            $permissionNestedArray[] = \Utility::recursiveDottedArray($permission->name, $permission);
        endforeach;*/

        /**
         * Tanvir
         */
        $permissionArray = array();
        foreach ($role->permissions as $permission) {
            //$permissionNestedArray[] = $this->recursiveDottedArray($permission->name, $permission);
            $roles = (explode('.', $permission->name));
            $permissionArray[$roles[0]][] = $permission;
            $permissionArray[$roles[0]][]['parent_name'] = $roles[0];
            //$permission->pivot;
        }
        $permissionData = $permissionArray;
        //dd($role, $permissionData);
        //return view('backend.user.roles.permissions-two',compact('permissionData','role'));
        return view('backend.user.roles.show', compact( 'permissionData', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(int $id)
    {
        $roleDetails = $this->repository->find($id);
        return view('backend.user.roles.edit', compact('roleDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, int $id)
    {
        $this->repository->update($request->except(['_token', '_method']), $id);

        flash('Role has been updated');

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse|Response
     */
    public function destroy(int $id)
    {
        $role = $this->repository->find($id);

        if ($role) {
            flash('Role has been deleted');

            $role->delete();

        }

        return redirect()->route('roles.index');
    }

    /**
     * @param $role_id
     *
     * @return array|Factory|View|mixed
     */
    public function permission($role_id)
    {
        $role = $this->repository->findWith($role_id, ['permissions']);
        $permissions = $this->repository->getPermissions();
        $permissionArray = array();
        foreach ($permissions as $permission) {
            $roles = (explode('.', $permission->name));
            $permissionArray[$roles[0]][] = $permission;
            $permissionArray[$roles[0]][]['parent_name'] = $roles[0];
            //$permission->pivot;
        }
        $permissionData = $permissionArray;
        //dd($permissionData);
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        //dd($permissions);
        return view('backend.user.roles.permissions-three', compact('permissionData', 'role', 'permissions', 'rolePermissions'));

        //return view('backend.user.roles.permissions-two',compact('permissionData','role','permissions', 'rolePermissions'));
        //return view('backend.user.roles.permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * @param Request $request
     * @param                          $id
     *
     * @return RedirectResponse
     */
    public function storePermission(Request $request, $id)
    {
        //dd($request->all());
        $is_assigned = $this->repository->assignPermissionToRole($request->all(), $id);

        if ($is_assigned) {
            flash('Permission(s) assigned successfully');
        } else {
            flash('Failed to update permission');
        }

        return redirect()->route('roles.show', $id);
    }
}
