@extends('backend.layouts.master')

@section('content-header')
    <h1>
        <i class="fa fa-book"></i>
        Book
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
                    <h3 class="box-title">Book Details</h3>
                    <div class="pull-right">
                        <a href="{{route('books.index')}}"
                           class="btn btn-danger hidden-print">
                            <i class="glyphicon glyphicon-hand-left"></i> Back
                        </a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Book Information</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Preview Image</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">
                                    @role(\Utility::SUPER_ADMIN)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Company:</label>
                                            <p class="">{{ $book->company->company_name ?? null }}</p>
                                        </div>
                                    </div>
                                    @else
                                        <div class="@role(\Utility::SUPER_ADMIN) col-md-6 @else col-md-12 @endrole">
                                            <div class="form-group">
                                                <label class="control-label">Branch:</label>
                                                <p>{{ $book->branch->branch_name ?? null }}</p>
                                            </div>
                                        </div>
                                        @endrole
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Book Name/Title:</label>
                                            <p class="">{{ $book->book_name ?? null }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Edition:</label>
                                            <p>{{ $book->edition  ?? null}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Author:</label>
                                            <p>{{ $book->author  ?? null}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Contributors:</label>
                                            <p>{{ $book->contributor ?? null }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Category:</label>
                                            <p>{{ $book->category->book_category_name  ?? null}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Publish Language</label>
                                            <p>{{ \Utility::$languageList[$book->language]  ?? null}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">ISBN Number:</label>
                                            <p>{{ $book->isbn_number  ?? null}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Publish Date</label>
                                            <p>{{ \Carbon\Carbon::parse($book->publish_date)->format('d F, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Total Pages</label>
                                            <p>{{ $book->pages  ?? null}} Pages</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Book Status</label>
                                            <p>{{ $book->book_status  ?? null}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Is Book Sellable</label>
                                            <p>
                                                @if($book->is_sellable == 'YES')
                                                    <label class="label label-success">YES</label>
                                                @else
                                                    <label class="label label-warning">NO</label>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Book Price</label>
                                            <p>
                                                @if($book->is_sellable == 'YES')
                                                    {{ $book->book_price  ?? null}} {{ $book->currency  ?? null}}
                                                @else
                                                    FREE
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if($book->is_ebook == 'YES')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Is Book a Ebook</label>
                                                <p>
                                                    @if($book->is_sellable == 'YES')
                                                        <label class="label label-success">YES</label>
                                                    @else
                                                        <label class="label label-warning">NO</label>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">EBook Type</label>
                                                <p> {{ $book->type->ebook_type_name  ?? null}} </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Keywords:</label>
                                            <p>
                                                {!! \CHTML::displayTags($book->keywords, 'keyword_name', true) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Description</label><br>
                                            <div class="container-fluid"
                                                 style="border: 2px solid #d2d6de; min-height: 200px">
                                                {!! html_entity_decode($book->book_description) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($book->is_ebook == 'YES')
                                    <div class="form-group text-center">
                                        <label class="control-label">EBook Link</label><br>
                                        <a href="{{ route('ebooks.download', $book->book_id) }}"
                                           class="btn btn-primary">Download Ebook File</a>

                                    </div>
                                @endif
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Book Cover Image:</label>
                                            <p>
                                                <img class="img-responsive img-thumbnail img-bordered"
                                                     src="{{ asset($book->photo[0]) }}">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        Inner Sample Image
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            @foreach($book->photo as $index => $photo)
                                                @if($index == 0)
                                                    @continue
                                                @elseif(is_null($photo))
                                                    @continue
                                                @else
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <img class="img-responsive img-thumbnail img-bordered"
                                                                 src="{{ asset($photo) }}">
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
