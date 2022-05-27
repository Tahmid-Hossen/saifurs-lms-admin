@include('backend.layouts.partials.errors')
<div class="box-body">
    <h3>Event Inititals</h3>
    <section>
        <div class="row">
            @if (auth()->user()->userDetails->company_id == 1)
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('company_id', 'Company', true) !!}
                        <select name="company_id" id="company_id" class="form-control custom-select" required>
                            <option value="">Select Company</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                        @if (old('company_id', isset($event) ? $event['company_id'] : null) == $company->id) selected @endif>{{ $company->company_name }}
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
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('branch_id', 'Branch') !!}
                    <select name="branch_id" id="branch_id" class="form-control">
                        <option value="">Select Branch</option>
                    </select>
                    <span id="branch_id-error" class="help-block d-block text-danger">
                            {{ $errors->first('branch_id') }}
                        </span>
                </div>
            </div>
        </div> <!-- end row -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! \Form::nLabel('event_title', 'Event Title', true) !!}
                    <input id="event_title" type="text" class="form-control" name="event_title"
                           value="{{ old('event_title', isset($event) ? $event->event_title : null) }}"
                           required>
                    <span id="event_title-error" class="help-block d-block text-danger">
                            {{ $errors->first('event_title') }}
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('event_type', 'Event Type', true) !!}
                    <select name="event_type" id="event_type" class="form-control" required>
                        <option value="">Select Event Type</option>
                        @foreach (\Utility::$eventType as $key => $eventType)
                            <option value="{{ $key }}"
                                    @if (old('event_type', isset($event) ? $event->event_type : null) == $key) selected @endif>{{ $eventType }}</option>
                        @endforeach
                    </select>
                    <span id="event_type-error" class="help-block d-block text-danger">
                            {{ $errors->first('event_type') }}
                        </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('event_schedule', 'Event Duration(Start - End)', true) !!}
                    @php
                        $start_date = (isset($event) && !is_null($event->event_start))
                        ? \Carbon\Carbon::parse($event->event_start)->format('Y-m-d H:i:s')
                        : date('Y-m-d H:i:s');

                        $end_date = (isset($event) && !is_null($event->event_end))
                        ? \Carbon\Carbon::parse($event->event_end)->format('Y-m-d H:i:s')
                        : date('Y-m-d H:i:s');

                        $duration = $start_date . ' - ' . $end_date;
                    @endphp
                    <input id="event_schedule" type="text" readonly
                           class="form-control event_duration" name="event_schedule"
                           value="{{ old('event_schedule', $duration) }}"
                           required>
                    <span id="event_schedule-error" class="help-block d-block text-danger">
                            {{ $errors->first('event_schedule') }}
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('event_link', 'Event Join Link', true) !!}
                    <input id="event_link" type="text"
                           class="form-control"
                           name="event_link"
                           value="{{ old('event_link', isset($event) ? $event->event_link : null) }}"
                           placeholder="https://example-meeting.com/" required>
                    <span id="event_link-error" class="help-block d-block text-danger">
                            {{ $errors->first('event_link') }}
                        </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="event_featured" class="control-label">Featured Event</label>
                    <select name="event_featured" id="event_featured" class="form-control">
                        @foreach (\Utility::$featuredStatusText as $featuredStatus)
                            <option value="{{ $featuredStatus }}"
                                    @if (isset($event) && $event->event_featured === $featuredStatus) selected @endif>{{ $featuredStatus }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>
    <h3>Event Promo Banner & Description</h3>
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! \Form::nLabel('event_status', 'Event Status') !!}
                    <select name="event_status" id="event_status" class="form-control">
                        @foreach (\Utility::$statusText as $status)
                            <option value="{{ $status }}"
                                    @if (isset($event) && $event->event_status === $status) selected @endif>{{ $status }}</option>
                        @endforeach
                    </select>
                    <span id="event_status-error" class="help-block d-block text-danger">
                            {{ $errors->first('event_status') }}
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    @php $event_banner_width = \Utility::$eventImageSize['width'] ; $event_banner_height = \Utility::$eventImageSize['height']@endphp
                    {!! \Form::nLabel('event_image', 'Event Banner ('.$event_banner_width.'px  X  '.$event_banner_height.'px)', (empty($event->event_image))) !!}
                    <input type="file" class="form-control" name="event_image" id="event_image"
                           placeholder="Enter Event Banner" onchange="imageIsLoaded(this, 'event_image_show');"
                           value="{{ old('event_image', isset($event) ? $event->event_image : null) }}">
                    @if (isset($event->event_image))
                        <input type="hidden" name="existing_image" value="{{ $event->event_image }}">
                    @endif
                    <div class="img-responsive img-thumbnail bg-dark my-2 text-center"
                         style="width: 100%; height: 216px">
                        <img id="event_image_show" style="height: 206px; display: inline-block; max-width: 100%"
                             src="{{ isset($event->event_image) ? URL::to($event->event_image) : 'https://dummyimage.com/'.$event_banner_width.'X'.$event_banner_height.'' }}">
                    </div>
                    <span id="event_image-error" class="help-block d-block text-danger">
                            {{ $errors->first('event_image') }}
                        </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! \Form::nLabel('event_description', 'Event Description', true) !!}
                    <textarea id="event_description" name="event_description"
                              class="form-control custom-editor"
                              required>{!! old('event_description', isset($event) ? $event->event_description : null) !!}</textarea>

                    <span id="event_description-error" class="help-block d-block text-danger">
                            {{ $errors->first('event_description') }}
                        </span>
                </div>
            </div>
        </div>
        <!-- end row -->
    </section>
</div>

@push('scripts')
    <script>
        const selected_branch_id = '{{ old('branch_id', isset($event) ? $event->branch_id : null) }}';

        $(document).ready(function () {
            //Jquery Steps
            $('.box-body').steps({
                startIndex: 0,
                onStepChanging: function (event, currentIndex, newIndex) {
                    if (currentIndex < newIndex) {
                        // Step 1 form validation
                        if (currentIndex === 0) {
                            return !!(formValidator.element("#company_id") &&
                                formValidator.element("#branch_id") &&
                                formValidator.element("#event_title") &&
                                formValidator.element("#event_type") &&
                                formValidator.element("#event_schedule") &&
                                formValidator.element("#event_link") &&
                                formValidator.element("#event_featured"));
                        }
                        // Step 2 form validation
                        if (currentIndex === 1) {
                            return !!(
                                formValidator.element("#event_image") &&
                                formValidator.element("#event_description") &&
                                formValidator.element("#event_status"));
                        }
                        // Always allow step back to the previous step even if the current step is not valid.
                    } else {
                        return true;
                    }
                },
                onFinished: function (event, currentIndex) {
                    formObject.submit();
                }
            });

            formObject = $("form#event_form");
            formValidator = formObject.validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    branch_id: {
                        required: false
                    },
                    event_title: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    event_type: {
                        required: true
                    },
                    event_link: {
                        required: true,
                        url: true
                    },
                    event_image: {
                        required: {{ empty($event->event_image) ? 'true' : 'false' }},
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    },
                    event_description : {
                        required:true
                    }
                }
            });


            if (selected_branch_id.length > 0) {
                getBranchDropdown($("#company_id"), $("#branch_id"), selected_branch_id);
                $("#branch_id").val(selected_branch_id);
                $("#branch_id").trigger("change:select2");
            }
            $("#company_id").change(function () {
                getBranchDropdown($(this), $("#branch_id"), selected_branch_id);
            });

            // date and time picker for events
            $('#event_duration, .event_duration').daterangepicker({
                timePicker: true,
                timePickerIncrement: 1,
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            });

            $('.custom-select').select2({
                width: "100%"
            });

            //editor
            $(".custom-editor").wysihtml5({
                toolbar : {
                    "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
                    "emphasis": true, //Italics, bold, etc. Default true
                    "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                    "html": false, //Button which allows you to edit the generated HTML. Default false
                    "link": true, //Button to insert a link. Default true
                    "image": false, //Button to insert an image. Default true,
                    "color": false, //Button to change color of font
                    "blockquote": false, //Blockquote
                    "size": "sm" //default: none, other options are xs, sm, lg
                }
            });
        });
    </script>
@endpush

