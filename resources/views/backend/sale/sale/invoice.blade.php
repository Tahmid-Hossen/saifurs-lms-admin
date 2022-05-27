@extends('backend.layouts.master')

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
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Sale Details</h3>
                    <div class="pull-right">
                        <a onclick="printInvoice(this);" class="btn btn-info hidden-print">
                            <i class="fa fa-print"></i>
                            Print
                        </a>
                        <a href="{{route('sales.show', $sale->id)}}"
                           class="btn btn-danger hidden-print">
                            <i class="glyphicon glyphicon-hand-left"></i> Back
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('backend.layouts.flash')

                    <section class="invoice">

                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <i class="fa fa-globe"></i> {!! auth()->user()->userDetails->company->company_name !!}
                                    .
                                    <small
                                        class="pull-right">Date: {!! $sale->entry_date->format(config('app.date_format2')) !!}</small>
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>{!! auth()->user()->userDetails->company->company_name !!}.</strong><br>
                                    {!! auth()->user()->userDetails->company->company_address !!}<br>
                                    Phone: {!! auth()->user()->userDetails->company->company_phone !!}<br>
                                    Email: {!! auth()->user()->userDetails->company->company_email !!}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>
                                        {!! $sale->customer_name ?? $sale->user->name !!}
                                    </strong>
                                    <br>
                                    {!! $sale->customer_address ??  $sale->user->userDetails->mailing_address !!}<br>

                                    Phone: {!! $sale->customer_phone  ??  $sale->user->mobile_number !!} <br>
                                    Email: {!! $sale->customer_email ??  $sale->user->email !!}<br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>Transaction ID: </b>{!! $sale->transaction_id !!}<br><br>
                                <b>Payment Status: </b><label class="label
                                    @if($sale->payment_status == 'full')
                                    label-success
@elseif($sale->payment_status == 'partial')
                                    label-warning
@elseif($sale->payment_status == 'due')
                                    label-danger
@else
                                    label-default
@endif
                                    ">
                                    {{ \Utility::$paymentStates[$sale->payment_status] }}
                                </label><br><br>
                                <b>Due Date: </b> @if(!is_null($sale->due_date))
                                    {{ \Carbon\Carbon::parse($sale->due_date)->format(config('app.date_format2')) }}
                                @else
                                    N/A
                                @endif
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Delivery Type</th>
                                        <th class="text-center">Price</th>
                                        <th></th>
                                        <th class="text-center">Quantity</th>
                                        <th></th>
                                        <th class="text-center">Sub Total</th>
                                        <th></th>
                                        <th class="text-center">Discount</th>
                                        <th></th>
                                        <th class="text-center">Amount</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($sale->items as $si => $item)
                                        <tr>
                                            <td class="text-right">{{ ++$si }}</td>
                                            <td class="text-bold"
                                                title="{{ $item->item_type }}">{{ $item->item_name }}</td>
                                            <td class="text-left">
                                                {{ ($item->delivery_type =='cod') ?  'Cash On Delivery' : 'Online' }}
                                            </td>
                                            <td class="text-right">{{ number_format($item->price_amount, 2,'.',',') }}</td>
                                            <td class="text-center">X</td>
                                            <td class="text-right">{{ round($item->quantity) }}</td>
                                            <td class="text-center">=</td>
                                            <td class="text-right">{{ number_format($item->sub_total_amount, 2,'.',',') }}</td>
                                            <td>-</td>
                                            <td class="text-right">{{ number_format($item->discount_amount, 2,'.',',') }}</td>
                                            <td>=</td>
                                            <td class="text-right">{{ number_format($item->total_amount, 2,'.',',') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11">No Items Available</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-xs-6">
                                <p class="lead">Payment Methods:</p>
                                {{--<img src="{{ asset('assets/dist/img/credit/visa.png') }}" alt="Visa">
                                <img src="{{ asset('assets/dist/img/credit/mastercard.png') }}" alt="Mastercard">
                                <img src="{{ asset('assets/dist/img/credit/american-express.png') }}" alt="American Express">
                                <img src="{{ asset('assets/dist/img/credit/paypal2.png') }}" alt="Paypal">

                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                                    plugg
                                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                </p>--}}
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ number_format($sale->sub_total_amount, 2,'.',',') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount</th>
                                            <td>
                                                {{ number_format($sale->discount_amount, 2,'.',',') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Shipping Cost</th>
                                            <td>
                                                {{ number_format($sale->shipping_cost, 2,'.',',') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ number_format($sale->total_amount, 2,'.',',') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Due Amount:</th>
                                            <td>{{ number_format($sale->due_amount, 2,'.',',') }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/printThis/printThis.js') }}"></script>
    <script>
        function printInvoice(element) {
            $('.invoice').printThis({
                importCSS: true,
                header: "<h2 style='text-align: center'>Invoice</h2>"
            });
        }
    </script>
@endpush
