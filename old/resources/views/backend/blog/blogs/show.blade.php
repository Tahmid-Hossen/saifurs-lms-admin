@extends('backend.layouts.master')
@section('title')
    Detail/Show Blog
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

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!!
                                    \CHTML::actionButton(
                                        $reportTitle='..',
                                        $routeLink='#',
                                        $blog->id,
                                        $selectButton=['backButton','editButton'],
                                        $class = ' btn-icon btn-circle ',
                                        $onlyIcon='no',
                                        $othersPram=array()
                                    )
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name" class="control-label">Company Name</label><br>
                                            {{ isset($blog->company) ? $blog->company->company_name: null }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="blog_email" class="control-label">Blog Publish By</label><br>
                                            {{
                                                isset($blog->userDetails) ?
                                                    $blog->userDetails->first_name.' '.$blog->userDetails->last_name.' ('.$blog->userDetails->mobile_phone.')':
                                                    null
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="blog_title" class="control-label">Blog Title</label><br>
                                            {{ isset($blog) ? $blog->blog_title: null }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="blog_type" class="control-label">Blog Type</label><br>
                                            {{isset($blog) ? $blog->blog_type: null}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="blog_publish_date" class="control-label">Blog Publish Date</label><br>
                                            {{isset($blog) ? date(config('app.date_format2'), strtotime($blog->blog_publish_date)): null}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="blog_status"
                                                   class="control-label">@lang('common.Status')</label><br>
                                            {{ isset($blog) ? $blog->blog_status: null }}
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="blog_address" class="control-label">Blog Description</label><br>
                                            {!!  isset($blog) ? $blog->blog_description: null !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <img
                                    id="blog_logo_show" class="img-responsive img-thumbnail"
                                    src="{{isset($blog->blog_logo)?URL::to($blog->blog_logo):config('app.default_image')}}"
                                    width="{{\Utility::$blogLogoSize['width']}}"
                                    height="{{\Utility::$blogLogoSize['height']}}"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
@endsection
