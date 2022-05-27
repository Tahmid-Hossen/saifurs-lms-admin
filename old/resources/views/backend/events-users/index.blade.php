@extends('backend.layouts.master')
@section('title')
    Events
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-graduation-cap"></i>
        Event Users
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection
@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Events</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route('events.pdf', [
                                'search_text' => $request->get('search_text'),
                                'event_type' => $request->get('event_type'),
                                'event_featured' => $request->get('event_featured'),
                                'event_status' => $request->get('event_status')
                            ]) !!}">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route('events.excel', [
                                'search_text' => $request->get('search_text'),
                                'event_type' => $request->get('event_type'),
                                'event_featured' => $request->get('event_featured'),
                                'event_status' => $request->get('event_status')
                            ]) !!}">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('events.index') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search Text</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}"
                                           placeholder="Insert a Text to Search Below">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="event_type" class="control-label">Event Type</label>
                                    <select name="event_type" id="event_type" class="form-control">
                                        <option value="">== Choose an Option ==</option>
                                        @foreach (\Utility::$eventType as $key => $type)
                                            <option value="{{ $key }}"
                                                    @if (old('event_type', isset($request) ? $request->event_type : null) == $key) selected @endif>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="event_featured" class="control-label">Featured ?</label>
                                    <select name="event_featured" id="event_featured" class="form-control">
                                        <option value="">== Choose an Option ==</option>
                                        @foreach (\Utility::$eventFeatured as $key => $type)
                                            <option value="{{ $key }}"
                                                    @if (old('event_featured', isset($request) ? $request->event_featured : null) == $key) selected @endif>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="event_status" class="control-label">Event Status</label>
                                    <select name="event_status" id="event_status" class="form-control">
                                        <option value=""
                                                @if (old('event_status', isset($request) ? $request->event_status : null) == $request->event_status) selected @endif>
                                            == Choose an Option ==
                                        </option>
                                        @foreach (\Utility::$statusText as $status)
                                            <option value="{{ $status }}"
                                                    @if (old('event_status', isset($request) ? $request->event_status : null) == $status) selected @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                            class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box">
                {!! \CHTML::formTitleBox($caption = 'List of All Events', 'null', $routeName = 'events', $buttonClass = '', $buttonIcon = '') !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="sample_1" width="100%">
                            <tr>
                                <th>SL</th>
                                <th>@sortablelink('event_title', 'Event Title')</th>
                                <th class="text-center">@sortablelink('event_start', 'Start At')</th>
                                <th class="text-center">Guests</th>
                                <th class="text-center">Status</th>
                                <th class="tbl-action">Actions</th>
                            </tr>
                            @foreach ($datas as $data)
                                <tr class="odd gradeX">
                                    <td>{{ $datas->firstItem() + $loop->index }}</td>
                                    <td>
                                        <a href="{{ route('events.show', $data->id) }}">
                                            {{ $data->event_title }}
                                        </a>
                                    </td>
                                    <td class="text-center">{!! \Carbon\Carbon::parse($data->event_start)->format('h:i A (d\<\s\up>S</\s\up> F, Y)') !!}</td>
                                    <td>{{ $data->getTotalRegistered() }}</td>
                                    <td class="text-center">
                                        {!! $data->getEventProgress() !!}
                                        {{--
                                                                                {!! \CHTML::flagChangeButton($data, 'event_status', \Utility::$statusText) !!}
                                        --}}
                                    </td>
                                    <td>{!! \CHTML::actionButton($reportTitle = '..',
 $routeLink = '#',
 $data->id,
 $selectButton = ['showButton', 'editButton'],
 $class = ' btn-icon btn-circle ',
 $onlyIcon = 'yes',
 $othersPram = []) !!}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                {!! \CHTML::customPaginate($datas, '') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection