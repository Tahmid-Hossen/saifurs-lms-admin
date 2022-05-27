@extends('backend.layouts.master')
@section('title')
    Update Book Price List
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
      Book Price List
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
                    <form class="horizontal-form" id="book_price_form" role="form" method="POST"
                          action="{{ route('bookpricelist.update',$bookpricelist->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.bookpricelist.form')
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
            $("#book_price_form").validate({
                rules: {
                    book_name: {
                        required: true,
                    },
                    cover_price: {
                        min: 1,
                        number: true
                    },
                    retail_price: {
                        min: 1,
                        number: true
                    },
                    wholesale: {
                        min: 1,
                        number: true
                    }

                },
            });
        });
    </script>
    @endpush

