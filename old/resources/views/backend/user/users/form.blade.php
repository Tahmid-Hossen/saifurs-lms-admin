@include('backend.layouts.partials.errors')
<div class="box-body">
    {!! \Form::hidden('user_id', isset($user) ? $user->id : null, ['id' => 'user_id']) !!}
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', 'Full Name', (isset($user) ? $user->name : null) , true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('username', 'Username (Unique Identifier)', (isset($user) ? $user->username : null) , true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nTel('mobile_number', 'Mobile Number', (isset($user) ? $user->mobile_number : null) , true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nEmail('email', 'Email Address', (isset($user) ? $user->email : null) , true) !!}
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nPassword('password', 'Password', (isset($user) ? '' : '123456') , empty($user)) !!}
            <span class="help-block">
                    {{isset($user) ? 'Left it blank if you do not want to change!!!':'By default: 123456;'}}
                </span>
        </div>
        <div class="col-md-6">
            {!! \Form::nPassword('password_confirmation', 'ReType Password', (isset($user) ? '' : '123456') , empty($user)) !!}
            <span class="help-block">
                    {{isset($user) ? 'Left it blank if you do not want to change!!!':'By default: 123456;'}}
                </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group @error('roles.*') has-error @enderror">
                {!! \Form::nLabel('role', 'Assign Role(s)', true) !!}
                <select class="form-control tags" id="role" name="roles[]">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" label="{{ $role->name }}"
                                @if(isset($userRoles))
                                @foreach($userRoles as $userRole)
                                @if($role->id == $userRole) selected @endif
                                @endforeach
                                @elseif(!empty(old('roles')))
                                @foreach(old('roles') as $r)
                                @if($role->id == $r) selected @endif
                            @endforeach
                            @endif
                        >
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <span id="roles-error" class="d-block text-danger help-block">
                    @error('roles.*')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="status" class="control-label">@lang('common.Status')</label>
                <select name="status" id="status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$user_status as $status)
                        <option value="{{$status}}"
                                @if (isset($user) && ($user->status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!!
        \CHTML::actionButton(
            $reportTitle='..',
            $routeLink='#',
            isset($user) ? $user->id : null,
            $selectButton=['cancelButton','storeButton'],
            $class = ' btn-icon btn-circle ',
            $onlyIcon='yes',
            $othersPram=array()
        )
    !!}
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            formObject = $("form#users");
            formObject.validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    username: {
                        required: true,
                        minlength: 5,
                        maxlength: 255,
                        alphanumeric:true
                       /* uniqueusername: function () {
                            return $('#user_id').val();
                        }*/
                    },
                    mobile_number: {
                        required: true,
                        minlength: 11,
                        maxlength: 11,
                        mobilenumber: true,
                        digits: true
                    },
                    email: {
                        required: true,
                        minlength: 5,
                        maxlength: 255,
                        email:true
                        /*uniqueemail: function () {
                            return $('#user_id').val();
                        },*/
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 255
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 6,
                        maxlength: 255,
                        equalTo: "#password"
                    },
                    "roles[]": {
                        minlength: 1,
                        required: true
                    }
                },
                messages: {
                    'roles[]': "Please assign at least 1 Role(s)"
                }
            });
            $('#username').focusout(function () {
                findUserName();
            });
            $('#email').focusout(function () {
                findEmail();
            });
            $('#mobile_number').focusout(function () {
                findMobile();
            });
        });
    </script>
@endpush
