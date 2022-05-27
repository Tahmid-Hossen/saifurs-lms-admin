@extends('backend.layouts.master')
@section('title')
    Create/Add Branch
@endsection
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    @section('content-header')
        <h1>
            <i class="fa fa-building"></i>
            Branch
            <small>Control Panel</small>
        </h1>
        {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
    @endsection

    @section('content')
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.flash')
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create </h3>
                    </div>
                    <form class="horizontal-form" id="branch_form" role="form" method="POST"
                          action="{{ route('branches.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.user.branches.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
        <script>
            $(document).ready(function () {
                $("#branch_form").validate({
                    rules: {
                        company_id: {
                            required: true
                        },
                        branch_name: {
                            required: true,
                            alphanumeric: true
                        },
                        branch_email: {
                            email: true
                        },
                        city_id: {
                            required: true
                        },
                        state_id: {
                            required: true
                        },
                        country_id: {
                            required: true
                        },
                        branch_mobile: {
                            required: true,
                            digits: true,
                            minlength: 11,
                            maxlength: 11
                        },
                        branch_phone: {
                            required: true,
                            digits: true,
                            minlength: 9,
                            maxlength: 11
                        }
                    }
                });
            });
        </script>
@endsection
