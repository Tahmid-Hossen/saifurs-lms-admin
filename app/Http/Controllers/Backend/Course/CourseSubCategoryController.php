<?php

namespace App\Http\Controllers\Backend\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Course\CourseSubCategoryRequest;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\Course\CourseCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseSubCategoryController extends Controller
{
    /**
    * @var CourseSubCategoryService
    */
    private $courseSubCategoryService;

    /**
     * @var companyService
     */
    private $companyService;

    /**
     * @var courseCategoryService
     */
    private $courseCategoryService;

    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CompanyService $companyService
     * @param CourseCategoryService $courseCategoryService
     * @param UserService $userService
     * @param BranchService $branchService
     */
    public function __construct(
        CourseSubCategoryService $courseSubCategoryService,
        CompanyService $companyService,
        CourseCategoryService $courseCategoryService,
        UserService $userService,
        BranchService $branchService
    )
    {
        $this->courseSubCategoryService = $courseSubCategoryService;
        $this->companyService = $companyService;
        $this->courseCategoryService = $courseCategoryService;
        $this->userService = $userService;
        $this->branchService = $branchService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
         try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $courseSubCategories = $this->courseSubCategoryService->showAllCourseSubCategory($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            return view('backend.course.courseSubCategory.index', compact('companies', 'request', 'courseSubCategories', 'course_categories', 'branches'));
         } catch (\Exception $e) {
            \Log::error($e->getMessage());
             flash('Course Sub Category table not found!')->error();
             return Redirect::to('/backend');
         }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.course.courseSubCategory.create', compact('companies', 'course_categories', 'branches'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Sub Category Data!')->error();
            return Redirect::to('/backend/course-sub-categories');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CourseSubCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $course_sub_category = $this->courseSubCategoryService->createCourseSubCategory($request->except('_wysihtml5_mode', 'course_sub_category_image', '_token'));
            // dd($course_sub_category);
            if ($course_sub_category) {
                // Course Sub Category Image
                $request['course_sub_category_id'] = $course_sub_category->id;
                if ($request->hasFile('course_sub_category_image')) {
                    $image_url = $this->courseSubCategoryService->courseSubCategoryImage($request);
                    $course_sub_category->course_sub_category_image = $image_url;
                    $course_sub_category->save();
                }
                flash('Course Sub Category created successfully')->success();
            } else {
                flash('Failed to create Course Sub Category')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Course Sub Category')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-sub-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $course_sub_category = $this->courseSubCategoryService->courseSubCategoryById($id);
            return view('backend.course.courseSubCategory.show', compact('course_sub_category'));
        } catch (\Exception $e) {
            flash('Course Sub Category data not found!')->error();
            return redirect()->route('course-sub-categories.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $courseSubCategory = $this->courseSubCategoryService->courseSubCategoryById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();

            return view('backend.course.courseSubCategory.edit', compact('courseSubCategory', 'companies', 'course_categories', 'branches'));
        } catch (\Exception $e) {
            flash('Course Sub Category data not found!')->error();
            return redirect()->route('course-sub-categories.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function update(CourseSubCategoryRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $course_sub_category = $this->courseSubCategoryService->updateCourseSubCategory($request->except('_wysihtml5_mode', 'course_sub_category_image', '_token'), $id);

            // dd($course_sub_category);
            if ($course_sub_category) {
                // Course Category Image
                $request['course_sub_category_id'] = $course_sub_category->id;
                if ($request->hasFile('course_sub_category_image')) {
                    $image_url = $this->courseSubCategoryService->courseSubCategoryImage($request);
                    $course_sub_category->course_sub_category_image = $image_url;
                    $course_sub_category->save();
                }

                flash('Course Sub Category updated successfully')->success();
            } else {
                flash('Failed to update Course Sub Category')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Course Sub Category')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-sub-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $course_sub_category = $this->courseSubCategoryService->courseSubCategoryById($id);
            if ($course_sub_category) {
                $course_sub_category->delete();
                flash('Course Sub Category deleted successfully')->success();
            }else{
                flash('Course Sub Category not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-sub-categories.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($requestData)->orderBy('course_sub_category.id','DESC')->get();
            return view('backend.course.courseSubCategory.pdf', compact('course_sub_categories'));
        } catch (\Exception $e) {
            flash('Course Sub Category table not found!')->error();
            return Redirect::to('/backend/course-sub-categories');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($requestData)->orderBy('course_sub_category.id','DESC')->get();
            return view('backend.course.courseSubCategory.excel', compact('course_sub_categories'));
        } catch (\Exception $e) {
            flash('Course Sub Category table not found!')->error();
            return Redirect::to('/backend/course-sub-categories');
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getCourseSubCategoryList(Request $request): JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->except('_token'));
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($requestData)->get()->toArray();
            if (count($course_sub_categories) > 0):
                $message = response()->json(['status' => 200, 'data' => $course_sub_categories]);
            else:
                $message = response()->json(['status' => 403, 'message' => 'Unauthorised']);
            endif;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
        return $message;
    }
}
