@extends('backend.layouts.master')
@section('title')
Detail/Show Banner
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Banner
        <small>Control panel</small>
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
                    <h3 class="box-title">Detail</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            {!! \CHTML::actionButton($reportTitle = '..', $routeLink = '#', $data->id, $selectButton = ['backButton', 'editButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'no', $othersPram = []) !!}
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Banner Title</label><br>
                                {{$data->banner_title ?? null}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Banner Image</label><br>
                                <img src="{{''.$data->banner_image  ?? null}}" style="width: 50%; height:auto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
@endsection
