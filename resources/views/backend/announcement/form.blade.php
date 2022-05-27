@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        @if (auth()->user()->userDetails->company_id == 1)
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('company_id', 'Company', true) !!}
                    <select name="company_id" id="company_id" class="form-control" required>
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @if (old('company_id', isset($announcement) ? $announcement['company_id'] : null) == $company->id) selected @endif>{{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="company_id-error" class="form-text text-danger help-block" role="alert">
                        {{ $errors->first('company_id') }}
                    </span>
                </div>
            </div>
        @else
            <input type="hidden" name="company_id" id="company_id"
                value="{{ auth()->user()->userDetails->company_id }}">
        @endif
        {{-- <div class="col-md-6">
            <div class="form-group">
                <label for="branch_id" class="control-label">Branch</label>
                <select name="branch_id" id="branch_id" class="form-control">
                    <option value="">Select Branch</option>
                </select>
            </div>
        </div> --}}
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="" @if (isset($announcement) && $announcement['course_id'] === '') selected @endif>Select Course
                    </option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @if (isset($announcement) && $announcement['course_id'] === $course->id) selected @endif>{{ $course->course_title }}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="form-text text-danger help-block" role="alert">
                    {{ $errors->first('course_id') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('announcement_title', 'Announcement Title', true) !!}
                <input class="form-control" required="required" name="announcement_title" type="text"
                    id="announcement_title"
                    value="{{ isset($announcement) ? $announcement['announcement_title'] : old('announcement_title') }}" placeholder="Enter Announcement Title">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nTextarea('announcement_details', 'Announcement Details', isset($announcement) ? $announcement->announcement_details : null, true, ['rows' => 10, 'class' => 'form-control editor', 'placeholder' => 'Enter Announcement Details']) !!}
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4">
            {!! \Form::nLabel('announcement_date', 'Announcement Date', false) !!}
            <input class="form-control only_date" required="required" name="announcement_date" type="text"
                   id="announcement_date" readonly
                   value="{{ isset($announcement) ? $announcement['announcement_date'] : old('announcement_date') }}">
            <span id="announcement_date-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('announcement_date') }}
            </span>
        </div>
        <div class="col-md-4">
            {!! \Form::nLabel('announcement_type', 'Announcement Type', true) !!}
            <select name="announcement_type" id="announcement_type" class="form-control" required>
                @foreach (\Utility::$announcementType as $key => $val)
                    <option value="{{ $key }}" @if (old('announcement_type', isset($announcement) ? $announcement['announcement_types'] : $key) == $val) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
            <span id="announcement_type-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('announcement_type') }}
            </span>
        </div>
        <div class="col-md-4">
            {!! \Form::nLabel('announcement_status', 'Announcement Status', true) !!}
            <select name="announcement_status" id="announcement_status" class="form-control" required>
                @foreach (\App\Services\UtilityService::$statusText as $key => $val)
                    <option value="{{ $val }}" @if (old('announcement_status', isset($announcement) ? $announcement['announcement_status'] : null) == $val) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
            <span id="announcement_status-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('announcement_status') }}
            </span>
        </div>
    </div>
</div>
<div class="box-footer">
    {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', null, $selectButton = ['cancelButton', 'storeButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'yes', $othersPram = []) !!}
</div>
@push('scripts')
    <script>
        let selected_course_id = "{{ old('course_id', isset($announcement) ? $announcement->course_id : null) }}";
        $(document).ready(function() {
            getCourseList();
            $("#company_id").change(function() {
                getCourseList();
            });

            $("#announcement_form").validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    branch_id: {
                        required: false
                    },
                    course_id: {
                        required: true
                    },
                    announcement_title: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    announcement_status: {
                        required: true
                    },
                    announcement_details: {
                        required: true
                    }
                }
            });

            function getCourseList() {
                let company_id = $('#company_id').val();
                let pickToken = '{{ csrf_token() }}';
                if (company_id) {
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "{{ route('course-listview.get') }}",
                        data: {
                            company_id: company_id,
                            '_token': pickToken,
                            'course_option_is_not': "Offline",
                        },
                        success: function(res) {
                            if (res.status == 200) {
                                $("#course_id").empty();
                                $("#course_id").append(
                                    '<option value="">Please Select Course</option>');
                                $.each(res.data, function(key, value) {
                                    if (selected_course_id == value.id) {
                                        courseSelectedStatus = ' selected ';
                                    } else {
                                        courseSelectedStatus = '';
                                    }
                                    $("#course_id").append('<option value="' + value.id + '" ' +
                                        courseSelectedStatus + '>' + value.course_title +
                                        '</option>');
                                });
                            } else {
                                $("#course_id").empty();
                                $("#course_id").append(
                                    '<option value="">Please Select Course</option>');
                            }
                        }
                    });
                } else {
                    $("#course_id").empty();
                    $("#course_id").append('<option value="">Please Select Course</option>');
                }
            }
        });
    </script>
@endpush
