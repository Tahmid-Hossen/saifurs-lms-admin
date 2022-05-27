@extends('backend.layouts.master')
@section('title')
    Course
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        FAQ
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
                        $caption="FAQ",
                        $captionIcon="fa fa-question-circle",
                        $routeName="faq",
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
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th class="tbl-date"> Created At</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($faqs as $i => $faq)
                                <tr>
                                    <td>{{ $faq->id }}</td>
                                    <td>{!!  $faq->question ?? ''!!}</td>
                                    <td>{!!  $faq->answer !!}</td>
                                    <td>
                                        {!! CHTML::flagChangeButton($faq,
                                                'status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td> {{isset($faq->created_at)?$faq->created_at->format('d M, Y'):null}}</td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $faq->id,
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
                {!! CHTML::customPaginate($faqs,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection


