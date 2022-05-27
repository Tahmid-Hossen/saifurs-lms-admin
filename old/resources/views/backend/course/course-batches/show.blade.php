@extends('backend.layouts.master')
@section('title')
    Detail/Show Course Batch
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-laptop"></i>
        Batch
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!!
                                    CHTML::actionButton(
                                        $reportTitle='..',
                                        $routeLink='#',
                                        $courseBatch->id,
                                        $selectButton=['backButton','editButton'],
                                        $class = ' btn-icon btn-circle ',
                                        $onlyIcon='no',
                                        $othersPram=array()
                                    )
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
{{--                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_id" class="control-label">Company Name</label><br>
                                            {{isset($courseBatch->company) ? $courseBatch->company->company_name: null}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="branch_id" class="control-label">Branch:</label><br>
                                            {{isset($courseBatch->branch) ? $courseBatch->branch->branch_name: null}}
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_id" class="control-label">Course</label><br>
                                            {{isset($courseBatch->course) ? $courseBatch->course->course_title: null}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="instructor_id" class="control-label">Instructor</label><br>
                                            {!! isset($courseBatch->instructor->userDetails) ?
                                                    $courseBatch->instructor->userDetails->first_name.'&nbsp;'.$courseBatch->instructor->userDetails->last_name
                                                    .'&nbsp;('.$courseBatch->instructor->userDetails->mobile_phone.')'
                                                    : null !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_batch_name" class="control-label">Name</label><br>
                                            {{isset($courseBatch) ? $courseBatch->course_batch_name: null}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_batch_detail" class="control-label">Detail</label><br>
                                            {{isset($courseBatch) ? $courseBatch->course_batch_detail: null}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_batch_name" class="control-label">Batch Start
                                                Date</label><br>
                                            {{isset($courseBatch->course_batch_start_date) ? \Carbon\Carbon::parse($courseBatch->course_batch_start_date)->format('d F, Y'): 'N/A'}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_batch_detail" class="control-label">Batch End
                                                Date</label><br>
                                            {{isset($courseBatch->course_batch_end_date) ? \Carbon\Carbon::parse($courseBatch->course_batch_end_date)->format('d F, Y'): 'N/A'}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_batch_name" class="control-label">Class Start
                                                Time</label><br>
                                            {{isset($courseBatch->batch_class_start_time) ? \Carbon\Carbon::parse($courseBatch->batch_class_start_time)->format('h:i A'): 'N/A'}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_batch_detail" class="control-label">Class End
                                                Time</label><br>
                                            {{isset($courseBatch->batch_class_end_time) ? \Carbon\Carbon::parse($courseBatch->batch_class_end_time)->format('h:i A'): 'N/A'}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="course_batch_name" class="control-label">Class Days</label><br>
                                            {{isset($courseBatch->batch_class_days) ? ucwords(str_replace(',', ', ', $courseBatch->batch_class_days)) : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img
                                    src="{{asset(isset($courseBatch->course_batch_logo)?($courseBatch->course_batch_logo):null)}}"
                                    width="{{Utility::$courseBatchLogoSize['width']}}
                                        height="{{Utility::$courseBatchLogoSize['height']}}"
                                >
                            </div>
                            <div class="col-md-12">
                                @include('backend.course.course-batches.course-batch-student-list-table')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
