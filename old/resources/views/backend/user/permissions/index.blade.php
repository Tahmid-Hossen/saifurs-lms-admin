@extends('backend.layouts.master')
@section('title')
    Permissions
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-key"></i>
        Permission
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box box-primary">
            {!!
                \CHTML::formTitleBox(
                    $caption="Permissions",
                    $captionIcon="icon-settings",
                    $routeName="roles",
                    $buttonClass="",
                    $buttonIcon=""
                )
            !!}
            <!-- /.box-header -->
                <div class="box-body  no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                width="100%">
                            <thead>
                            <tr>
                                <th> Id</th>
                                <th> Permission</th>
                                <th> Created at</th>
                               <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $thisPermission)
                                <tr>
                                    <td>{{$thisPermission->id}}</td>
                                    <td>{{$thisPermission->name}}</td>
                                    <td class="center">
                                        {{ $thisPermission->created_at->format(config('app.date_format')) }}
                                    </td>
                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='permissions',
                                                $thisPermission->id,
                                                $selectButton=['editButton','deleteButton'],
                                                $class = ' btn-icon btn-circle ',
                                                $onlyIcon='yes',
                                                $othersPram=array()
                                            )
                                        !!}

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                {!! \CHTML::customPaginate($permissions,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection

@section('script')

@endsection

