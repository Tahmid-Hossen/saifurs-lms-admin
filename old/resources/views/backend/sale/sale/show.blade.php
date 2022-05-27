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
                        <form action="{{ route('sales.update-field', $sale->id) }}" method="post" class="form-inline">
                            @csrf @method('put')
                            <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-primary text-bold ">
                                <i class="fa fa-list"></i>
                                Invoice
                            </a>
                            @if($sale->online_total_amount > 0)
                            <a href="{{ route('transactions.status', $sale->transaction_id) }}"
                               class="btn btn-info text-bold ">
                                <i class="fa fa-check"></i>
                                Trans. Details
                            </a>
                            @endif
                            @if($sale->cod_total_amount > 0 && $sale->due_amount > 0)
                                <input type="hidden" name="payment_status" value="paid">
                                <input type="hidden" name="due_amount" value="0">
                                <input type="hidden" name="sale_status" value="completed">
                                <button type="submit" class="btn btn-success text-bold ">
                                    <i class="fa fa-paypal"></i>
                                    COD Payment Approval
                                </button>
                            @endif
                            <a href="{{route('sales.index')}}"
                               class="btn btn-danger hidden-print">
                                <i class="glyphicon glyphicon-hand-left"></i> Back
                            </a>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        @role(\Utility::SUPER_ADMIN)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Company:</label>
                                <p class="">{{ $sale->company->company_name ?? ''}}</p>
                            </div>
                        </div>
                        @endrole

                        <div class="@role(\Utility::SUPER_ADMIN) col-md-6 @else col-md-12 @endrole">
                            <div class="form-group">
                                <label class="control-label">Branch:</label>
                                <p>{{ $sale->branch->branch_name ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Customer:</label>
                                <p>{{ $sale->customer_name  ?? $sale->user->name }}</p>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Contact:</label>
                                <p>
                                    <b>Phone: </b>{{ $sale->customer_phone ?? $sale->user->mobile_number }}<br>
                                    <b>Email: </b>{{ $sale->customer_email ?? $sale->user->email }}<br>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Transaction Number:</label>
                                <p class="">{{ $sale->transaction_id }}</p>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date:</label>
                                <p>{{ $sale->entry_date->format(config('app.date_format2')) }}</p>
                            </div>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Address:</label>
                                <p>{{ $sale->address }}</p>
                            </div>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-hover">
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
                                        <td class="text-bold" title="{{ $item->item_type }}">{{ $item->item_name }}</td>
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
                                <tfoot>
                                <tr>
                                    <td class="text-right" colspan="10">Sub Total</td>
                                    <td class="text-center">=</td>
                                    <td class="text-bold text-right">{{ number_format(($sale->sub_total_amount ?? 0.0), 2, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold vcenter" colspan="10">Shipping Cost</td>
                                    <td class="text-center">=</td>
                                    <td class="text-right" colspan="2">
                                        {{ number_format($sale->shipping_cost, 2,'.',',') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-right text-bold vcenter" colspan="10">Coupon Discount (-)</td>
                                    <td class="text-center">=</td>
                                    <td class="text-right" colspan="3">
                                        {{ number_format($sale->discount_amount, 2,'.',',') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold vcenter" colspan=10">Total Price</td>
                                    <td class="text-center">=</td>
                                    <td class="text-right" colspan="3">
                                        {{ number_format($sale->total_amount, 2,'.',',') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right text-bold vcenter" colspan="10">Due Amount</td>
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
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
