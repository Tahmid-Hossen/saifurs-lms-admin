@extends('backend.layouts.master')
@section('title')
    Course Sub Category
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-clone"></i>
        Course Sub Category
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="row">
            @include('backend.layouts.flash')
            <div class="col-xs-12">
                <div class="box box-default collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Find Course Sub Category</h3>

                        <div class="box-tools pull-right">
                            <a class="btn btn-primary hidden-print" id="payeePrint"
                               href="{!! route(
                                'course-sub-categories.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'course_sub_category_title_wild_card'=>$request->get('course_sub_category_title_wild_card'),
                                    'course_sub_category_image'=>$request->get('course_sub_category_image'),
                                    'course_sub_category_slug'=>$request->get('course_sub_category_slug'),
                                    'company_id'=>$request->get('company_id'),
                                    // 'branch_id'=>$request->get('branch_id'),
                                    'course_sub_category_status'=>$request->get('course_sub_category_status'),
                                    'course_sub_category_featured'=>$request->get('course_sub_category_featured'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                            >
                                <i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                            <a class="btn btn-primary hidden-print" id="payeePrint"
                               href="{!! route(
                                'course-sub-categories.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'course_sub_category_title_wild_card'=>$request->get('course_sub_category_title_wild_card'),
                                    'course_sub_category_image'=>$request->get('course_sub_category_image'),
                                    'course_sub_category_slug'=>$request->get('course_sub_category_slug'),
                                    'company_id'=>$request->get('company_id'),
                                    // 'branch_id'=>$request->get('branch_id'),
                                    'course_sub_category_status'=>$request->get('course_sub_category_status'),
                                    'course_sub_category_featured'=>$request->get('course_sub_category_featured'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                            >
                                <i class="fa fa-file-excel-o"></i> Excel
                            </a>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="horizontal-form" role="form" method="GET"
                              action="{{ route('course-sub-categories.index') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="barcode" class="control-label">Search:</label>
                                        <input type="text" class="form-control" id="search_text" name="search_text"
                                               value="{{ $request->search_text }}" placeholder="Search Text">
                                    </div>
                                </div>
                                @role(\Utility::SUPER_ADMIN)
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="control-label">Status:</label>
                                        <select name="course_sub_category_status" id="course_sub_category_status"
                                                class="form-control">
                                            <option value="">Select Status</option>
                                            @foreach(\App\Support\Configs\Constants::$course_status as $status)
                                                <option value="{{ $status }}"
                                                        @if(old('course_sub_category_status', isset($request) ? $request->course_sub_category_status:null) == $status) selected @endif
                                                >{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="control-label">Featured:</label>
                                        <select name="course_sub_category_featured" id="course_sub_category_featured"
                                                class="form-control">
                                            <option value="">Select Featured</option>
                                            @foreach(\App\Support\Configs\Constants::$course_featured as $featured)
                                                <option value="{{ $featured }}"
                                                        @if(old('course_sub_category_featured', isset($request) ? $request->course_sub_category_featured:null) == $featured) selected @endif
                                                >{{ $featured }}</option>
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
                            $caption="Course Sub Categories",
                            $captionIcon="icon-users",
                            $routeName="course-sub-categories",
                            $buttonClass="",
                            $buttonIcon=""
                        )
                    !!}
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover order-column"
                            >
                                <thead>
                                <tr>
                                    <th> ID</th>
                                    @role(\Utility::SUPER_ADMIN)
                                    <th> Company</th>
                                    @endrole
                                    <th> Course Category</th>
                                    <th> @sortablelink('course_sub_category_title', 'Course Sub Category Title')</th>
                                    <th> Featured</th>
                                    <th> Status</th>
                                    <th class="tbl-date"> Created At</th>
                                    <th class="tbl-action"> Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($courseSubCategories as $index => $course_sub_category)
                                    <tr>
                                        <td> {{$index+1}}</td>
                                        @role(\Utility::SUPER_ADMIN)
                                        <td>{!! isset($course_sub_category->company)?$course_sub_category->company->company_name:null !!}</td>
                                        @endrole
                                        <td>{!! isset($course_sub_category->courseCategory)?$course_sub_category->courseCategory->course_category_title:null !!}</td>
                                        <td>{!! isset($course_sub_category->course_sub_category_title)?$course_sub_category->course_sub_category_title:null !!}</td>

                                    <!-- <td>{{$course_sub_category->course_sub_category_slug}}</td> -->

                                        <td>
                                            {!! CHTML::flagChangeButton($course_sub_category,
                                                    'course_sub_category_featured', \App\Support\Configs\Constants::$course_featured,
                                                null,['on' => 'primary', 'off' => 'default']) !!}
                                        </td>

                                        <td>
                                            {!! CHTML::flagChangeButton($course_sub_category,
                                                    'course_sub_category_status',
                                                ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}
                                        </td>

                                        <td> {{isset($course_sub_category->created_at)?$course_sub_category->created_at->format(config('app.date_format2')):null}}</td>

                                        <td class="tbl-action">
                                            {!!
                                                CHTML::actionButton(
                                                    $reportTitle='..',
                                                    $routeLink='#',
                                                    $course_sub_category->id,
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
                    {!! CHTML::customPaginate($courseSubCategories,'') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var selected_course_category_id = '{{ old('course_category_id', isset($request) ? $request->course_category_id : null) }}';
        $(document).ready(function () {
            getCourseCategoryList();
            $("#company_id").change(function () {
                getCourseCategoryList();
            });
        })

        function getCourseCategoryList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{ csrf_token() }}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{ route('course-categories.get-course-category-list') }}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#course_category_id").empty();
                            $("#course_category_id").append('<option value="">Please Select Course Category</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_course_category_id == value.id) {
                                    courseCategorySelectedStatus = ' selected ';
                                } else {
                                    courseCategorySelectedStatus = '';
                                }
                                $("#course_category_id").append('<option value="' + value.id + '" ' +
                                    courseCategorySelectedStatus + '>' + value.course_category_title + '</option>');
                            });
                        } else {
                            $("#course_category_id").empty();
                            $("#course_category_id").append('<option value="">Please Select Course Category</option>');
                        }
                    }
                });
            } else {
                $("#course_category_id").empty();
                $("#course_category_id").append('<option value="">Please Select Course Category</option>');
            }
        }
    </script>
@endpush


