@extends('backend.layouts.master')
@section('title')
    Vendors
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-user-plus"></i>
        Vendor
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
                    <h3 class="box-title">Find Vendor</h3>

                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('vendors.index') }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
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
            <div class="box">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Vendors",
                        $captionIcon="icon-users",
                        $routeName="vendors.create",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                        >
                            <thead>
                            <tr>
                                <th>  @sortablelink('id', 'ID')</th>
                                {{--                            <th> Logo</th>--}}
                                <th> @sortablelink('vendor_name', 'Name')</th>
                                <th> Status</th>
                                <th>  @sortablelink('created_at', 'Created At')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vendors as $vendor)
                                <tr>
                                    <td> {{$vendor->id}}</td>
                                    {{-- <td> <img src="{{isset($vendor->vendor_logo)?URL::to($vendor->vendor_logo):'http://placehold.it/32x32/007F7B/007F7B&amp;text='.config('app.name')}}" width="32" height="32"> </td>
                                    --}}
                                    <td> {!! $vendor->vendor_name !!}</td>
                                    <td width="95">
                                        {!! \CHTML::flagChangeButton($vendor, 'vendor_status', ['ACTIVE', 'IN-ACTIVE']) !!}
                                    </td>
                                    <td> {{$vendor->created_at->format(config('app.date_format2'))}}</td>
                                   
                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $vendor->id,
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
                </div>
                {!! \CHTML::customPaginate($vendors,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')

@endpush


