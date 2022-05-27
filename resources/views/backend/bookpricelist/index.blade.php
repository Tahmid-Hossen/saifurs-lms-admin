@extends('backend.layouts.master')
@section('title')
    Course
@endsection
@section('page_styles')

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
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box">
                {!!
                    CHTML::formTitleBox(
                        $caption="Book Price List",
                        $captionIcon="fa fa-book",
                        $routeName="bookpricelist",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Book Name</th>
                                <th>Cover Price</th>
                                <th>Retail Price</th>
                                <th>WholeSale</th>
                                <th>Status</th>
                                <th class="tbl-date"> Created At</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($bookpricelists as $i => $bookpricelist)
                                <tr>
                                    <td>{{ $bookpricelist->id }}</td>
                                    <td>{{ $bookpricelist->book_name }}</td>
                                    <td>{{ $bookpricelist->cover_price }}</td>
                                    <td>{{ $bookpricelist->retail_price }}</td>
                                    <td>{{ $bookpricelist->wholesale }}</td>
                                    <td>
                                        {!! CHTML::flagChangeButton($bookpricelist,
                                                'status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td> {{isset($bookpricelist->created_at)?$bookpricelist->created_at->format('d M, Y'):null}}</td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $bookpricelist->id,
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
                {!! CHTML::customPaginate($bookpricelists,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection


