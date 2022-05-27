@include('backend.layouts.partials.errors')
<link rel="stylesheet" href="{{ asset('ijaboCropTool/ijaboCropTool.min.css') }}">
<div class="box-body">
    <input type="hidden" name="course_batch_name" value="">
    <input type="hidden" name="course_id" value="">
    <input type="hidden" name="instructor_id" value="">
    <input type="hidden" name="course_batch_duration" value="">
    <input type="hidden" name="batch_class_days" value="">
    <input type="hidden" name="company_id" id="company_id" value="{{ auth()->user()->userDetails->company_id }}">

    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('course_title', 'Course Title', true) !!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="course_title"
                    id="course_title"
                    placeholder="Enter Course Title"
                    value="{{ old('course_title', isset($course) ? $course->course_title: null) }}"
                    autofocus
                >
                <span id="course_title-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_title') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_category_id', 'Category', true) !!}
                <select name="course_category_id" id="course_category_id" class="form-control">
                    <option value="" @if (isset($course) && ($course->course_category_id === "")) selected @endif>
                        Select Course Category
                    </option>
                </select>
                <span id="course_category_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_category_title') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_sub_category_id', 'Sub Category', true) !!}
                <select name="course_sub_category_id" id="course_sub_category_id"
                        class="form-control">
                    <option value="" @if (isset($course) && ($course->course_sub_category_id == "")) selected @endif>
                        Select Course Sub Category
                    </option>
                </select>

                <span id="course_sub_category_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_sub_category_title') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_child_category_id', 'Child Category', true) !!}
                <select name="course_child_category_id" id="course_child_category_id"
                        class="form-control courseChildCategory_id">
                    <option value=""
                            @if (isset($course) && ($course->course_child_category_id === "")) selected @endif>
                        Select Course Child Category
                    </option>
                </select>
                <span id="course_child_category_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_child_category_title') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{-- {!! \Form::nText('course_short_description', 'Short Description',
old('course_short_description', ($course->course_short_description) ??  null), true, ['size' => '255', 'maxlength' => 255, 'minlength' => 3]) !!} --}}
{!! \Form::nText('course_short_description', 'Short Description',
old('course_short_description', ($course->course_short_description) ??  null), true) !!}
        {{-- <span id="course_short_description-error" class="form-text text-danger" role="alert">
            {{ $errors->first('course_short_description') }}
        </span> --}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_option', 'Course Option (Online/Offline)', true) !!}
                <select name="course_option" id="course_option" class="form-control view-color"
                        required>
                    <option value="">Select Course Option</option>
                    @foreach(\App\Support\Configs\Constants::$class_types as $c_type)
                        <option value="{{$c_type}}"
                                @if (isset($course) && ($course->course_option === $c_type)) selected @endif
                        >{{ strtoupper($c_type)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">{{ $errors->first('course_option') }}</span>
            </div>
        </div>
        <div id="c_option">
        </div>
        <div class="col-md-4">
            <div class="form-group" id="branch_show">
                {!! \Form::nLabel('branch_id', 'Branch') !!}
                <select name="branch_id[]" id="" class="form-control select2" multiple>
                    <option value="">Select Branch</option>
                       @foreach($branches as $branch)
                        <option value="{{$branch->id}}"
                                @if(isset($course) && !empty($selectedbranches) && count($selectedbranches) > 0)
                                @foreach($selectedbranches as $selectedbranch)
                                @if($selectedbranch->id === $branch->id) selected @endif
                                @endforeach
                                @elseif(!empty(old('branch_id')))
                                @foreach(old('branch_id') as $c_branch)
                                @if($branch->id == $c_branch) selected @endif
                            @endforeach
                            @endif
                        >
                            {{$branch->branch_name}}

                        </option>
                    @endforeach
                    <!--@if (!empty($selectedbranches) && count($selectedbranches) > 0 )
                        @foreach($selectedbranches as $selectedbranch)
                            <option value="{{ $selectedbranch->id }}" selected>{{ $selectedbranch->branch_name }}</option>
                        @endforeach
                    @endif

                    @foreach($branches as $branch)
                        <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                    @endforeach-->
                </select>

                <span id="branch_id-error"
                      class="help-block text-danger"><strong>{{ $errors->first('branch_id') }}</strong>
                </span>
            </div>
            <div class="form-group" id="instructor_show">
                {!! \Form::nLabel('instructor_id', 'Instructor') !!}
                <select name="instructor_id" id="instructor_id" class="form-control">
                    <option value="">
                        Select Instructor
                    </option>
                </select>
                <span id="instructor_id-error"
                      class="help-block text-danger"><strong>{{ $errors->first('instructor_id') }}</strong>
                </span>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_requirements', 'Requirements', true) !!}
                <textarea id="course_requirements" name="course_requirements" rows="5"
                          class="form-control editor"
                          placeholder="Enter Course details">{{ old('course_requirements', isset($course->course_requirements) ? $course->course_requirements: null) }}</textarea>

                <span id="course_requirements-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_requirements') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_description', 'Description', true) !!}
                <textarea id="course_description" name="course_description" rows="5"
                          class="form-control details_editor editor"
                          placeholder="Enter Course details">{{ old('course_description', isset($course->course_description) ? $course->course_description: null) }}</textarea>
                <span id="course_description-error" class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_description') }}
                                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('course_tags', 'Course Tags', false) !!}
                <select name="course_tags[]" id="course_tags" class="form-control tags" multiple>
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}"
                                @if(isset($course))
                                @foreach($course->tags as $c_tag)
                                @if($c_tag->id === $tag->id) selected @endif
                                @endforeach
                                @elseif(!empty(old('course_tags')))
                                @foreach(old('course_tags') as $c_tag)
                                @if($tag->id == $c_tag) selected @endif
                            @endforeach
                            @endif
                        >
                            {{$tag->tag_name}}

                        </option>
                    @endforeach
                </select>
                <span id="course_tags-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_tags') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_duration', 'Course Duration Unit',true) !!}
                <select name="course_duration" id="course_duration" class="form-control view-color" required>
                    <option value="">Select an option</option>
                    @foreach(\App\Support\Configs\Constants::$course_duration as $duration)
                        <option value="{{$duration}}"
                                @if (isset($course) && ($course->course_duration === $duration)) selected @endif
                        >{{$duration}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_duration') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_duration', 'Course Duration Time', true) !!}
                <input
                    type="number"
                    min="1"
                    class="form-control view-color"
                    name="course_duration_expire"
                    id="course_duration_expire"
                    placeholder="Enter Course Expire Duration"
                    value="{{ old('course_duration_expire', isset($course) ? $course->course_duration_expire : null) }}"
                >
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_duration_expire') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('total_class_no', 'Total Class No', true) !!}
                <input
                    type="number"
                    class="form-control"
                    name="total_class_no"
                    id="total_class_no"
                    placeholder="Enter Total Class No"
                    value="{{ old('total_class_no', isset($course) ? $course->total_class_no:null) }}"
                >
                <span class="help-block">{{ $errors->first('total_class_no') }}</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label id="returnmsg">Image (800x450)</label>
                {{-- <input
                     type="file"
                     class="form-control"
                     name="course_image"
                     id="course_image"
                     onchange=" imageIsLoaded(this,'preview_img');"
                     value="{{ old('course_image', isset($course) ? $course->course_image: null) }}"
                 >--}}
                <input type="file" name="cropableimage" id="cropablefile" onchange="imageIsLoaded(this,'preview_img');">
                <input type="text" name="course_image" id="imagename" readonly value="{{ old('course_image', isset($course) ? $course->course_image: null) }}" style="border: none;">

                @if (isset($course->course_image))
                    <img src="{{ asset('/public/'.$imagepath.$course->course_image) }}" id="preview_img" alt="course image"
                         style=" margin-top: 5px; max-width:100px;"/>
                @endif

                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_image') }}
                </span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                {!! \Form::nLabel('course_file', 'Upload File (docx/pdf)', false) !!}
                <input
                    type="file"
                    class="form-control view-color"
                    name="course_file"
                    id="course_file"
                    placeholder="Enter Course File"
                    value="{{ old('course_file', isset($course) ? $course->course_file : null) }}"
                    autofocus
                >
                @if (isset($course->course_file))
                    {{--<a href="{{url('backend/course/download-file',$course->id)}}">--}}
                    <a href="{{url('/').$course->course_file}}" target="_blank">
                        <i class="fa fa-download" aria-hidden="true"></i> Download Existing File
                    </a>
                @endif
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_file') }}
                </span>
            </div>
        </div>
        <div class="col-md-3">
            {{-- <div class="form-group">
                {!! \Form::nLabel('course_video_id', 'Choose Video Option') !!}
                <select name="course_video_id" id="course_video_id" class="form-control view-color">
                    <option value="">Select an option</option>
                    <option value="upload">Video Upload</option>
                    <option value="url" selected>Video URL</option>
                </select>
                <span id="course_video_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_video_id') }}
                </span>
            </div> --}}
            <div class="form-group" id="url_box">
                <label for="course_video_url">Video URL: </label>
                <input type="text"
                       class="form-control"
                       id="course_video_url"
                       name="course_video_url"
                       value="{{ old('course_video_url', isset($course) ? $course->course_video_url : null) }}"
                       placeholder="Enter Course URL: https://www.youtube.com/">
                <span id="course_video_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_video_url') }}
                </span>
            </div>
            <div class="form-group" id="url_file">
                <label for="course_video">Video File: </label>
                <input type="file" class="form-control view-color" id="course_video"
                       name="course_video"
                       value="{{ old('course_video', isset($course) ? $course->course_video : null) }}"
                       placeholder="Upload">
                <span id="course_video-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_video') }}
                </span>
            </div>
        </div>
        <div class="col-md-3">
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
                            @if (isset($course->course_video))
                                <video width="100%" height="500px" controls>
                                    <source src="{{ $course->course_video }}" type="video/mp4">
                                </video>
                            @else
                                <p>NOT AVAILABLE !</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                {!! \Form::nLabel('course_is_assignment', 'Assignment') !!}
                <input type="hidden" value="NO" name="course_is_assignment">
                <input
                    style="margin-left: 10px"
                    class="form-check-input"
                    type="checkbox"
                    name="course_is_assignment"
                    id="course_is_assignment"
                    value="YES"
                    @if (isset($course) && ($course->course_is_assignment == 'YES')) checked @endif
                >

                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_is_assignment') }}
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">

                <label for="course_is_certified"> Certified</label>
                <input type="hidden" value="NO" name="course_is_certified">
                <input
                    style="margin-left: 10px"
                    class="form-check-input"
                    type="checkbox"
                    name="course_is_certified"
                    id="course_is_certified"
                    value="YES"
                    @if (isset($course) && ($course->course_is_certified === 'YES')) checked @endif
                >

                <span class="form-text text-danger" role="alert">{{ $errors->first('course_is_certified') }}</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! \Form::nLabel('course_is_subscribed', 'Subscription', false) !!}
                <input type="hidden" value="NO" name="course_is_subscribed">
                <input
                    style="margin-left: 10px"
                    class="form-check-input"
                    type="checkbox"
                    name="course_is_subscribed"
                    id="course_is_subscribed"
                    value="YES"
                    @if (isset($course) && ($course->course_is_subscribed === 'YES')) checked @endif
                >
                <span class="form-text text-danger" role="alert">{{ $errors->first('course_is_subscribed') }}</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! \Form::nLabel('course_download_able', 'Downloadable') !!}
                <input type="hidden" value="NO" name="course_download_able">
                <input
                    style="margin-left: 10px"
                    class="form-check-input"
                    type="checkbox"
                    name="course_download_able"
                    id="course_download_able"
                    value="YES"
                    @if (isset($course) && ($course->course_download_able === 'YES')) checked @endif
                >
                <span class="form-text text-danger" role="alert">{{ $errors->first('course_download_able') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('course_status', 'Status', false) !!}
                        <select name="course_status" id="course_status" class="form-control view-color">
                            @foreach(\App\Support\Configs\Constants::$course_status as $status)
                                <option value="{{$status}}"
                                        @if (isset($course) && ($course->course_status === $status)) selected @endif
                                >{{str_replace("-","",$status)}}</option>
                            @endforeach
                        </select>
                        <span class="form-text text-danger" role="alert">{{ $errors->first('course_status') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('course_featured', 'Featured', false) !!}
                        <select name="course_featured" id="course_featured" class="form-control view-color">
                            @foreach(\App\Support\Configs\Constants::$course_featured as $featured)
                                <option value="{{$featured}}"
                                        @if (isset($course) && ($course->course_featured === $featured)) selected @endif
                                >{{$featured}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('course_featured') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! \Form::nLabel('course_language', 'Language', false) !!}
                        <select name="course_language" id="course_language" class="form-control view-color">
                            <option value="">Select Course Language</option>
                            @foreach(\App\Support\Configs\Constants::$course_language as $language)
                                <option value="{{$language}}"
                                        @if (isset($course) && ($course->course_language === $language)) selected @endif
                                >{{$language}}</option>
                            @endforeach
                        </select>

                        <span class="help-block">{{ $errors->first('course_language') }}</span>
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('course_drip_content', 'Drip Content', false) !!}
                        <select name="course_drip_content" id="course_drip_content" class="form-control view-color">
                            <option value="">Select Drip Content</option>
                            @foreach(\App\Support\Configs\Constants::$course_drip_content as $drip_content)
                                <option value="{{$drip_content}}"
                                        @if (isset($course) && ($course->course_drip_content === $drip_content)) selected @endif
                                >{{$drip_content}}</option>
                            @endforeach
                        </select>

                        <span class="form-text text-danger" role="alert">{{ $errors->first('course_drip_content') }}</span>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_content_type', 'Course Type', true) !!}
                <select name="course_content_type" id="course_content_type" class="form-control view-color"
                        required>
                    <option value="">Select Course Type</option>
                    @foreach(\App\Support\Configs\Constants::$course_types as $type)
                        <option value="{{$type}}"
                                @if (isset($course) && ($course->course_content_type === $type)) selected @endif
                        >{{ strtoupper($type)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">{{ $errors->first('course_content_type') }}</span>
            </div>
            <div id="content_type">
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

    <script src="{{ asset('ijaboCropTool/ijaboCropTool.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#cropablefile').ijaboCropTool({
                preview : '.image-previewer',
                setRatio: -1.1,
                allowedExtensions: ['jpg', 'jpeg','png'],
                buttonsText:['CROP','QUIT'],
                buttonsColor:['#30bf7d','#ee5155', -15],
                processUrl:'{{ route("crop") }}',
                withCSRF:['_token','{{ csrf_token() }}'],
                onSuccess:function(message, imagename, status){
                    //console.dir(imagename);
                    alert(message);
                    $("#imagename").css('display','inline');
                    $("#imagename").val(imagename);
                    $("#returnmsg").html("Image Selected");
                },
                onError:function(message, element, status){
                    alert(message);
                }
            });
        });

    </script>
    <script>
        var selected_company_id = '{{auth()->user()->userDetails->company_id}}';
        var selected_branch_id = '{{old("branch_id", (isset($course)?$course->branch_id:null))}}';
        var selected_course_category_id = '{{old("course_category_id", (isset($course)?$course->course_category_id:null))}}';
        var selected_course_sub_category_id = '{{old("course_sub_category_id", (isset($course)?$course->course_sub_category_id:null))}}';
        var selected_course_child_category_id = '{{old("course_child_category_id", (isset($course)?$course->course_child_category_id:null))}}';
        var selected_instructor_id = '{{old("instructor_id", (isset($course->batches) && isset($course->batches[0]->instructor_id)?$course->batches[0]->instructor_id:''))}}';

        function getCourseList() {
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-list')}}',
                    data: {
                        company_id: company_id,
                        branch_id: branch_id,
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

        function getTeacherList() {
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('teachers.get-teacher-list')}}',
                    data: {
                        company_id: company_id,
                        branch_id: branch_id,
                        course_id: course_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#instructor_id").empty();
                            $("#instructor_id").append('<option value="">Please Select Instructor</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_instructor_id == value.user_id) {
                                    instructorSelectedStatus = ' selected ';
                                } else {
                                    instructorSelectedStatus = '';
                                }
                                $("#instructor_id").append('<option value="' + value.user_id + '" ' + instructorSelectedStatus + '>' + value.first_name + ' ' + value.last_name + ' (' + value.mobile_phone + ')' + '</option>');
                            });
                        } else {
                            $("#instructor_id").empty();
                            $("#instructor_id").append('<option value="">Please Select Instructor</option>');
                        }
                    }
                });
            } else {
                $("#instructor_id").empty();
                $("#instructor_id").append('<option value="">Please Select Instructor</option>');
            }
        }

        function getBranchList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('branches.get-branch-list')}}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#branch_id").empty();
                            $("#branch_id").append('<option value="">Please Select Branch</option>');
                            $.each(res.data, function (key, value) {

                                if (selected_branch_id == value.id) {
                                    branchSelectedStatus = ' selected ';
                                } else {
                                    branchSelectedStatus = '';
                                }
                                $("#branch_id").append('<option value="' + value.id + '" ' + branchSelectedStatus + '>' + value.branch_name + '</option>');
                            });
                        } else {
                            $("#branch_id").empty();
                            $("#branch_id").append('<option value="">Please Select Branch</option>');
                        }
                    }
                });
            } else {
                $("#branch_id").empty();
                $("#branch_id").append('<option value="">Please Select Branch</option>');
            }
        }

        $(document).ready(function () {
            @if(isset($course))
            getBranchDropdown($("#company_id"), $("#branch_id"), selected_branch_id);
            getCourseCategoryDropdown($("#company_id"), $("#course_category_id"), selected_course_category_id);
            $("#course_category_id").val(selected_course_category_id);
            setTimeout(function () {
                getSubCategoryDropdown($("#course_category_id"), $("#course_sub_category_id"), selected_course_sub_category_id);
                setTimeout(function () {
                    getChildCategoryDropdown($("#course_sub_category_id"), $("#course_child_category_id"), selected_course_child_category_id);
                }, 2000);
            }, 1000);
            @endif

                if($("#company_id").val().length > 0) {
                getBranchDropdown($("#company_id"), $("#branch_id"), selected_company_id);
                getCourseCategoryDropdown($("#company_id"), $("#course_category_id"), null);
            }

            $("#company_id").change(function () {
                getBranchDropdown($("#company_id"), $("#branch_id"), null);
                getCourseCategoryDropdown($(this), $("#course_category_id"), null);
            });

            $("#course_category_id").change(function () {
                getSubCategoryDropdown($(this), $("#course_sub_category_id"), null);
            });

            $("#course_sub_category_id").change(function () {
                getChildCategoryDropdown($(this), $("#course_child_category_id"), null);
            });

            $("#course_form").validate({
                rules: {
                    course_option: {
                        required: true,
                    },
                    branch_id: {
                        required: {{ isset($course) ? 'false' : 'true' }},
                    },
                    course_title: {
                        required: true,
                    },
                    company_id: {
                        required: true,
                    },
                    course_category_id: {
                        required: true,
                    },
                    course_sub_category_id: {
                        required: true,
                    },
                    course_child_category_id: {
                        required: true,
                    },
                    course_duration: {
                        required: true,
                    },
                    total_class_no: {
                        digits: true,
                        step: 1,
                        required: true,

                    },
                    course_duration_expire: {
                        digits: true,
                        step: 1,
                        required: true,
                    },
                   /* course_image: {
                        extension: "jpg|jpeg|png|webp|svg|bmp"
                    },*/
                    course_file: {
                        extension: "doc|docx|pdf"
                    },
                    course_video: {
                        extension: "mp4|mov|ogg|avi",
                        videofilesize: 786432000

                    },
                    course_position: {
                        digits: true,
                        minlength: 0,
                        maxlength: 12
                    },
                    course_regular_price: {
                        min: 1,
                        number: true,
                        required: true
                    },
                    course_discount: {
                        min: 1,
                        number: true,
                        required: false,
                        max: function (element) {
                            return parseFloat($('#course_regular_price').val()) - 1;
                        }
                    },
                    ignore: ":hidden:not(textarea)",
                    course_short_description: {
                        maxlength: 255,
                        minlength: 3,
                        required: true
                    },
                    course_video_url: {
                        url: true,
                    }
                },
                messages: {
                    course_discount: {
                        max: "Course discount price cannot be equal or greater then regular price"
                    },
                    course_short_description: {
                        max: "Course short description maximum 255 character"
                    }
                }
            });

            // $("#course_video_id").change(function () {
            //     if ($("#course_video_id").val() == "upload") {
            //         $("#url_file").show();
            //         $("#url_box").hide();
            //     } else {
            //         $("#url_file").hide();
            //         $("#url_box").show();
            //     }
            // });

            $("#course_content_type").change(function () {
                var val = $("#course_content_type").val();
                $("#content_type").html('');
                if (val == "paid") {
                    $("#content_type").append('' +
                        '<div class="row">' +
                        '<div class="col-md-6">' +
                        '<div class="form-group">' +
                        '{{ \Form::nLabel('course_regular_price', 'Regular Price', true) }}' +
                        '<input type="text" ' +
                        'onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"' +
                        'class="form-control float_number" id="course_regular_price" name="course_regular_price"' +
                        'value="{{ old('course_regular_price', isset($course) ? $course->course_regular_price : null) }}"' +
                        'placeholder="Regular Price">' +
                        '<span class="form-text text-danger" role="alert" id="course_regular_price-error">' +
                        '{{ $errors->first('course_content_type') }}' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<div class="form-group">' +
                        '{{ \Form::nLabel('course_discount', 'Discount Price', false) }}' +
                        '<input type="text" ' +
                        'onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"' +
                        'class="form-control float_number" id="course_discount" name="course_discount"' +
                        'value="{{ old('course_discount', isset($course) ? $course->course_discount : null) }}"' +
                        'placeholder="Discount Price">' +
                        '<span class="form-text text-danger" role="alert" id="course_discount-error">' +
                        '{{ $errors->first('course_content_type') }}' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '');
                }
            });

            $(document).ready(function() {
                var val = $("#course_content_type").val();
                // alert(val);
                if(val == "paid") {
                    $("#course_content_type").val("paid").trigger("change");
                }
            });


            $(document).ready(function() {
                var val = $("#course_option").val();
                $("#c_option").html('');
                if (val == "Online") {
                    /*$("#c_option").append('' +
                        '<div class="col-md-4">' +
                        '<div class="form-group">' +
                        '{{ \Form::nLabel('course_type', 'Option', true) }}' +
                        '<select name="course_type" id="course_type" class="form-control" onchange="showInstructor(this);" required>' +
                        '<option value="">Select an Option</option>' +
                        '@foreach (\App\Support\Configs\Constants::$course_options as $option)' +
                        '<option value="{{$option}}" @if (isset($course) && ($course->course_type === $option)) selected @endif>' +
                        '{{strtoupper($option)}}' +
                        '</option>' +
                        '@endforeach' +
                        '</select>' +
                        '<span class="form-text text-danger" role="alert" id="course_type-error">' +
                        '{{ $errors->first('course_option') }}' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '');*/
						$("#c_option").append('' +
                        '<div class="col-md-4">' +
                        '{{ \Form::nLabel('course_type', 'Option', true) }}' +
						'<div class="row">'+
                        '@foreach (\App\Support\Configs\Constants::$course_options as $option)' +
                        '<div class="col-sm-6">' +
						'<input type="checkbox" value="{{$option}}" @if (isset($course) && ($course->course_type === $option)) checked @endif name="course_type[]" id="course_type"  onchange="showInstructor(this);" style="width:15px; height:15px; margin:10px; ">' +
                        '{{strtoupper($option)}}' +
						'</div>' +
                        '@endforeach' +
						'</div>' +
                        '<span class="form-text text-danger" role="alert" id="course_type-error">' +
                        '{{ $errors->first('course_option') }}' +
                        '</span>' +

                        '</div>' +
                        '');
                        var c_option = $("#course_type").val();

                        if(c_option == "Recorded"){
                            $("#instructor_show").show();
                        }

                    $("#branch_show").hide();
                } else if (val == "Offline") {
                    $("#branch_show").show();
                    $("#instructor_show").hide();
                } else {
                    $("#branch_show").hide();
                    $("#instructor_show").hide();
                }
            });

            $("#course_option").change(function () {
                var val = $("#course_option").val();
                $("#c_option").html('');
                if (val == "Online") {
                    /*$("#c_option").append('' +
                        '<div class="col-md-4">' +
                        '<div class="form-group" id="file_type">' +
                        '{{ \Form::nLabel('course_type', 'Option', true) }}' +
                        '<select name="course_type" id="course_type" class="form-control" onchange="showInstructor(this);" required>' +
                        '<option value="">Select an Option</option>' +
                        '@foreach (\App\Support\Configs\Constants::$course_options as $option)' +
                        '<option value="{{$option}}" @if (isset($course) && ($course->course_type === $option)) selected @endif>' +
                        '{{strtoupper($option)}}' +
                        '</option>' +
                        '@endforeach' +
                        '</select>' +
                        '<span class="form-text text-danger" role="alert" id="course_type-error">' +
                        '{{ $errors->first('course_option') }}' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '');*/

						$("#c_option").append('' +
                        '<div class="col-md-4">' +
                        '{{ \Form::nLabel('course_type', 'Option', true) }}' +
						'<div class="row">'+
                        '@foreach (\App\Support\Configs\Constants::$course_options as $k=>$option)' +
                        '<div class="col-sm-6">' +
						'<input type="checkbox" value="{{$option}}" @if (isset($course) && ($course->course_type === $option)) checked @endif name="course_type[]" id="course_type{{ $k }}"  onchange="showInstructor(this,{{ $k }});" style="width:15px; height:15px; margin:10px; ">' +
                        '{{strtoupper($option)}}' +
						'</div>' +
                        '@endforeach' +
						'</div>' +
                        '<span class="form-text text-danger" role="alert" id="course_type-error">' +
                        '{{ $errors->first('course_option') }}' +
                        '</span>' +

                        '</div>' +
                        '');

                        $("#branch_show").hide();
                } else if (val == "Offline") {
                    $("#instructor_show").hide();
                    $("#branch_show").show();
                    $("#url_file").hide();
                    $("#url_box").hide();
                } else {
                    $("#branch_show").hide();
                }
            });

            $("#branch_show").hide();

            $("#instructor_show").hide();

            $("#url_file").hide();
            // $("#course_content_type").val("paid").trigger("change");

            //select instruct by company id
            getTeacherList();
            $("#company_id").change(function () {
                getBranchList();
                getTeacherList();
            });

            $("#branch_id").change(function () {
                getCourseList();
                getTeacherList();
            });

        });

        // Course Option
        function showInstructor(element,si) {
		   var array = []
			$("input:checkbox[name='course_type[]']:checked").each(function(){
				array.push($(this).val());
			});

			var val = array.toString();
			if (val == "Recorded" || val == "Live,Recorded" || val == "Recorded,Live") {
				$("#instructor_show").show();
				// $("#instructor_id").attr('required', 'required');
				$("#url_file").show();
				$("#url_box").hide();
			} else {
				$("#instructor_show").hide();
				// $("#instructor_id").attr('required', '');
				$("#url_file").hide();
				$("#url_box").show();
			}

        }
    </script>
@endpush



