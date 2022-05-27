@extends('backend.layouts.master')
@section('title')
    Detail/Show Course Assignment
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-building"></i>
                Course Assignment
                <small>Control Panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
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
                                        $courseAssignment->id,
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_id" class="control-label">Company Name</label><br>
                                    {{isset($courseAssignment->company) ? $courseAssignment->company->company_name: null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_id" class="control-label">Branch:</label><br>
                                    {{isset($courseAssignment->branch) ? $courseAssignment->branch->branch_name: null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_id" class="control-label">Course</label><br>
                                    {{isset($courseAssignment->course) ? $courseAssignment->course->course_title: null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_chapter_id" class="control-label">Chapter:</label><br>
                                    {{isset($courseAssignment->courseChapter) ? $courseAssignment->courseChapter->chapter_title: null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="announcement_id" class="control-label">Announcement:</label><br>
                                    {{isset($courseAssignment->courseAnnouncement) ? $courseAssignment->courseAnnouncement->announcement_title: null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instructor_id" class="control-label">Instructor</label><br>
                                    {!! isset($courseAssignment->instructor->userDetails) ?
                                            $courseAssignment->instructor->userDetails->first_name.'&nbsp;'.$courseAssignment->instructor->userDetails->last_name
                                            .'&nbsp;('.$courseAssignment->instructor->userDetails->mobile_phone.')'
                                            : null !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_id" class="control-label">Student:</label><br>
                                    {!! isset($courseAssignment->student->userDetails) ?
                                            $courseAssignment->student->userDetails->first_name.'&nbsp;'.$courseAssignment->student->userDetails->last_name
                                            .'&nbsp;('.$courseAssignment->student->userDetails->mobile_phone.')'
                                            : null !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_assignment_name" class="control-label">Assignment Name</label><br>
                                    {{isset($courseAssignment) ? $courseAssignment->course_assignment_name: null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_assignment_detail" class="control-label">Assignment Detail</label><br>
                                    {{isset($courseAssignment) ? $courseAssignment->course_assignment_detail: null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_assignment_url">URL</label><br>
                                    {!! isset($courseAssignment->course_assignment_url) ? '<a href="'.$courseAssignment->course_assignment_url.'">'.(isset($courseAssignment) ? $courseAssignment->course_assignment_name: null).'</a>': null !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_assignment_document">Document</label><br>
                                    <a href="{{asset(isset($courseAssignment->course_assignment_document)?($courseAssignment->course_assignment_document):null)}}"
                                       class="fa fa-download">&nbsp;Download</a>
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
