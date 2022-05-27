@include('backend.layouts.partials.errors')
<style>
.correctanswer{
	width:20px;
	height:20px;
	margin-top:10px;
}
.labels{	
	padding:3px;
	height:20px;
	top:0;
	position:absolute;
}
</style>
<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control auto_search view-color">
                    <option value="" @if (isset($course_question) && ($course_question->company_id == "")) selected @endif>
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}"
                                @if (isset($course_question->company_id) && ($course_question->company_id == $company->id)) selected @endif
                        >{{$company->company_name}}</option>
                    @endforeach
                </select>
                <span id="company_id-error" class="form-text text-danger" role="alert">
                                    {{ $errors->first('company_name') }}
                                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('quiz_id', 'Quiz', true) !!}
                <select name="quiz_id" id="quiz_id" class="form-control auto_search view-color">
                    <option value="" @if (isset($course_question) && ($course_question->company_id == "")) selected @endif>
                        Select Quiz
                    </option>
                    @foreach($quizes as $quiz)
                        <option value="{{$quiz->id}}"
                                @if (isset($course_question->quiz_id) && ($course_question->quiz_id == $quiz->id)) selected @endif
                        >{{$quiz->quiz_topic}}</option>
                    @endforeach
                </select>
                <span id="company_id-error" class="form-text text-danger" role="alert">
                                    {{ $errors->first('company_name') }}
                                </span>
            </div>
        </div>        
    </div>
    <!-- end row -->
    
    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                {!! \Form::nLabel('question', 'Question', true)!!}
                <input
                    type="text"
                    class="form-control view-color"
                    name="question"
                    id="question"
                    placeholder="Enter Question"
                    value="{{ old('question', isset($course_question) ? $course_question->question: null) }}"
                    autofocus
                >
                <span class="form-text text-danger" role="alert">
                                    <strong>{{ $errors->first('question') }}</strong>
                                </span>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! \Form::nLabel('mark', 'Mark', true)!!}
                <input type="number" class="form-control view-color" name="mark" id="mark" placeholder="Enter Mark" value="{{ old('mark') }}" pattern="[0-9]+" min="0">
                	<span class="form-text text-danger" role="alert">
                        <strong>{{ $errors->first('mark') }}</strong>
                    </span>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
        	 <div class="options">
                <div class="form-group">
                {!! \Form::nLabel('option', 'Options', true) !!}
                <button class="add_form_field btn btn-success btn-xs" style="float:right">Add New Option &nbsp; 
                  <span style="font-size:16px; font-weight:bold;">+ </span>
                </button>
             </div>            
                
              <div class="col-sm-4" style="margin-bottom:10px;">              
              <div class="col-sm-12">
              <input type="radio" name="correctanswer" id="correctanswer1" class="correctanswer" onclick="getAnswer(1)" />
              <label class="labels" for="correctanswer1">Correct Answer</label>
              <input type="text" name="option[]" id="option1" class="form-control view-color" placeholder="Option 1" required></div>
              {{ $errors->first('option') }}
              </div>
           </div>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('answer', 'Answer', true) !!}
                <input type="text" class="form-control view-color" name="answer" id="answer" placeholder="Enter Answer" required readonly="readonly" />
                <span class="form-text text-danger" role="alert">
                        {{ $errors->first('answer') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('question_status', 'Status', false) !!}
                <select name="question_status" id="question_status" class="form-control view-color">
                    @foreach(\App\Support\Configs\Constants::$course_status as $status)
                        <option value="{{$status}}"
                                @if (isset($course_question) && ($course_question->question_status === $status)) selected @endif
                        >{{str_replace("-","",$status)}}</option>
                    @endforeach
                </select>
                <span class="form-text text-danger" role="alert">
                        {{ $errors->first('question_status') }}
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('question_status', 'Can Select', false) !!}
                <select name="question_position" id="question_position" class="form-control view-color">
                   <option value="Single Choice">Single Choice</option>
                   <option value="Multiple Choice">Multiple Choice</option>
                </select>
                <span class="form-text text-danger" role="alert">
                        {{ $errors->first('question_status') }}
                </span>
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
        var selected_course_id = '{{old("course_id", (isset($course_question)?$course_question->course_id:null))}}';

        $(document).ready(function () {
            getCourseList();
            $("#company_id").change(function () {
                getCourseList();
            });
        });


        function getCourseList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-list')}}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken,
                        'course_option_is_not': "Offline",
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_course_id == value.id) {
                                    courseSelectedStatus = ' selected ';
                                } else {
                                    courseSelectedStatus = '';
                                }
                                $("#course_id").append('<option value="' + value.id + '" ' + courseSelectedStatus + '>' + value.course_title + '</option>');
                            });
                        } else {
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                        }
                    }
                });
            } else {
                $("#course_id").empty();
                $("#course_id").append('<option value="">Please Select Course</option>');
            }
        }


$(document).ready(function() {
    var max_fields = 10;
    var wrapper = $(".options");
    var add_button = $(".add_form_field");

    var x = 1;
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append(`<div class="col-sm-4"><div class="col-sm-12"><input type="radio" name="correctanswer" class="correctanswer" id="correctanswer${x}" onclick="getAnswer(${x})" /><label class="labels" for="correctanswer${x}">Correct Answer</label></div><div class="col-sm-12"><input type="text" name="option[]" id="option${x}"  placeholder="Option ${x}" class="form-control" style="width:80%; float:left;margin-bottom:10px;"/><a href="#" class="delete btn btn-danger btn-sm" style="width:20%; float:left">Delete</a></div></div>`); //add input box
        } else {
            alert('You Reached the limits')
        }
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })
});

const getAnswer = (id) => {
	let correctanswer = document.getElementById('option'+id).value;
	if(correctanswer!=""){
      document.getElementById('answer').value = correctanswer;
	}
}
</script>
@endpush



