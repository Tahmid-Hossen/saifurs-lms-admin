@extends('backend.layouts.master')
@section('title')
    Course Ratings
@endsection

@section('content-header')
    <h1>
        Banners
        <small>Control panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Banner</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('banners.index') }}">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="banner_title" class="control-label">Banner Title</label>
                                    <input type="text" class="form-control" id="banner_title" name="banner_title"
                                           value="{{ $request->banner_title }}" placeholder="Insert a Banner Title">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="banner_status" class="control-label">Banner Status</label>
                                    <select name="banner_status" id="banner_status" class="form-control">
                                        <option value=""
                                                @if (old('banner_status', isset($request) ? $request->banner_status : null) == $request->banner_status) selected @endif>
                                            -------- No Status Selected --------
                                        </option>
                                        @foreach (\Utility::$statusText as $status)
                                            <option value="{{ $status }}"
                                                    @if (old('banner_status', isset($request) ? $request->banner_status : null) == $status) selected @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
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
                {!! \CHTML::formTitleBox($caption = 'List of All Banners', $captionIcon = 'null', $routeName = 'banners', $buttonClass = '', $buttonIcon = '') !!}

                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="sample_1"
                               width="100%">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th width="30%">Banner Image</th>
                                {{-- <th class="text-center">Banner Title</th> --}}
                                <th class="text-center">@sortablelink('created_at', 'Created At')</th>
                                <th class="text-center">Status</th>
                                <th class="tbl-action">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($datas as $data)
                                <tr class="odd gradeX">
                                    <td>{{ $datas->firstItem() + $loop->index }}</td>
                                    <td>
                                        <img src="{{ $data->banner_image_full_path }}"
                                             class="img-responsive img-thumbnail">
                                    </td>
                                    {{-- <td class="text-center">
                                        <a href="{{ route('banners.show', $data->id) }}">{{ $data->banner_title }}</a>
                                    </td> --}}
                                    <td class="text-center">
                                        {!! \Utility::getDateTimeHuman($data->created_at) !!}
                                    </td>
                                    <td class="text-center">
                                        {!! \CHTML::flagChangeButton($data, 'banner_status', \Utility::$statusText) !!}
                                    </td>
                                    <td class="tbl-action">
                                        {!! \CHTML::actionButton($reportTitle = '..', $routeLink = '#', $data->id, $selectButton = ['showButton', 'editButton', 'deleteButton'], $class = 'btn-icon btn-circle', $onlyIcon = 'yes', $othersPram = []) !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {!! \CHTML::customPaginate($datas, '') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
