@extends('backend.layouts.master')
@section('title')
    Roles
@endsection
@section('page_styles')

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
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box">
            {!!
                \CHTML::formTitleBox(
                    $caption="Roles",
                    $captionIcon="icon-settings",
                    $routeName="roles",
                    $buttonClass="",
                    $buttonIcon=""
                )
            !!}
            <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <tr>
                                <th width="5%"> Id</th>
                                <th> Role</th>
                                {{--<th>Status</th>--}}
                                <th class="tbl-date"> Created At</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>
                                        {{$role->name}}
                                    </td>
{{--                                    <td>
                                        {!! \CHTML::flagChangeButton($role, 'status', \Utility::$statusText) !!}
                                    </td>--}}
                                    <td class="tbl-date">{{$role->created_at->format(config('app.date_format2'))}}</td>
                                   
                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='roles',
                                                $role->id,
                                                $selectButton=['showButton','editButton', 'deleteButton'],
                                                $class = ' btn-icon btn-circle ',
                                                $onlyIcon='yes',
                                                $othersPram=array()
                                            )
                                        !!}

                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {!! \CHTML::customPaginate($roles,'') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@section('page_scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{URL::to('/')}}/assets/admin/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{URL::to('/')}}/assets/admin/global/plugins/datatables/datatables.min.js"
            type="text/javascript"></script>
    <script src="{{URL::to('/')}}/assets/admin/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

<!-- BEGIN PAGE LEVEL SCRIPTS -->
@section('page_scripts2')
    <script src="{{URL::to('/')}}/assets/admin/pages/scripts/table-datatables-managed.min.js"
            type="text/javascript"></script>
@endsection
<!-- END PAGE LEVEL SCRIPTS -->
