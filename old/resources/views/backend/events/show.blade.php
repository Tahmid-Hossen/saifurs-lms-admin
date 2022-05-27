@extends('backend.layouts.master')
@section('title')
    Detail/Show Event
@endsection

@section('content-header')
    <h1><i class="fa fa-graduation-cap"></i>Event</h1>
    <p>{!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}</p>
@endsection

@section('content')
    <div class="page-content-wrapper">
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="box-title"><small>Full Detailed View of the Event</small></h2>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!! \CHTML::actionButton($reportTitle = '..', $routeLink = '#', $event->id, $selectButton = ['backButton', 'editButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'no', $othersPram = []) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#event_deatils_initials" data-toggle="tab">Event's Initials</a>
                                </li>
                                <li><a href="#event_deatils_promo" data-toggle="tab">Event's Promo Banner</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="event_deatils_initials">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Event Title:</label>
                                                    <p>{{ $event->event_title }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @if (auth()->user()->userDetails->company_id == 1)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Company:</label>
                                                        <p class="">{{ isset($event->company)?$event->company->company_name:null }}</p>
                                                    </div>
                                                </div>
                                                @if (isset($event->branch->branch_name))
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Branch:</label>
                                                            <p>{{ $event->branch->branch_name }}</p>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="branch_id" class="control-label">Branch:</label>
                                                            <p>Available for all Branches</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Event Type</label>
                                                    <p>
                                                    @if ($event->event_type == 'review') Book Review @else
                                                            Course Announcement @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Event Joining URL</label>
                                                    <p>
                                                        <span class="text-primary text-bold">
                                                            {{ $event->event_link }}
                                                        </span>
                                                        <button type="button" id="event_url_copy"
                                                            class="btn btn-primary btn-xs pull-right" data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-clipboard-text="{{ isset($event) ? $event->event_link : null }}"
                                                            title="Copy Link" onclick="copyLinkFromButton('#'+this.id)">
                                                            <i class="fa fa-copy"></i>
                                                        </button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Event Starts</label>
                                                    <p class="text-success text-bold">
                                                        {!! \Utility::getDateTimeHuman(\Carbon\Carbon::parse($event->event_start)) !!}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Event Ends</label>
                                                    <p class="text-success text-bold">
                                                        {!! \Utility::getDateTimeHuman(\Carbon\Carbon::parse($event->event_end)) !!}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Event Duration</label>
                                                    <p>{!! \Utility::getTimeRangeHuman(\Carbon\Carbon::parse($event->event_start), \Carbon\Carbon::parse($event->event_end)) !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="event_schedule">Event Featured</label>
                                                    <p>{{ $event->event_featured }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="event_schedule">Event Status</label>
                                                    <p>{{ $event->event_status }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="event_deatils_promo">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Event Banner</label>
                                                    <img src="{{ $event->event_image_full_path }}"
                                                        class="img-responsive img-thumbnail" style="display: block">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Event Description</label>
                                                    <div class="description-box">
                                                        {!! html_entity_decode($event->event_description) !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
