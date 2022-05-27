<form action="{{route('users.roles.store', $user->id)}}" method="POST">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><i class="fa fa-expeditedssl"></i> Assign Role(s)</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">

                {{csrf_field()}}
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{$role->name}}</td>
                            <td><input type="checkbox" name="roles[]"
                                       @if (in_array($role->id, $userRoles))
                                       @if (in_array($role->id, array(0=>\Utility::$EmployeeRoleID)))
                                       disabled
                                       @endif
                                       checked
                                       @endif
                                       @if(isset($employee->user_id)?$employee->user_id:0 == $user->id)
                                       @if (in_array($role->id, array(0=>\Utility::$VendorRoleID)))
                                       disabled
                                       @endif
                                       @if (in_array($role->id, array(0=>\Utility::$ClientsRoleID)))
                                       disabled
                                       @endif
                                       @endif
                                       value="{{$role->id}}"/>
                                @if (in_array($role->id, array(0=>\Utility::$EmployeeRoleID)))
                                    <input type="hidden" name="roles[]" value="{{$role->id}}">
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">
                                There is no role.
                            </td>
                        </tr>
                    @endforelse
                </table>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn blue">Save changes</button>
    </div>
</form>
