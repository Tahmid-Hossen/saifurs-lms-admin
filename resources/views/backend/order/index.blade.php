@extends('backend.layouts.master')
@section('title')
    Order
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-star" aria-hidden="true"></i>
        Order
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
                    <h3 class="box-title">Find Order</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'orders.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'user_id'=>$request->get('user_id'),
                                    'batch_id'=>$request->get('batch_id'),
                                    'class_id'=>$request->get('class_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'quiz_id'=>$request->get('quiz_id'),
                                    'total_score'=>$request->get('total_score'),
                                    'pass_score'=>$request->get('pass_score'),
                                    'result_status'=>$request->get('result_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'orders.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'user_id'=>$request->get('user_id'),
                                    'batch_id'=>$request->get('batch_id'),
                                    'class_id'=>$request->get('class_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'quiz_id'=>$request->get('quiz_id'),
                                    'total_score'=>$request->get('total_score'),
                                    'pass_score'=>$request->get('pass_score'),
                                    'result_status'=>$request->get('result_status'),
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
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('orders.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>

                            <div class="col-md-4">
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Course:</label>
                                    <select name="course_id" id="course_id" class="form-control">
                                        <option value="">Select Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}"
                                                    @if(old('course_id', isset($request) ? $request->course_id:null) == $course->id) selected @endif
                                            >{{ $course->course_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="class_id" class="control-label">Class:</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach($course_classes as $course_class)
                            <option value="{{ $course_class->id }}"
                                                    @if(old('class_id', isset($request) ? $request->class_id:null) == $course_class->id) selected @endif
                                >{{ $course_class->class_name }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div> -->
                        <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="class_id" class="control-label">Batch:</label>
                                    <select name="batch_id" id="batch_id" class="form-control">
                                        <option value="">Select Batch</option>
                                        @foreach($course_batches as $course_batch)
                            <option value="{{ $course_batch->id }}"
                                                    @if(old('batch_id', isset($request) ? $request->batch_id:null) == $course_batch->id) selected @endif
                                >{{ $course_batch->course_batch_name }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div> -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Status:</label>
                                    <select name="result_status" id="result_status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach(\App\Support\Configs\Constants::$result_status as $status)
                                            <option value="{{ $status }}"
                                                    @if(old('result_status', isset($request) ? $request->result_status:null) == $status) selected @endif
                                            >{{ str_replace("-","",$status) }}</option>
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
            <div class="box">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Orders",
                        $captionIcon="icon-users",
                        $routeName="orders",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="sample_1">
                            <thead>
                            <tr>
                                <th> Company</th>
                                <th> Course</th>
                                <th> User</th>
                                <th> @sortablelink('event_start', 'Payment Type')</th>
                                <th> @sortablelink('amount', 'Amount')</th>
                                <th> Status</th>
                               <th> @sortablelink('created_at', 'Created At')</th>
                                <th> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orders as $order)

                                <tr class="odd gradeX">
                                    <td style="color: #76767f">{{isset($order->company)?$order->company->company_name:null}}</td>
                                    <td style="color: #76767f">{{isset($order->course)?$order->course->course_title:null}}</td>
                                    <td style="color: #76767f">{{isset($order->user)?$order->user->name:null}}</td>
                                    <td>{{isset($order->amount)?$order->amount:null}}</td>
                                    <td>
                                        {!! \CHTML::flagChangeButton($order,
                                                'order_status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td> {{isset($order->created_at)?$order->created_at->format('d M, Y'):null}}</td>
                                   <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $order->id,
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
                {!! \CHTML::customPaginate($orders,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')

@endpush


