@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        {{--<div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control auto_search view-color">
                    <option value="" @if (isset($course_syllabus) && ($course_syllabus->company_id == "")) selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($course_syllabus->company_id) && ($course_syllabus->company_id == $company->id)) selected @endif
                        >{{$company->company_name}}</option>
                    @endforeach
                </select>
                <span id="company_id-error" class="form-text text-danger" role="alert">
                                    {{ $errors->first('company_name') }}
                                </span>
            </div>
        </div>--}}
        <input type="hidden" id="company_id" name="company_id" value="{{auth()->user()->userDetails->company_id}}" />
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control auto_search">
                    <option value="" @if (isset($course_syllabus) && ($course_syllabus->course_id === "")) selected @endif>
                        Select Course
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($course_syllabus->course_id) && ($course_syllabus->course_id === $course->id)) selected @endif
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
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('syllabus_title', 'Syllabus Title', true) !!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="syllabus_title"
                    id="syllabus_title"
                    placeholder="Enter Syllabus Title"
                    value="{{ old('syllabus_title', isset($course_syllabus) ? $course_syllabus->syllabus_title: null) }}"
                    autofocus
                >
                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('syllabus_title') }}</strong>
                                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="syllabus_details"> Notes </label>
                <textarea id="syllabus_details" name="syllabus_details" rows="5"
                          class="form-control details_editor editor view-color"
                          placeholder="Enter Notes">{{ old('syllabus_details', isset($course_syllabus->syllabus_details) ? $course_syllabus->syllabus_details: null) }}</textarea>


                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('syllabus_details') }}</strong>
                                </span>
            </div>
        </div>
    </div>
    <input
        type="hidden"
        class="form-control view-color"
        name="syllabus_file"
        id="syllabus_file"
        placeholder="Upload Syllabus"
        value="{{ old('syllabus_file', isset($course_syllabus) ? $course_syllabus->syllabus_file : null) }}"
    >

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
        var selected_course_id = '{{old("course_id", (isset($course_syllabus)?$course_syllabus->course_id:null))}}';
        // var selected_chapter_id = '{{old("chapter_id", (isset($course_question)?$course_question->chapter_id:null))}}';
        // var selected_class_id = '{{old("class_id", (isset($course_question)?$course_question->class_id:null))}}';

        $(document).ready(function () {
            getCourseList();
            $("#company_id").change(function () {
                getCourseList();
            });

            // getCourseChapterList();
            // $("#course_id").change(function () {
            //     getCourseChapterList();
            // });

            // getCourseClassList();
            // $("#chapter_id").change(function () {
            //     getCourseClassList();
            // });

            jQuery.validator.addMethod("noSpace", function (value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

            $("#syllabus_form").validate({
                rules: {
                    syllabus_title: {
                        required: true,
                        noSpace: false,
                    },
                    company_id: {
                        required: true,
                    },
                    course_id: {
                        required: true,
                    },
                    syllabus_file: {
                        extension: "doc|docx|pdf"
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

        // function getCourseChapterList() {
        //     var course_id = $('#course_id').val();
        //     var pickToken = '{{csrf_token()}}';
        //     if (course_id) {
        //         $.ajax({
        //             type: "POST",
        //             dataType: 'json',
        //             url: '{{route('course.get-course-chapter-list')}}',
        //             data: {
        //                 course_id: course_id,
        //                 '_token': pickToken
        //             },
        //             success: function (res) {
        //                 if (res.status == 200) {
        //                     $("#chapter_id").empty();
        //                     $("#chapter_id").append('<option value="">Please Select Course Chapter</option>');
        //                     $.each(res.data, function (key, value) {
        //                         if (selected_chapter_id == value.id) {
        //                             courseChapterSelectedStatus = ' selected ';
        //                         } else {
        //                             courseChapterSelectedStatus = '';
        //                         }
        //                         $("#chapter_id").append('<option value="' + value.id + '" ' + courseChapterSelectedStatus + '>' + value.chapter_title + '</option>');
        //                     });
        //                 } else {
        //                     $("#chapter_id").empty();
        //                     $("#chapter_id").append('<option value="">Please Select Course Chapter</option>');
        //                 }
        //             }
        //         });
        //     } else {
        //         $("#chapter_id").empty();
        //         $("#chapter_id").append('<option value="">Please Select Course Chapter</option>');
        //     }
        // }

        // function getCourseClassList() {
        //     var chapter_id = $('#chapter_id').val();
        //     var pickToken = '{{csrf_token()}}';
        //     if (chapter_id) {
        //         $.ajax({
        //             type: "POST",
        //             dataType: 'json',
        //             url: '{{route('course.get-course-class-list')}}',
        //             data: {
        //                 chapter_id: chapter_id,
        //                 '_token': pickToken
        //             },
        //             success: function (res) {
        //                 if (res.status == 200) {
        //                     $("#class_id").empty();
        //                     $("#class_id").append('<option value="">Please Select Course Class</option>');
        //                     $.each(res.data, function (key, value) {
        //                         if (selected_class_id == value.id) {
        //                             courseClassSelectedStatus = ' selected ';
        //                         } else {
        //                             courseClassSelectedStatus = '';
        //                         }
        //                         $("#class_id").append('<option value="' + value.id + '" ' + courseClassSelectedStatus + '>' + value.class_name + '</option>');
        //                     });
        //                 } else {
        //                     $("#class_id").empty();
        //                     $("#class_id").append('<option value="">Please Select Course Class</option>');
        //                 }
        //             }
        //         });
        //     } else {
        //         $("#class_id").empty();
        //         $("#class_id").append('<option value="">Please Select Course Class</option>');
        //     }
        // }

    </script>
@endpush



