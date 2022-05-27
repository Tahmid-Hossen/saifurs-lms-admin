@extends('backend.layouts.master')
@section('title')
    Create Role of Users
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-expeditedssl"></i>
        Role
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">

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
                        <form class="form-group" role="form" method="POST" action="{{ route('roles.store') }}" id="roles">
                           @csrf
                            @include('backend.user.roles.form')

                            <div class="box-footer">
                                {!!
                                \CHTML::actionButton(
                                    $reportTitle='..',
                                    $routeLink='#',
                                    (isset($role) ? $role->id : null),
                                    $selectButton=['cancelButton','storeButton'],
                                    $class = ' btn-icon btn-circle ',
                                    $onlyIcon='yes',
                                    $othersPram=array()
                                )
                            !!}
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            </div>

        </div>
        <!-- END CONTENT -->
    @endsection

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    @section('page_scripts')

    @endsection
    <!-- END PAGE LEVEL PLUGINS -->
