@extends('backend.layouts.master')
@section('title')
    Detail/Show Event
@endsection

@section('content-header')
    <h1><i class="fa fa-graduation-cap"></i>Event Users</h1>
    <p>{!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}</p>
@endsection

@section('content')
    <div class="page-content-wrapper">
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="box-title">Event Registered List</h2>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!! \CHTML::actionButton($reportTitle = '..', $routeLink = '#', $event->id, $selectButton = ['backButton', 'editButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'no', $othersPram = []) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email Address</th>
                                    <th>Invitation</th>
                                    <th>Remarks</th>
                                    <th>Applied At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($event->getEnrolledUsersList as $index => $invite)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td> {{ $invite->name }}</td>
                                        <td> {{ $invite->mobile_number }}</td>
                                        <td> {{ $invite->email }}</td>
                                        <td>
                                            @if($invite->pivot->event_user_status == 'confirmed')
                                                <h4 class="label label-success">Confirmed</h4>
                                            @else
                                                <h4 class="label label-warning">Pending</h4>
                                            @endif
                                        </td>
                                        <td>{{ $invite->pivot->remarks }}</td>
                                        <td>{{ \Carbon\Carbon::parse($invite->pivot->created_at)->format('d/m/Y h:i A') }}</td>
                                        <td class="tbl-action">
                                            <div style="display: flex; min-width:102px !important; justify-content: flex-end;">
                                                <a href="{{ route('user-details.show', $invite->id) }}"
                                                   class="btn btn-xs btn-success  m-2  btn-icon btn-circle "
                                                   title="Show">
                                                    <i class="fa fa-eye"></i>
                                                </a>
{{--                                                <a href="http://127.0.0.1:8000/backend/books/7/edit"
                                                       class="btn btn-xs m-2 btn-primary" title="Edit">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>

                                                <a
                                                    href="http://127.0.0.1:8000/backend/common/delete?id=7&amp;route=books"
                                                    class="btn btn-xs btn-danger m-2" data-target="#pop-up-modal"
                                                    data-toggle="modal" title="Delete">
                                                    <i class="fa fa-times"></i>
                                                </a>--}}
                                            </div>


                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="text-align: center !important;">No Invitation data Found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
