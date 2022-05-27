@extends('backend.layouts.master')
@section('title')
    Edit/Update Category
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-list-alt"></i>
        Category
        <small>Book</small>
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
                    <form class="horizontal-form" role="form" method="POST" id="category_form"
                          action="{{ route('categories.update',$category->book_category_id) }}">
                       @csrf
                        @method('PUT')
                        @include('backend.book.category.form')
                    </form>
                    <!-- END FORM-->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
