@extends('backend.layouts.master')

@section('title')
    Manage Event Joins
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-graduation-cap"></i>
        Event Join
        <small>Control Panel</small>
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
                    <form class="horizontal-form" id="event_register_form" role="form" method="POST"
                        action="{{ route('events-registration.store') }}">
                        @csrf
                        @include('backend.events-users.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    @endsection
