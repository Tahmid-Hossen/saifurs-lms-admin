@extends('backend.layouts.master')

@section('title')
    Edit/Update Book
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-book"></i>
        Books
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
                {!! \Form::open(['route' => ['books.update',$book->book_id], 'id' => 'books_form', 'files' => true, 'role' => 'form', 'method' => 'put']) !!}
                @include('backend.book.book.form')
                {!! \Form::close() !!}
                <!-- /.box -->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
