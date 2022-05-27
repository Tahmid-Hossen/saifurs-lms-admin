@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-expeditedssl"></i>
        Role
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            @include('backend.layouts.flash')
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Details</h3>
                    <div class="pull-right">
                        <a
                            href="{{route('roles.index')}}"
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
                            <div class="col-md-6">
                                <div class="note note-info">
                                    <p> {{$role->name}} </p>
                                    <p> Created at: {{$role->created_at->format(config('app.date_format'))}} </p>
                                </div>
                            </div>

                        </div>
                        <h3 class="form-section">Permissions
                            @can('roles.permissions')
                                <a class=" btn btn-primary"
                                   href="{{route('roles.permissions', $role->id)}}" data-target="#pop-up-modal"
                                   data-toggle="modal"> Add/Update Permission </a>
                            @endcan
                        </h3>

{{--                        <div class="row">
                            <div class="col-md-12">
                                <div id="treeview_container" class="hummingbird-treeview">
                                    <ul id="treeview" class="hummingbird-base">

                                    </ul>
                                </div>
                                @forelse($permissionNestedArray as $permission)
                                    <tr>
                                        <td>{{$permission->name}}</td>
                                        <td><input type="checkbox"
                                                   checked
                                                   disabled
                                                   value="{{$permission->id}}"/></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            There is no permission added to this role.
                                        </td>
                                    </tr>
                                @endforelse
                            </div>
                        </div>--}}
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>

                                    @forelse($role->permissions as $permission)
                                        <tr>
                                            <td>{{$permission->name}}</td>
                                            <td><input type="checkbox"
                                                       checked
                                                       disabled
                                                       value="{{$permission->id}}"/></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">
                                                There is no permission added to this role.
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

@endsection

@push('scripts')
    <script src="{{ asset('/assets/js/collapsible-tree/hummingbird-treeview.min.js') }}"></script>
@endpush
