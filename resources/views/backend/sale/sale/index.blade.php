@extends('backend.layouts.master')

@section('title')
    Sales
@endsection

@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-dollar"></i>
        Sales
        <small>Control Panel</small>
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
                    <h3 class="box-title">Find Sale</h3>

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
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                {!! \Form::nText('search_text', 'Search: ',($inputs['search_text'] ?? null), false, ['placeholder' => 'Search name, Id , etc...']) !!}
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="col-md-4">
                                {!! \Form::nSelect('company_id', 'Company',$global_companies, ($inputs['company'] ?? null), false, ['placeholder' => 'Company Name', 'class' => 'form-control select2']) !!}
                            </div>
                            @endrole
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                <div class="form-group">
                                    <label for="name" class="control-label">Branch:</label>
                                    <select name="branch_id" id="branch_id" class="form-control">
                                        <option value="">Select Branch</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nText('transaction_id', 'Transaction ID') !!}
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select name="payment_status" type="submit"
                                            class="form-control text-center payment_status_dropdown">
                                        <option value="">Select Status</option>
                                        <option value="partial"
                                                @if(request()->get('payment_status') ==  'partial' ) selected @endif>
                                            Partial
                                        </option>
                                        <option value="paid"
                                                @if(request()->get('payment_status') ==  'paid' ) selected @endif>Paid
                                        </option>
                                        <option value="unpaid"
                                                @if(request()->get('payment_status') ==  'unpaid' ) selected @endif>
                                            Unpaid
                                        </option>
                                        <option value="refunded"
                                                @if(request()->get('payment_status') ==  'refunded' ) selected @endif>
                                            Refunded
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sale Status</label>
                                    <select name="sale_status" type="submit"
                                            class="form-control text-center sale_status_dropdown">
                                        <option value="">Select Status</option>
                                        <option value="pending"
                                                @if(request()->get('sale_status') ==  'pending' ) selected @endif>
                                            Pending
                                        </option>
                                        <option value="processing"
                                                @if(request()->get('sale_status') ==  'processing' ) selected @endif>
                                            Processing
                                        </option>
                                        <option value="completed"
                                                @if(request()->get('sale_status') ==  'completed' ) selected @endif>
                                            Completed
                                        </option>
                                        <option value="canceled"
                                                @if(request()->get('sale_status') ==  'canceled' ) selected @endif>
                                            Canceled
                                        </option>
                                        <option value="refunded"
                                                @if(request()->get('sale_status') ==  'refunded' ) selected @endif>
                                            Refunded
                                        </option>
                                        <option value="refunded"
                                                @if(request()->get('sale_status') ==  'temporary' ) selected @endif>
                                            Temporary
                                        </option>
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
                {!!
                    \CHTML::formTitleBox(
                        $caption="Sales",
                        $captionIcon="fa fa-dollar",
                        $routeName="sales",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr class="text-center">
                                <th class="text-center"> #</th>
                                <th class="text-center"> @sortablelink('entry_date', 'Date')</th>
                                <th class="text-center"> @sortablelink('id', 'Trans. ID')</th>
                                <th class="text-center"> Customer</th>
                                <th class="text-center"> Quantity</th>
                                <th class="text-center">@sortablelink('total_amount', 'Amount')</th>
                                <th class="text-center">Type</th>
                                <th class="text-center"> Payment Status</th>
                                <th class="text-center"> Sale Status</th>
                                <th class="text-center"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sales->firstItem() + $loop->index }}</td>
                                    <td>
                                        {{ $sale->entry_date->format(config('app.date_format2')) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('sales.show',$sale->id ?? $sale->sale_id) }}">
                                            {!! $sale->transaction_id !!}
                                        </a>
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
                                    <td align="right">
                                        {{ \CHTML::numberFormat(($sale->total_items())) }}
                                    </td>
                                    <td align="right">
                                        {{ \CHTML::customNumberFormat(($sale->total_amount ?? 0), 2) }}
                                    </td>
                                    <td class="text-center">
                                        @if($sale->cod_total_amount > 0 && $sale->online_total_amount > 0)
                                            Online & COD
                                        @elseif($sale->cod_total_amount > 0 && $sale->online_total_amount == 0)
                                            COD
                                        @elseif($sale->cod_total_amount == 0 && $sale->online_total_amount > 0)
                                            Online
                                        @endif
                                    </td>
                                    <td>
                                        <form action=" {{ route('payment.status.update',$sale->id) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <select name="payment_status" type="submit"
                                                    class="form-control text-center payment_status_dropdown">
                                                <option value="partial"
                                                        @if($sale->payment_status === 'partial' ) selected @endif>
                                                    Partial
                                                </option>
                                                <option value="paid"
                                                        @if($sale->payment_status === 'paid' ) selected @endif>Paid
                                                </option>
                                                <option value="unpaid"
                                                        @if($sale->payment_status === 'unpaid' ) selected @endif>Unpaid
                                                </option>
                                                <option value="refunded"
                                                        @if($sale->payment_status === 'refunded' ) selected @endif>
                                                    Refunded
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form action=" {{ route('sales.status.update',$sale->id) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <select name="sale_status" type="submit"
                                                    class="form-control text-center sale_status_dropdown">
                                                <option value="pending"
                                                        @if($sale->sale_status === 'pending' ) selected @endif>Pending
                                                </option>
                                                <option value="processing"
                                                        @if($sale->sale_status === 'processing' ) selected @endif>
                                                    Processing
                                                </option>
                                                <option value="completed"
                                                        @if($sale->sale_status === 'completed' ) selected @endif>
                                                    Completed
                                                </option>
                                                <option value="canceled"
                                                        @if($sale->sale_status === 'canceled' ) selected @endif>Canceled
                                                </option>
                                                <option value="refunded"
                                                        @if($sale->sale_status === 'refunded' ) selected @endif>Refunded
                                                </option>
                                                <option value="refunded"
                                                        @if($sale->sale_status === 'temporary' ) selected @endif>
                                                    Temporary
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class=" tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='sales',
                                                $sale->id,
                                                $selectButton=['showButton',/*'editButton',*/'deleteButton'],
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
    <script>
        $('.sale_status_dropdown, .payment_status_dropdown').change(function () {
            $(this).closest('form').submit();
        });
    </script>
@endpush


