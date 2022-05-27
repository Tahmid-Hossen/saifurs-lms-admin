<div class="box-body">
    <div class="row">
        @if (auth()->user()->userDetails->company_id == 1)
            <div class="col-md-12">
                <div class="form-group">
                    {!! \Form::nLabel('company_id', 'Company', true) !!}
                    <select name="company_id" id="company_id" class="form-control" required>
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @if (old('company_id', isset($quiz) ? $quiz['company_id'] : null) == $company->id) selected @endif>{{ $company->company_name }}
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
    </div>
    <div class="row">
        <div class="col-md-12" id="course_choose_from_dropdown">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id[]" id="course_id" class="form-control" required multiple="multiple">
                    <option value="" @if (isset($quiz) && $quiz['course_id'] === '') selected @endif>Select Course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @if (isset($quiz) && $quiz['course_id'] === $course->id) selected @endif>{{ $course->course_title }}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="form-text text-danger help-block" role="alert">
                    {{ $errors->first('course_id') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nLabel('quiz_type', 'Quiz Type', true) !!}
            <select name="quiz_type" id="quiz_type" class="form-control" required>
                @foreach (\App\Services\UtilityService::$quizType as $key => $val)
                    <option value="{{ $key }}" @if (old('quiz_type', isset($quiz) ? $quiz['quiz_type'] : null) == $key) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
            <span id="quiz_type-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('quiz_type') }}
            </span>
        </div>
        <div class="col-md-6">
            {!! \Form::nText('quiz_topic', 'Quiz Topic', isset($quiz) ? $quiz['quiz_topic'] : null, true, ['class' => 'form-control']) !!}
            <span id="quiz_topic-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('quiz_topic') }}
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nNumber('quiz_full_marks', 'Quiz Full Marks', isset($quiz) ? $quiz['quiz_full_marks'] : 20, true, ['min' => 0, 'step' => '1']) !!}
            <span id="quiz_full_marks-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('quiz_full_marks') }}
            </span>
        </div>
        <div class="col-md-6">
            {{ \Form::nText('quiz_pass_percentage', 'Percent to Pass this Quiz (%)', isset($quiz) ? $quiz['quiz_pass_percentage'] : 33, true, ['class' => 'form-control']) }}
            <span id="quiz_pass_percentage-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('quiz_pass_percentage') }}
            </span>
        </div>
    </div>
    <div  style="display:none" id="externalurl">
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('quiz_url', 'Quiz Question URL (Google DOC)', isset($quiz) ? $quiz['quiz_url'] : null, true, ['class' => 'form-control']) !!}
            <span id="quiz_url-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('quiz_url') }}
            </span>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('quiz_description', 'Short Description about the Quiz', isset($quiz) ? $quiz['quiz_description'] : null, true, ['class' => 'form-control']) !!}
            <span id="quiz_description-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('quiz_description') }}
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nLabel('quiz_re_attempt', 'Quiz Re - Attempt Chance possible ?', true) !!}
            <select name="quiz_re_attempt" id="quiz_re_attempt" class="form-control" required>
                @foreach (\App\Services\UtilityService::$approvedStatus as $key => $val)
                    <option value="{{ $val }}" @if (old('quiz_re_attempt', isset($quiz) ? $quiz['quiz_re_attempt'] : null) == $val) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
            <span id="quiz_re_attempt-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('quiz_re_attempt') }}
            </span>
        </div>
        <div class="col-md-6">
            <label for="quiz_status" class="control-label">Quiz Status</label>
            <select name="quiz_status" id="quiz_status" class="form-control" required>
                @foreach (\App\Services\UtilityService::$statusText as $key => $val)
                    <option value="{{ $val }}" @if (old('quiz_status', isset($quiz) ? $quiz['quiz_status'] : null) == $val) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
            <span id="quiz_status-error" class="form-text text-danger help-block" role="alert">
                {{ $errors->first('quiz_status') }}
            </span>
        </div>
        <input type="hidden" name="course_category_id" id="course_category_id">
        <input type="hidden" name="course_sub_category_id" id="course_sub_category_id">
        <input type="hidden" name="course_child_category_id" id="course_child_category_id">
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('quiz_duration', 'Quiz (Start - End)', true) !!}
                {{--@php
                    $start_date = (isset($quiz) && !is_null($quiz->quiz_start))
                    ? $quiz->quiz_start->format('Y-m-d H:i:s')
                    : date('Y-m-d H:i:s');

                    $end_date = (isset($quiz) && !is_null($quiz->quiz_end))
                    ? $quiz->quiz_end->format('Y-m-d H:i:s')
                    : date('Y-m-d H:i:s');

                    $duration = $start_date . ' - ' . $end_date;
                @endphp--}}
                <input id="quiz_duration" type="text" readonly
                       class="form-control event_duration" name="quiz_duration"
                       value="{{ old('quiz_duration', (isset($quiz) ? $quiz['quiz_duration'] : null)) }}"
                       required>
                <span id="quiz_duration-error" class="help-block d-block text-danger">
                    {{ $errors->first('quiz_duration') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('quiz_duration', 'Quiz Time Duration (In minuit)', true) !!}
                <input id="quiz_time_duration" type="number" class="form-control" name="quiz_time_duration" value="30" required pattern="[0-9]+" min="0">
                <span id="quiz_duration-error" class="help-block d-block text-danger">
                    {{ $errors->first('quiz_duration') }}
                </span>
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', null, $selectButton = ['cancelButton', 'storeButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'yes', $othersPram = []) !!}
</div>
@section('scripts')
    <script>
        let selected_company_id = "{{ old('company_id', isset($quiz) ? $quiz->company_id : null) }}";
        //let selected_course_id = "{{ old('course_id', isset($quiz) ? $quiz->course_id : null) }}";
        let get_drip_content = "{{ old('drip_content', isset($quiz) ? $quiz->drip_content : "specific_date") }}";
        let get_visible_date = "{{ old('visible_date', isset($quiz) ? $quiz->visible_date : null) }}";
        let get_visible_days = "{{ old('visible_days', isset($quiz) ? $quiz->visible_days : null) }}";

        //get course list function
        /*function getCourseList() {
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
        }*/

        function hideDripOption() {
            $('#course_wise_drip_type').hide();
            $('#drip_specified_date').hide();
            $('#drip_specified_days').hide();
            $("#drip_content_type").attr('required', false);
            $("#visible_date").attr('required', false);
            $("#visible_days").attr('required', false);
        }

        function showDripOption() {
            $('#course_wise_drip_type').show();
            $("#drip_content_type").val(get_drip_content);
            switchDripContentType();
        }

        function switchDripContentType() {
            if ($("#drip_content_type").val() == "specific_date") {
                $('#drip_specified_date').show();
                $("#visible_date").attr('required', true);
                $('#drip_specified_days').hide();
                $("#visible_days").attr('required', false);
            } else {
                $('#drip_specified_days').show();
                $("#visible_days").attr('required', true);
                $('#drip_specified_date').hide();
                $("#visible_date").attr('required', false);
            }
        }

        /*function isDripEnabled() {
            let id = $('#course_id').val();
            let APP_URL = '{{ url('/') }}';
            $.get(APP_URL + "/backend/driptype/" + id, function(data) {
                data = JSON.parse(data);
                let is_enable = data[0].course_drip_content;
                if (is_enable == 'Enable') {
                    showDripOption();
                } else {
                    hideDripOption();
                }
            });
        }*/

        $(document).ready(function() {

           /* let course_list = null;
            hideDripOption();

            //step handle company dd change get values when form server validation failed
            if (selected_company_id.length > 0) {
                getCourseList();
                $("#course_id").val(selected_course_id);
                setTimeout(function(){
                    $("#course_id").trigger("change");
                },1000);
            }

            //if company dd change from client choice
            $("#company_id").change(function() {
                getCourseList();
                hideDripOption();
            });

            //Now for the course change
            $("#course_id").change(function() {
                //reset drip as course is changed
                hideDripOption();
                //try ajax call
                isDripEnabled();
            });*/

            //when drip type change
            $("#drip_content_type").change(function() {
                switchDripContentType();
            });

            $("#quiz_form").validate({
                rules: {
                    quiz_url: {
                        required: true,
                        url: true
                    },
                    quiz_re_attempt: {
                        required: true
                    },
                    quiz_pass_percentage: {
                        required: true,
                        number: true,
                        max: 100,
                        min: 0
                    },
                    quiz_full_marks: {
                        required: true,
                        digits: true,
                        step: 1,
                    },
                    quiz_topic: {
                        required: true
                    },
                    quiz_type: {
                        required: true
                    },
                    company_id: {
                        required: true
                    },
                    course_id: {
                        required: true
                    },
                    quiz_duration: {
                        required: true
                    }
                }
            });
			
			$("#quiz_type").change(function() {
                 var thisval = this.value;
				 if(thisval=='google-form'){
				 	$("#externalurl").css('display','inline');
				 }
				 else{
				 	$("#externalurl").css('display','none');
				 }
            });
        });
    </script>
@endsection
