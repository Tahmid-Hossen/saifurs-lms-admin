@extends('backend.layouts.master')

@section('title')
    Create/Add Transaction
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-hand-grab-o"></i>
        Transaction
        <small>Sales</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create </h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="portlet-body">
                    {!! \Form::open(['route' => 'transactions.store', 'role' => 'form', 'id' => 'transactions']) !!}

                    @include('backend.sale.transaction.form')

                    {!! \Form::close() !!}
                    <!-- END FORM-->
                    </div>
                    <!-- /.box -->
                </div>
            </div>

        </div>
    </div>
    <!-- END CONTENT -->
@endsection

