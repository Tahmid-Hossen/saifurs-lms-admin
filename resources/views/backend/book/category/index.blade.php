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
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-6 @else col-md-12 @endrole">
                                {!! \Form::nText('search_text', 'Search: ',($inputs['search_text'] ?? null), false, ['placeholder' => 'Search name, Id , etc...']) !!}
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                                <div class="col-md-6">
                                    {!! \Form::nSelect('company_id', 'Company',$global_companies, ($inputs['company'] ?? null), false, ['placeholder' => 'Select a Company']) !!}
                                </div>
                            @else
                                <input type="hidden" name="company_id" id="company" value="{{auth()->user()->userDetails->company_id}}">
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
                    \CHTML::formTitleBox(
                        $caption="Book Categories",
                        $captionIcon="fa fa-list-alt",
                        $routeName="categories",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> ID</th>
                                <th> Category Name</th>
                                @role(\Utility::SUPER_ADMIN)
                                <th>Company</th>
                                @endrole
                                <th> Status</th>
                                {{--                                <th> Created At</th>--}}
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td width="5%">{{ $category->book_category_id }}</td>

                                    <td>
                                        {!! $category->book_category_name !!}
                                    </td>
                                    @role(\Utility::SUPER_ADMIN)
                                    <td>
                                        {{ $category->company->company_name }}
                                    </td>
                                    @endrole
                                    <td width="83">
                                        {!! \CHTML::flagChangeButton($category,'book_category_status', \Utility::$statusText) !!}
                                    </td>
                                    {{--<td class="tbl-date"> {{$category->created_at->format('d M, Y')}}</td>
                                    --}}
                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='categories',
                                                $category->book_category_id,
                                                $selectButton=['showButton','editButton', 'deleteButton'],
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
                    </div>
                </div>
                {!! \CHTML::customPaginate($categories,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection

@push('scripts')

@endpush


