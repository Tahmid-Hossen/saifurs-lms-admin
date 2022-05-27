@extends('backend.layouts.master')
@section('title')
    Course
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-paragraph" aria-hidden="true"></i>
        Course
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Course</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'course.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_category_id'=>$request->get('course_category_id'),
                                    'course_sub_category_id'=>$request->get('course_sub_category_id'),
                                    'course_child_category_id'=>$request->get('course_child_category_id'),
                                    'course_title'=>$request->get('course_title'),
                                    'course_option'=>$request->get('course_option'),
                                    'course_type'=>$request->get('course_type'),
                                    'course_slug'=>$request->get('course_slug'),
                                    'course_status'=>$request->get('course_status'),
                                    'course_featured'=>$request->get('course_featured'),
                                    'course_language'=>$request->get('course_language'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('course.index') }}">
                        <div class="row">
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                <div class="form-group">
                                    <label for="barcode" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                <div class="form-group">
                                    <label for="name" class="control-label">Company:</label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}"
                                                    @if(old('company_id', isset($request) ? $request->company_id:null) == $company->id) selected @endif
                                            >{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                <div class="form-group">
                                    <label for="name" class="control-label">Branch:</label>
                                    <select name="branch_id" id="branch_id" class="form-control">
                                        <option value="">Select Branch</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Course Category:</label>
                                    <select name="course_category_id" id="course_category_id" class="form-control">
                                        <option value="">Select Course Category</option>
                                        @foreach($course_categories as $course_category)
                                            <option value="{{ $course_category->id }}"
                                                    @if(old('course_category_id', isset($request) ? $request->course_category_id:null) == $course_category->id) selected @endif
                                            >{{ $course_category->course_category_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Course Sub Category:</label>
                                    <select name="course_sub_category_id" id="course_sub_category_id"
                                            class="form-control">
                                        <option value="">Select Course Sub Category</option>
                                        @foreach($course_sub_categories as $course_sub_category)
                                            <option value="{{ $course_sub_category->id }}"
                                                    @if(old('course_sub_category_id', isset($request) ? $request->course_sub_category_id:null) == $course_sub_category->id) selected @endif
                                            >{{ $course_sub_category->course_sub_category_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Course Child Category:</label>
                                    <select name="course_child_category_id" id="course_child_category_id"
                                            class="form-control">
                                        <option value="">Select Course Child Category</option>
                                        @foreach($course_child_categories as $course_child_category)
                                            <option value="{{ $course_child_category->id }}"
                                                    @if(old('course_child_category_id', isset($request) ? $request->course_child_category_id:null) == $course_child_category->id) selected @endif
                                            >{{ $course_child_category->course_child_category_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="control-label">Status:</label>
                                    <select name="course_status" id="course_status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach(\App\Support\Configs\Constants::$course_status as $status)
                                            <option value="{{ $status }}"
                                                    @if(old('course_status', isset($request) ? $request->course_status:null) == $status) selected @endif
                                            >{{ str_replace("-","",$status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="control-label">Featured:</label>
                                    <select name="course_featured" id="course_featured" class="form-control">
                                        <option value="">Select Featured</option>
                                        @foreach(\App\Support\Configs\Constants::$course_featured as $featured)
                                            <option value="{{ $featured }}"
                                                    @if(old('course_featured', isset($request) ? $request->course_featured:null) == $featured) selected @endif
                                            >{{ $featured }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="course_option" class="control-label">Course Option</label>
                                    <select name="course_option" id="course_option" class="form-control">
                                        <option value="">Select Course Type</option>
                                        @foreach (\App\Support\Configs\Constants::$class_types as $option)
                                            <option value="{{ $option }}"
                                                    @if(old('course_option', isset($request) ? $request->course_option : null) == $option) selected @endif
                                            >{{ strtoupper($option) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="course_language" class="control-label">Language</label>
                                    <select name="course_language" id="course_language" class="form-control">
                                        <option value="">Select Language</option>
                                        @foreach(\App\Support\Configs\Constants::$course_language as $language)
                                            <option value="{{$language}}"
                                                    @if (isset($course) && ($course->course_language === $language)) selected @endif
                                            >{{$language}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger text-bold" style="margin-right: 1rem"><i
                                        class="fa fa-eraser"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary text-bold"><i
                                        class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box">
                {!!
                    CHTML::formTitleBox(
                        $caption="Courses",
                        $captionIcon="fa fa-paragraph",
                        $routeName="course",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                        >
                            <thead>
                            <tr>
                                <th>#</th>
                                @role(\Utility::SUPER_ADMIN)
                                <th> Company</th>
                                @endrole
                                <th> @sortablelink('course_title', 'Course')</th>
                                <th class="text-center"> Type</th>
                                <th> Featured</th>
                                <th> Branch(s)</th>
                                <th> Batch(s)</th>
                                <th> Status</th>
                                <th class="tbl-date"> Created At</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($courses as $i => $course)
                            	@php
                                	 $course_batches = App\Models\Backend\Course\CourseBatch::where('course_id', $course->id)->get();
                                	 $course_branches = \App\Models\Backend\User\Branch::whereIn('id', explode(',' , $course->branch_id))->get();
                                @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    @role(\Utility::SUPER_ADMIN)
                                    <td>{{isset($course->company)?$course->company->company_name:null}}</td>
                                    @endrole
                                    <td>{!!  $course->course_title ?? ''!!}</td>

                                    <td>
                                        {{ $course->course_option }}
                                        @if(!empty($course->course_type))
                                            (<b>{{ $course->course_type }}</b>)
                                        @endif
                                    </td>

                                    <td>
                                        {!! \CHTML::flagChangeButton($course,
                                                'course_featured',
                                            ['on' => 'YES', 'off' => 'NO']) !!}

                                    </td>
                                    <td>
                                        @if(count($course_branches) > 0)
                                            @foreach($course_branches as $cbranch)
                                                {{ $cbranch->branch_name }}<br>
                                            @endforeach
                                        @endif
                                    </td>
                                     <td>
                                     	@if(count($course_batches) > 0)
                                        	@foreach($course_batches as $cbatch)
                                            	<a href="{{ route('course-batches.show',$cbatch->id) }}" target="_blank">{{ $cbatch->course_batch_name }}</a><br>
                                            @endforeach
                                        @endif
                                     </td>
                                    <td>
                                    	@if(count($course_batches) > 0)
                                        {!! CHTML::flagChangeButton($course,
                                                'course_status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}
                                       @else
                                       		<h6 style="color:red">Course should not display before adding batch</h6>
                                            <a href="{{ route('course-batches.create',['course_id'=>$course->id,'branch_id'=>$course->branch_id]) }}" target="_blank">Add batch</a>
                                       @endif

                                    </td>
                                    <td> {{isset($course->created_at)?$course->created_at->format('d M, Y'):null}}</td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $course->id,
                                                $selectButton=['showButton','editButton','deleteButton'],
                                                $class = ' btn-icon btn-circle ',
                                                $onlyIcon='yes',
                                                $othersPram=array()
                                            )
                                        !!}

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                {!! CHTML::customPaginate($courses,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')
    <script>
        var selected_company_id = '{{old("company_id", (isset($request)?$request->company_id:null))}}';
        var selected_course_category_id = '{{old("course_category_id", (isset($request)?$request->course_category_id:null))}}';
        var selected_course_sub_category_id = '{{old("course_sub_category_id", (isset($request)?$request->course_sub_category_id:null))}}';
        var selected_course_child_category_id = '{{old("course_child_category_id", (isset($request)?$request->course_child_category_id:null))}}';
        var selected_branch_id = '{{ old('branch_id', isset($request) ? $request->branch_id : null) }}';

        $(document).ready(function () {
            getCourseCategoryDropdown($("#company_id"), $("#course_category_id"), selected_course_category_id);
            getBranchDropdown($("#company_id"), $("#branch_id"), selected_branch_id);

            $("#course_category_id").val(selected_course_category_id);
            setTimeout(function () {
                getSubCategoryDropdown($("#course_category_id"), $("#course_sub_category_id"), selected_course_sub_category_id);
                setTimeout(function () {
                    getChildCategoryDropdown($("#course_sub_category_id"), $("#course_child_category_id"), selected_course_child_category_id);
                }, 2000);
            }, 1000);


            $("#company_id").change(function () {
                getCourseCategoryDropdown($(this), $("#course_category_id"), null);
                getBranchDropdown($(this), $("#branch_id"), null);
            });

            $("#course_category_id").change(function () {
                getSubCategoryDropdown($(this), $("#course_sub_category_id"), null);
            });

            $("#course_sub_category_id").change(function () {
                getChildCategoryDropdown($(this), $("#course_child_category_id"), null);
            });
        });
    </script>
@endpush


