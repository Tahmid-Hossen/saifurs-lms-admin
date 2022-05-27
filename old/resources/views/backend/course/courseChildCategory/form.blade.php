@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        @if(auth()->user()->userDetails->company_id == 1)
            <div class="col-md-12">
                {!! \Form::nSelect('company_id', 'Select Company', $global_companies, isset($course_child_category) ? $course_child_category->company_id: null, true,
    [ 'class' => 'form-control select2']) !!}
            </div>
        @else
            <input type="hidden" name="company_id" id="company_id"
                   value="{{auth()->user()->userDetails->company_id}}">
        @endif
        {{-- @if(auth()->user()->userDetails->company_id == 1)
            <div class="col-md-6">
                {!! \Form::nSelect('branch_id', 'Select Branch', [], null, false,
                ['placeholder' => 'Select Company First', 'class' => 'form-control select2']) !!}
            </div>
        @else
            <input type="hidden" name="branch_id" id="branch_id"
                   value="{{auth()->user()->userDetails->branch_id}}">
        @endif --}}
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_category_id', 'Course Category', isset($course_child_category) ? $course_child_category->course_category_id: null, true) !!}
                <select name="course_category_id" id="course_category_id" class="form-control select2">

                    {{--@foreach($course_categories as $course_category)
                        <option value="{{$course_category->id}}"
                                @if (isset($course_child_category->course_category_id) && ($course_child_category->course_category_id === $course_category->id)) selected @endif
                        >{{$course_category->course_category_title}}</option>
                    @endforeach--}}
                </select>
                <span id="course_category_id-error" class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('course_category_id') }}</strong>
                                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_sub_category_id', 'Sub Category', isset($course_child_category) ? $course_child_category->course_sub_category_id: null, true) !!}
                <select name="course_sub_category_id" id="course_sub_category_id"
                        class="form-control select2">
                    {{--@foreach($course_sub_categories as $course_sub_category)
                        <option value="{{$course_sub_category->id}}"
                                @if (isset($course_sub_category->course_sub_category_id)
&& ($course_child_category->course_sub_category_id === $course_sub_category->id)) selected @endif
                        >{{$course_sub_category->course_sub_category_title}}</option>
                    @endforeach--}}
                </select>
                <span id="course_sub_category_id-error" class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('course_sub_category_id') }}</strong>
                                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('course_child_category_title', 'Title', old('course_child_category_title', isset($course_child_category)
? $course_child_category->course_child_category_title: null), true, ['placeholder' => 'Enter Course Child Category Title']) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('course_child_category_details', 'Description', true) !!}
                <textarea id="course_child_category_details" name="course_child_category_details" rows="5"
                          class="form-control editor"
                          placeholder="Enter Course Category details">{{ old('course_child_category_details', isset($course_child_category->course_child_category_details) ? $course_child_category->course_child_category_details: null) }}</textarea>

                <span id="course_child_category_details-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_child_category_details') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_child_category_featured', 'Featured', true) !!}
                <select name="course_child_category_featured" id="course_child_category_featured" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$course_featured as $featured)
                        <option value="{{$featured}}"
                                @if (isset($course_child_category) && ($course_child_category->course_child_category_featured === $featured)) selected @endif
                        >{{$featured}}</option>
                    @endforeach
                </select>
                <span id="course_child_category_featured-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_child_category_featured') }}
                </span>
            </div>
            <div class="form-group">
                {!! \Form::nLabel('course_child_category_status', 'Status', false) !!}
                <select name="course_child_category_status" id="course_child_category_status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$course_status as $status)
                        <option value="{{$status}}"
                                @if (isset($course_child_category) && ($course_child_category->course_child_category_status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
                <span id="course_child_category_status-error" class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_child_category_status') }}
                                </span>
            </div>
            <div class="form-group">
                {!! \Form::nLabel('course_child_category_image', 'Display Image', isset($courseCategory)) !!}
                <input
                    type="file"
                    class="form-control"
                    name="course_child_category_image"
                    id="course_child_category_image"
                    value="{{ old('course_child_category_image', isset($course_child_category) ? $course_child_category->course_child_category_image: null) }}"
                    onchange="imageIsLoaded(this,'preview_img');"
                >
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_child_category_image') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="container img-thumbnail text-center" style="margin-top: 20px">
                <img src="{{ asset($course_child_category->course_child_category_image ?? "assets/img/default.png") }}"
                     id="preview_img" alt="course image" class="img-responsive"
                     style="display: inline-block; height: 178px"/>
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!!
        \CHTML::actionButton(
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
        const selected_branch_id = '{{old("branch_id", (isset($course_child_category)?$course_child_category->branch_id:null))}}';
        const selected_company_id = '{{old("company_id", (isset($course_child_category)?$course_child_category->company_id:null))}}';
        const selected_course_category_id = '{{old("course_category_id", (isset($course_child_category)?$course_child_category->course_category_id:null))}}';
        const selected_course_sub_category_id = '{{old("course_sub_category_id", (isset($course_child_category)?$course_child_category->course_sub_category_id:null))}}';

        $(document).ready(function () {

            $('#company_id').change(function () {
                getBranchDropdown($(this), $("#branch_id"), selected_branch_id);
                getCourseCategoryDropdown($(this), $("#course_category_id"), selected_course_category_id);
            });

            $('#course_category_id').change(function () {
                getSubCategoryDropdown($(this), $("#course_sub_category_id"), selected_course_sub_category_id);
            });

            formObject = $('form#course_child_category_form');

            formValidator = formObject.validate({
                rules: {
                    course_category_id: {
                        required: true
                    },
                    course_sub_category_id: {
                        required: true
                    },
                    course_child_category_title: {
                        required: true
                    },
                    company_id: {
                        required: true,
                    },
                    // branch_id: {
                    //     required: false,
                    // },
                    course_child_category_image: {
                        required: {{ isset($course_child_category) ? 'false' : 'true' }},
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                }
            });

            //if (selected_company_id.length > 0) {
                getBranchDropdown($("#company_id"), $("#branch_id"), selected_branch_id);
                getCourseCategoryDropdown($("#company_id"), $("#course_category_id"), selected_course_category_id);
                $("#course_category_id").val(selected_course_category_id);
                $("#course_category_id").trigger("change");
            //}

            //if (selected_course_category_id.length > 0)
                getCourseCategoryDropdown($("#company_id"), $("#course_category_id"), selected_course_category_id);
        });
    </script>
@endpush
