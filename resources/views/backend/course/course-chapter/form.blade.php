@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
{{--        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control view-color">
                    <option value="" @if (old('company_id', isset($course_chapter) ? $course_chapter->company_id : null) == "") selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (old('company_id', isset($course_chapter) ? $course_chapter->company_id : null) == $company->id) selected @endif
                        >{{$company->company_name}}</option>
                    @endforeach
                </select>
                <span id="company_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('company_id') }}
                </span>
            </div>
        </div>--}}
        <input type="hidden" name="company_id" id="company_id" value="{{auth()->user()->userDetails->company_id}}">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control auto_search">
                    {{-- <option value="" @if (isset($course_chapter) && ($course_chapter->course_id === "")) selected @endif>
                        Select Course
                    </option> --}}
                    <option value="" @if (old('course_id', isset($course_chapter) ? $course_chapter->course_id : null) == "") selected @endif>
                        Select Course
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($course_chapter->course_id) && ($course_chapter->course_id === $course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_id') }}
                </span>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('chapter_title', 'Class Title', true)!!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="chapter_title"
                    id="chapter_title"
                    placeholder="Enter Class Title"
                    value="{{ old('chapter_title', isset($course_chapter) ? $course_chapter->chapter_title: null) }}"
                >
                <span class="form-text text-danger" role="alert">
                    <strong>{{ $errors->first('chapter_title') }}</strong>
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('chapter_short_description', 'Short Details', false) !!}
                <textarea id="chapter_short_description" name="chapter_short_description" rows="5"
                          class="form-control editor"
                          placeholder="Enter Course Class Short details">{{ old('chapter_short_description', isset($course_chapter->chapter_short_description) ? $course_chapter->chapter_short_description: null) }}</textarea>
                <span id="chapter_short_description-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('chapter_short_description') }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('chapter_description', 'Description', true) !!}
                <textarea id="chapter_description" name="chapter_description" rows="5"
                          class="form-control details_editor editor"
                          placeholder="Enter Course Class details">{{ old('chapter_description', isset($course_chapter->chapter_description) ? $course_chapter->chapter_description: null) }}</textarea>

                <span id="chapter_description-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('chapter_description') }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
        <div class="form-group">
                {!! \Form::nLabel('chapter_image', 'Image') !!}
                <input
                    type="file"
                    class="form-control"
                    name="chapter_image"
                    id="chapter_image"
                    onchange=" imageIsLoaded(this,'preview_img');"
                    value="{{ old('chapter_image', isset($course_chapter) ? $course_chapter->chapter_image: null) }}"
                >
                @if (isset($course_chapter->chapter_image))
                    <img src="{{ asset($course_chapter->chapter_image) }}" id="preview_img" alt="course-chapter-image"
                         style=" margin-top: 5px; max-width:100px;"/>
                @endif

                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('chapter_image') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('chapter_file', 'Upload File (docx/pdf)', false) !!}
                <input
                    type="file"
                    class="form-control view-color"
                    name="chapter_file"
                    id="chapter_file"
                    placeholder="Enter Course File"
                    value="{{ old('chapter_file', isset($course_chapter) ? $course_chapter->chapter_file : null) }}"
                    autofocus
                >
                @if (isset($course_chapter->chapter_file))
                        {{-- <a href="{{route('course-chapters.download-file',$course_chapter->id)}}"><i class="fa fa-download" aria-hidden="true"></i> Download Existing File </a> --}}
                        {{--<a href="{{url('backend/course-chapters/download-file',$course_chapter->id)}}"><i class="fa fa-download" aria-hidden="true"></i> Download Existing File </a>--}}
                        <a href="{{url('/').$course_chapter->chapter_file}}"><i class="fa fa-download" aria-hidden="true"></i> Download Existing File </a>
                @endif
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('chapter_file') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('chapter_status', 'Status', false) !!}
                <select name="chapter_status" id="chapter_status" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$chapter_status as $status)
                        <option value="{{$status}}"
                                @if (isset($course_chapter) && ($course_chapter->chapter_status === $status)) selected @endif
                        >{{str_replace("-","",$status)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('chapter_status') }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='course-chapters.index',
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
        var selected_course_id = '{{old("course_id", (isset($course_chapter)?$course_chapter->course_id:null))}}';
        var selected_chapter_id = '{{old("chapter_id", (isset($course_chapter)?$course_chapter->chapter_id:null))}}';
        var selected_class_id = '{{old("class_id", (isset($course_chapter)?$course_chapter->class_id:null))}}';
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


        $(document).ready(function () {
            getCourseList();
            $("#company_id").change(function () {
                getCourseList();
            });

            $("#chapter_form").validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    course_id: {
                        required: true
                    },
                    chapter_title: {
                        required: true
                    },
                    chapter_file: {
                        // required: {{ isset($course_chapter)?'false':'true' }},
                        extension: "doc|docx|pdf"
                    },
                    chapter_image: {
                        // required: {{ isset($course_chapter)?'false':'true' }},
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                }
            });
        });

    </script>
@endpush



