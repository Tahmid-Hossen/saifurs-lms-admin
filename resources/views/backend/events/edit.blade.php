@extends('backend.layouts.master')

@section('title')
    Edit Event
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-graduation-cap"></i>
        Event
        <small>Edit</small>
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
                    <!-- form start -->
                    <form class="horizontal-form" id="event_form" role="form" method="POST"
                        action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.events.form')
                    </form>
                    <!-- form end -->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    @endsection
