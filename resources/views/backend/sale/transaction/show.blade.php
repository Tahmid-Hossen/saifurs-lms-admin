@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-dollar"></i>
        Sale
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Sale Details</h3>
                    <div class="pull-right">
                        <a href="{{route('sales.index')}}"
                           class="btn btn-danger hidden-print">
                            <i class="glyphicon glyphicon-hand-left"></i> Back
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if(auth()->user()->userDetails->company_id == 1)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Company:</label>
                                    <p class="">{{ $sale->company->company_name ?? ''}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Branch:</label>
                                    <p>{{ $sale->branch->branch_name ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Invoice Number:</label>
                                <p class="">INV{{ $sale->reference_number ?? ''}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date:</label>
                                <p>{{ $sale->entry_date->format(config('app.date_format2')) }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Payment Status:</label>
                                <p><label class="label
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
                                    </label></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Customer:</label>
                                <p>@if(is_null($sale->user_id))
                                        <b>{{ $sale->customer_name }}</b>
                                    @else
                                        <b>{{ $sale->user->name }}</b>
                                    @endif</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Contact:</label>
                                <p>@if(is_null($sale->user_id))
                                        <b>Phone: {{ $sale->customer_phone }}</b><br>
                                        <b>Email: {{ $sale->customer_email }}</b><br>
                                    @else
                                        <b>Phone: {{ $sale->user->mobile_number }}</b><br>
                                        <b>Email: {{ $sale->user->email }}</b><br>
                                    @endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Address:</label>
                                <p>{{ $sale->address }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Quantity</th>
                                    <th></th>
                                    <th class="text-center">Price (BDT)</th>
                                    <th></th>
                                    <th class="text-center">Amount (BDT)</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($sale->items as $si => $item)
                                    <tr>
                                        <td class="text-right">{{ ++$si }}</td>
                                        <td class="text-bold">{{ $item->item_name }}</td>
                                        <td class="text-left">{{ $item->item_type }}</td>
                                        <td class="text-right">{{ round($item->quantity) }}</td>
                                        <td class="text-center">X</td>
                                        <td class="text-right">{{ number_format($item->price_amount, 2,'.',',') }}</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right">{{ number_format($item->total_amount, 2,'.',',') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No Items Available</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="text-right text-bold vcenter" colspan="5">Sub Total</td>
                                    <td class="text-center">=</td>
                                    <td class="text-right" colspan="2">
                                        {{ number_format($sale->sub_total_amount, 2,'.',',') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold vcenter" colspan="5">Discount (-)</td>
                                    <td class="text-center">=</td>
                                    <td class="text-right" colspan="2">
                                        {{ number_format($sale->discount_amount, 2,'.',',') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold vcenter" colspan="5">Grand Total</td>
                                    <td class="text-center">=</td>
                                    <td class="text-right" colspan="2">
                                        {{ number_format($sale->total_amount, 2,'.',',') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold vcenter" colspan="5">Due Amount</td>
                                    <td class="text-center">=</td>
                                    <td class="text-right" colspan="2">
                                        {{ number_format($sale->due_amount, 2,'.',',') }}
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-primary text-bold">
                                <i class="fa fa-list"></i>
                                Invoice
                            </a>
                            <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-success text-bold pull-right">
                                <i class="fa fa-paypal"></i>

                                Submit Payment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

@endsection
