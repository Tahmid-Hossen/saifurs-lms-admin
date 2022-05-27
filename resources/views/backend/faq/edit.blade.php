@extends('backend.layouts.master')
@section('title')
    Update Faq Information
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        FAQ
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
                    <form class="horizontal-form" id="faq_form" role="form" method="POST"
                          action="{{ route('faq.update',$faq->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.faq.form')
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
            $("#faq_form").validate({
                rules: {
                    question: {
                        required: true,
                    },
                    answer: {
                        required: true,
                    }
                },
            });
        });
    </script>
    @endpush

