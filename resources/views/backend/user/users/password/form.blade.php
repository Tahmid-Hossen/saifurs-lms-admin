<div class="box-body">
{{--    <div class="container">--}}
        <div class="row">
            <div class="col-md-12 offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                            <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                <label for="new_password" class="col-md-4 control-label">Current Password</label>

                                <div class="col-md-6">
                                    <input id="current_password" type="password" class="form-control" name="current_password" value="{{ old('current_password') }}" required>

                                    @if ($errors->has('current_password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }} mt-5">
                                <label for="new_password" class="col-md-4 control-label">New Password</label>

                                <div class="col-md-6 mt-5">
                                    <input id="new_password" type="password" class="form-control" name="new_password" value="{{ old('new_password') }}" required>

                                    @if ($errors->has('new_password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <br>
                            <div class="form-group mt-5">
                                <label for="new_password_confirmation" class="col-md-4 control-label">Confirm New Password</label>

                                <div class="col-md-6 mt-5">
                                    <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}" required>
                                </div>
                            </div>

                            <br>
                            <div class="form-group mt-5">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary mt-5">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            formObject = $("form#changePassword");
            formObject.validate({
                rules: {
                    current_password: {
                        required: true,
                    },
                    new_password: {
                        required: true,
                    },
                    new_password_confirmation: {
                        required: true,
                    }
                }
            });
        });
    </script>
@endpush
