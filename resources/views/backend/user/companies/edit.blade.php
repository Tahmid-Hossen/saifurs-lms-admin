@extends('backend.layouts.master')
@section('title')
    Edit/Update Company
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Company
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
                        <h3 class="box-title">Edit/ Update </h3>
                    </div>
                    <!-- /.box-header -->
                <form class="horizontal-form" id="company_form" role="form" method="POST" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data">
                   @csrf
                    @method('PUT')
                    @include('backend.user.companies.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
