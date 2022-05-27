<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! \Form::nLabel('vendor_name', 'Name', true) !!}
                            <input
                                id="vendor_name"
                                type="text"
                                class="form-control"
                                name="vendor_name"
                                placeholder="Enter Vendor Name"
                                value="{{ old('vendor_name', isset($vendor) ? $vendor->vendor_name: null) }}"
                                required
                                autofocus
                            >
                            <span id="vendor_name-error" class="help-block">{{ $errors->first('vendor_name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! \Form::nLabel('vendor_status', 'Status', true) !!}
                            <select name="vendor_status" id="vendor_status" class="form-control">
                                @foreach(\App\Support\Configs\Constants::$user_status as $status)
                                    <option value="{{$status}}"
                                            @if (isset($vendor) && ($vendor->vendor_status === $status)) selected @endif
                                    >{{$status}}</option>
                                @endforeach
                            </select>
                            <span id="vendor_status-error" class="help-block">{{ $errors->first('vendor_status') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! \Form::nLabel('vendor_logo', 'Logo', empty($vendor->vendor_logo)) !!}
                            <input
                                type="file"
                                class="form-control"
                                name="vendor_logo"
                                id="vendor_logo"
                                placeholder="Enter Vendor Flag"
                                value="{{ old('vendor_logo', isset($vendor) ? $vendor->vendor_logo:null) }}"
                                @if(!isset($vendor))
                                    required
                                @endif
                                readonly
                            >
                            <span id="vendor_logo-error" class="help-block">{{ $errors->first('vendor_logo') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <img
                        id="vendor_logo_show"
                        src="{{isset($vendor->vendor_logo)?URL::to($vendor->vendor_logo):config('app.default_image')}}"
                        width="{{\Utility::$vendorLogoSize['width']}}"
                        height="{{\Utility::$vendorLogoSize['height']}}"
                    >
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!!
        \CHTML::actionButton(
            $reportTitle='..',
            $routeLink='#',
            '',
            $selectButton=['cancelButton','storeButton'],
            $class = ' btn-icon btn-circle ',
            $onlyIcon='yes',
            $othersPram=array()
        )
    !!}
</div>
