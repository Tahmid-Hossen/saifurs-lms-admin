@extends('backend.layouts.master')
@section('title')
    Teacher
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-user-secret"></i>
        Teacher
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
                    <h3 class="box-title">Find Teacher</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'teachers.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'username'=>$request->get('username'),
                                    'mobile_phone'=>$request->get('mobile_phone'),
                                    'name'=>$request->get('name'),
                                    'company_id'=>$request->get('company_id'),
                                    'branch_id'=>$request->get('branch_id'),
                                    'user_detail_start_date'=>$request->get('user_detail_start_date'),
                                    'user_detail_end_date'=>$request->get('user_detail_end_date'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'teachers.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'username'=>$request->get('username'),
                                    'mobile_phone'=>$request->get('mobile_phone'),
                                    'name'=>$request->get('name'),
                                    'company_id'=>$request->get('company_id'),
                                    'branch_id'=>$request->get('branch_id'),
                                    'user_detail_start_date'=>$request->get('user_detail_start_date'),
                                    'user_detail_end_date'=>$request->get('user_detail_end_date'),
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
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('teachers.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username" class="control-label">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                           value="{{ $request->username }}" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile_phone" class="control-label">Mobile:</label>
                                    <input type="text" class="form-control" id="mobile_phone" name="mobile_phone"
                                           value="{{ $request->mobile_phone }}" placeholder="Mobile">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $request->name }}" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_id" class="control-label">Company:</label>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_id" class="control-label">Branch:</label>
                                    <select name="branch_id" id="branch_id" class="form-control">
                                        <option value="">Select Branch</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="daterange-btn" class="control-label">Joining Date:</label>
                                    <input type="hidden" class="form-control pull-right only_date"
                                           id="user_detail_start_date"
                                           name="user_detail_start_date"
                                           value="{{ \Carbon\Carbon::parse($request->user_detail_start_date)->format('Y-m-d') }}"
                                           placeholder="From">
                                    <input type="hidden" class="form-control pull-right only_date"
                                           id="user_detail_end_date"
                                           name="user_detail_end_date"
                                           value="{{ \Carbon\Carbon::parse($request->user_detail_end_date)->format('Y-m-d') }}"
                                           placeholder="To">
                                    <div class="input-group col-md-12">
                                        <button type="button" class="btn btn-default col-md-12" id="daterange-btn"
                                                name="date_range">
                                            <span>
                                                <i class="fa fa-calendar"></i>
                                                @if(isset($request->date_range))
                                                    {{$request->date_range}}
                                                @else
                                                    Date range picker
                                                @endif
                                            </span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                            class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Teacher",
                        $captionIcon="fa fa-user-secret",
                        $routeName="teachers",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover order-column">
                            <thead>
                            <tr>
                                <th> Sl</th>
                                <th> Member Id</th>
                                <th>Username</th>
                                <th> Full Name</th>
                                <th> Mobile</th>
                                <th> Role</th>
                                <th> Joined At</th>
                                <th> Status</th>
                                <th> Created At</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{ $teachers->firstItem() + $loop->index }}</td>
                                    <td>{!!$teacher->user_id !!}</td>
                                    <td>{{$teacher->user->username}}</td>
                                    <td>{{$teacher->user->name}}</td>
                                    <td>{!!$teacher->mobile_phone !!}</td>
                                    <td>
                                        @forelse($teacher->user->roles as $role)
                                            {!! $role->name !!} {!! (!$loop->last) ? ', ':'' !!}
                                        @empty
                                            NA
                                        @endforelse
                                    </td>
                                    <td>{{\Carbon\Carbon::parse($teacher->date_of_enrollment)->format(config('app.date_format2'))}}</td>
                                    <td>{!! \CHTML::flagChangeButton($teacher->user, 'status', \Utility::$statusText); !!}</td>
                                    {{--<td>{{\Carbon\Carbon::parse($teacher->created_at)->format(config('app.date_format2'))}}</td>
                                    --}}
                                    <td class="tbl-date">{{$teacher->created_at->format(config('app.date_format2'))}}</td>

                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $teacher->id,
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
                    {!! \CHTML::customPaginate($teachers,'') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var selected_branch_id = '{{old("branch_id", (isset($request)?$request->branch_id:null))}}';
        $(document).ready(function () {
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment(),
                    autoclose: true
                },
                function (start, end) {
                    $('#user_detail_start_date').val(start.format('YYYY-MM-DD'))
                    $('#user_detail_end_date').val(end.format('YYYY-MM-DD'))
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

                }
            );
            getBranchList();
            $("#company_id").change(function () {
                getBranchList();
            });
        })

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
    </script>
@endpush


