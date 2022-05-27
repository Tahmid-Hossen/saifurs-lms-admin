@extends('backend.layouts.master')

@section('title')
    Create/Add Sale
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-dollar"></i>
        Sale
        <small>Control Panel</small>
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
                    {!! \Form::open(['route' => 'sales.store', 'role' => 'form', 'id' => 'sales']) !!}
                    @include('backend.sale.sale.form')
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

