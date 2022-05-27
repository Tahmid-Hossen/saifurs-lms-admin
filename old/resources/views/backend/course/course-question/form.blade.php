@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control auto_search view-color">
                    <option value="" @if (isset($course_question) && ($course_question->company_id == "")) selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($course_question->company_id) && ($course_question->company_id == $company->id)) selected @endif
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
                    <option value="" @if (isset($course_question) && ($course_question->course_id === "")) selected @endif>
                        Select Course 
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($course_question->course_id) && ($course_question->course_id === $course->id)) selected @endif
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
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('chapter_id', 'Chapter', false) !!}
                <select name="chapter_id" id="chapter_id" class="form-control auto_search">
                    <option value="" @if (isset($course_question) && ($course_question->chapter_id === "")) selected @endif>
                        Select Chapter 
                    </option>
                    @foreach($course_chapters as $course_chapter)
                        <option value="{{$course_chapter->id}}"
                                @if (isset($course_question->chapter_id) && ($course_question->chapter_id === $course_chapter->id)) selected @endif
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
                    <option value="" @if (isset($course_question) && ($course_question->class_id === "")) selected @endif>
                        Select Class 
                    </option>
                    @foreach($course_classes as $class)
                        <option value="{{$class->id}}"
                                @if (isset($course_question->class_id) && ($course_question->class_id === $class->id)) selected @endif
                        >{{$class->class_name}}</option>
                    @endforeach
                </select>
                <span id="class_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('class_name') }}
                </span>
            </div>
        </div> 
        <div class="col-md-4">
            <div class="form-group">
                <label for="question_image"> Image
                </label>
                <input
                    type="file"
                    class="form-control"
                    name="question_image"
                    id="question_image"
                    value="{{ old('question_image', isset($course_question) ? $course_question->question_image: null) }}"

                >
                @if (isset($course_question->question_image))
                    <img src="{{ asset($course_question->question_image) }}"
                         style=" margin-top: 5px; width:50px; height:auto"/>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('question', 'Question', true)!!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="question"
                    id="question"
                    placeholder="Enter Question"
                    value="{{ old('question', isset($course_question) ? $course_question->question: null) }}"
                    autofocus
                >
                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('question') }}</strong>
                                </span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('question_status', 'Status', false) !!}
                <select name="question_status" id="question_status" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$course_status as $status)
                        <option value="{{$status}}"
                                @if (isset($course_question) && ($course_question->question_status === $status)) selected @endif
                        >{{str_replace("-","",$status)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">
                        {{ $errors->first('question_status') }}
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
        var selected_course_id = '{{old("course_id", (isset($course_question)?$course_question->course_id:null))}}';
        var selected_chapter_id = '{{old("chapter_id", (isset($course_question)?$course_question->chapter_id:null))}}';
        var selected_class_id = '{{old("class_id", (isset($course_question)?$course_question->class_id:null))}}';

        $(document).ready(function () {
            getCourseList();
            $("#company_id").change(function () {
                getCourseList();
            });

            getCourseChapterList();
            $("#course_id").change(function () {
                getCourseChapterList();
            });

            getCourseClassList();
            $("#chapter_id").change(function () {
                getCourseClassList();
            });

            jQuery.validator.addMethod("noSpace", function (value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

            $("#question_form").validate({
                rules: {
                    question: {
                        required: true,
                    },
                    company_id: {
                        required: true,
                    },
                    course_id: {
                        required: true,
                    },
                    question_image: {
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
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

        function getCourseChapterList() {
            var course_id = $('#course_id').val();
            var pickToken = '{{csrf_token()}}';
            if (course_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-chapter-list')}}',
                    data: {
                        course_id: course_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#chapter_id").empty();
                            $("#chapter_id").append('<option value="">Please Select Course Chapter</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_chapter_id == value.id) {
                                    courseChapterSelectedStatus = ' selected ';
                                } else {
                                    courseChapterSelectedStatus = '';
                                }
                                $("#chapter_id").append('<option value="' + value.id + '" ' + courseChapterSelectedStatus + '>' + value.chapter_title + '</option>');
                            });
                        } else {
                            $("#chapter_id").empty();
                            $("#chapter_id").append('<option value="">Please Select Course Chapter</option>');
                        }
                    }
                });
            } else {
                $("#chapter_id").empty();
                $("#chapter_id").append('<option value="">Please Select Course Chapter</option>');
            }
        }

        function getCourseClassList() {
            var chapter_id = $('#chapter_id').val();
            var pickToken = '{{csrf_token()}}';
            if (chapter_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-class-list')}}',
                    data: {
                        chapter_id: chapter_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#class_id").empty();
                            $("#class_id").append('<option value="">Please Select Course Class</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_class_id == value.id) {
                                    courseClassSelectedStatus = ' selected ';
                                } else {
                                    courseClassSelectedStatus = '';
                                }
                                $("#class_id").append('<option value="' + value.id + '" ' + courseClassSelectedStatus + '>' + value.class_name + '</option>');
                            });
                        } else {
                            $("#class_id").empty();
                            $("#class_id").append('<option value="">Please Select Course Class</option>');
                        }
                    }
                });
            } else {
                $("#class_id").empty();
                $("#class_id").append('<option value="">Please Select Course Class</option>');
            }
        }

    </script>
@endpush



