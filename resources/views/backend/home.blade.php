@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-book"></i>
        Dashboard
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    @include('backend.layouts.partials.errors')
    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                        {!! auth()->user()->default_language !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
