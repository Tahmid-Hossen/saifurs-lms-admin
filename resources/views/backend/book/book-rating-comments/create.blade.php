@extends('backend.layouts.master')
@section('title')
    Create/Add Branch
@endsection

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

    @section('content')
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.flash')
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create </h3>&nbsp;<span
                            class="text-danger"></span>
                    </div>
                    <form class="horizontal-form" id="book_rating_comment_form" role="form" method="POST"
                          action="{{ route('book-rating-comments.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.book.book-rating-comments.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function () {
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
@endpush
