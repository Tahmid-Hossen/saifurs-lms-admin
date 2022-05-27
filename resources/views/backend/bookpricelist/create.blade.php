@extends('backend.layouts.master')

@section('title')
    Create/Add Book Price List
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
                        <h3 class="box-title">Create </h3>&nbsp;<span
                            class="text-danger"></span>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="book_price_form" role="form" method="POST"
                          action="{{ route('bookpricelist.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.bookpricelist.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
@endsection
