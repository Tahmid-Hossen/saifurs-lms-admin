@extends('backend.layouts.master')
@section('title')
    Course
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        Branch Location
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
                    CHTML::formTitleBox(
                        $caption="Branch Location",
                        $captionIcon="fa fa-question-circle",
                        $routeName="branchlocation",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column">
                            <thead>
                            <tr>
                                <th> ID</th>
                                <th> Branch Name</th>
                                <th> Manager Name</th>
                                <th> Address English</th>
                                <th> Address Bangla</th>
                                <th> Email</th>
                                <th> Phone</th>
                                <th> Status</th>
                                <th class="tbl-date"> Created At</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($branchlocations as $i => $branchlocation)
                                <tr>
                                    <td> {{$branchlocation->id}}</td>
                                    <td> {{ $branchlocation->branch_name }} </td>
                                    <td> {{ $branchlocation->manager_name }} </td>
                                    <td> {!! $branchlocation->address_en !!}</td>
                                    <td> {!! $branchlocation->address_bn !!}</td>
                                    <td> {!! $branchlocation->email !!}</td>
                                    <td> {{$branchlocation->phone}} </td>
                                    <td>
                                        {!! CHTML::flagChangeButton($branchlocation,
                                                'status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td> {{isset($branchlocation->created_at)?$branchlocation->created_at->format('d M, Y'):null}}</td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $branchlocation->id,
                                                $selectButton=['showButton','editButton','deleteButton'],
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
                {!! CHTML::customPaginate($branchlocations,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection


