@extends('backend.layouts.master')
@section('title')
    Review Course Assignment
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
                                        $selectButton=['backButton'],
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
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instructor_id" class="control-label">Instructor</label><br>
                                    {!! isset($courseAssignment->instructor->userDetails) ?
                                            $courseAssignment->instructor->userDetails->first_name.'&nbsp;'.$courseAssignment->instructor->userDetails->last_name
                                            .'&nbsp;('.$courseAssignment->instructor->userDetails->mobile_phone.')'
                                            : null !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_id" class="control-label">Student:</label><br>
                                    {!! isset($courseAssignment->student->userDetails) ?
                                            $courseAssignment->student->userDetails->first_name.'&nbsp;'.$courseAssignment->student->userDetails->last_name
                                            .'&nbsp;('.$courseAssignment->student->userDetails->mobile_phone.')'
                                            : null !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_assignment_name" class="control-label">Name</label><br>
                                    {{isset($courseAssignment) ? $courseAssignment->course_assignment_name: null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_assignment_detail" class="control-label">Detail</label><br>
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
                        <form class="horizontal-form" id="course_assignment_review_form" role="form" method="POST"
                              action="{{ route('course-assignments.assignment-review-update', $courseAssignment->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="course_assignment_review" class="control-label">Review:</label>
                                        <select name="course_assignment_review" id="course_assignment_review"
                                                class="form-control" required onchange="divShowHide('course_assignment')">
                                            <option value=""
                                                    @if(old('company_id', isset($courseAssignment) ? $courseAssignment->course_assignment_review:null) == "") selected @endif>
                                                Select IS Review
                                            </option>
                                            <option value="Unchecked"
                                                    @if(old('company_id', isset($courseAssignment) ? $courseAssignment->course_assignment_review:null) == "Unchecked") selected @endif>
                                                Unchecked
                                            </option>
                                            <option value="Checked"
                                                    @if(old('company_id', isset($courseAssignment) ? $courseAssignment->course_assignment_review:null) == "Checked") selected @endif>
                                                Checked
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="course_assignment_score_div">
                                    <div class="form-group">
                                        <label for="course_assignment_score">Give scores to assignment (1 to 10)</label>
                                        <input
                                            id="course_assignment_score"
                                            type="text"
                                            class="form-control"
                                            name="course_assignment_score"
                                            placeholder="Give scores to assignment (1 to 10)"
                                            value="{{ old('course_assignment_score', isset($courseAssignment) ? $courseAssignment->course_assignment_score: null) }}"
                                            required
                                            autofocus
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4" id="course_assignment_button"><br>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                                class="fa fa-check"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            divShowHide('course_assignment');
            $("#course_assignment_review_form").validate({
                rules: {
                    course_assignment_review: {
                        required: true
                    },
                    course_assignment_score: {
                        required: true,
                        max: 10
                    }
                }
            });
        });

        function divShowHide(id) {
            if ($('#' + id + '_review').val() == 'Checked') {
                $('#' + id + '_score_div').show();
                $('#' + id + '_button').show();
                $('#' + id + '_button').attr('class', 'col-md-4');
                $('#' + id + '_score').attr("required", "required");
            } else {
                $('#' + id + '_score_div').hide();
                $('#' + id + '_button').hide();
                $('#' + id + '_button').attr('class', 'col-md-6');
                $('#' + id + '_score').removeAttr("required");
            }
        }
    </script>
@endsection
