<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\Backend\Course\CourseCategoryRequest;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseCategoryController
{
    /**
     * @var CourseCategoryService
     */
    private $courseCategoryService;

    /**
     * @var companyService
     */
    private $companyService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * UserDetailController constructor.
     * @param CourseCategoryService $courseCategoryService
     * @param CompanyService $companyService
     * @param UserService $userService
     * @param BranchService $branchService
     */
    public function __construct(CourseCategoryService $courseCategoryService, CompanyService $companyService, UserService $userService, BranchService $branchService)
    {

        $this->courseCategoryService = $courseCategoryService;
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->branchService = $branchService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $data['courseCategories'] = $this->courseCategoryService->showAllCourseCategory($requestData)->paginate($request->display_item_per_page);
            $data['companies'] = $this->companyService->showAllCompany($requestData)->get();
            $data['branches'] = $this->branchService->showAllBranch($requestData)->get();
            $data['request'] = $request->all();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Course Category table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): \Illuminate\Http\JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $data['companies'] = $this->companyService->showAllCompany($companyWiseUser)->get();
            $data['branches'] = $this->branchService->showAllBranch($companyWiseUser)->get();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Something wrong with Course Category Data!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CourseCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $courseCategory = $this->courseCategoryService->createCourseCategory($request->except('course_category_image', '_token'));
            if ($courseCategory) {
                // Course Category Image
                $request['course_category_id'] = $courseCategory->id;
                if ($request->hasFile('course_category_image')) {
                    $image_url = $this->courseCategoryService->courseCategoryImage($request);
                    $courseCategory->course_category_image = $image_url;
                    $courseCategory->save();
                }
                $data['courseCategory'] = $courseCategory;
                $data['status'] = true;
                $data['message'] = 'Course Category created successfully!';
                $data['request'] = $request;
                $jsonReturn = response()->json($data,200);
            } else {
                $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to create Course Category!'], 200);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to create Course Category!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $data['courseCategory'] = $this->courseCategoryService->courseCategoryById($id);
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Course Category data not found!'], 200);
        }
        return  $jsonReturn;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id): \Illuminate\Http\JsonResponse
    {
        try {
            $data['courseCategory'] = $this->courseCategoryService->courseCategoryById($id);
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $data['companies'] = $this->companyService->showAllCompany($companyWiseUser)->get();
            $data['branches'] = $this->branchService->showAllBranch($companyWiseUser)->get();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Course Category data not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseCategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CourseCategoryRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $courseCategory = $this->courseCategoryService->updateCourseCategory($request->except('course_category_image', '_token'), $id);
            if ($courseCategory) {
                // Course Category Image
                $request['course_category_id'] = $courseCategory->id;
                if ($request->hasFile('course_category_image')) {
                    $image_url = $this->courseCategoryService->courseCategoryImage($request);
                    $courseCategory->course_category_image = $image_url;
                    $courseCategory->save();
                }
                $data['courseCategory'] = $courseCategory;
                $data['status'] = true;
                $data['message'] = 'Course Category updated successfully!';
                $data['request'] = $request;
                $jsonReturn = response()->json($data,200);
            } else {
                $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to update Course Category!'], 200);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to update Course Category!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try{
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $courseCategory = $this->courseCategoryService->courseCategoryById($id);
                if ($courseCategory) {
                    $courseCategory->delete();
                    $data['status'] = true;
                    $data['message'] = 'Course Category deleted successfully!';
                    $jsonReturn = response()->json($data,200);
                }else{
                    $jsonReturn = response()->json(['status' => false, 'message'=>'Course Category not found!'], 200);
                }
            }else{
                $jsonReturn = response()->json(['status' => false, 'message'=>'You Entered Wrong Password!'], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to delete Course Category!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function courseCategoryList(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $courseCategories = $this->courseCategoryService->showAllCourseCategory($requestData)->orderBy('course_category.course_category_title','DESC')->get();
            $courseCategoryArray = array();
            foreach ($courseCategories as $courseCategory):
                $courseCategoryArray [] = $courseCategory;
                $courseSubCategoryArray = array();
                foreach ($courseCategory->courseSubCategory as $courseSubCategory):
                    $courseSubCategoryArray [] = $courseSubCategory;
                    $courseSubCategory->courseChildCategory;
                endforeach;
                $data['courseCategories']['courseSubCategory'] = $courseSubCategoryArray;
            endforeach;
            $data['courseCategories'] = $courseCategoryArray;
            $data['request'] = $request->all();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Course Category table not found!'], 200);
        }
        return $jsonReturn;
    }

}

