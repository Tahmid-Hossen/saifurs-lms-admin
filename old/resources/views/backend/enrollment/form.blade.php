<div class="box-body">
    <div class="row">
        @if (auth()->user()->userDetails->company_id == 1)
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('company_id', 'Company', true) !!}
                    <select name="company_id" id="company_id" class="form-control auto_search class_id" required>
                        <option value="" @if (isset($enrollment) && ($enrollment->company_id === "")) selected @endif>
                            Select Company
                        </option>
                        @foreach($companies as $company)
                            <option value="{{$company->id}}"
                                    @if (isset($enrollment->company_id) && ($enrollment->company_id === $company->id)) selected @endif
                            >{{$company->company_name}}</option>
                        @endforeach
                    </select>
                    <span id="company_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('company_id') }}
                </span>
                </div>
            </div>
        @else
            <input type="hidden" name="company_id" id="company_id"
                   value="{{ auth()->user()->userDetails->company_id }}">
        @endif
        @if (auth()->user()->userDetails->company_id == 1)
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('branch_id', 'Branch') !!}
                    <select name="branch_id" id="branch_id" class="form-control auto_search">
                        <option value="">Select Branch</option>
                    </select>
                </div>
            </div>
        @else
            <input type="hidden" name="company_id" id="company_id"
                   value="{{ auth()->user()->userDetails->branch_id }}">
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control auto_search" required>
                    <option value="" @if (isset($enrollment) && ($enrollment->course_id === "")) selected @endif>Select
                        Course
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($enrollment->course_id) && ($enrollment->course_id === $course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_id') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('batch_id', 'Course Batch') !!}
                <select name="batch_id" id="batch_id" class="form-control auto_search">
                    <option value=""
                            @if (isset($enrollment) && ($enrollment->batch_id === "")) selected @endif>Select
                        Course Batch
                    </option>
                    @foreach($course_batches as $course_batch)
                        <option value="{{$course_batch->id}}"
                                @if (isset($enrollment->batch_id) && ($enrollment->batch_id === $course_batch->id)) selected @endif
                        >{{$course_batch->course_batch_name}}</option>
                    @endforeach
                </select>
                @error('batch_id')
                <span class="form-text text-danger" role="alert">
                                    {{ $errors->first('batch_id') }}
                                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('user_id', 'Student/User', true) !!}
                <select name="user_id" id="user_id" name="user_id" class="form-control auto_search" required>
                    <option value="" @if (isset($enrollment) && ($enrollment->user_id === "")) selected @endif>
                        Select an Option
                    </option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}"
                                @if (isset($enrollment->user_id) && ($enrollment->user_id === $user->id)) selected @endif
                        >{{$user->name}}</option>
                    @endforeach
                </select>
                @error('user_id')
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('user_id') }}
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('enroll_title', 'Remarks') !!}
                <input
                    type="text"
                    class="form-control"
                    name="enroll_title"
                    id="enroll_title"
                    placeholder="Enter Enrollment Title"
                    value="{{ old('enroll_title', isset($enrollment) ? $enrollment->enroll_title: null) }}"
                    autofocus
                >
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('enroll_title') }}
                </span>
            </div>
        </div>
    </div>
<input type="hidden" name="enroll_status" value="ACTIVE">
    @if(isset($enrollment))
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="enroll_status"> Status
                    </label>
                    <select name="enroll_status" id="enroll_status" class="form-control auto_search view-color">
                        @foreach(\App\Support\Configs\Constants::$question_status as $status)
                            <option value="{{$status}}"
                                    @if (isset($enrollment) && ($enrollment->enroll_status === $status)) selected @endif
                            >{{str_replace("-","",$status)}}</option>
                        @endforeach
                    </select>
                    @error('enroll_status')
                    <span class="form-text text-danger" role="alert">
                    {{ $errors->first('enroll_status') }}
                </span>
                    @enderror
                </div>
            </div>
        </div>
    @endif
</div>
<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='enrollments',
        isset($enrollment) ? $enrollment->id : null,
        $selectButton=['cancelButton','storeButton'],
        $class = ' btn-icon btn-circle ',
        $onlyIcon='yes',
        $othersPram=array()
    )
!!}
</div>

@push('scripts')
    <script>
        var selected_course_id = '{{old("course_id", (isset($enrollment)?$enrollment->course_id:null))}}';
        var selected_batch_id = '{{old("batch_id", (isset($enrollment)?$enrollment->batch_id:null))}}';
        var selected_user_id = '{{old("user_id", (isset($enrollment)?$enrollment->user_id:null))}}';

        $(document).ready(function () {
            getCourseCategoryList();
            $("#company_id").change(function () {
                getCourseCategoryList();
                getUserList();
            });

            getCourseBatchList();
            $("#course_id").change(function () {
                getCourseBatchList();
            });

            getUserList();
            $("#batch_id").change(function () {
                getUserList();
            });


            $("#enrollment_form").validate({
                rules: {
                    enroll_title: {
                        required: true,
                    },

                    company_id: {
                        required: true,
                    },

                    course_id: {
                        required: true,
                    },

                    user_id: {
                        required: true,
                    },
                }
            });
        });


        function getCourseCategoryList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-list')}}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_course_id == value.id) {
                                    courseSelectedStatus = ' selected ';
                                } else {
                                    courseSelectedStatus = '';
                                }
                                $("#course_id").append('<option value="' + value.id + '" ' + courseSelectedStatus + '>' + value.course_title + '</option>');
                            });
                        } else {
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                        }
                    }
                });
            } else {
                $("#course_id").empty();
                $("#course_id").append('<option value="">Please Select Course</option>');
            }
        }

        function getCourseBatchList() {
            var course_id = $('#course_id').val();
            var pickToken = '{{csrf_token()}}';
            if (course_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course-batches.get-course-batch-list')}}',
                    data: {
                        course_id: course_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#batch_id").empty();
                            $("#batch_id").append('<option value="">Please Select Course Batch</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_batch_id == value.id) {
                                    courseBatchSelectedStatus = ' selected ';
                                } else {
                                    courseBatchSelectedStatus = '';
                                }
                                $("#batch_id").append('<option value="' + value.id + '" ' + courseBatchSelectedStatus + '>' + value.course_batch_name + '</option>');
                            });
                        } else {
                            $("#batch_id").empty();
                            $("#batch_id").append('<option value="">Please Select Course Batch</option>');
                        }
                    }
                });
            } else {
                $("#batch_id").empty();
                $("#batch_id").append('<option value="">Please Select Course Batch</option>');
            }
        }

        function getUserList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if (batch_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('user-details.get-user-detail-list')}}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#user_id").empty();
                            $("#user_id").append('<option value="">Please Select User</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_user_id == value.id) {
                                    userSelectedStatus = ' selected ';
                                } else {
                                    userSelectedStatus = '';
                                }
                                $("#user_id").append('<option value="' + value.id + '" ' + userSelectedStatus + '>' + value.name + '</option>');
                            });
                        } else {
                            $("#user_id").empty();
                            $("#user_id").append('<option value="">Please Select User</option>');
                        }
                    }
                });
            } else {
                $("#user_id").empty();
                $("#user_id").append('<option value="">Please Select User</option>');
            }
        }
    </script>
@endpush

