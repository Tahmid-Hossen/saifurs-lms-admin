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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="class_id"> Class
                                <span class="required text-danger" aria-required="true"> * </span>
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user_id"> Student
                                <span class="required text-danger" aria-required="true"> * </span>
                            </label>
                            <select name="user_id" id="user_id" class="form-control auto_search">
                            <option value="" @if (isset($result) && ($result->user_id === "")) selected @endif>Select Student</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}"
                                            @if (isset($result->user_id) && ($result->user_id === $user->id)) selected @endif
                                    >{{$user->name}}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="result_title"> Result Title
                                <span class="required text-danger" aria-required="true"> * </span>
                            </label>
                            <input
                                type="text"
                                class="form-control view-color"
                                name="result_title"
                                id="result_title"
                                placeholder="Enter Result Title"
                                value="{{ old('result_title', isset($result) ? $result->result_title: null) }}"
                                autofocus
                            >
                            @error('result_title')
                                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('result_title') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

{{--                    <div class="col-md-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="result_details"> Details--}}
{{--                            </label>--}}
{{--                            <textarea id="result_details" name="result_details" rows="5" class="form-control" placeholder="Enter Result Details">--}}
{{--                                {{ old('result_details', isset($result->result_details) ? $result->result_details: null) }}</textarea>--}}

{{--                            @error('result_details')--}}
{{--                            <span class="form-text text-danger" role="alert">--}}
{{--                                    <strong>{{ $errors->first('result_details') }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_score"> Score</label>
                            <input
                                type="number"
                                min="1"
                                id="number"
                                class="form-control float_number"
                                name="total_score"
                                id="total_score"
                                placeholder="Enter Total Score"
                                value="{{ old('total_score', isset($result) ? $result->total_score: null) }}"
                            >
                            @error('total_score')
                                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('total_score') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pass_score"> Pass Mark</label>
                            <input
                                type="number"
                                min="1"
                                id="number"
                                class="form-control float_number"
                                name="pass_score"
                                id="pass_score"
                                placeholder="Enter Pass Mark"
                                value="{{ old('pass_score', isset($result) ? $result->pass_score: null) }}"
                            >
                            @error('pass_score')
                            <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('pass_score') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fail_score"> Fail Mark</label>
                            <input
                                type="number"
                                min="1"
                                id="number"
                                class="form-control float_number"
                                name="fail_score"
                                id="fail_score"
                                placeholder="Enter Fail Mark"
                                value="{{ old('fail_score', isset($result) ? $result->fail_score: null) }}"
                            >
                            @error('fail_score')
                            <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('fail_score') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="result_status"> Status
                            </label>
                            <select name="result_status" id="result_status" class="form-control view-color">
                                @foreach(\App\Support\Configs\Constants::$question_status as $status)
                                    <option value="{{$status}}"
                                            @if (isset($result) && ($result->result_status === $status)) selected @endif
                                    >{{str_replace("-","",$status)}}</option>
                                @endforeach
                            </select>
                            @error('result_status')
                                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('result_status') }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
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

<script>
    $(function(){
        $('.float_number').keypress(function(e) {
        if(isNaN(this.value+""+String.fromCharCode(e.charCode)))
            return false;
        })
        .on("paste",function(e){
            e.preventDefault();
        });

    });
</script>
