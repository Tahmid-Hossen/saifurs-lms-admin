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
                <form class="horizontal-form" id="state_form" role="form" method="POST" action="{{ route('states.store') }}" enctype="multipart/form-data">
                   @csrf
                    @include('backend.setting.states.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            jQuery.validator.addMethod("noSpace", function(value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

            $("state_form").validate({
                rules: {
                    state_name: {
                        required: true
                    },
                    country_id: {
                        required: true
                    }
                }
            });
        });
    </script>
@endsection
