@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control auto_search view-color">
                    <option value="" @if (isset($order) && ($order->company_id == "")) selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($order->company_id) && ($order->company_id == $company->id)) selected @endif
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
                    <option value="" @if (isset($order) && ($order->course_id === "")) selected @endif>
                        Select Course 
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($order->course_id) && ($order->course_id === $course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_title') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('user_id', 'Student/User', true) !!}
                <select name="user_id" id="user_id" name="user_id" class="form-control" required>
                    <option value="" @if (isset($order) && ($order->user_id === "")) selected @endif>
                        Select an Option
                    </option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}"
                                @if (isset($order->user_id) && ($order->user_id === $user->id)) selected @endif
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
    <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_short_description', 'Short Details', true) !!}
                <textarea id="course_short_description" name="course_short_description" rows="5"
                          class="form-control editor"
                          placeholder="Enter Course details">{{ old('course_short_description', isset($course->course_short_description) ? $course->course_short_description: null) }}</textarea>
                <span id="course_short_description-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_short_description') }}
                </span>
            </div>
        </div>
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
    </div>
    <div class="row">
        <div class="col-md-12">
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
                {!! \Form::nLabel('course_duration', 'Duration Unit') !!}
                <select name="course_duration" id="course_duration" class="form-control view-color">
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
            <div class="form-group">
                {!! \Form::nLabel('course_duration', 'Duration Time') !!}
                <input
                    type="number"
                    min="1"
                    id="number"
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
                {!! \Form::nLabel('course_image', 'Image') !!}
                <input
                    type="file"
                    class="form-control"
                    name="course_image"
                    id="course_image"
                    onchange=" imageIsLoaded(this,'preview_img');"
                    value="{{ old('course_image', isset($course) ? $course->course_image: null) }}"
                >
                @if (isset($course->course_image))
                    <img src="{{ asset($course->course_image) }}" id="preview_img" alt="course image"
                         style=" margin-top: 5px; max-width:100px;"/>
                @endif

                <span class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_image') }}
                                </span>
            </div>
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
                        <a href="{{url('backend/course/download-file',$course->id)}}"><i class="fa fa-download" aria-hidden="true"></i> Download Existing File </a>
                @endif
                <span class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_file') }}
                                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_video_id', 'Choose Video Option') !!}
                <select name="course_video_id" id="course_video_id" class="form-control view-color">
                    <option value="">Select an option</option>
                    <option value="upload">Video Upload</option>
                    <option value="url" selected>Video URL</option>
                </select>
                <span id="course_video_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_video_id') }}
                </span>
            </div>
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
    </div>
    <div class="row">
        <div class="col-md-12">
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

                <span class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_is_certified') }}
                </span>
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
                <span class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_is_subscribed') }}
                                </span>
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
                <span class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_download_able') }}
                                </span>
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
                        <span class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_status') }}
                                </span>
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
                        <span class="help-block">
                                    {{ $errors->first('course_featured') }}
                                </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
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

                        <span class="help-block">
                    {{ $errors->first('course_language') }}
                </span>
                    </div>
                </div>
                <div class="col-md-6">
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

                        <span class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_drip_content') }}
                                </span>
                    </div>
                </div>
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
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_content_type') }}
                </span>
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
    <script>
        var selected_company_id = '{{old("company_id", (isset($course)?$course->company_id:null))}}';
        var selected_course_category_id = '{{old("course_category_id", (isset($course)?$course->course_category_id:null))}}';
        var selected_course_sub_category_id = '{{old("course_sub_category_id", (isset($course)?$course->course_sub_category_id:null))}}';
        var selected_course_child_category_id = '{{old("course_child_category_id", (isset($course)?$course->course_child_category_id:null))}}';

        $(document).ready(function () {
            getCourseCategoryDropdown($("#company_id"), $("#course_category_id"), selected_course_category_id);
            $("#course_category_id").val(selected_course_category_id);
            setTimeout(function () {
                getSubCategoryDropdown($("#course_category_id"), $("#course_sub_category_id"), selected_course_sub_category_id);
                setTimeout(function () {
                    getChildCategoryDropdown($("#course_sub_category_id"), $("#course_child_category_id"), selected_course_child_category_id);
                }, 2000);
            }, 1000);


            $("#company_id").change(function () {
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
                    course_duration_expire: {
                        digits: true,
                        step: 1
                    },
                    course_image: {
                        extension: "jpg|jpeg|png|webp|svg|bmp"
                    },
                    course_file: {
                        extension: "doc|docx|pdf"
                    },
                    course_video: {
                        extension: "mp4|mov|ogg|avi",
                        maxfilesize: 10485760

                    },
                    course_position: {
                        digits: true,
                        minlength: 0,
                        maxlength: 12
                    }
                }
            });

            $("#course_video_id").change(function () {
                if ($("#course_video_id").val() == "upload") {
                    $("#url_file").show();
                    $("#url_box").hide();
                } else {
                    $("#url_file").hide();
                    $("#url_box").show();
                }
            });

            $("#course_content_type").change(function () {
                var val = $("#course_content_type").val();
                $("#content_type").html('');
                if (val == "paid") {
                    $("#content_type")
                        .append(`<div class="row">
                                          <div class="col-md-6">
                                                        <div class="form-group">
                                                        {{ \Form::nLabel('course_regular_price', 'Regular Price', true) }}
                        <input type="text" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                        class="form-control float_number" id="course_regular_price" name="course_regular_price"
                        value="{{ old('course_regular_price', isset($course) ? $course->course_regular_price : null) }}"
                                                                      placeholder="Regular Price">
                                                        </div>
                                          </div>
                                          <div class="col-md-6">
                                                        <div class="form-group">
                                                        {{ \Form::nLabel('course_discount', 'Discount Price', true) }}
                        <input type="text" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;"
                         class="form-control float_number" id="course_discount" name="course_discount"
                         value="{{ old('course_discount', isset($course) ? $course->course_discount : null) }}"
                                                                       placeholder="Discount Price">
                                                        </div>
                                          </div>
                                          </div>`);
                }
            });

            $("#url_file").hide();
            $("#course_content_type").val("paid").trigger("change");

        });
    </script>
@endpush



