<div class="box-body">
    <div class="row">
{{--        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control" required>
                    <option value="" @if (isset($courseBatch) && ($courseBatch->company_id === "")) selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($courseBatch) && ($courseBatch->company_id === $company->id)) selected @endif
                        >{{$company->company_name}}</option>
                    @endforeach
                </select>
                <span id="company_id-error"
                      class="help-block text-danger"><strong>{{ $errors->first('company_id') }}</strong></span>
            </div>
        </div>--}}
        <input type="hidden" id="company_id" name="comapny_id" value="{{auth()->user()->userDetails->company_id}}">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('branch_id', 'Branch') !!}
                <select name="branch_id" id="branch_id" class="form-control">
                    <option value="">Select Branch</option>
                </select>
                <span id="branch_id-error"
                      class="help-block text-danger"><strong>{{ $errors->first('branch_id') }}</strong></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="" @if (isset($courseBatch) && ($courseBatch->company_id === "")) selected @endif>
                        Select Course
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($courseBatch) && ($courseBatch->course_id === $course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span id="course_id-error"
                      class="help-block text-danger"><strong>{{ $errors->first('course_id') }}</strong></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('instructor_id', 'Instructor', true) !!}
                <select name="instructor_id" id="instructor_id" class="form-control" required>
                    <option value="">Select Instructor</option>
                </select>
                <span id="instructor_id-error"
                      class="help-block text-danger"><strong>{{ $errors->first('instructor_id') }}</strong></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_batch_duration', 'Batch/Session Duration(Start - End)', false) !!}
                @php
                    $start_date = (isset($courseBatch) && !is_null($courseBatch->course_batch_start_date))
                    ? \Carbon\Carbon::parse($courseBatch->course_batch_start_date)->format('Y-m-d')
                    : date('Y-m-d');

                    $end_date = (isset($courseBatch) && !is_null($courseBatch->course_batch_end_date))
                    ? \Carbon\Carbon::parse($courseBatch->course_batch_end_date)->format('Y-m-d')
                    : date('Y-m-d');

                    $duration = $start_date . ' - ' . $end_date;
                @endphp
                <input id="course_batch_duration" type="text" readonly
                       class="form-control course_batch_duration" name="course_batch_duration"
                       value="{{ old('course_batch_duration', $duration) }}"
                       required>
                <span id="course_batch_duration-error" class="help-block d-block text-danger">
                            {{ $errors->first('course_batch_duration') }}
                        </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('batch_class_start_time', 'Class Start Time', false) !!}
                        <input id="batch_class_start_time" type="text" readonly
                               class="form-control class_time" name="batch_class_start_time"
                               value="{{ old('batch_class_start_time', $courseBatch->batch_class_start_time ?? date('H:i:s')) }}"
                               required>
                        <span id="batch_class_start_time-error" class="help-block d-block text-danger">
                            {{ $errors->first('batch_class_start_time') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('batch_class_end_time', 'Class End Time', false) !!}
                        <input id="batch_class_end_time" type="text" readonly
                               class="form-control class_time" name="batch_class_end_time"
                               value="{{ old('batch_class_end_time', ($courseBatch->batch_class_end_time ?? null)) }}"
                               required>
                        <span id="batch_class_end_time-error" class="help-block d-block text-danger">
                            {{ $errors->first('batch_class_end_time') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('batch_class_days', 'Schedule Class Days: ', false) !!}
                @foreach(\App\Services\UtilityService::$working_days as $input_day => $text_day)
                    <div class="checkbox-inline">
                        <input type="checkbox" class="form-check-input" name="batch_class_days[{{$input_day}}]"
                               id="{{ $input_day }}" value="{{$input_day}}"
                               @if(old('batch_class_days[' .$input_day . ']', ($courseBatch->batch_class_day[$input_day] ?? null) ) == $input_day) checked @endif
                        >
                        <label class="form-check-label" for="{{ $input_day }}">{{ $text_day }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! \Form::nLabel('student_id', 'Student', false) !!}
                        <select name="student_id[]" id="student_id" class="form-control student-tags" multiple>
                            <option value="">Select Student</option>
                        </select>
                        <span id="student_id-error"
                              class="help-block text-danger"><strong>{{ $errors->first('student_id') }}</strong></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('course_batch_name', 'Name', true) !!}
                        <input
                            id="course_batch_name"
                            type="text"
                            class="form-control"
                            name="course_batch_name"
                            placeholder="Enter Batch Name"
                            value="{{ old('course_batch_name', isset($courseBatch) ? $courseBatch->course_batch_name: null) }}"
                            required
                            autofocus
                        >
                        <span id="course_batch_name-error"
                              class="help-block text-danger"><strong>{{ $errors->first('course_batch_name') }}</strong></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('course_batch_detail', 'Detail', true) !!}
                        <input
                            id="course_batch_detail"
                            type="text"
                            class="form-control"
                            name="course_batch_detail"
                            placeholder="Enter Batch Detail"
                            value="{{ old('course_batch_detail', isset($courseBatch) ? $courseBatch->course_batch_detail: null) }}"
                            required
                            autofocus
                        >
                        <span id="course_batch_detail-error"
                              class="help-block text-danger"><strong>{{ $errors->first('course_batch_detail') }}</strong></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('course_batch_status', 'Status') !!}
                        <select name="course_batch_status" id="course_batch_status" class="form-control">
                            @foreach(\App\Support\Configs\Constants::$user_status as $status)
                                <option value="{{$status}}"
                                        @if (isset($courseBatch) && ($courseBatch->course_batch_status === $status)) selected @endif
                                >{{$status}}</option>
                            @endforeach
                        </select>
                        <span id="course_batch_status-error"
                              class="help-block text-danger"><strong>{{ $errors->first('course_batch_status') }}</strong></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('course_batch_logo', 'Logo', empty($courseBatch->course_batch_logo)) !!}
                        <input
                            type="file" onchange="imageIsLoaded(this, 'course_batch_logo_show')"
                            class="form-control"
                            name="course_batch_logo"
                            id="course_batch_logo"
                            placeholder="Enter Batch Logo"
                            value="{{ old('course_batch_logo', isset($courseBatch) ? $courseBatch->course_batch_logo:null) }}"
                        >
                        <span id="course_batch_logo-error"
                              class="help-block text-danger"><strong>{{ $errors->first('course_batch_logo') }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="img-thumbnail text-center">
                        <img class="img-responsive" style="display: inline-block; height: 178px;"
                             id="course_batch_logo_show"
                             src="{{isset($courseBatch->course_batch_logo)?URL::to($courseBatch->course_batch_logo):config('app.default_image')}}"
                             width="{{\Utility::$courseBatchLogoSize['width']}}"
                             height="{{\Utility::$courseBatchLogoSize['height']}}"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!!
        CHTML::actionButton(
            $reportTitle='..',
            $routeLink='#',
            '',
            $selectButton=['cancelButton','storeButton'],
            $class = ' btn-icon btn-circle ',
            $onlyIcon='yes',
            $othersPram=array()
        )
    !!}
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            //tag created
            $(".student-tags").select2({
                "width": "100%",
                placeholder: "Select an option"
            });

            $('.course_batch_duration').daterangepicker({
                showDropdowns: true,
                startDate: moment(),
                locale: {
                    format: "YYYY-MM-DD"
                }
            });

            //Timepicker
            $(".class_time").timepicker({
                autoclose: true,
                showMeridian: false,
                showSeconds: true
            });

            if($("#company_id").val().length > 0) {
                getBranchDropdown($("#company_id"), $("#branch_id"), selected_company_id);
                getCourseCategoryDropdown($("#company_id"), $("#course_category_id"), null);
            }
        });
    </script>
@endpush
