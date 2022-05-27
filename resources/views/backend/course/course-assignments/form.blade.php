<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control" required>
                    <option value=""
                            @if (isset($courseAssignment) && ($courseAssignment->company_id === "")) selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($courseAssignment) && ($courseAssignment->company_id === $company->id)) selected @endif
                        >{{$company->company_name}}</option>
                    @endforeach
                </select>
                <span id="company_id-error" class="help-block text-danger"><strong>{{ $errors->first('company_id') }}</strong></span>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('branch_id', 'Branch') !!}
                <select name="branch_id" id="branch_id" class="form-control">
                    <option value="">Select Branch</option>
                </select>
                <span id="branch_id-error" class="help-block text-danger"><strong>{{ $errors->first('branch_id') }}</strong></span>
            </div>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value=""
                            @if (isset($courseAssignment) && ($courseAssignment->company_id === "")) selected @endif>
                        Select Course
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($courseAssignment) && ($courseAssignment->course_id === $course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="help-block text-danger"><strong>{{ $errors->first('course_id') }}</strong></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_chapter_id', 'Chapter') !!}
                <select name="course_chapter_id" id="course_chapter_id" class="form-control">
                    <option value="">Select Chapter</option>
                </select>
                <span id="course_chapter_id-error" class="help-block text-danger"><strong>{{ $errors->first('course_chapter_id') }}</strong></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('announcement_id', 'Announcement') !!}
                <select name="announcement_id" id="announcement_id" class="form-control">
                    <option value="">Select Announcement</option>
                </select>
                <span id="announcement_id-error" class="help-block text-danger"><strong>{{ $errors->first('announcement_id') }}</strong></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('instructor_id', 'Instructor', true) !!}
                <select name="instructor_id" id="instructor_id" class="form-control" required>
                    <option value="">Select Instructor</option>
                </select>
                <span id="instructor_id-error" class="help-block text-danger"><strong>{{ $errors->first('instructor_id') }}</strong></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('student_id', 'Student', true) !!}
                <select name="student_id" id="student_id" class="form-control" required>
                    <option value="">Select Student</option>
                </select>
                <span id="student_id-error" class="help-block text-danger"><strong>{{ $errors->first('student_id') }}</strong></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_assignment_name', 'Name', true) !!}
                <input
                    id="course_assignment_name"
                    type="text"
                    class="form-control"
                    name="course_assignment_name"
                    placeholder="Enter Assignment Name"
                    value="{{ old('course_assignment_name', isset($courseAssignment) ? $courseAssignment->course_assignment_name: null) }}"
                    required
                    autofocus
                >
                <span id="course_assignment_name-error" class="help-block text-danger"><strong>{{ $errors->first('course_assignment_name') }}</strong></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_assignment_detail', 'Detail', true) !!}
                <input
                    id="course_assignment_detail"
                    type="text"
                    class="form-control"
                    name="course_assignment_detail"
                    placeholder="Enter Assignment Detail"
                    value="{{ old('course_assignment_detail', isset($courseAssignment) ? $courseAssignment->course_assignment_detail: null) }}"
                    required
                    autofocus
                >
                <span id="course_assignment_detail-error" class="help-block text-danger"><strong>{{ $errors->first('course_assignment_detail') }}</strong></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_assignment_url', 'URL') !!}
                <input
                    id="course_assignment_url"
                    type="text"
                    class="form-control"
                    name="course_assignment_url"
                    placeholder="Enter Assignment URL"
                    value="{{ old('course_assignment_url', isset($courseAssignment) ? $courseAssignment->course_assignment_url: null) }}"
                    autofocus
                >
                <span id="course_assignment_url-error" class="help-block text-danger"><strong>{{ $errors->first('course_assignment_url') }}</strong></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('course_assignment_document', 'Document') !!}
                <input
                    type="file"
                    class="form-control"
                    name="course_assignment_document"
                    id="course_assignment_document"
                    placeholder="Enter Assignment Document"
                    value="{{ old('course_assignment_document', isset($courseAssignment) ? $courseAssignment->course_assignment_document:null) }}"
                >
                <span id="course_assignment_document-error" class="help-block text-danger"><strong>{{ $errors->first('course_assignment_document') }}</strong></span>
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!!
        CHTML::actionButton(
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
