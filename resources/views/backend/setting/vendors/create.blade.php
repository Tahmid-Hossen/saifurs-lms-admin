@extends('backend.layouts.master')
@section('title')
    CEdit/Update Vendor
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
                        <h3 class="box-title">Create </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="vendor_form" role="form" method="POST" action="{{ route('vendors.store') }}" enctype="multipart/form-data">
                       @csrf
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
        $("#vendor_form").validate({
            rules: {
                vendor_name: {
                    required: true
                },
                vendor_logo: {
                    required: true,
                    extension: "jpg|jpeg|png|ico|bmp|svg"
                }
            }
        });
    });
</script>
@endpush
