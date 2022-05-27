@extends('backend.layouts.master')
@section('title')
    Detail/Show Announcement
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Announcement
        <small>Control panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', $announcement->id, $selectButton = ['backButton', 'editButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'no', $othersPram = []) !!}
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Announcement Title</label><br>
                                {{ isset($announcement) ? $announcement->announcement_title : null }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Course Name</label><br>
                                {{ isset($announcement) ? $announcement->course->course_title : null }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Announcement Status</label><br>
                                {{ isset($announcement) ? $announcement->announcement_status : null }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Announcement Deatils</label><br>
                                {!! isset($announcement) ? html_entity_decode($announcement->announcement_details) : 'No Details Found' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
@endsection
