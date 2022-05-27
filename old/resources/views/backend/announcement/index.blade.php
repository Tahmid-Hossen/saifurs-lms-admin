@extends('backend.layouts.master')
@section('title')
    Announcements
@endsection
@section('page_styles')

@endsection

@section('content-header')
        <h1>
            <i class="fa fa-bullhorn"></i>  Announcements
        </h1>
        {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
    @endsection

@section('content')
    <div class="row">

    @include('backend.layouts.flash')
    <div class="col-xs-12">
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Find a Announcement</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('announcements.pdf', [
                        'announcement_title' => $request->announcement_title,
                        'announcement_status' => $request->announcement_status,
                        'announcement_date' => $request->announcement_date,
                        'announcement_type' => $request->announcement_type,
                        'course_title' => $request->course_title
                    ]) !!}">
                        <i class="fa fa-file-pdf-o"></i> PDF
                    </a>
                    <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('announcements.excel', [
                        'announcement_title' => $request->announcement_title,
                        'announcement_status' => $request->announcement_status,
                        'announcement_date' => $request->announcement_date,
                        'announcement_type' => $request->announcement_type,
                        'course_title' => $request->course_title
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
                <form class="horizontal-form" role="form" method="GET" action="{{ route('announcements.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="announcement_title" class="control-label">Search by Announcement Title</label>
                                <input type="text" class="form-control" id="announcement_title" name="announcement_title"
                                    value="{{ $request->announcement_title }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="course_title" class="control-label">Search by Course Title</label>
                                <input type="text" class="form-control" id="course_title" name="course_title"
                                    value="{{ $request->course_title }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="announcement_type" class="control-label">Search by Type</label>
                                <select name="announcement_type" id="announcement_type" class="form-control">
                                    <option value="">Click to select Type</option>
                                    @foreach (\Utility::$announcementType as $key => $status)
                                        <option value="{{ $key }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="announcement_status" class="control-label">Search by Status</label>
                                <select name="announcement_status" id="announcement_status" class="form-control">
                                    <option value="">Click to select status</option>
                                    @foreach (\Utility::$statusText as $key => $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info btn-block">
                                    <i class="fa fa-search"></i> &nbsp;&nbsp;Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div class="box">
            {!! \CHTML::formTitleBox(
                $caption = 'All Announcements',
                $captionIcon = 'icon-users',
                $routeName = 'announcements',
                $buttonClass = '',
                $buttonIcon = '') !!}

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1"
                    width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Announcement Title</th>
                            <th>Course Title</th>
                            <th>Type</th>
                            <th>Due Date</th>
{{--
                            <th>Created At</th>
--}}
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as  $data)
                            <tr class="odd gradeX">
                                <td>{{ $datas->firstItem() + $loop->index }}</td>
                                <td><a href="{{ route('announcements.show', $data->id) }}">{{ $data->announcement_title }}</a></td>
                                <td>{{ $data->course->course_title }}</td>
                                <td>{{ \Utility::$announcementType[$data->announcement_types]??\Utility::$announcementType['general'] }}</td>
                                <td>{{ date('jS M, Y', strtotime($data->announcement_date)) }}</td>
                                <td class="text-center">
                                    {!! \CHTML::flagChangeButton($data, 'announcement_status', \Utility::$statusText) !!}
                                </td>
                                <td class="tbl-action">
                                    {!! \CHTML::actionButton(
                                        $reportTitle = '..',
                                        $routeLink = '#',
                                        $data->id,
                                        $selectButton = ['showButton', 'editButton', 'deleteButton'],
                                        $class = 'btn-icon btn-circle',
                                        $onlyIcon = 'yes',
                                        $othersPram = []) !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! \CHTML::customPaginate($datas, '') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
@push('scripts')
<script>
    var selected_branch_id = '{{ old('branch_id', isset($request) ? $request->branch_id : null) }}';
    $(document).ready(function() {
        getBranchList();
        $("#company_id").change(function() {
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
                url: '{{ route('branches.get-branch-list') }}',
                data: {
                    company_id: company_id,
                    '_token': pickToken
                },
                success: function(res) {
                    if (res.status == 200) {
                        $("#branch_id").empty();
                        $("#branch_id").append('<option value="">Please Select Branch</option>');
                        $.each(res.data, function(key, value) {
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
