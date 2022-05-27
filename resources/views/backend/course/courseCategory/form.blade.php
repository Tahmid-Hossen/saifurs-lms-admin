@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        @if(auth()->user()->userDetails->company_id == 1)
            <div class="col-md-12">
                {!! \Form::nSelect('company_id', 'Select Company', $global_companies, isset($courseCategory) ? $courseCategory->company_id: null, true,
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
        <div class="col-md-12">
            {!! \Form::nText('course_category_title', 'Title', old('course_category_title', isset($courseCategory)
? $courseCategory->course_category_title: null), true, ['placeholder' => 'Enter Course Category Title']) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('course_category_details', 'Description', true) !!}
                <textarea id="course_category_details" name="course_category_details" rows="5"
                          class="form-control editor"
                          placeholder="Enter Course Category details">{{ old('course_category_details', isset($courseCategory->course_category_details) ? $courseCategory->course_category_details: null) }}</textarea>

                <span id="course_category_details-error" class="help-block text-danger">
                    {{ $errors->first('course_category_details') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_category_featured', 'Featured', true) !!}
                <select name="course_category_featured" id="course_category_featured" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$course_featured as $featured)
                        <option value="{{$featured}}"
                                @if (isset($courseCategory) && ($courseCategory->course_category_featured === $featured)) selected @endif
                        >{{$featured}}</option>
                    @endforeach
                </select>
                <span id="course_category_featured-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('course_category_featured') }}
                </span>
            </div>
            <div class="form-group">
                {!! \Form::nLabel('course_category_status', 'Status', false) !!}
                <select name="course_category_status" id="course_category_status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$course_status as $status)
                        <option value="{{$status}}"
                                @if (isset($courseCategory) && ($courseCategory->course_category_status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
                <span id="course_category_status-error" class="form-text text-danger" role="alert">
                                    {{ $errors->first('course_category_status') }}
                                </span>
            </div>
            <div class="form-group">
                {!! \Form::nLabel('course_category_image', 'Display Image', false) !!}
                <input
                    type="file"
                    class="form-control"
                    name="course_category_image"
                    id="course_category_image"
                    value="{{ old('course_category_image', isset($courseCategory) ? $courseCategory->course_category_image: null) }}"
                    onchange="imageIsLoaded(this,'preview_img');"
                >
                <span class="form-text text-danger" role="alert">
                    {{ $errors->first('course_category_image') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="container img-thumbnail text-center" style="margin-top: 20px">
                <img src="{{ asset($courseCategory->course_category_image ?? "assets/img/default.png") }}"
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
        isset($courseCategory) ? $courseCategory->id : null,
        $selectButton=['cancelButton','storeButton'],
        $class = ' btn-icon btn-circle ',
        $onlyIcon='yes',
        $othersPram=array()
    )
!!}
</div>
@push('scripts')
    <script>
        const selected_branch_id = '{{old("branch_id", (isset($courseCategory)?$courseCategory->branch_id:null))}}';
        const selected_company_id = '{{old("company_id", (isset($courseCategory)?$courseCategory->company_id:null))}}';
        $(document).ready(function () {
            formObject = $('form#course_category_form');
            formValidator = formObject.validate({
                rules: {
                    course_category_title: {
                        required: true
                    },
                    company_id: {
                        required: true,
                    },
                    course_category_image: {
                        required: {{ isset($courseCategory) ? 'false' : 'true' }},
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                }
            });
            //if (selected_company_id.length > 0)
                getBranchDropdown($("#company_id"), $("#branch_id"), selected_branch_id);

            $('#company_id').change(function () {
                getBranchDropdown($(this), $("#branch_id"), selected_branch_id);
            });
        });
    </script>
@endpush
