<div class="nav-tabs-custom">
    <div class="tab-content">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="portlet-body">
            <input type="hidden" id="totalRow" name="totalRow" value="">
            <div class="panel-heading"><i class="fa fa-star" aria-hidden="true"></i> Result </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_id"> Company
                                <span class="required text-danger" aria-required="true"> * </span>
                            </label>
                            <select name="company_id" id="company_id" class="form-control auto_search">
                            <option value="" @if (isset($result) && ($result->company_id === "")) selected @endif>Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}"
                                            @if (isset($result->company_id) && ($result->company_id === $company->id)) selected @endif
                                    >{{$company->company_name}}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                            <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('company_id') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="course_id"> Course
                                <span class="required text-danger" aria-required="true"> * </span>
                            </label>
                            <select name="course_id" id="course_id" class="form-control auto_search">
                            <option value="" @if (isset($result) && ($result->course_id === "")) selected @endif>Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}"
                                            @if (isset($result->course_id) && ($result->course_id === $course->id)) selected @endif
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="class_id"> Class
                                {{--<span class="required text-danger" aria-required="true"> * </span>--}}
                            </label>
                            <select name="class_id" id="class_id" class="form-control auto_search class_id">
                            <option value="" @if (isset($result) && ($result->class_id === "")) selected @endif>Select Class</option>
                                @foreach($course_classes as $class)
                                    <option value="{{$class->id}}"
                                            @if (isset($result->class_id) && ($result->class_id === $class->id)) selected @endif
                                    >{{$class->class_name}}</option>
                                @endforeach
                            </select>
                            @error('class_name')
                                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('class_name') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="batch_id"> Course Batch
                                <span class="required text-danger" aria-required="true"> * </span>
                            </label>
                            <select name="batch_id" id="batch_id" class="form-control auto_search">
                            <option value="" @if (isset($result) && ($result->batch_id === "")) selected @endif>Select Batch</option>
                                @foreach($course_batches as $course_batch)
                                    <option value="{{$course_batch->id}}"
                                            @if (isset($result->batch_id) && ($result->batch_id === $course_batch->id)) selected @endif
                                    >{{$course_batch->course_batch_name}}</option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('batch_id') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="quiz_id"> Quiz
                                <span class="required text-danger" aria-required="true"> * </span>
                            </label>
                            <select name="quiz_id" id="quiz_id" class="form-control auto_search">
                            <option value="" @if (isset($result) && ($result->quiz_id === "")) selected @endif>Select Quiz</option>
                                @foreach($quizzes as $quiz)
                                    <option value="{{$quiz->id}}"
                                            @if (isset($result->quiz_id) && ($result->quiz_id === $quiz->id)) selected @endif
                                    >{{$quiz->quiz_topic}}</option>
                                @endforeach
                            </select>
                            @error('quiz_id')
                            <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('quiz_id') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row" id="student_list">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-footer">
        <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i> Save</button>
        <a href="{{route('results.index')}}" class="btn default" >
            Cancel
        </a>
    </div>
</div>

{{--<script>
    $(function(){
        $('.float_number').keypress(function(e) {
        if(isNaN(this.value+""+String.fromCharCode(e.charCode)))
            return false;
        })
        .on("paste",function(e){
            e.preventDefault();
        });

    });
</script>--}}
