{{--@include('backend.layouts.partials.errors')--}}
<div class="box-body">
    <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group" id="url_box">
                <label for="course_video_url">GoogleApiKey </label>
                <input type="text"
                       class="form-control"
                       id="google_api_key"
                       name="google_api_key"
                       value="{{ old('google_api_key', isset($googleApiKey) ? $googleApiKey->google_api_key : null) }}"
                       placeholder="Enter Course URL: https://www.youtube.com/">
                <span id="google_api_key_id-error" class="form-text text-danger" role="alert">
                    {{ $errors->first('google_api_key') }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('status', 'Status', false) !!}
                <select name="status" id="status" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$googleApiKey_status as $status)
                        <option value="{{$status}}"
                                @if (isset($googleApiKey) && ($googleApiKey->status === $status)) selected @endif
                        >{{str_replace("-","",$status)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">{{ $errors->first('status') }}</span>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">


            </div>
        </div>
    </div>

</div>

<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='#',
        null,
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
            $("#googleApiKey_form").validate({
                rules: {
                    google_api_key: {
                        required: true,
                    }

                },
            });
        });

    </script>
@endpush



