<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control" required>
                    <option value="" @if (isset($vendorMeeting) && ($vendorMeeting->company_id === "")) selected @endif>Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($vendorMeeting) && ($vendorMeeting->company_id === $company->id)) selected @endif
                        >{{$company->company_name}}</option>
                    @endforeach
                </select>
                <span id="company_id-error" class="help-block">{{ $errors->first('company_id') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('branch_id', 'Branch') !!}
                <select name="branch_id" id="branch_id" class="form-control">
                    <option value="">Select Branch</option>
                </select>
                <span id="branch_id-error" class="help-block">{{ $errors->first('branch_id') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('vendor_id', 'Vendor', true) !!}
                <select name="vendor_id" id="vendor_id" class="form-control" required>
                    <option value="" @if (isset($vendorMeeting) && ($vendorMeeting->vendor_id === "")) selected @endif>Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{$vendor->id}}"
                                @if (isset($vendorMeeting) && ($vendorMeeting->vendor_id === $vendor->id)) selected @endif
                        >{{$vendor->vendor_name}}</option>
                    @endforeach
                </select>
                <span id="vendor_id-error" class="help-block">{{ $errors->first('vendor_id') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course') !!}
                <select name="course_id" id="course_id" class="form-control">
                    <option value="" @if (isset($vendorMeeting) && ($vendorMeeting->company_id === "")) selected @endif>Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($vendorMeeting) && ($vendorMeeting->course_id === $course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="help-block">{{ $errors->first('course_id') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_batch_id', 'Batch') !!}
                <select name="course_batch_id" id="course_batch_id" class="form-control">
                    <option value="">Select Batch</option>
                </select>
                <span id="course_batch_id-error" class="help-block">{{ $errors->first('course_batch_id') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_chapter_id', 'Chapter') !!}
                <select name="course_chapter_id" id="course_chapter_id" class="form-control">
                    <option value="">Select Chapter</option>
                </select>
                <span id="course_chapter_id-error" class="help-block">{{ $errors->first('course_chapter_id') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('course_class_id', 'Class') !!}
                <select name="course_class_id" id="course_class_id" class="form-control">
                    <option value="">Select Class</option>
                </select>
                <span id="course_class_id-error" class="help-block">{{ $errors->first('course_class_id') }}</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('instructor_id', 'Instructor') !!}
                <select name="instructor_id" id="instructor_id" class="form-control">
                    <option value="">Select Instructor</option>
                </select>
                <span id="instructor_id-error" class="help-block">{{ $errors->first('instructor_id') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        {!! \Form::nLabel('vendor_meeting_duration', 'Meeting Duration(Start - End)', true) !!}
                        @php
                            $start_date = (isset($event) && !is_null($event->event_start))
                            ? $event->event_start->format('Y-m-d H:i:s')
                            : date('Y-m-d H:i:s');

                            $end_date = (isset($event) && !is_null($event->event_end))
                            ? $event->event_end->format('Y-m-d H:i:s')
                            : date('Y-m-d H:i:s');

                            $duration = $start_date . ' - ' . $end_date;
                        @endphp
                        <input id="vendor_meeting_duration" type="text" readonly
                               class="form-control event_duration" name="vendor_meeting_duration"
                               value="{{ old('vendor_meeting_duration', $duration) }}"
                               required>
                        <span id="vendor_meeting_duration-error" class="help-block d-block text-danger">
                            {{ $errors->first('vendor_meeting_duration') }}
                        </span>
                    </div>
                    <div class="form-group">
                        {!! \Form::nLabel('vendor_meeting_title', 'Name', true) !!}
                        <input
                            id="vendor_meeting_title"
                            type="text"
                            class="form-control"
                            name="vendor_meeting_title"
                            placeholder="Enter Vendor Meeting Name"
                            value="{{ old('vendor_meeting_title', isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_title: null) }}"
                            required
                            autofocus
                        >
                        <span id="vendor_meeting_title-error" class="help-block">{{ $errors->first('vendor_meeting_title') }}</span>
                    </div>
                    <div class="form-group">
                        {!! \Form::nLabel('vendor_meeting_agenda', 'Agenda', true) !!}
                        <textarea id="vendor_meeting_agenda" name="vendor_meeting_agenda" required rows="5" class="form-control" placeholder="Enter Meeting Agenda">{{ old('vendor_meeting_agenda', isset($vendorMeeting->vendor_meeting_agenda) ? $vendorMeeting->vendor_meeting_agenda: null) }}</textarea>
                        <span id="vendor_meeting_agenda-error" class="help-block">{{ $errors->first('vendor_meeting_agenda') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! \Form::nLabel('vendor_meeting_status', 'Status') !!}
                        <select name="vendor_meeting_status" id="vendor_meeting_status" class="form-control">
                            @foreach(\App\Support\Configs\Constants::$user_status as $status)
                                <option value="{{$status}}"
                                        @if (isset($vendor) && ($vendor->vendor_status === $status)) selected @endif
                                >{{$status}}</option>
                            @endforeach
                        </select>
                        <span id="vendor_meeting_status-error" class="help-block">{{ $errors->first('vendor_meeting_status') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! \Form::nLabel('vendor_meeting_url', 'URL', true) !!}
                        <input
                            id="vendor_meeting_url"
                            type="text"
                            class="form-control"
                            name="vendor_meeting_url"
                            placeholder="Enter Assignment URL"
                            value="{{ old('vendor_meeting_url', isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_url: null) }}"
                            autofocus
                            required
                        >
                        <span id="vendor_meeting_url-error" class="help-block">{{ $errors->first('vendor_meeting_url') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! \Form::nLabel('vendor_meeting_logo', 'Logo', empty($vendorMeeting->vendor_meeting_logo)) !!}
                        <input
                            type="file"
                            class="form-control"
                            name="vendor_meeting_logo"
                            id="vendor_meeting_logo"
                            placeholder="Enter Assignment Document"
                            value="{{ old('vendor_meeting_logo', isset($vendorMeeting) ? $vendorMeeting->vendor_meeting_logo:null) }}"
                        >
                        <span id="vendor_meeting_logo-error" class="help-block">{{ $errors->first('vendor_meeting_logo') }}</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <img class="img-thumbnail img-responsive"
                         id="vendor_meeting_logo_show"
                         src="{{isset($vendorMeeting->vendor_meeting_logo)?URL::to($vendorMeeting->vendor_meeting_logo):config('app.default_image')}}"
                         width="{{\Utility::$vendorMeetingLogoSize['width']}}"
                         height="{{\Utility::$vendorMeetingLogoSize['height']}}"
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
