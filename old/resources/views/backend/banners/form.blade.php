@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        @if (auth()->user()->userDetails->company_id == 1)
            <div class="col-md-12">
                <div class="form-group">
                    {!! \Form::nLabel('company_id', 'Company', true) !!}
                    <select name="company_id" id="company_id" class="form-control custom-select" required>
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @if (old('company_id', isset($banner) ? $banner['company_id'] : null) == $company->id) selected @endif>{{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="company_id-error" class="help-block d-block text-danger">
                        {{ $errors->first('company_id') }}
                    </span>
                </div>
            </div>
        @else
            <input type="hidden" name="company_id" id="company_id"
                value="{{ auth()->user()->userDetails->company_id }}">
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('banner_title', 'Banner Title', true) !!}
                <input id="banner_title" type="text" class="form-control" name="banner_title"
                    value="{{ old('banner_title', isset($banner) ? $banner->banner_title : null) }}" required>
                <span id="banner_title-error" class="help-block d-block text-danger">
                    {{ $errors->first('banner_title') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                @php $banner_img_width = \Utility::$bannerImageSize['width'] ; $banner_img_height = \Utility::$bannerImageSize['height']@endphp
                {!! \Form::nLabel('banner_image', 'Banner (' . $banner_img_width . 'px  X  ' . $banner_img_height . 'px)', empty($banner->banner_image)) !!}
                <input type="file" class="form-control" name="banner_image" id="banner_image"
                    placeholder="Enter a Banner" onchange="imageIsLoaded(this, 'banner_image_show');"
                    value="{{ old('banner_image', isset($banner) ? $banner->banner_image : null) }}">
                @if (isset($banner->banner_image))
                    <input type="hidden" name="existing_image" value="{{ $banner->banner_image }}">
                @endif
                <div class="img-responsive img-thumbnail bg-dark my-2 text-center" style="width: 100%; height: 216px">
                    <img id="banner_image_show" style="height: 206px; display: inline-block; max-width: 100%"
                        src="{{ isset($banner->banner_image) ? URL::to($banner->banner_image) : 'https://dummyimage.com/'.$banner_img_width.'X'.$banner_img_height.'' }}">
                </div>
                <span id="banner_image-error" class="help-block d-block text-danger">
                    {{ $errors->first('banner_image') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nLabel('banner_status', 'Status') !!}
            <select name="banner_status" id="banner_status" class="form-control" required>
                @foreach (\Utility::$statusText as $key => $val)
                    <option value="{{ $val }}" @if (old('banner_status', isset($banner) ? $banner['banner_status'] : null) == $val) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="box-footer">
    {!! \CHTML::actionButton($reportTitle = '..', $routeLink = '#', null, $selectButton = ['cancelButton', 'storeButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'yes', $othersPram = []) !!}
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            formObject = $("form#banner_form");
            formValidator = formObject.validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    banner_title: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    banner_image: {
                        required: {{ empty($banner->banner_image) ? 'true' : 'false' }},
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                }
            });
        });
    </script>
@endpush
