@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-users"></i>
        User
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection
@include('backend.layouts.flash')
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Details</h3>
                <div class="pull-right">
                    <a
                        href="{{route('users.index')}}"
                        class="btn btn-danger hidden-print">
                        <i class="glyphicon glyphicon-hand-left"></i> Back
                    </a>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="portlet-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 profile-info">
                            <h3 class="font-green sbold uppercase">{{$user->name}}</h3>

                            <p>
                                <a href="mailto:{{$user->email}}"> {{$user->email}} </a>
                            </p>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <h3 class="form-section">Roles
                                @if(isset($employee->user_id)?$employee->user_id:0 == $user->id)
                                    @can('users.roles')
                                        <a class=" btn btn-sm yellow btn-outline sbold"
                                           href="{{route('users.roles', $user->id)}}"
                                           data-target="#roles-modal"
                                           data-toggle="modal">
                                            Add/Update Role
                                        </a>
                                    @endcan
                                @endif
                            </h3>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                </tr>

                                @forelse($user->roles as $role)
                                    <tr>
                                        <td>{{$role->name}}</td>
                                        <td><input type="checkbox"
                                                   checked
                                                   disabled
                                                   value="{{$role->id}}"/></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            There is no role added to this user.
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>

                        <div class="col-md-6">

                            <h3 class="form-section">Permissions
                                @can('users.permissions')
                                    <a class=" btn btn-sm yellow btn-outline sbold"
                                       href="{{route('users.permissions', $user->id)}}"
                                       data-target="#permissions-modal"
                                       data-toggle="modal"
                                    >
                                        Add/Update Permission
                                    </a>
                                @endcan
                            </h3>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                </tr>

                                @forelse($user->permissions as $permission)
                                    <tr>
                                        <td>{{$permission->name}}</td>
                                        <td>
                                            <input
                                                type="checkbox"
                                                checked
                                                disabled
                                                value="{{$permission->id}}"
                                            />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            There is no permission added to this user.
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>

@include('backend.user.users.partials.roles-modal')
@include('backend.user.users.partials.permissions-modal')
@endsection
