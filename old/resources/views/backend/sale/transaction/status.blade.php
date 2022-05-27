@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-dollar"></i>
        Sale
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName(), $transaction_id) !!}
@endsection

@section('content')
    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Transaction Details</h3>
                    <div class="pull-right">
                        <a href="{{ \URL::previous() }}" class="btn btn-danger hidden-print">
                            <i class="glyphicon glyphicon-hand-left"></i> Back
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Status</th>
                            <td>{{ ($transaction_response['status']) ? 'Received' : 'Failed' }}</td>
                            <th>Message</th>
                            <td>{{ isset($transaction_response['message']) ? $transaction_response['message'] : null }}</td>
                        </tr>
                    </table>
                    @if(isset($transaction_response['output']))
                        @if(isset($transaction_response['output']->no_of_trans_found)
                            && $transaction_response['output']->no_of_trans_found >= 1)
                            @foreach($transaction_response['output']->element as $index => $transaction)
                                <table style="margin-top: 1rem" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">Transaction Details #{{$index +1}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transaction as $property => $value)
                                        <tr>
                                            <th>{{ ucwords(str_replace('_', ' ', $property)) }}</th>
                                            <td>{!! $value !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
