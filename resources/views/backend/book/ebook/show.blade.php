@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-address-book"></i>
        EBook
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">EBook Details</h3>
                    <div class="pull-right">
                        <a href="{{route('ebooks.index')}}"
                           class="btn btn-danger hidden-print">
                            <i class="glyphicon glyphicon-hand-left"></i> Back
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-9">
                            @if(auth()->user()->userDetails->company_id == 1)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Company:</label>
                                            <p class="">{{ $ebook->company->company_name ?? NULL }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Branch:</label>
                                            <p>{{ isset($ebook->branch) ? $ebook->branch->branch_name : null}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Book Name/Title:</label>
                                        <p class="">{{ $ebook->book_name ?? NULL}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Edition:</label>
                                        <p>{{ $ebook->edition ?? NULL}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Author:</label>
                                        <p>{{ $ebook->author ?? NULL}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Contributors:</label>
                                        <p>{{ $ebook->contributor ?? NULL}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Category:</label>
                                        <p>{{ $ebook->category->book_category_name ?? NULL}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Publish Language</label>
                                        <p>{{ \Utility::$languageList[$ebook->language] ?? NULL}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ISBN Number:</label>
                                        <p>{{ $ebook->isbn_number ?? NULL}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Publish Date</label>
                                        <p>{{ \Carbon\Carbon::parse($ebook->publish_date)->format('d F, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Total Pages</label>
                                        <p>{{ $ebook->pages ?? NULL}} Pages</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Book Status</label>
                                        <p>{{ $ebook->book_status ?? NULL}}</p>
                                    </div>
                                </div>
                            </div>
                            @if(isset($ebook->type))
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Ebook Type</label>
                                            <p>{{ isset($ebook->type) ? $ebook->type->ebook_type_name : null }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <div class="form-group text-center">
                                <label class="control-label">EBook Link</label><br>
                                <a href="{{ route('ebooks.download', $ebook->book_id?? 1) }}"
                                   class="btn btn-primary">Download Ebook File</a>

                            </div>
                            <div class="form-group">
                                <label class="control-label">Book Preview Image:</label>
                                <p>
                                    <img class="img-responsive img-thumbnail img-bordered"
                                         src="{{ asset($ebook->photo ?? config('app.default_image')) }}">
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Keywords:</label>
                                {!! \CHTML::displayTags($ebook->keywords, 'keyword_name', true) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <div class="container-fluid">
                                    {!! html_entity_decode($ebook->book_description ?? null) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
