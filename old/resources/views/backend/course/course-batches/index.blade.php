@extends('backend.layouts.master')
@section('title')
    Course Batches
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-laptop"></i>
        Course Batches
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
                    <h3 class="box-title">Find Course Batches</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('course-batches.index') }}">
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
                                    <label for="company_id" class="control-label">Company:</label>
                                    <select name="company_id" id="company_id" class="form-control auto_search">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}"
                                                    @if(old('company_id', isset($request) ? $request->company_id:null) == $company->id) selected @endif
                                            >{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                                <input type="hidden" id="company_id" name="company_id" value="{{auth()->user()->userDetails->company_id}}">
                            @endrole

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_id" class="control-label">Branch:</label>
                                    <select name="branch_id" id="branch_id" class="form-control auto_search">
                                        <option value="">Select Branch</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Course:</label>
                                    <select name="course_id" id="course_id" class="form-control auto_search">
                                        <option value="">Select Course</option>
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
                        $caption="Course Batches",
                        $captionIcon="icon-users",
                        $routeName="course-batches",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th> @sortablelink('course_batch_name', 'Batch Name')</th>
                                <th> Branch</th>
                                <th> Course</th>
                                <th> Students</th>
                                <th> Status</th>
                                <th class="tbl-date"> @sortablelink('created_at', 'Created At')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($courseBatches as $index => $courseBatch)
                                <tr>
                                    <td>{{ $index + 1}}</td>
                                    <td>{{isset($courseBatch)?strtoupper($courseBatch->course_batch_name):null}}</td>
                                    <td>{{isset($courseBatch->branch->branch_name)?strtoupper($courseBatch->branch->branch_name):'N/A'}}</td>
                                    <td>{{isset($courseBatch->course)?strtoupper($courseBatch->course->course_title):null}}</td>
                                    <td>
                                        <a class=" btn  mx-2 btn-primary"
                                           href="{{route('course-batches.course-batch-student-list', $courseBatch->id)}}"
                                           data-target="#pop-up-modal"
                                           data-toggle="modal">
                                            Students ({{$courseBatch->student->count()}})
                                        </a>
                                    </td>
                                    <td>{!! \CHTML::flagChangeButton($courseBatch, 'course_batch_status', \Utility::$statusText) !!}</td>
                                    <td class="tbl-date"> {{isset($courseBatch->created_at)?$courseBatch->created_at->format(config('app.date_format2')):null}}</td>

                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $courseBatch->id,
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
                {!! CHTML::customPaginate($courseBatches,'') !!}
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
            getBranchDropdown($("#company_id"), $("#branch_id"), $("#company_id").val());

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


