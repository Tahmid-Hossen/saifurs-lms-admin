<div class="modal-dialog modal-dialog-centered">

    <!-- BEGIN FORM-->
    {!! \Form::open(['route' => [$request->get('route').'.destroy', $request->get('id')], 'method' =>'delete']) !!}
    <div class="modal-content">
        <div class="modal-header with-border">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title">
                @php
                    \Breadcrumbs::setCurrentRoute($request->get('route').'.destroy');
                @endphp
                {{ \Breadcrumbs::generate()->where('current', '!==', false)->last()->title }}
            </h4>
        </div>
        <div class="modal-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            @if(config('app.login_method')==0)
                                <div class="col-md-12">
                                    <label for="email" class="control-label">
                                        Email
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        value=""
                                        required
                                        autofocus
                                    >

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                            @endif
                            @if(config('app.login_method')==1)
                                <div class="col-md-12">
                                    <label for="username" class="control-label">
                                        User Name
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input
                                        id="username"
                                        type="username"
                                        class="form-control"
                                        name="username"
                                        value=""
                                        required
                                        autofocus
                                    >

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="employee_department_history_start_date" class="control-label">
                                    Password
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default pull-left text-bold" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger  text-bold">
                <i class="fa fa-times"></i>
                Delete
            </button>
        </div>
    </div>
{!! \Form::close() !!}
<!-- END FORM-->
</div>
