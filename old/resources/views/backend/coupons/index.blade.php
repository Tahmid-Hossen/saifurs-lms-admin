@extends('backend.layouts.master')
@section('title')
    Coupons
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-scissors"></i>
        Coupons
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
                <h3 class="box-title">Find Coupons</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('coupons.pdf', [
                            'search_text' => $request->get('search_text'),
                            'coupon_code' => $request->get('coupon_code'),
                            'coupon_status' => $request->get('coupon_status'),
                        ]) !!}">
                        <i class="fa fa-file-pdf-o"></i> PDF
                    </a>
                    <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('coupons.excel', [
                            'search_text' => $request->get('search_text'),
                            'coupon_code' => $request->get('coupon_code'),
                            'coupon_status' => $request->get('coupon_status'),
                        ]) !!}">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="horizontal-form" role="form" method="GET" action="{{ route('coupons.index') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search_text" class="control-label">Search Text</label>
                                <input type="text" class="form-control" id="search_text" name="search_text"
                                    value="{{ $request->search_text }}" placeholder="Insert a Text to Search Below">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="coupon_code" class="control-label">Coupon Code</label>
                                <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                    value="{{ $request->coupon_code }}" placeholder="Insert a Coupon Code">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="coupon_status" class="control-label">Coupon Status</label>
                                <select name="coupon_status" id="coupon_status" class="form-control">
                                    <option value="" @if (old('coupon_status', isset($request) ? $request->coupon_status : null) == $request->coupon_status) selected @endif>== Choose an Option ==</option>
                                    @foreach (\App\Services\UtilityService::$statusText as $status)
                                        <option value="{{ $status }}" @if (old('coupon_status', isset($request) ? $request->coupon_status : null) == $status) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
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
            {!! CHTML::formTitleBox($caption = 'List of All Coupons', 'null', $routeName = 'coupons', $buttonClass = '', $buttonIcon = '') !!}

            <div class="box-body table-responsive">

                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1" width="100%">
                    <tr>
                        <th> SL</th>
                        <th> @sortablelink('coupon_title', 'Title')</th>
                        <th class="text-center"> @sortablelink('coupon_code', 'Code')</th>
                        <th class="text-center"> Validity</th>
                        <th class="text-center"> Status</th>
                        <th class="tbl-action"> Actions</th>
                    </tr>
                    @foreach ($datas as $data)
                    <tr>
                        <td>{{ $datas->firstItem() + $loop->index }}</td>
                        <td>
                            {{ $data->coupon_title }}
                        </td>
                        <td class="text-center">
                            {{ $data->coupon_code }}
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($data->coupon_start)->format('d M, Y h:i:s A') }}
                            &nbsp; - &nbsp;
                            {{ \Carbon\Carbon::parse($data->coupon_end)->format('d M, Y h:i:s A') }}
                        </td>
                        <td class="text-center">
                            {!! \CHTML::flagChangeButton($data, 'coupon_status', \Utility::$statusText) !!}
                        </td>
                        <td>{!! \CHTML::actionButton($reportTitle = '..', $routeLink = '#', $data->id, $selectButton = ['showButton', 'editButton', 'deleteButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'yes', $othersPram = []) !!}</td>
                    </tr>
                    @endforeach
                </table>
                {!! CHTML::customPaginate($datas, '') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
