@extends('backend.layouts.master')
@section('title')
    Create/Add Vendor
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-building"></i>
                Vendor
                <small>Control Panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit/Update </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="vendor_form" role="form" method="POST" action="{{ route('vendors.update', $vendor->id) }}" enctype="multipart/form-data">
                       @csrf
                        @method('PUT')
                        @include('backend.setting.vendors.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $("#vendor_logo").change(function() {
            imageIsLoaded(this, 'vendor_logo_show');
        });
        jQuery.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "No space please and don't leave it empty");

        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
        }, "Letters and numbers only please");

        $("state_form").validate({
            rules: {
                vendor_name: {
                    required: true
                },
                vendor_logo: {
                    extension: "jpg|jpeg|png|ico|bmp|svg"
                }
            }
        });
    });
</script>
@endpush
