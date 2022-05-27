@extends('backend.layouts.master')

@section('title')
    Transactions
@endsection

@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-hand-grab-o"></i>
        Transactions
        <small>Sales</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <!-- Find Option -->
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Transactions</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route('book.pdf', request()->query()) !!}">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route( 'book.excel',request()->query()) !!}">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('sales.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                {!! \Form::nText('search_text', 'Search: ',($inputs['search_text'] ?? null), false, ['placeholder' => 'Search name, Id , etc...']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nText('name', 'Name',($inputs['name'] ?? null), false, ['placeholder' => 'Sale Title']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nSelect('category', 'Category',$categories ?? [], ($inputs['category'] ?? null), false, ['class' => 'form-control select2']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {!! \Form::nText('author', 'Author, Contributor',($inputs['author'] ?? null), false, ['placeholder' => 'Author, Contributor']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nSelect('company', 'Company',$companies, ($inputs['company'] ?? null), false, ['placeholder' => 'Company Name', 'class' => 'form-control select2']) !!}
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="daterange-btn" class="control-label">Creation Date Range:</label>
                                    <input type="hidden" class="form-control pull-right only_date"
                                           id="start_date"
                                           name="start_date"
                                           value="{{ \Carbon\Carbon::parse($inputs['start_date'] ?? 'now')->format('Y-m-d') }}"
                                           placeholder="From">
                                    <input type="hidden" class="form-control pull-right only_date"
                                           id="end_date"
                                           name="end_date"
                                           value="{{ \Carbon\Carbon::parse($inputs['end_date'] ?? 'now')->format('Y-m-d') }}"
                                           placeholder="To">
                                    <div class="input-group col-md-12">
                                        <button type="button" class="btn btn-default col-md-12" id="daterange-btn"
                                                name="date_range">
                                            <span>
                                                <i class="fa fa-calendar"></i>
                                                @if(isset($inputs['date_range']))
                                                    {{$inputs['date_range']}}
                                                @else
                                                    Date Range
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
                        $caption="Transactions",
                        $captionIcon="fa fa-hand-grab-o",
                        $routeName="",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr class="text-center">
                                <th class="text-center"> ID</th>
                                <th class="text-center"> Transaction ID</th>
                                <th class="text-center"> Customer</th>
                                <th class="text-center"> Entry Date</th>
                                <th class="text-center"> Billed Amount ({{ \Utility::$defaultCurrency['ISO'] }})</th>
                                <th class="text-center"> Due Date</th>
                                <th class="text-center"> Due Amount ({{ \Utility::$defaultCurrency['ISO'] }})</th>
                                <th class="text-center"> Status</th>
                                <th> Created At</th>
                                <th class="text-center"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sales->firstItem() + $loop->index }}</td>
                                    <td>
                                            {!! $sale->transaction_id !!}
                                    </td>
                                    <td>
                                        @if(is_null($sale->user_id))
                                            <b>{{ $sale->customer_name }}</b>
                                            <br>({{ $sale->customer_phone }})
                                        @else
                                            <b>{{ $sale->user->name }}</b>
                                            <br>({{ $sale->user->mobile_number }})
                                        @endif
                                    </td>
                                    <td>
                                        {{ $sale->entry_date->format(config('app.date_format2')) }}
                                    </td>
                                    <td align="right">
                                        {{ \CHTML::customNumberFormat(($sale->total_amount ?? 0), 2) }}
                                    </td>
                                    <td>
                                        {{ !empty($sale->due_date) ? $sale->due_date->format(config('app.date_format2')) : 'N/A' }}
                                    </td>
                                    <td align="right">
                                        {{ \CHTML::customNumberFormat(($sale->due_amount ?? 0), 2) }}
                                    </td>
                                    <td align="center">
                                        {!! \CHTML::paymentStatus($sale->payment_status) !!}
                                    </td>
                                    <td> {{$sale->created_at->format(config('app.date_format2')) }}</td>
                                                                       
                                    <td class=" tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='sales',
                                                $sale->id,
                                                $selectButton=['showButton',/*'editButton','deleteButton'*/],
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
            {!! \CHTML::customPaginate($sales,'') !!}
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('scripts')

@endpush


