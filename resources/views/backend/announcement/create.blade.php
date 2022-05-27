@extends('backend.layouts.master')

@section('title')
    Create/Add Announcement
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-bullhorn"></i>
        Announcement
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
                    <!-- form start -->
                    <div class="portlet-body">
                        <form class="horizontal-form" id="announcement_form" role="form" method="POST"
                            action="{{ route('announcements.store') }}">
                           @csrf
                            @include('backend.announcement.form')
                        </form>
                        <!-- END FORM-->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
