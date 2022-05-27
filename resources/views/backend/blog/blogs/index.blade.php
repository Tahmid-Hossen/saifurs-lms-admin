@extends('backend.layouts.master')
@section('title')
    Blogs
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-wordpress"></i>
        Blog
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
                    <h3 class="box-title">Find Blogs</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('blogs.index') }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="barcode" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
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
            <div class="box with-border">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Blogs",
                        $captionIcon="fa fa-wordpress",
                        $routeName="blogs.create",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-bordered table-hover"
                    >
                        <thead>
                        <tr>
                            <th> @sortablelink('id', 'ID')</th>
{{--
                            <th> Logo</th>
--}}
                            <th>  @sortablelink('blog_title', 'Title')</th>
                            <th>  @sortablelink('name', 'Publish By')</th>
                            <th> @sortablelink('blog_publish_date', 'Publish Date ')</th>
                            <th> Status</th>
{{--                            <th> Created At</th>--}}
                            <th class="tbl-action"> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($blogs as $blog)
                            <tr>
                                <td> {{$blog->id}}</td>
{{--                                <td><img src="{{asset($blog->blog_logo)}}" width="200"
                                         class="img-responsive img-thumbnail"></td>--}}
                                <td> {!! $blog->blog_title !!}</td>
                                <td> {!! $blog->name !!}</td>
                                <td> {!! date(config('app.date_format2'), strtotime($blog->blog_publish_date),) !!}</td>
                                <td>{!! \CHTML::flagChangeButton($blog,'blog_status', \Utility::$statusText) !!}</td>
                                {{--<td class="tbl-date"> {{$blog->created_at->format(config('app.date_format2'))}}</td>
                                --}}<td class="tbl-action">
                                    {!!
                                        \CHTML::actionButton(
                                            $reportTitle='..',
                                            $routeLink='#',
                                            $blog->id,
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
                {!! \CHTML::customPaginate($blogs) !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush


