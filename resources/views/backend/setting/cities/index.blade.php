@extends('backend.layouts.master')
@section('title')
    Cities
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-map-pin"></i>
        City
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
                    <h3 class="box-title">Find Cities</h3>

                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('cities.index') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state_id" class="control-label">Search:</label>
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value=""
                                                @if (isset($request) && ($request->state_id === '')) selected @endif
                                        >Please Select State
                                        </option>
                                        @foreach($provinces as $state)
                                            <option value="{{$state->id}}"
                                                    @if (isset($request) && ($request->state_id === $state->id)) selected @endif
                                            >{{$state->state_name}}</option>
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
                {!!
                    \CHTML::formTitleBox(
                        $caption="Cities",
                        $captionIcon="icon-users",
                        $routeName="cities.create",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column">
                            <thead>
                            <tr>
                                <th> ID</th>
                                <th> Country</th>
                                <th> State</th>
                                <th>  @sortablelink('city_name', 'City')</th>
                                <th> Status</th>
                               <th> @sortablelink('created_at', 'Created At')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cities as $city)
                                <tr>
                                    <td> {{$city->id}}</td>
                                    <td> {!! $city->state->country->country_name !!}</td>
                                    <td> {{$city->state->state_name}}</td>
                                    <td> {{$city->city_name}}</td>
                                    <td>{!! \CHTML::flagChangeButton($city, 'city_status', \Utility::$statusText) !!}</td>
                                    <td> {{$city->created_at->format(config('app.date_format2'))}}</td>
                                   <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $city->id,
                                                $selectButton=['showButton','editButton','deleteButton'],
                                                $class = ' btn-icon btn-circle ',
                                                $onlyIcon='yes',
                                                $othersPram=array()
                                            )
                                        !!}

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                {!! \CHTML::customPaginate($cities,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')

@endpush


