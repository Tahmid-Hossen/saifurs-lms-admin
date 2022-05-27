@extends('backend.layouts.master')
@section('title')
    Branches
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Branch
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
                    <h3 class="box-title">Find Branches</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'branches.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id')
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'branches.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id')
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
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('branches.index') }}">
                        <div class="row">
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-6 @else col-md-12 @endrole">
                                <div class="form-group">
                                    <label for="barcode" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_id" class="control-label">Company Name</label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value=""
                                                @if (isset($request) && ($request->company_id === "")) selected @endif>
                                            Select Company
                                        </option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}"
                                                    @if (isset($request) && ($request->company_id === $company->id)) selected @endif
                                            >{{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole
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
                        $caption="Branches",
                        $captionIcon="icon-users",
                        $routeName="branches",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-checkable order-column">
        <thead>
        <tr>
            <th> ID</th>
            @role(\Utility::SUPER_ADMIN)
            <th> Company</th>
            @endrole
            <th>Branch Name</th>
            <th>Manager Name</th>
            <th>Branch Address(English)</th>
           {{-- <th>Branch Address(Bangla)</th>--}}
            <th>Email</th>
            <th> Contact</th>
            <th> Latitude</th>
            <th> Longitude</th>
            <th> Status</th>
           <th> Created At</th>
            <th class="tbl-action"> Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($branches as $branch)
            <tr>
                <td> {{$branch->id}}</td>
                @role(\Utility::SUPER_ADMIN)
                <td> {!! $branch->company_name !!}</td>
                @endrole
                <td> {!! $branch->branch_name !!}</td>
                <td> {!! $branch->manager_name !!}</td>
                <td> {!! $branch->branch_address !!}</td>
               {{-- <td> {!! $branch->address_bn !!}</td>--}}
                <td> {!! $branch->branch_email !!}</td>
                <td>
                    {{$branch->branch_mobile}}
                    @if(isset($company->branch_phone)),
                    {{$company->branch_phone}}
                    @endif
                </td>
                <td> {{$branch->branch_latitude}}</td>
                <td> {{$branch->branch_longitude}}</td>
                <td> {!! \CHTML::flagChangeButton($branch, 'branch_status', \Utility::$statusText) !!}</td>
                <td class="tbl-date"> {{$branch->created_at->format(config('app.date_format2'))}}</td>
               <td class="tbl-action">
                    {!!
                        \CHTML::actionButton(
                            $reportTitle='..',
                            $routeLink='#',
                            $branch->id,
                            $selectButton=['showButton','editButton','deleteButton'],
                            $class = ' btn-icon btn-circle ',
                            $onlyIcon='yes',
                            $othersPram=[]
                        )
                    !!}

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>

                    {!! \CHTML::customPaginate($branches,'') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@push('scripts')

@endpush


