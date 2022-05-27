@extends('backend.layouts.master')

@section('title')
    Create/Add EBook
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-address-book"></i>
        EBook
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
                        <h3 class="box-title">Create </h3>&nbsp;<span
                            class="text-danger"></span>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                {!! \Form::open(['route' => 'ebooks.store', 'files' => true, 'role' => 'form', 'id' => 'ebooks_form']) !!}
                @include('backend.book.ebook.form')
                {!! \Form::close() !!}
                <!-- END FORM-->
                </div>
                <!-- /.box -->
            </div>
        </div>

    </div>
    <!-- END CONTENT -->
@endsection

