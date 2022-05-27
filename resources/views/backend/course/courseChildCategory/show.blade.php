@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-list-alt"></i>
        Course Child Category
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection
@include('backend.layouts.flash')
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Course Child Category</h3>
                <div class="pull-right">
                    <a
                        href="{{route('course-child-categories.index')}}"
                        class="btn btn-danger hidden-print">
                        <i class="glyphicon glyphicon-hand-left"></i> Back
                    </a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    @if(auth()->user()->userDetails->company_id == 1)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Company</label>
                                <p>{{ $course_child_category->company->company_name ?? null }}</p>
                            </div>
                        </div>
                    @endif
                    {{-- @if(auth()->user()->userDetails->company_id == 1)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Branch</label>
                                <p>{{ $course_child_category->branch->branch_name ?? null }}</p>
                            </div>
                        </div>
                    @endif --}}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <p>{{ $course_child_category->courseCategory->course_category_title ?? null }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Sub Category</label>
                            <p>{{ $course_child_category->courseSubCategory->course_sub_category_title ?? null }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <p>{{ $course_child_category->course_child_category_title ?? null }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Featured</label>
                            <p>{{ $course_child_category->course_child_category_featured ?? null }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <p>{{ $course_child_category->course_child_category_status ?? null }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group border-dark">
                            <label class="control-label">Description</label>
                            <p>{!!  $course_child_category->course_child_category_details ?? null !!}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="container img-thumbnail text-center" style="margin-top: 20px">
                            <img
                                src="{{ asset($course_child_category->course_sub_category_image ?? "assets/img/default.png") }}"
                                id="preview_img" alt="course image" class="img-responsive"
                                style="display: inline-block; height: 178px"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
