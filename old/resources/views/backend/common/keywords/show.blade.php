@extends('backend.layouts.master')

@section('content')

@section('content-header')
    <h1>
        <i class="fa fa-list-alt"></i>
        Category
        <small>Book</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@include('backend.layouts.flash')
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Details</h3>
                <div class="pull-right">
                    <a
                        href="{{route('categories.index')}}"
                        class="btn btn-danger hidden-print">
                        <i class="glyphicon glyphicon-hand-left"></i> Back
                    </a>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="row">
                    <label class="col-md-3">
                        Category Title
                    </label>
                    <p class="col-md-8 font-green sbold uppercase">{{$category->book_category_name}}</p>
            </div>
            <!-- /.box-body -->
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection
