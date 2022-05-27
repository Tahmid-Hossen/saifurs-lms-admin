@extends('backend.layouts.master')

@section('title')
    Create/Add Book
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-book"></i>
        Book
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
                {!! \Form::open(['route' => 'books.store', 'files' => true, 'role' => 'form', 'id' => 'books_form', 'accept-charset' => null]) !!}
                @include('backend.book.book.form')
                {!! \Form::close() !!}
                <!-- /.box -->
                </div>
            </div>

        </div>
    </div>
    <!-- END CONTENT -->
@endsection
