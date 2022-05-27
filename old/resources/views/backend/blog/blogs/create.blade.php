@extends('backend.layouts.master')
@section('title')
    Create/Add Blog
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-wordpress"></i>
        Blog
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
                    <form class="horizontal-form" id="blog_form" role="form" method="POST"
                          action="{{ route('blogs.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.blog.blogs.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
@endsection
