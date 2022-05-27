@extends('backend.layouts.master')
@section('title')
    Course Ratings
@endsection

@section('content-header')
    <h1>
        Course Ratings
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
                    <h3 class="box-title">Find Course Rating</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('course-ratings.pdf', [
                            'course_rating_id' => $request->get('course_rating_id'),
                            'course_title' => $request->get('course_title'),
                            'course_feedback' => $request->get('course_feedback'),
                            'is_approved' => $request->get('is_approved'),
                            'is_featured' => $request->get('is_featured'),
                            'course_rating_stars' => $request->get('course_rating_stars'),
                            'course_rating_status' => $request->get('course_rating_status')
                            ]) !!}">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('course-ratings.excel', [
                            'course_rating_id' => $request->get('course_rating_id'),
                            'course_title' => $request->get('course_title'),
                            'course_feedback' => $request->get('course_feedback'),
                            'is_approved' => $request->get('is_approved'),
                            'is_featured' => $request->get('is_featured'),
                            'course_rating_stars' => $request->get('course_rating_stars'),
                            'course_rating_status' => $request->get('course_rating_status')
                            ]) !!}">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('course-ratings.index') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_title" class="control-label">Course Title</label>
                                    <input type="text" class="form-control" id="course_title" name="course_title"
                                           value="{{ $request->course_title }}" placeholder="Insert a Course Title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_feedback" class="control-label">Course Rating Review</label>
                                    <input type="text" class="form-control" id="course_feedback" name="course_feedback"
                                           value="{{ $request->course_feedback }}"
                                           placeholder="Insert a Course Ratinge Review Text">
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="is_approved" class="control-label">Course Rating Is Approved</label>
                                    <select name="is_approved" id="is_approved" class="form-control">
                                        <option value=""
                                                @if (old('is_approved', isset($request) ? $request->is_approved : null) == $request->is_approved) selected @endif>
                                            -------- No Option Selected --------
                                        </option>
                                        @foreach (Utility::$featuredStatusText as $status)
                                            <option value="{{ $status }}"
                                                    @if (old('is_approved', isset($request) ? $request->is_approved : null) == $status) selected @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="is_featured" class="control-label">Course Rating Is Featured</label>
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value=""
                                                @if (old('is_featured', isset($request) ? $request->is_featured : null) == $request->is_featured) selected @endif>
                                            -------- No Option Selected --------
                                        </option>
                                        @foreach (Utility::$featuredStatusText as $status)
                                            <option value="{{ $status }}"
                                                    @if (old('is_featured', isset($request) ? $request->is_featured : null) == $status) selected @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="course_rating_stars" class="control-label">Course Ratings</label>
                                    <select name="course_rating_stars" id="course_rating_stars" class="form-control">
                                        <option value=""
                                                @if (old('course_rating_stars', isset($request) ? $request->course_rating_stars : 0) == $request->course_rating_stars) selected @endif>
                                            -------- No Ratings Selected--------
                                        </option>
                                        @foreach (Utility::$stars as $key => $values)
                                            <option value="{{ $key }}"
                                                    @if (old('course_rating_stars', isset($request) ? $request->course_rating_stars : 0) == $key) selected @endif>{{ $values }}</option>
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
            <!-- /.box -->
            <div class="box">
                {!! CHTML::formTitleBox($caption = 'List of All Course Ratings', $captionIcon = 'null', $routeName = 'quizzes', $buttonClass = '', $buttonIcon = '') !!}

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="sample_1" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>@sortablelink('course_rating_stars', 'Ratings')</th>
                            <th>Reviews</th>
                            <th>Approved</th>
                            <th>Status</th>
                            <th class="tbl-action">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($datas as $data)
                            <tr class="odd gradeX">
                                <td>{{ $datas->firstItem() + $loop->index }}</td>
                                <td>{{ $data->course->course_title }}</td>
                                <td>
                                    {!! \App\Services\CustomHtmlService::startRating($data->course_rating_stars) !!}
                                </td>
                                <td>
                                    <div class="comment">{{ $data->course_rating_feedback }}</div>
                                </td>
                                <td>
                                    {!! \CHTML::flagChangeButton($data, 'is_approved', \Utility::$approvedStatus, null,
    ['on' => 'primary', 'off' => 'default']) !!}
                                </td>
                                <td class="text-center">
                                    {!! \CHTML::flagChangeButton($data, 'course_rating_status', \Utility::$statusText) !!}
                                </td>
                                <td class="tbl-action">
                                    {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', $data->id, $selectButton = ['showButton', 'editButton', 'deleteButton'], $class = 'btn-icon btn-circle', $onlyIcon = 'yes', $othersPram = []) !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! CHTML::customPaginate($datas, '') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var selected_branch_id = "{{ old('branch_id', isset($request) ? $request->branch_id : null) }}";
        $(document).ready(function () {
            getBranchList();
            $("#company_id").change(function () {
                getBranchList();
            });
        })

        function getBranchList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{ csrf_token() }}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "{{ route('branches.get-branch-list') }}",
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
                                $("#branch_id").append('<option value="' + value.id + '" ' +
                                    branchSelectedStatus + '>' + value.branch_name + '</option>');
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
    </script>
@endpush
