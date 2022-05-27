<?php


namespace App\Http\Controllers\Api\V1;


use App\Services\Backend\Books\BookService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\UserDetailsService;
use App\Services\Backend\User\UserService;
use Illuminate\Http\Request;

class AppHomeController
{
    /**
     * @var CourseCategoryService
     */
    private $courseCategoryService;
    /**
     * @var CourseService
     */
    private $courseService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var CourseBatchService
     */
    private $courseBatchService;
    /**
     * @var BookService
     */
    private $bookService;
    /**
     * @var UserDetailsService
     */
    private $userDetailsService;

    /**
     * AppHomeController constructor.
     * @param CourseCategoryService $courseCategoryService
     * @param CourseService $courseService
     * @param UserService $userService
     * @param CourseBatchService $courseBatchService
     * @param BookService $bookService
     * @param UserDetailsService $userDetailsService
     */
    public function __construct(
        CourseCategoryService $courseCategoryService,
        CourseService $courseService,
        UserService $userService,
        CourseBatchService $courseBatchService,
        BookService $bookService,
        UserDetailsService $userDetailsService
    ){

        $this->courseCategoryService = $courseCategoryService;
        $this->courseService = $courseService;
        $this->userService = $userService;
        $this->courseBatchService = $courseBatchService;
        $this->bookService = $bookService;
        $this->userDetailsService = $userDetailsService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data['total_student'] = $this->userDetailsService->userDetails(array_merge(['role_id'=>array(5)],$request->all()))->count();
            $data['total_instructor'] = $this->userDetailsService->userDetails(array_merge(['role_id'=>array(6,8)],$request->all()))->count();
            $data['total_course'] = $this->courseService->showAllCourse($request)->count();
            $data['total_batch'] = $this->courseBatchService->showAllCourseBatch($request)->count();
            $data['total_book'] = $this->bookService->getAllBook($request->all())->count();
            $data['request'] = $request;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Data not found!'], 200);
        }
        return $jsonReturn;
    }
}
