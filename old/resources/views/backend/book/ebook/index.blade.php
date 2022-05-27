@extends('backend.layouts.master')

@section('title')
    EBooks
@endsection

@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-address-book"></i>
        EBook
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="row">
            @include('backend.layouts.flash')
            <div class="col-xs-12">
                <!-- Find Option -->
                <div class="box box-default collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Find EBooks</h3>

                        <div class="box-tools pull-right">
                            <a class="btn btn-primary hidden-print" id="payeePrint"
                               href="{!! route('ebooks.pdf', request()->query()) !!}">
                                <i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                            <a class="btn btn-primary hidden-print" id="payeePrint"
                               href="{!! route( 'ebooks.excel',request()->query()) !!}">
                                <i class="fa fa-file-excel-o"></i> Excel
                            </a>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="horizontal-form" role="form" method="GET" action="{{ route('ebooks.index') }}">
                            <input type="hidden" name="is_ebook" value="YES">
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! \Form::nText('search_text', 'Search: ',($inputs['search_text'] ?? null), false, ['placeholder' => 'Search name, Id , etc...']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! \Form::nText('author', 'Author, Contributor',($inputs['author'] ?? null), false, ['placeholder' => 'Author, Contributor']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! \Form::nSelect('category', 'Category',$categories, ($inputs['category'] ?? null), false, ['class' => 'form-control']) !!}
                                    </div>
                                    @if(auth()->user()->userDetails->company_id == 1)
                                        <div class="col-md-4">
                                            {!! \Form::nSelect('company', 'Company',$global_companies, ($inputs['company'] ?? null), false, ['placeholder' => 'Select a Option']) !!}
                                        </div>
                                    @else
                                        <div class="col-md-4">
                                            <input type="hidden" name="company" id="company"
                                                   value="{{auth()->user()->userDetails->company_id}}">
                                        </div>
                                    @endif
                                    <div class="col-md-4">
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
                </div>
                <!-- /.box -->
                <div class="box">
                    {!!
                        \CHTML::formTitleBox(
                            $caption="EBooks",
                            $captionIcon="fa fa-address-book",
                            $routeName="ebooks",
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
                                    <th> Name(Edition)</th>
                                    <th> Authors</th>
                                    <th> Company</th>
                                    <th> Category</th>
                                    <th> Type</th>
                                    <th> Status</th>
                                    {{--                                <th class="tbl-date"> Created At</th>--}}
                                    <th> Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ebooks as $index => $ebook)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('books.show',$ebook->book_id) }}">
                                                {!! $ebook->book_name !!}
                                                @if(!empty($ebook->edition))
                                                    ({{ $ebook->edition }})
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <strong>{{ $ebook->author}}</strong>
                                            @if(!empty($ebook->contributor))
                                                <br>
                                                ({{ $ebook->contributor }})
                                            @endif
                                        </td>
                                        <td>
                                            {!! $ebook->company->company_name !!}
                                        </td>
                                        <td> {{ $ebook->category->book_category_name }}</td>
                                        <td>
                                            <label
                                                title="{{ $ebook->type->ebook_type_name??null }}"> {{ $ebook->type->extension?? null }}</label>
                                        </td>
                                        <td>
                                            {!! \CHTML::flagChangeButton($ebook, 'book_status', \Utility::$statusText) !!}
                                        </td>
                                        {{--<td> {{\Carbon\Carbon::parse($ebook->created_at)->format(config('app.date_format2'))}}</td>
                                        --}}
                                        <td class="tbl-action">
                                            {!!
                                                \CHTML::actionButton(
                                                    $reportTitle='..',
                                                    $routeLink='books',
                                                    $ebook->book_id,
                                                    $selectButton=['showButton','editButton','downloadButton','deleteButton'],
                                                    $class = ' btn-icon btn-circle ',
                                                    $onlyIcon='yes',
                                                    $othersPram=array()
                                                )
                                            !!}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: left !important;">
                                            {!! \CHTML::displayTagsLimited($ebook->keywords, 'keyword_name', true, 'fa fa-tags') !!}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    {!! \CHTML::customPaginate($ebooks,'') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('scripts')

@endpush


