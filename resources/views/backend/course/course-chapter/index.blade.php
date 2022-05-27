@extends('backend.layouts.master')
@section('title')
    Course Class
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-columns"></i>
        Course Class
        <small>Control panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Course Class</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'course-chapters.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'chapter_title_wild_card'=>$request->get('chapter_title_wild_card'),
                                    'chapter_status'=>$request->get('chapter_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'course-chapters.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'chapter_title_wild_card'=>$request->get('chapter_title_wild_card'),
                                    'chapter_status'=>$request->get('chapter_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET"
                          action="{{ route('course-chapters.index') }}">
                        <div class="row">
                            <div class="@role(\Utility::SUPER_ADMIN)col-md-6 @else col-md-12 @endrole">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-6 @else col-md-12 @endrole">
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
                                    <label for="name" class="control-label">Course:</label>
                                    <select name="course_id" id="course_id" class="form-control">
                                        <option value="">Select Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}"
                                                    @if(old('course_id', isset($request) ? $request->course_id:null) == $course->id) selected @endif
                                            >{{ $course->course_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Status:</label>
                                    <select name="chapter_status" id="chapter_status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach(\App\Support\Configs\Constants::$chapter_status as $status)
                                            <option value="{{ $status }}"
                                                    @if(old('chapter_status', isset($request) ? $request->chapter_status:null) == $status) selected @endif
                                            >{{ str_replace("-","",$status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Featured:</label>
                                    <select name="chapter_featured" id="chapter_featured" class="form-control auto_search">
                                        <option value="">Select Featured</option>
                                        @foreach(\App\Support\Configs\Constants::$chapter_featured as $featured)
                                            <option value="{{ $featured }}"
                                                    @if(old('chapter_featured', isset($request) ? $request->chapter_featured:null) == $featured) selected @endif
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
                        $caption="Course Classes",
                        $captionIcon="icon-users",
                        $routeName="course-chapters",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="sample_1">
                            <thead>
                            <tr>
                                <th>#</th>
                                @role(\Utility::SUPER_ADMIN)
                                <th> Company</th>
                                @endrole
                                <th>  @sortablelink('chapter_title', 'Class Title')</th>
                                <th>  Course</th>
                                <th> Status</th>
                               <th>  @sortablelink('created_at', 'Created Date')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($course_chapters as $index => $course_chapter)

                                <tr class="odd gradeX">
                                    <td>{{ $index+1 }}</td>
                                    @role(\Utility::SUPER_ADMIN)
                                    <td style="color: #0f13d3">{{isset($course_chapter->company)?mb_strtoupper($course_chapter->company->company_name):null}}</td>
                                    @endrole
                                    <td>{{isset($course_chapter->chapter_title)?mb_strtoupper($course_chapter->chapter_title):null}}</td>
                                    <td style="color: #76767f">{{isset($course_chapter->course)?$course_chapter->course->course_title:null}}</td>
                                    <td>
                                        {!! CHTML::flagChangeButton($course_chapter,
                                                'chapter_status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td> {{isset($course_chapter->created_at)?$course_chapter->created_at->format('d M, Y'):null}}</td>
                                   <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $course_chapter->id,
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
                {!! CHTML::customPaginate($course_chapters,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')
    <script>
        var selected_course_id = '{{ old('course_id', isset($request) ? $request->course_id : null) }}';
        $(document).ready(function () {
            getCourseList();
            $("#company_id").change(function () {
                getCourseList();
            });
        })

        function getCourseList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{ csrf_token() }}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{ route('course.get-course-list') }}',
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
                                $("#course_id").append('<option value="' + value.id + '" ' +
                                courseSelectedStatus + '>' + value.course_title + '</option>');
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
    </script>
@endpush


