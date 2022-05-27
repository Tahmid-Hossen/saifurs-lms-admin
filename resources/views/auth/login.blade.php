@extends('layouts.app')
@section('body-class', 'hold-transition login-page')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{!! config('app.name') !!}</b></a>
        </div>
        <!-- /.login-logo -->
        @include('backend.layouts.flash')

        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                @if(config('app.login_method')==0)
                    <div class="form-group has-feedback">
                        <input id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required
                               autofocus autocomplete="off">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                        @endif
                    </div>
                @endif
                @if(config('app.login_method')==1)
                    <div class="form-group has-feedback">
                        <input id="username" type="text"
                               class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                               placeholder="{{ __('User Name') }}" name="username" value="{{ old('username') }}"
                               required autofocus autocomplete="off">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                        @endif
                    </div>
                @endif
                @if(config('app.login_method')==2)
                    <div class="form-group has-feedback">
                        <input id="username" type="text"
                               class="form-control{{ $errors->has('mobile_number') ? ' is-invalid' : '' }}"
                               placeholder="{{ __('Mobile Number') }}" name="mobile_number"
                               value="{{ old('mobile_number') }}" required autofocus autocomplete="off">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>

                        @if ($errors->has('mobile_number'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('mobile_number') }}</strong>
                    </span>
                        @endif
                    </div>
                @endif
                <div class="form-group has-feedback">
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('Password') }}" name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false"
                                     style="position: relative;">
                                    <input type="checkbox"
                                           style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0; padding: 0; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                    <ins class="iCheck-helper"
                                         style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0; padding: 0; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                </div>
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-12">
                        @include('backend.layouts.partials.errors')
                    </div>
                </div>
            </form>

        {{--<div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="https://adminlte.io/themes/AdminLTE/pages/examples/login.html#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                Facebook</a>
            <a href="https://adminlte.io/themes/AdminLTE/pages/examples/login.html#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                Google+</a>
        </div>--}}
        <!-- /.social-auth-links -->

            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a><br>
            {{--<a href="{{ route('register') }}" class="text-center">Register a new membership</a>--}}

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
