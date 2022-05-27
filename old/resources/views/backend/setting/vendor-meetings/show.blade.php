@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-file-text"></i>
        Vendor Meeting
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
                <h3 class="box-title">Vendor Meeting</h3>
                <div class="pull-right">
                    {!!
                        \CHTML::actionButton(
                            $reportTitle='..',
                            $routeLink='#',
                            $vendorMeeting->id,
                            $selectButton=['backButton','editButton'],
                            $class = ' btn-icon btn-circle ',
                            $onlyIcon='no',
                            $othersPram=array()
                        )
                    !!}
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="portlet-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="company_id" class="control-label">Company Name</label><br>
                                {!! isset($vendorMeeting->company->company_name)?$vendorMeeting->company->company_name:null !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branch_id" class="control-label">Branch:</label><br>
                                {!! isset($vendorMeeting->branch->branch_name)?$vendorMeeting->branch->branch_name:null !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vendor_id" class="control-label">Vendor</label><br>
                                {!! isset($vendorMeeting->vendor->vendor_name)?$vendorMeeting->vendor->vendor_name:null !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="course_id" class="control-label">Course</label><br>
                                {!! isset($vendorMeeting->course->course_title)?$vendorMeeting->course->course_title:null !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="course_batch_id" class="control-label">Batch:</label><br>
                                {!! isset($vendorMeeting->courseBatch->course_batch_name)?$vendorMeeting->courseBatch->course_batch_name:null !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="course_chapter_id" class="control-label">Chapter:</label><br>
                                {!! isset($vendorMeeting->courseChapter->chapter_title)?$vendorMeeting->courseChapter->chapter_title:null !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instructor_id" class="control-label">Instructor</label><br>
                                {{isset($vendorMeeting->instructor->userDetails->first_name)?$vendorMeeting->instructor->userDetails->first_name:null}}&nbsp;
                                {{isset($vendorMeeting->instructor->userDetails->last_name)?$vendorMeeting->instructor->userDetails->last_name:null}}&nbsp;
                                {{isset($vendorMeeting->instructor->mobile_number)?'('.$vendorMeeting->instructor->mobile_number.')':null}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vendor_meeting_title" class="control-label">Name</label><br>
                                        {{isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_title: null}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="vendor_meeting_title" class="control-label">Start At</label><br>
                                                {{isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_start_time: null}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="vendor_meeting_title" class="control-label">End At</label><br>
                                                {{isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_end_time: null}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vendor_meeting_agenda" class="control-label">Agenda</label><br>
                                        {!! isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_agenda: null !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vendor_meeting_status" class="control-label">@lang('common.Status')</label><br>
                                        {{isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_status: null}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vendor_meeting_url">URL</label><br>
                                        {{isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_url: null}}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="vendor_meeting_logo">Logo</label><br>
                                    <img class="img-thumbnail img-responsive"
                                         id="vendor_meeting_logo_show"
                                         src="{{isset($vendorMeeting->vendor_meeting_logo)?URL::to($vendorMeeting->vendor_meeting_logo):config('app.default_image')}}"
                                         width="{{\Utility::$vendorMeetingLogoSize['width']}}"
                                         height="{{\Utility::$vendorMeetingLogoSize['height']}}"
                                    >
                                </div>
                            </div>
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
