@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        Book Price List
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @include('backend.layouts.flash')
        <div class="row">
   {{--         <div class="col-md-2">
            <div class="box box-primary with-border">
                <div class="box-header">
                    <h3 class="box-title">Menubar</h3>
                </div>
            </div>
            </div>--}}
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!!
                                    CHTML::actionButton(
                                        $reportTitle='..',
                                        $routeLink='#',
                                        $bookPriceList->id,
                                        $selectButton=['backButton', 'editButton'],
                                        $class = 'btn-icon btn-circle',
                                        $onlyIcon='no',
                                        $othersPram=array()
                                    )
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8 profile-info">
                                <h3 class="font-green sbold uppercase">
                                </h3>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Book Name</th>
                                        <th>{{ $bookPriceList->book_name }}</th>
                                    </tr>
                                    <tr>
                                        <th>Cover Price</th>
                                        <th>{{ $bookPriceList->cover_price }}</th>
                                    </tr>
                                    <tr>
                                        <th>Retail Price</th>
                                        <th>{{ $bookPriceList->retail_price }}</th>
                                    </tr>
                                    <tr>
                                        <th>Wholesale</th>
                                        <th>{{ $bookPriceList->wholesale }}</th>
                                    </tr>
                                </table>>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Status: </label>
                                    @if($bookPriceList->status == 'ACTIVE')
                                        <button
                                            class="btn btn-success btn-sm">{{$bookPriceList->status}}</button>
                                    @else
                                        <button
                                            class="btn btn-danger btn-sm">{{ str_replace("-","",$bookPriceList->status) }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        $(document).ready(function () {
            resizeNavbar();
            $(window).resize(function () {
                resizeNavbar();
            });
            $("#nav-sidebar li a").click(function () {
                console.log("echo from click");
                resizeNavbar();
            });

        });
    </script>
@endpush
