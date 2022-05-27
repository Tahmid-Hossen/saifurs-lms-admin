@extends('backend.layouts.master')
@section('title')
    Detail/Show Branch Location
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Branch Location
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
                        <h3 class="box-title">Detail</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!!
                                    \CHTML::actionButton(
                                        $reportTitle='..',
                                        $routeLink='#',
                                        $branchlocation->id,
                                        $selectButton=['backButton','editButton'],
                                        $class = ' btn-icon btn-circle ',
                                        $onlyIcon='no',
                                        $othersPram=array()
                                    )
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_name" class="control-label">Branch Name</label><br>
                                    {{isset($branchlocation)?$branchlocation->branch_name:null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_name" class="control-label">Manager Name</label><br>
                                    {{isset($branchlocation)?$branchlocation->manager_name:null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="branch_address" class="control-label">Address English</label><br>
                                    {{isset($branchlocation)?$branchlocation->address_en:null}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="branch_address" class="control-label">Address Bangla</label><br>
                                    {{isset($branchlocation)?$branchlocation->address_bn:null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_phone" class="control-label">Email</label><br>
                                    {{isset($branchlocation)?$branchlocation->email:null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_phone" class="control-label">Phone</label><br>
                                    {{isset($branchlocation)?$branchlocation->phone:null}}
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Status: </label>
                                @if($branchlocation->status == 'ACTIVE')
                                    <button
                                        class="btn btn-success btn-sm">{{$branchlocation->status}}</button>
                                @else
                                    <button
                                        class="btn btn-danger btn-sm">{{ str_replace("-","",$branchlocation->status) }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
@endsection
