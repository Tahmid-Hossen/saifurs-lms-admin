@extends('backend.layouts.master')
@section('title')
    Course Learn
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-leanpub"></i>
        Course Learn
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
                    <h3 class="box-title">Find Learn</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'course-learns.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'learn_title'=>$request->get('learn_title'),
                                    'learn_status'=>$request->get('learn_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'course-learns.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'learn_title'=>$request->get('learn_title'),
                                    'learn_status'=>$request->get('learn_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('course-learns.index') }}">
                        <div class="row">
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                <div class="form-group">
                                    <label for="name" class="control-label">Company:</label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}"
                                                    @if(old('company_id', isset($request) ? $request->company_id:null) == $company->id) selected @endif
                                            >{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                <div class="form-group">
                                    <label for="name" class="control-label">Status:</label>
                                    <select name="learn_status" id="learn_status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach(\App\Support\Configs\Constants::$question_status as $status)
                                            <option value="{{ $status }}"
                                                    @if(old('learn_status', isset($request) ? $request->learn_status:null) == $status) selected @endif
                                            >{{ str_replace("-","",$status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                <!-- /.box-body -->
            </div>

            <div class="box">
                {!!
                    CHTML::formTitleBox(
                        $caption="Learns",
                        $captionIcon="icon-users",
                        $routeName="course-learns",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="sample_1">
                            <thead>
                            <tr>
                                <th>SI</th>
                                <th> @sortablelink('learn_title', 'Learn Title')</th>
                                @role(\Utility::SUPER_ADMIN)
                                <th> Company</th>
                                @endrole
                                <th> Course</th>
                                <th> Status</th>
                                <th> @sortablelink('created_at', 'Created Date')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($course_learns as $course_learn)

                                <tr>
                                    <td>{{ $course_learns->firstItem() + $loop->index }}</td>
                                    <td>{{isset($course_learn->learn_title)?$course_learn->learn_title:null}}</td>
                                    @role(\Utility::SUPER_ADMIN)
                                    <td style="color: #76767f">{{isset($course_learn->company)?strtoupper($course_learn->company->company_name):null}}</td>
                                    @endrole
                                    <td style="color: #76767f">{{isset($course_learn->course)?$course_learn->course->course_title:null}}</td>
                                    <td>
                                        {!! CHTML::flagChangeButton($course_learn,
                                                'learn_status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td> {{isset($course_learn->created_at)?$course_learn->created_at->format('d M, Y'):null}}</td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $course_learn->id,
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
                {!! CHTML::customPaginate($course_learns,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')

@endpush


