@extends('backend.layouts.master')

@section('title')
    Book
@endsection

@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-book"></i>
        Book
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <!-- Find Option -->
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Book</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route('book.pdf', request()->query()) !!}">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route( 'book.excel',request()->query()) !!}">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('books.index') }}">
                        <input type="hidden" name="is_ebook" value="NO">
                        <div class="row">
                            <div class="col-md-6">
                                {!! \Form::nText('search_text', 'Search: ',($inputs['search_text'] ?? null), false, ['placeholder' => 'Search name, Id , etc...']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! \Form::nText('author', 'Author, Contributor',($inputs['author'] ?? null), false, ['placeholder' => 'Author, Contributor']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                {!! \Form::nSelect('category', 'Category',$categories ??[], ($inputs['category'] ?? null), false, ['class' => 'form-control']) !!}
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                {!! \Form::nSelect('company', 'Company',$global_companies, ($inputs['company'] ?? null), false, ['placeholder' => 'Select a Company']) !!}
                            </div>
                            @else
                                <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                    <input type="hidden" name="company" id="company"
                                           value="{{auth()->user()->userDetails->company_id}}">
                                </div>
                                @endrole
                                <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                    {!! \Form::nSelect('status', 'Status', ['ACTIVE' => 'ACTIVE', 'IN-ACTIVE' => 'IN-ACTIVE'],
                                $inputs['status'] ?? null, false, ['placeholder' => 'Select a Option']) !!}
                                </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger text-bold" style="margin-right: 1rem"><i
                                        class="fa fa-eraser"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary text-bold"><i
                                        class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.box -->
            <div class="box with-border">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Books",
                        $captionIcon="fa fa-book",
                        $routeName="book",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> @sortablelink('book_name', 'Name(Edition)')</th>
                                <th> Authors</th>
                                @role(\Utility::SUPER_ADMIN)
                                <th> Company</th>
                                @endrole
                                <th> Category</th>
                                <th> Status</th>
                                <th class="tbl-date"> Publish Date</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $index => $book)
                                @php
                                    $color = "#e9e9e9";
                                    if($index % 2 == 0) $color = "white";
                                @endphp
                                <tr style="background-color: {{$color}};">
                                    <td>{{ $books->firstItem() + $loop->index }}</td>
                                    <td>
                                        <a href="{{ route('books.show',$book->book_id) }}">
                                            {!! $book->book_name !!}
                                            @if(!empty($book->edition))
                                                ({{ $book->edition }})
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <strong>{{ $book->author}}</strong>
                                        @if(!empty($book->contributor))
                                            <br>
                                            ({{ $book->contributor }})
                                        @endif
                                    </td>
                                    @role(\Utility::SUPER_ADMIN)
                                    <td>
                                        {!! $book->company->company_name ?? null !!}
                                    </td>
                                    @endrole
                                    <td> {{ $book->book_category_name }}</td>
                                    <td>
                                        {!! \CHTML::flagChangeButton($book, 'book_status', \Utility::$statusText) !!}
                                    </td>
                                    <td> {{ human_date($book->publish_date) }}</td>
                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='book',
                                                $book->book_id,
                                                $selectButton=['showButton','editButton','deleteButton'],
                                                $class = ' btn-icon btn-circle ',
                                                $onlyIcon='yes',
                                                $othersPram=array()
                                            )
                                        !!}
                                    </td>
                                </tr>
                                <tr style="background-color: {{$color}};">
                                    <td colspan="@role(\Utility::SUPER_ADMIN) 8 @else 7 @endrole"
                                        style="text-align: left !important;">
                                        {!! \CHTML::displayTagsLimited($book->keywords, 'keyword_name', true, 'fa fa-tags') !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                {!! \CHTML::customPaginate($books,'') !!}
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('scripts')

@endpush


