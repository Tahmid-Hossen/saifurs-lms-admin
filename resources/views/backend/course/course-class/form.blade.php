@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
{{--        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control auto_search view-color">
                    <option value="" @if (old('company_id', isset($course_class) ? $course_class->company_id: null) == "") selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                            @if (old('company_id', isset($course_class) ? $course_class->company_id : null) == $company->id) selected @endif
                    >{{$company->company_name}}</option>
                    @endforeach
                </select>
                <span id="company_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('company_name') }}
                </span>
            </div>
        </div>--}}
        <input type="hidden" id="company_id" name="company_id" value="{{auth()->user()->userDetails->company_id}}">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control auto_search">
                    <option value="" @if (old('course_id', isset($course_class) ? $course_class->course_id: null) == "") selected @endif>
                        Select Course
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                            @if (old('course_id', isset($course_class) ? $course_class->course_id : null) == $course->id) selected @endif
                    >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_title') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('chapter_id', 'Class', true) !!}
                <select name="chapter_id" id="chapter_id" class="form-control auto_search required">
                    <option value="" @if (old('chapter_id', isset($course_class) ? $course_class->chapter_id: null) == "") selected @endif>
                        Select Chapter
                    </option>
                    @foreach($course_chapters as $course_chapter)
                        <option value="{{$course_chapter->id}}"
                            @if (old('chapter_id', isset($course_class) ? $course_class->chapter_id : null) == $course_chapter->id) selected @endif
                    >{{$course_chapter->chapter_title}}</option>
                    @endforeach
                </select>
                <span id="chapter_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('chapter_title') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
                {!! \Form::nLabel('class_name', 'Lesson Name', true) !!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="class_name"
                    id="class_name"
                    placeholder="Enter Lesson Name"
                    value="{{ old('class_name', isset($course_class) ? $course_class->class_name: null) }}"
                    autofocus
                >
                <span id="class_name-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('class_name') }}
                </span>
            </div>
        </div>
    </div> <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('class_short_description', 'Short Details', false) !!}
                <textarea id="class_short_description" name="class_short_description" rows="5"
                          class="form-control editor"
                          placeholder="Enter Lesson Short details">{{ old('class_short_description', isset($course_class->class_short_description) ? $course_class->class_short_description: null) }}</textarea>
                <span id="class_short_description-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('class_short_description') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('class_description', 'Description', false) !!}
                <textarea id="class_description" name="class_description" rows="5"
                          class="form-control details_editor editor"
                          placeholder="Enter Lesson Description">{{ old('class_description', isset($course_class->class_description) ? $course_class->class_description: null) }}</textarea>

                <span id="class_description-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('class_description') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('class_image', 'Image') !!}
                <input
                    type="file"
                    class="form-control"
                    name="class_image"
                    id="class_image"
                    value="{{ old('class_image', isset($course_class) ? $course_class->class_image: null) }}"
                >
                @if (isset($course_class->class_image))
                    <img src="{{ asset($course_class->class_image) }}" id="preview_img" alt="course-class-image"
                         style=" margin-top: 5px; max-width:100px;"/>
                @endif

                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('class_image') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('class_file', 'Upload File (docx/pdf)', false) !!}
                <input
                    type="file"
                    class="form-control view-color"
                    name="class_file"
                    id="class_file"
                    placeholder="Enter Course Lesson File"
                    value="{{ old('class_file', isset($course_class) ? $course_class->class_file : null) }}"
                    autofocus
                >
                @if (isset($course_class->class_file))
                        {{--<a href="{{url('backend/course-classes/download-file',$course_class->id)}}"><i class="fa fa-download" aria-hidden="true"></i> Download Existing File </a>--}}
                    <a href="{{url('/').$course_class->class_file}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Download Existing File </a>
                @endif
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('class_file') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('class_video_id', 'Choose Video Option') !!}
                <select name="class_video_id" id="class_video_id" class="form-control view-color">
                    <option value="">Select an option</option>
                    <option value="upload">Video Upload</option>
                    <option value="url" selected>Video URL</option>
                </select>
                <span id="class_video_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('class_video_id') }}
                </span>
            </div>
            <div class="form-group" id="url_box">
                <label for="class_video_url">Video URL: </label>
                <input type="text"
                       class="form-control"
                       id="class_video_url"
                       name="class_video_url"
                       value="{{ old('class_video_url', isset($course_class) ? $course_class->class_video_url : null) }}"
                       placeholder="Enter Lesson URL: https://www.youtube.com/">
                <span id="class_video_url-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('class_video_url') }}
                </span>
            </div>
            <div class="form-group" id="url_file">
                <label for="class_video">Video File: </label>
                <input type="file" class="form-control view-color" id="class_video"
                       name="class_video"
                       value="{{ old('class_video', isset($course_class) ? $course_class->class_video : null) }}"
                       placeholder="Upload">
                <span id="class_video-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('class_video') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('class_status', 'Status', false) !!}
                <select name="class_status" id="class_status" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$class_status as $status)
                        <option value="{{$status}}"
                            @if (isset($course_class) && ($course_class->class_status === $status)) selected @endif
                        >{{str_replace("-","",$status)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('class_status') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('class_featured', 'Featured', false) !!}
                <select name="class_featured" id="class_featured" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$class_featured as $featured)
                        <option value="{{$featured}}"
                            @if (isset($course_class) && ($course_class->class_featured === $featured)) selected @endif
                        >{{$featured}}</option>
                    @endforeach
                </select>
                <span class="help-block">
                    {{ $errors->first('class_featured') }}
                </span>
            </div>
        </div>
        <!-- <div class="col-md-8">
            <div class="form-group" id="video_file" style="padding-top: 25px"></div>
        </div> -->
        <!-- Modal for Video-->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (isset($course_class->class_video))
                            <video width="100%" height="500px" controls>
                                <source src="{{ $course_class->class_video }}" type="video/mp4">
                            </video>
                        @else
                            <p>NOT AVAILABLE !</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('class_type', 'Lesson Type', false) !!}
                <select name="class_type" id="class_type" class="form-control view-color">
                    <option value="">Select Lesson Type</option>
                    @foreach(\App\Support\Configs\Constants::$class_types as $type)
                        <option value="{{$type}}"
                            @if (isset($course_class) && ($course_class->class_type === $type)) selected @endif
                        >{{strtoupper($type)}}</option>
                    @endforeach
                </select>

                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('class_type') }}
                </span>
            </div>
        </div> --}}
        {{-- <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('class_status', 'Status', false) !!}
                <select name="class_status" id="class_status" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$class_status as $status)
                        <option value="{{$status}}"
                            @if (isset($course_class) && ($course_class->class_status === $status)) selected @endif
                        >{{str_replace("-","",$status)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('class_status') }}
                </span>
            </div>
        </div> --}}
        {{-- <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('class_featured', 'Featured', false) !!}
                <select name="class_featured" id="class_featured" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$class_featured as $featured)
                        <option value="{{$featured}}"
                            @if (isset($course_class) && ($course_class->class_featured === $featured)) selected @endif
                        >{{$featured}}</option>
                    @endforeach
                </select>
                <span class="help-block">
                    {{ $errors->first('class_featured') }}
                </span>
            </div>
        </div> --}}
    </div>
{{--
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('class_drip_content', 'Drip Content', false) !!}
                <select name="class_drip_content" id="class_drip_content" class="form-control view-color">
                    <option value="">Select Drip Content</option>
                    @foreach(\App\Support\Configs\Constants::$course_class_drip_content as $drip_content)
                        <option value="{{$drip_content}}"
                            @if (isset($course_class) && ($course_class->class_drip_content === $drip_content)) selected @endif
                        >{{$drip_content}}</option>
                    @endforeach
                </select>

                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('class_drip_content') }}
                </span>
            </div>
        </div>
    </div>
--}}
</div>


<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='course-classes.index',
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
        var selected_company_id = '{{old("company_id", (isset($course_class)?$course_class->company_id:null))}}';
        var selected_course_id = '{{old("course_id", (isset($course_class)?$course_class->course_id:null))}}';
        var selected_chapter_id = '{{old("chapter_id", (isset($course_class)?$course_class->chapter_id:null))}}';


        $(document).ready(function () {

            getCourseList();
            $("#company_id").change(function () {
                getCourseList();
            });

            getCourseChapterList();
            $("#course_id").change(function () {
                getCourseChapterList();
            });

            $("#class_form").validate({
                rules: {
                    class_name: {
                        required: true,
                        // noSpace: false,
                        // alphanumeric: true
                    },
                    company_id: {
                        required: true,
                    },
                    course_id: {
                        required: true,
                    },
                    chapter_id: {
                        required: true,
                    },
                    class_image: {
                        // required: true,
                        extension: "jpg|jpeg|png|ico|bmp"
                    },
                    class_file: {
                        // required: true,
                        extension: "doc|docx|pdf"
                    },
                    class_video : {
                        extension: "mp4|mov|ogg|avi",
                        //videofilesize: 7864320
						videofilesize: 10485760
                    },
                    class_video_url : {
                        url: true,
                    }
                }
            });

            $("#class_video_id").change(function () {
                if ($("#class_video_id").val() == "upload") {
                    $("#url_file").show();
                    $("#url_box").hide();
                } else {
                    $("#url_file").hide();
                    $("#url_box").show();
                }
            });

            $("#url_file").hide();

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
                        // 'course_option_is_not': "Offline",
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
    </script>
@endpush
