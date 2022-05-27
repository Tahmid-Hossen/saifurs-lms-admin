<div class="box-body">
    <div class="row">
        @if (auth()->user()->userDetails->company_id == 1)
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('company_id', 'Company', true) !!}
                    <select name="company_id" id="company_id" class="form-control" required>
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                    @if (old('company_id', isset($data) ? $data['company_id'] : null)==$company->id) selected @endif>{{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="company_id-error" class="help-block text-danger"><strong>{{ $errors->first('company_id') }}</strong></span>
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" id="course_choose_from_dropdown">
            <div class="form-group">
                {!! \Form::nLabel('course_id', 'Course', true) !!}
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="" @if (isset($data) && ($data['course_id']==='' )) selected @endif>Select Course
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($data) && ($data['course_id']===$course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                <span id="course_id-error" class="help-block text-danger"><strong>{{ $errors->first('course_id') }}</strong></span>
            </div>
        </div>
        <div class="col-md-6">
            {!! Form::nSelectRange('course_rating_stars', 'Course Rating Stars', 1,5,isset($data) ? $data['course_rating_stars'] : null, true, ['class' => 'form-control', 'max'=>5, 'min'=>0, 'step' => "1"]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::nTextarea('course_rating_feedback', 'Course Feedback', isset($data) ? $data['course_rating_feedback'] : null, false, ['class' => 'form-control', 'placeholder' => 'Enter Course Feedback']) !!}
        </div>
    </div>
    @if(isset($data))
    <div class="row">
        <div class="col-md-6">
            <label for="is_approved" class="control-label">Course Rating is Approved ?</label>
            <select name="is_approved" id="is_approved" class="form-control" required>
                @foreach (Utility::$featuredStatusText as $key => $val)
                    <option value="{{ $val }}"
                            @if (old('is_approved', isset($data) ? $data['is_approved'] : null)==$val) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="course_rating_status" class="control-label">Course Rating Status</label>
            <select name="course_rating_status" id="course_rating_status" class="form-control" required>
                @foreach (Utility::$statusText as $key => $val)
                    <option value="{{ $val }}"
                            @if (old('course_rating_status', isset($data) ? $data['course_rating_status'] : null)==$val) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
</div>
<div class="box-footer">
    {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', null, $selectButton = ['cancelButton', 'storeButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'yes', $othersPram = []) !!}
</div>
