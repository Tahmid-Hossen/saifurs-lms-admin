@extends('backend.layouts.master')
@section('title')
    Edit/Update Book Rating Comment
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-building"></i>
                Book Rating Comment
                <small>Control Panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit</h3>&nbsp;<sub class="text-danger text-sm-right"><i></i></sub>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="book_rating_comment_form" role="form" method="POST" action="{{ route('book-rating-comments.update', $bookRatingComment->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        @include('backend.book.book-rating-comments.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            jQuery.validator.addMethod("noSpace", function (value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

            $("#book_rating_comment_form").validate({
                rules: {
                    book_id: {
                        required: true
                    },
                    book_rating: {
                        min: 0,
                        max: 5
                    }
                }
            });
        });
    </script>
@endsection
