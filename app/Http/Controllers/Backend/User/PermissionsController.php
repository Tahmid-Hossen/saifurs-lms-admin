<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Backend\User\PermissionRequest;
use App\Repositories\Backend\User\PermissionRepository;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionsController extends Controller
{

    /**
     * @var PermissionRepository
     */
    private $repository;

    public function __construct(PermissionRepository $repository)
    {
        //$this->middleware('role:Admin');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->except('_token');
        $permissions = $this->repository->allPermissionsList($input)->paginate(UtilityService::$displayRecordPerPage);

        return view('backend.user.permissions.index')->withPermissions($permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.user.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     *
     * @return Response
     */
    public function store(PermissionRequest $request)
    {
        $permission = $this->repository->create($request->except('_token'));

        if ($permission) {
            flash('permission created successfully');
            return redirect()->route('permissions.index');
        }

        flash('Failed to create permission!', 'error');

        return redirect()->back()->withInput($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $permissionDetails = $this->repository->find($id);

        return view('backend.user.permissions.show', compact('permissionDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $permissionDetails = $this->repository->find($id);
        return view('backend.user.permissions.edit', compact('permissionDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param int $id
     *
     * @return Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $this->repository->update($request->except(['_token', '_method']), $id);

        flash('Permission has been updated');

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $permission = $this->repository->find($id);

        if ($permission) {
            flash('Permission has been deleted');

            $permission->delete();

        }

        return redirect()->route('permissions.index');
    }
}
