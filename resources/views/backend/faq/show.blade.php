@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        FAQ
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
                                        $faq->id,
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
                                <div class="form-group">
                                    <label class="control-label">Question: </label>
                                    @if (isset($faq->question))
                                        <div class="container-fluid"
                                             style="border: 2px solid #d2d6de; min-height: 200px">
                                            {!! $faq->question !!}
                                        </div>
                                    @else
                                        <p>N/A</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Answer: </label>
                                    @if (isset($faq->answer))
                                        <div class="container-fluid"
                                             style="border: 2px solid #d2d6de; min-height: 200px">
                                            {!! $faq->answer !!}
                                        </div>
                                    @else
                                        <p>N/A</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Status: </label>
                                    @if($faq->status == 'ACTIVE')
                                        <button
                                            class="btn btn-success btn-sm">{{$faq->status}}</button>
                                    @else
                                        <button
                                            class="btn btn-danger btn-sm">{{ str_replace("-","",$faq->status) }}</button>
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
