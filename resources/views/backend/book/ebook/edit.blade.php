@extends('backend.layouts.master')

@section('title')
    Edit/Update EBook
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
                        <h3 class="box-title">Edit/Update </h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="portlet-body">
                    {!! \Form::open(['route' => ['ebooks.update',$ebook->book_id], 'files' => true,
                                    'role' => 'form', 'method' => 'put', 'id' => 'ebooks_form']) !!}
                    @include('backend.book.ebook.form')
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
