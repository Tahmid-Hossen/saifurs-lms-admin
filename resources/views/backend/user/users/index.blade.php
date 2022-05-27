@extends('backend.layouts.master')

@section('title')
    Roles
@endsection

@section('page_styles')

@endsection

@section('content')
    <div class="row">
        @section('content-header')
            <h1>
                <i class="fa fa-users"></i>
                User
                <small>Control Panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Users",
                        $captionIcon="icon-users",
                        $routeName="users",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table
                            class="table table-striped table-bordered table-hover table-checkable order-column"
                            >
                            <thead>
                            <tr>
                                <th> ID</th>
                                <th> Name</th>
                                <th> Email</th>
                                <th> Roles</th>
                                <th> Status</th>
                                <th> Created At</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>
                                        <a href="{{ route('users.show',$user->id) }}">
                                            {!! $user->name !!}
                                        </a>
                                    </td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            {!! $role->name !!} {!! (!$loop->last) ? ', ':'' !!}
                                        @empty
                                            NA
                                        @endforelse
                                    </td>
                                    <td>{!! \CHTML::flagChangeButton($user, 'status', \Utility::$statusText) !!}</td>
                                    {{--<td class="tbl-date"> {{$user->created_at->format('d M, Y')}}</td>
                                    --}}
                                    <td class="tbl-date">{{$user->created_at->format(config('app.date_format2'))}}</td>

                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $user->id,
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
                    {!! \CHTML::customPaginate($users,'') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('scripts')

@endpush


