@extends('backend.layouts.master')

@section('title')
    Countries
@endsection


@section('content-header')
    <h1>
        <i class="fa fa-flag"></i>
        Countries
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-sm-12">
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Countries</h3>

                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('countries.index') }}">
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
                        $caption="Countries",
                        $captionIcon="fa fa-flag",
                        $routeName="countries",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover order-column">
                            <thead>
                            <tr>
                                <th> @sortablelink('id', 'ID')</th>
                                <th> Flag</th>
                                <th> ISO</th>
                                <th>  @sortablelink('country_name', 'Country')</th>
                                <th>  @sortablelink('country_phone_code', 'Phone Code')</th>
                                <th>  @sortablelink('country_currency', 'Currency')</th>
                                <th>  @sortablelink('country_language', 'Language')</th>
                                <th> Status</th>
                               <th class="tbl-date">  @sortablelink('created_at', 'Created At')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($countries as $country)
                                <tr>
                                    <td> {{$country->id}}</td>
                                    <td><img class="img-responsive img-rounded"
                                             src="{{isset($country->country_logo)
                                ?URL::to($country->country_logo)
                                :'http://placehold.it/32x32/007F7B/007F7B&amp;text='.config('app.name')
}}"
                                             width="32" height="32"></td>
                                    <td> {!! $country->country_iso !!}</td>
                                    <td> {!! $country->country_name !!}</td>
                                    <td> {{$country->country_phone_code}}</td>
                                    <td>
                                        {{$country->country_currency}}
                                        @if(!empty($country->country_currency_symbol))
                                            ( {!! $country->country_currency_symbol !!})
                                        @endif
                                    </td>
                                    <td> {{$country->country_language}}</td>
                                    <td> {!!  \CHTML::flagChangeButton($country,'country_status', \Utility::$statusText) !!} </td>

                                    <td> {{$country->created_at->format(config('app.date_format2')) }}</td>


                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $country->id,
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
                {!! \CHTML::customPaginate($countries,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')

@endpush


