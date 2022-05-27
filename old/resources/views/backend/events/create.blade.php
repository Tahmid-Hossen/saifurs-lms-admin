@extends('backend.layouts.master')

@section('title')
    Manage Event
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-graduation-cap"></i>
        Event
        <small>Manage</small>
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
                        <h3 class="box-title">Create </h3>&nbsp;<span style="color: #dd4b39; font-weight:700">(All '*'
                            fields are required)</span>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="event_form" role="form" method="POST"
                        action="{{ route('events.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.events.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    @endsection
