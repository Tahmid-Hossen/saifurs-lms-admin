@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control auto_search view-color">
                    <option value="" @if (isset($question_answer) && ($question_answer->company_id == "")) selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($question_answer->company_id) && ($question_answer->company_id == $company->id)) selected @endif
                        >{{$company->company_name}}</option>
                    @endforeach
                </select>
                <span id="company_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('company_name') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control auto_search">
                    <option value="" @if (isset($question_answer) && ($question_answer->course_id === "")) selected @endif>
                        Select Course 
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($question_answer->course_id) && ($question_answer->course_id === $course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_title') }}
                </span>
            </div>
        </div>
    </div>
    <!-- end row -->
    <!-- <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('chapter_id', 'Chapter', false) !!}
                <select name="chapter_id" id="chapter_id" class="form-control auto_search">
                    <option value="" @if (isset($question_answer) && ($question_answer->chapter_id === "")) selected @endif>
                        Select Chapter 
                    </option>
                    @foreach($course_chapters as $course_chapter)
                        <option value="{{$course_chapter->id}}"
                                @if (isset($question_answer->chapter_id) && ($question_answer->chapter_id === $course_chapter->id)) selected @endif
                        >{{$course_chapter->chapter_title}}</option>
                    @endforeach
                </select>
                <span id="chapter_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('chapter_title') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('class_id', 'Class', false) !!}
                <select name="class_id" id="class_id" class="form-control auto_search">
                    <option value="" @if (isset($question_answer) && ($question_answer->class_id === "")) selected @endif>
                        Select Class 
                    </option>
                    @foreach($course_classes as $class)
                        <option value="{{$class->id}}"
                                @if (isset($question_answer->class_id) && ($question_answer->class_id === $class->id)) selected @endif
                        >{{$class->class_name}}</option>
                    @endforeach
                </select>
                <span id="class_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('class_name') }}
                </span>
            </div>
        </div> 
        
    </div> -->
    <div class="row">
    <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('question_id', 'Question', true) !!}
                <select name="question_id" id="question_id" class="form-control auto_search">
                    <option value="" @if (isset($question_answer) && ($question_answer->question_id === "")) selected @endif>
                        Select Question 
                    </option>
                    @foreach($questions as $question)
                        <option value="{{$question->id}}"
                                @if (isset($question_answer->question_id) && ($question_answer->question_id === $question->id)) selected @endif
                        >{{$question->question}}</option>
                    @endforeach
                </select>
                <span id="question_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('question') }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('answer', 'Answer', true) !!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="answer"
                    id="answer"
                    placeholder="Enter Answer"
                    value="{{ old('answer', isset($question_answer) ? $question_answer->answer: null) }}"
                    autofocus
                >
                <span class="form-text text-danger" role="alert">
                    <strong>{{ $errors->first('answer') }}</strong>
                </span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('answer_status', 'Status', false) !!}
                <select name="answer_status" id="answer_status" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$answer_status as $status)
                        <option value="{{$status}}"
                                @if (isset($question_answer) && ($question_answer->answer_status === $status)) selected @endif
                        >{{str_replace("-","",$status)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">
                        {{ $errors->first('answer_status') }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='#',
        null,
        $selectButton=['cancelButton','storeButton'],
        $class = ' btn-icon btn-circle ',
        $onlyIcon='yes',
        $othersPram=array()
    )
!!}
</div>


@push('scripts')
    <script>
        var selected_course_id = '{{old("course_id", (isset($question_answer)?$question_answer->course_id:null))}}';
        var selected_question_id = '{{old("question_id", (isset($question_answer)?$question_answer->question_id:null))}}';

        $(document).ready(function () {
            getCourseList();
            $("#company_id").change(function () {
                getCourseList();
            });

            getQuestionList();
            $("#course_id").change(function () {
                getQuestionList();
            });

            jQuery.validator.addMethod("noSpace", function (value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

            $("#answer_form").validate({
                rules: {
                    answer: {
                        required: true,
                    },
                    company_id: {
                        required: true,
                    },
                    course_id: {
                        required: true,
                    },
                    question_id: {
                        required: true,
                    },
                }
            });
        });


        function getCourseList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-list')}}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken,
                        'course_option_is_not': "Offline",
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

        function getQuestionList() {
            var course_id = $('#course_id').val();
            var pickToken = '{{csrf_token()}}';
            if (course_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-question-list')}}',
                    data: {
                        course_id: course_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#question_id").empty();
                            $("#question_id").append('<option value="">Please Select Course Question</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_question_id == value.id) {
                                    courseQuestionSelectedStatus = ' selected ';
                                } else {
                                    courseQuestionSelectedStatus = '';
                                }
                                $("#question_id").append('<option value="' + value.id + '" ' + courseQuestionSelectedStatus + '>' + value.question + '</option>');
                            });
                        } else {
                            $("#question_id").empty();
                            $("#question_id").append('<option value="">Please Select Course Question</option>');
                        }
                    }
                });
            } else {
                $("#question_id").empty();
                $("#question_id").append('<option value="">Please Select Course Question</option>');
            }
        }


    </script>
@endpush



