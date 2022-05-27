@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-file-text"></i>
        Course Category
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Course Category</h3>
                    <div class="pull-right">
                        <a
                            href="{{route('course-categories.index')}}"
                            class="btn btn-danger hidden-print">
                            <i class="glyphicon glyphicon-hand-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        @if(auth()->user()->userDetails->company_id == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Company</label>
                                    <p>{{ $courseCategory->company->company_name ?? null }}</p>
                                </div>
                            </div>
                        @endif
                        {{-- @if(auth()->user()->userDetails->company_id == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Branch</label>
                                    <p>{{ $courseCategory->branch->branch_name ?? null }}</p>
                                </div>
                            </div>
                        @endif --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <p>{{ $courseCategory->course_category_title }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Featured</label>
                                <p>{{ $courseCategory->course_category_featured }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <p>{{ $courseCategory->course_category_status }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group border-dark">
                                <label class="control-label">Description</label>
                                <p>{!!  $courseCategory->course_category_details !!}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="container img-thumbnail text-center" style="margin-top: 20px">
                                <img
                                    src="{{ asset($courseCategory->course_category_image ?? "assets/img/default.png") }}"
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
