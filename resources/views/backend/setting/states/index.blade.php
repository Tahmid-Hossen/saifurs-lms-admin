@extends('backend.layouts.master')
@section('title')
    States
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-map-marker"></i>
        States
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
                    <h3 class="box-title">Find States</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('states.index') }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
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
                        $caption="States",
                        $captionIcon="fa fa-map-marker",
                        $routeName="states",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> ID</th>
                                <th> Country</th>
                                <th> @sortablelink('state_name', 'State')</th>
                                <th> Status</th>
                               <th class="tbl-date"> @sortablelink('created_at', 'Created At')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($provinces as $state)
                                <tr>
                                    <td> {{$state->id}}</td>
                                    <td> {!! $state->country->country_name !!}</td>
                                    <td> {{$state->state_name}}</td>
                                    <td width="82">
                                        {!! \CHTML::flagChangeButton($state, 'state_status', \Utility::$statusText) !!}
                                    </td>
                                    <td> {{$state->created_at->format(config('app.date_format2'))}}</td>
                                   <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $state->id,
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
                {!! \CHTML::customPaginate($provinces,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection


