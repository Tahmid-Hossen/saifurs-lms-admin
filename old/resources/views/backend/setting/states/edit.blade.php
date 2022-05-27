@extends('backend.layouts.master')
@section('title')
    Create/Add State
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-map-marker"></i>
        State
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="state_form" role="form" method="POST"
                          action="{{ route('states.update', $state->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.setting.states.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
@endsection
