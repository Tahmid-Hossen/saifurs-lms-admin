@extends('backend.layouts.master')
@section('title')
    Update Google Map Api Key
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        Google Map Api Key
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
                        <h3 class="box-title">Edit </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="googleApiKey_form" role="form" method="POST"
                          action="{{ route('googleApiKey.update',$googleApiKey->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.googleApiKey.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection

@push('old-scripts')
    <script>
        $(document).ready(function () {
            $("#googleApiKey_form").validate({
                rules: {
                    google_api_key: {
                        required: true,
                    }
                },
            });
        });
    </script>
    @endpush

