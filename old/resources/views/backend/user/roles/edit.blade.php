@extends('backend.layouts.master')
@section('title')
    Edit/Update
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

    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit/Update </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="portlet-body">
                    <form class="form-group" role="form" method="POST"
                          action="{{ route('roles.update',$roleDetails->id) }}"  id="roles">
                       @csrf
                        @method('PUT')
                        <div class="box-body">
                            @include('backend.user.roles.form')
                        </div>
                        <!-- /.box-body -->

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

@endsection

<!-- BEGIN PAGE LEVEL PLUGINS -->
@section('page_scripts')

@endsection
<!-- END PAGE LEVEL PLUGINS -->
