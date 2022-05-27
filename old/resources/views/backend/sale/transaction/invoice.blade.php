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
    @include('backend.layouts.flash')
    <section class="invoice">

        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> {!! auth()->user()->userDetails->company->company_name !!}.
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
                        @if(is_null($sale->user_id))
                            <b>{!! $sale->customer_name !!}</b>
                        @else
                            <b>{!! $sale->user->name !!}</b>
                        @endif
                    </strong>
                    <br>
                    @if(is_null($sale->user_id))
                        {!! $sale->customer_address !!}
                    @else
                        {!! $sale->user->userDetails->mailing_address !!}
                    @endif
                    Phone: @if(is_null($sale->user_id))
                        {!! $sale->customer_phone !!}
                    @else
                        {!! $sale->user->mobile_number !!}
                    @endif<br>
                    Email: @if(is_null($sale->user_id))
                        {!! $sale->customer_email !!}
                    @else
                        {!! $sale->user->email !!}
                    @endif
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice ID: INV{!! $sale->reference_number !!}</b><br>
                <br>
                <b>System ID:</b> INV-{{
                    \Str::padLeft(auth()->user()->userDetails->company_id, '5', '0') . '-' .
                    \Str::padLeft(auth()->user()->userDetails->branch_id, '3', '0') . '-'.
                    \Str::padLeft($sale->sale_id, '6', '0')
                }}
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
                        <th class="text-center">Item</th>
                        <th class="text-center">Quantity</th>
                        <th></th>
                        <th class="text-center">Price</th>
                        <th></th>
                        <th class="text-center">Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($sale->items as $si => $item)
                        <tr>
                            <td class="text-right">{{ ++$si }}</td>
                            <td class="text-bold">{{ $item->book_name }}</td>
                            <td class="text-right">{{ round($item->quantity) }}</td>
                            <td class="text-center">X</td>
                            <td class="text-right">{{ number_format($item->price, 2,'.',',') }}</td>
                            <td class="text-center">=</td>
                            <td class="text-right">{{ number_format($item->total, 2,'.',',') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No Items Available</td>
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
                <img src="{{ asset('assets/dist/img/credit/visa.png') }}" alt="Visa">
                <img src="{{ asset('assets/dist/img/credit/mastercard.png') }}" alt="Mastercard">
                <img src="{{ asset('assets/dist/img/credit/american-express.png') }}" alt="American Express">
                <img src="{{ asset('assets/dist/img/credit/paypal2.png') }}" alt="Paypal">

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead">Amount Due 2/22/2014</p>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>{{ number_format($sale->amount, 2,'.',',') }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>
                                @php $discount = (($sale->discount_amount/100) * $sale->amount); @endphp
                                {{ number_format($discount, 2,'.',',') }}
                                ({{ $sale->discount_amount }}%)
                            </td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>{{ number_format($sale->total, 2,'.',',') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a onclick="printInvoice(this);" class="btn btn-info btn-block">
                    <i class="fa fa-print"></i>
                    Print
                </a>
            </div>
        </div>

    </section>
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
