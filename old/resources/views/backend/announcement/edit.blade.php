@extends('backend.layouts.master')
@section('title')
    Edit/Update Announcement
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-bullhorn"></i>
        Announcement
        <small>Control panel</small>
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
                    <!-- form start -->
                    <div class="portlet-body">
                        <form class="horizontal-form" role="form" method="POST"
                            action="{{ route('announcements.update', $announcement->id) }}" id="announcement_form">
                           @csrf
                            @method('PUT')
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
