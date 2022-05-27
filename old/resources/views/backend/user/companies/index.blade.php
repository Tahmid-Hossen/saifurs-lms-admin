@extends('backend.layouts.master')
@section('title')
    Companies
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Company
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
                    <h3 class="box-title">Find Companies</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'companies.pdf',
                                [
                                    'search_text'=>$request->get('search_text')
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'companies.excel',
                                [
                                    'search_text'=>$request->get('search_text')
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
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('companies.index') }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="barcode" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
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
            <div class="box with-border">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Companies",
                        $captionIcon="fa fa-building",
                        $routeName="companies.create",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-bordered table-hover"
                    >
                        <thead>
                        <tr>
                            <th> ID</th>
                            <th> Name</th>
                            <th> Email</th>
                            <th> Contact</th>
                            <th> Status</th>
                            <th> Created At</th>
                            <th class="tbl-action"> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td> {{$company->id}}</td>
                                <td> {!! $company->company_name !!}</td>
                                <td> {{$company->company_email}}</td>
                                <td> {{$company->company_mobile}}
                                    @if(isset($company->company_phone)),
                                    {{$company->company_phone}}
                                    @endif
                                </td>
                                <td>
                                    {!! \CHTML::flagChangeButton($company,'company_status', \Utility::$statusText) !!}
                                </td>
                                <td class="tbl-date"> {{$company->created_at->format(config('app.date_format2'))}}</td>

                                <td class="tbl-action">
                                    {!!
                                        \CHTML::actionButton(
                                            $reportTitle='..',
                                            $routeLink='#',
                                            $company->id,
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
                {!! \CHTML::customPaginate($companies) !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush


