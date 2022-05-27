@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
    <!-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="class_id"> Class
                                <span class="required text-danger" aria-required="true"> * </span>
                            </label>
                            <select name="class_id" id="class_id" class="form-control auto_search class_id">
                                @foreach($course_classes as $class)
        <option value="{{$class->id}}"
                                            @if (isset($course_learn->class_id) && ($course_learn->class_id === $class->id)) selected @endif
            >{{$class->class_name}}</option>
                                @endforeach
        </select>
@error('class_name')
        <span class="form-text text-danger" role="alert">
                <strong>{{ $errors->first('class_name') }}</strong>
                                </span>
                            @enderror
        </div>
    </div> -->
{{--        <div class="col-md-4">
            <div class="form-group">
                <label for="company_id"> Company
                    <span class="required text-danger" aria-required="true"> * </span>
                </label>
                <select name="company_id" id="company_id" class="form-control auto_search view-color">
                    <option value="" @if (isset($course_learn) && ($course_learn->company_id === "")) selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($course_learn->company_id) && ($course_learn->company_id === $company->id)) selected @endif
                        >{{$company->company_name}}</option>
                    @endforeach
                </select>
                @error('company_name')
                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                @enderror
            </div>
        </div>--}}
        <input type="hidden" id="company_id" name="company_id" value="{{auth()->user()->userDetails->company_id}}" />
        <div class="col-md-12">
            <div class="form-group">
                <label for="course_id"> Course
                    <span class="required text-danger" aria-required="true"> * </span>
                </label>
                <select name="course_id" id="course_id" class="form-control auto_search">
                    <option value="" @if (isset($course_learn) && ($course_learn->course_id === "")) selected @endif>
                        Select Course
                    </option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}"
                                @if (isset($course_learn->course_id) && ($course_learn->course_id === $course->id)) selected @endif
                        >{{$course->course_title}}</option>
                    @endforeach
                </select>
                @error('course_id')
                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('course_id') }}</strong>
                                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="learn_title"> Course Learn Title
                    <span class="required text-danger" aria-required="true"> * </span>
                </label>
                <input
                    type="text"
                    class="form-control view-color"
                    name="learn_title"
                    id="learn_title"
                    placeholder="Enter Title"
                    value="{{ old('learn_title', isset($course_learn) ? $course_learn->learn_title: null) }}"
                    autofocus
                >
                @error('learn_title')
                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('learn_title') }}</strong>
                                </span>
                @enderror
            </div>
        </div>
    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="learn_slug"> Slug
                            </label>
                            <input
                                type="text"
                                class="form-control view-color"
                                name="learn_slug"
                                id="learn_slug"
                                placeholder="Enter Slug"
                                value="{{ old('learn_slug', isset($course_learn) ? $course_learn->learn_slug: null) }}"

                            >
                            @error('learn_slug')
        <span class="form-text text-danger" role="alert">
                <strong>{{ $errors->first('learn_slug') }}</strong>
                                </span>
                            @enderror
        </div>
    </div> -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="learn_details"> Details
                </label>
                <textarea id="learn_details" name="learn_details" rows="5"
                          class="form-control details_editor editor view-color"
                          placeholder="Enter Details">{{ old('learn_details', isset($course_learn->learn_details) ? $course_learn->learn_details: null) }}</textarea>

                @error('learn_details')
                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('learn_details') }}</strong>
                                </span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='course-learns.index',
        null,
        $selectButton=['cancelButton','storeButton'],
        $class = ' btn-icon btn-circle ',
        $onlyIcon='yes',
        $othersPram=array()
    )
!!}
</div>


