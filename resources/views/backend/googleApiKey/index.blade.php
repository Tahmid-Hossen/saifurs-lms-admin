@extends('backend.layouts.master')
@section('title')
    Course
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        Google Api Key
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box">
              {{--  {!!
                    CHTML::formTitleBox(
                        $caption="GoogleApiKey",
                        $captionIcon="fa fa-question-circle",
                        $routeName="googleApiKey",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}--}}
                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Google Api Key</th>
                                <th>Status</th>
                               {{-- <th class="tbl-date"> Created At</th>--}}
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($googleApiKeys as $i => $googleApiKey)
                                <tr>
                                    <td>{{ $googleApiKey->id }}</td>
                                    <td>{!!  $googleApiKey->google_api_key ?? ''!!}</td>
                                    <td>
                                        {!! CHTML::flagChangeButton($googleApiKey,
                                                'status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
{{--
                                    <td> {{isset($googleApiKey->created_at)?$googleApiKey->created_at->format('d M, Y'):null}}</td>
--}}
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $googleApiKey->id,
                                                $selectButton=['editButton'],
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
               {{-- {!! CHTML::customPaginate($googleApiKeys,'') !!}--}}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection


