<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Banner\BannerRequest;
use App\Services\Backend\Banner\BannerService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\Quiz\Quiz;
use App\Models\Backend\Course\CourseQuestion;
use App\Models\Backend\Quiz\QuizUserAnswer;
use App\Models\Backend\Course\QuestionAnswer;
use App\Models\Backend\Quiz\QuizResult;
use App\Models\Backend\Sale\Sale;
use App\Models\Backend\Sale\Item;

class QuizController extends Controller {
    /**
     * @var BannerService
     */
    private $bannerService;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * BannerController constructor.
     * @param BannerService $bannerService
     * @param UserService $userService
     * @param CompanyService $companyService
     */
    public function __construct(
        BannerService $bannerService,
        UserService $userService,
        CompanyService $companyService
    ) {
        $this->bannerService = $bannerService;
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

   public function getQuizList( Request $request ) {
        //$quizelist = Quiz::with('question','question.questionOptions')->get();
		$course_id = $request->course_id;
		//$quizelist = Quiz::where('quiz_status','ACTIVE')->get();
		$query = Quiz::where('quiz_status','ACTIVE');
		if(isset($course_id) && $course_id!=""){
			$query->whereRaw('FIND_IN_SET("'.$course_id.'",course_id)');
		}
		$quizelist = $query->get();
		
		$message = response()->json( ['status' => 200, 'data' => $quizelist] );
		return $message;
    }
	
	public function getQuizQuestionList( Request $request ) {
		//dd($request->all());
		$userid = $request->userid;
		//dd($userid);
        $quizelist = CourseQuestion::with('questionOptions')->where('quiz_id',$request->quiz_id)->get();
		$quizname = Quiz::where('id',$request->quiz_id)->select('id','quiz_topic','course_id','quiz_full_marks','quiz_pass_percentage','quiz_re_attempt','quiz_status','quiz_duration')
		->first();		
		
		$courseid = explode(',',$quizname->course_id);
		$checkcourse = Sale::where('user_id',$userid)->get();
		foreach($checkcourse as $checkitems){
			$salesid[] = $checkitems->id;
		}
		
		/*
		Relation query with condition
		$checkcourse = Sale::where('user_id',$userid)
			->with('items', function ($query) use ($courseid){
				$query->whereIn('item_id',$courseid);
			})
		->get();*/
		
		$getItems = Item::whereIn('sale_id',$salesid)->whereIn('item_id',$courseid)->get();
		if(count($getItems) > 0){
			$data['questionlist'] = $quizelist;
			$data['quiz'] = $quizname;
			
			$message = response()->json(['status' => 200, 'data' => $data]);
		}
		else{
			$message = response()->json(['status' => 0, 'message' => 'Quiz is not available for you. Please purchase course first']);
		}
		
		
		return $message;
    }
	
	
	public function quizAnswer(Request $input) {
		
		try {
			$totalMark = 0;
			$totalObtained = 0;
			$totalTime = $input->totaltime;
			$dueTime = $input->due_time;
			$spentTime = $totalTime - $dueTime;
			$getQuizInfo = Quiz::where('id',$input->quiz_id)->select('quiz_pass_percentage')->first();
			if($getQuizInfo!=""){			
				foreach($input->question_id as $queid){		
					$optiondata['company_id'] = $input->company_id;
					$optiondata['quiz_id'] = $input->quiz_id;	
					$optiondata['user_id'] = $input->userid;	
					$optiondata['question_id'] = $queid;	
					$optiondata['answer'] = $input->options[$queid];
					
					$getCorrenctAnswer = QuestionAnswer::where('question_id',$queid)->first();
					if($getCorrenctAnswer!=""){
						$corect_answer = $getCorrenctAnswer->answer;
						$mark = $getCorrenctAnswer->mark;
						if($corect_answer == $input->options[$queid]){
							$optainedMark = $mark;
							$status = 'correct';
						}
						else{
							$optainedMark = 0;
							$status = 'incorrect';
						}
					}
					else{
						$corect_answer = '';
						$mark = 0;
						$optainedMark = 0;
						$status = 'incorrect';
					}			
					
					$totalObtained += $optainedMark;
					$totalMark += $mark;
					
					$optiondata['corect_answer'] = $corect_answer;
					$optiondata['score'] = $mark;
					$optiondata['status'] = $status;
					$optiondata['optained_score'] = $optainedMark;
					QuizUserAnswer::create($optiondata);
				}	
								
				$passscore = ($totalMark*$getQuizInfo->quiz_pass_percentage)/100;
				if($passscore >= $totalObtained){
					$results = 'Pass';
				}
				else{
					$results = 'Fail';
				}
				
				$answerdata['company_id'] = $input->company_id;
				$answerdata['quiz_id'] = $input->quiz_id;
				$answerdata['user_id'] = $input->userid;	
				$answerdata['total_mark'] = $totalMark;	
				$answerdata['achive_mark'] = $totalObtained;				
				$answerdata['total_time'] = $totalTime;	
				$answerdata['spent_time'] = $spentTime;	
				$answerdata['result_status'] = $results;		
				QuizResult::create($answerdata);		
					
				$message = response()->json( ['status' => true, 'msg' => 'Successfully inserted'] );
			}
			else{
				$message = response()->json( ['status' => false, 'msg' => 'Quiz not found'] );
			}
			
        } catch (ModelNotFoundException $e) {
           \Log::error('Question not found');
		   $message = response()->json( ['status' => false, 'msg' => 'Failed to insert'] );
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
		   $message = response()->json( ['status' => false, 'msg' => 'Failed to insert'] );
        }		
		
		return $message;
    }
	
	
	public function quizUserResult( Request $request ) {
        $quizelist = QuizResult::with('quiz','users')->where('user_id',$request->user_id)->orderBy('id','DESC')->first();
		$message = response()->json( ['status' => 200, 'data' => $quizelist] );
		return $message;
    }
	

}
