@extends('backend.layouts.master')

@section('title')
    Book Categories
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-list-alt"></i>
        Category
        <small>Book</small>
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
                    <h3 class="box-title">Find Book Category</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('categories.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                {!! \Form::nText('search_text', 'Search: ',($inputs['search_text'] ?? null), false, ['placeholder' => 'Search name, Id , etc...']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! \Form::nText('name', 'Name',($inputs['name'] ?? null), false, ['placeholder' => 'Category Name']) !!}
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="daterange-btn" class="control-label">Creation Date Range:</label>

                                    <input type="hidden" class="form-control pull-right only_date"
                                           id="start_date"
                                           name="start_date"
                                           value="{{ \Carbon\Carbon::parse($inputs['start_date'] ?? 'now')->format('Y-m-d') }}"
                                           placeholder="From">
                                    <input type="hidden" class="form-control pull-right only_date"
                                           id="end_date"
                                           name="end_date"
                                           value="{{ \Carbon\Carbon::parse($inputs['end_date'] ?? 'now')->format('Y-m-d') }}"
                                           placeholder="To">
                                    <div class="input-group col-md-12">
                                        <button type="button" class="btn btn-default col-md-12" id="daterange-btn"
                                                name="date_range">
                                            <span>
                                                <i class="fa fa-calendar"></i>
                                                @if(isset($inputs['date_range']))
                                                    {{$inputs['date_range']}}
                                                @else
                                                    Date Range
                                                @endif
                                            </span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                            class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Book Categories",
                        $captionIcon="fa fa-list-alt",
                        $routeName="categories",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body table-responsive no-padding">

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> ID</th>
                            <th> Category Name</th>
                            <th> Status</th>
{{--                            <th> Created At</th>--}}
                            <th class="tbl-action"> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->book_category_id }}</td>
                                <td>
                                    <a href="{{ route('categories.show',$category->book_category_id) }}">
                                        {!! $category->book_category_name !!}
                                    </a>
                                </td>
                                <td>{{$category->book_category_status}}</td>
                                <td> {{$category->created_at->format('d M, Y')}}</td>
                                <td class="tbl-action" style="text-align: center !important;">
                                    {!!
                                        \CHTML::actionButton(
                                            $reportTitle='..',
                                            $routeLink='categories',
                                            $category->book_category_id,
                                            $selectButton=['editButton', 'deleteButton'],
                                            $class = 'btn-icon btn-circle',
                                            $onlyIcon='yes',
                                            $othersPram=array()
                                        )
                                    !!}
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {!! \CHTML::customPaginate($categories,'') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('scripts')

@endpush


