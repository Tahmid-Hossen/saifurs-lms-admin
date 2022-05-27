@extends('backend.layouts.master')

@section('title')
    Edit Banner
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-picture-o"></i>
        Banner
        <small>Create</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="page-content-wrapper">
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update </h3>&nbsp;<span style="color: #dd4b39; font-weight:700">(All '*'
                                fields are required)</span>
                    </div>
                    <div class="portlet-body">
                        <!-- form start -->
                        <form class="horizontal-form" role="form" method="POST"
                            action="{{ route('banners.update', $banner->id) }}" id="banner_form"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('backend.banners.form')
                        </form>
                        <!-- form end -->
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END CONTENT -->
@endsection
