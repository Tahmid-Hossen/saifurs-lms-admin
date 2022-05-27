@extends('backend.layouts.master')
@section('title')
    Create Permission of Users
@endsection


@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-key"></i>
        Permission
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
                <h3 class="box-title">Create </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="portlet-body">
                <form class="form-group" role="form" method="POST"
                      action="{{ route('permissions.store') }}" id="permissions">
                   @csrf
                    @include('backend.user.permissions.form')
                    <div class="box-footer">
                        {!!
\CHTML::actionButton(
    $reportTitle='..',
    $routeLink='permissions',
    (isset($permission) ? $permission->id : null),
    $selectButton=['cancelButton','storeButton'],
    $class = ' btn-icon btn-circle ',
    $onlyIcon='yes',
    $othersPram=array()
)
!!}
                    </div>
                </form>
                <div>
                    <!-- /.box -->
                </div>
            </div>

        </div>
    @endsection

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    @section('page_scripts')

    @endsection
    <!-- END PAGE LEVEL PLUGINS -->
