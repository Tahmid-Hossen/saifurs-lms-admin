@extends('backend.layouts.master')
@section('title')
    Book Rating Comment
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Book Rating Comment
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
                    <h3 class="box-title">Find Book Rating Comment</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'book-rating-comments.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'book_id'=>$request->get('book_id')
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'book-rating-comments.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id')
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET"
                          action="{{ route('book-rating-comments.index') }}">
                        <div class="row">
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-6 @else col-md-12 @endrole">
                                <div class="form-group">
                                    <label for="barcode" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_id" class="control-label">Company Name</label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value=""
                                                @if (isset($request) && ($request->company_id === "")) selected @endif>
                                            Select Company
                                        </option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}"
                                                    @if (isset($request) && ($request->company_id === $company->id)) selected @endif
                                            >{{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger text-bold" style="margin-right: 1rem"><i
                                    class="fa fa-eraser"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary text-bold"><i
                                    class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.box -->
            <div class="box">
                {!!
                    CHTML::formTitleBox(
                        $caption="Book Rating Comment",
                        $captionIcon="icon-book",
                        $routeName="book-rating-comments.create",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                        >
                            <thead>
                            <tr>
                                <th> ID</th>
                                <th> Book</th>
                                <th width="100"> Rating</th>
                                <th> Comment</th>
                                <th> Approved</th>
                                <th> Status</th>
                                <th> Created At</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookRatingComments as $bookRatingComment)
                                <tr>
                                    <td> {{$bookRatingComment->id}}</td>
                                    <td> {!! isset($bookRatingComment->book)?$bookRatingComment->book->book_name:null !!}</td>
                                    <td class="text-center">
                                        {!! \App\Services\CustomHtmlService::startRating($bookRatingComment->book_rating) !!}
                                    </td>
                                    <td>
                                        <div class="comment">
                                            {!! $bookRatingComment->book_comment !!}
                                        </div>
                                    </td>
                                    <td> {!! \CHTML::flagChangeButton($bookRatingComment, 'is_approved',['YES', 'NO'], null, ['on'=> 'primary', 'off' => 'default']) !!}</td>
                                    <td> {!! \CHTML::flagChangeButton($bookRatingComment, 'book_rating_comment_status', \Utility::$statusText) !!}</td>
                                    <td class="tbl-date"> {{ human_date($bookRatingComment->created_at) }}</td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $bookRatingComment->id,
                                                $selectButton=['showButton','editButton','deleteButton'],
                                                $class = ' btn-icon btn-circle ',
                                                $onlyIcon='yes',
                                                $othersPram=[]
                                            )
                                        !!}

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                {!! CHTML::customPaginate($bookRatingComments,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')

@endpush


