<?php

namespace App\Http\Controllers\Backend\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Course\CourseCategoryRequest;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseCategoryController extends Controller
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $courseCategories = $this->courseCategoryService->showAllCourseCategory($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.course.courseCategory.index', compact('companies', 'request', 'courseCategories', 'branches'));
        } catch (\Exception $e) {
            flash('Course Category table not found!')->error();
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.course.courseCategory.create', compact('companies', 'branches'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Category Data!')->error();
            return Redirect::to('/backend/course-categories');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseCategoryRequest $request
     * @return RedirectResponse|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(CourseCategoryRequest $request)
    {

        try {
            DB::beginTransaction();
            $courseCategory = $this->courseCategoryService->createCourseCategory($request->except('_wysihtml5_mode', 'course_category_image', '_token'));
            if ($courseCategory) {
                // Course Category Image
                $request['course_category_id'] = $courseCategory->id;
                if ($request->hasFile('course_category_image')) {
                    $image_url = $this->courseCategoryService->courseCategoryImage($request);
                    $courseCategory->course_category_image = $image_url;
                    $courseCategory->save();
                }
                flash('Course Category created successfully')->success();
            } else {
                flash('Failed to create Course Category')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Course Category')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $courseCategory = $this->courseCategoryService->courseCategoryById($id);
            return view('backend.course.courseCategory.show', compact('courseCategory'));
        } catch (\Exception $e) {
            flash('Course Category data not found!')->error();
            return redirect()->route('course-categories.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $courseCategory = $this->courseCategoryService->courseCategoryById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.course.courseCategory.edit', compact('companies', 'courseCategory', 'branches'));
        } catch (\Exception $e) {
            flash('Course Category data not found!')->error();
            return redirect()->route('course-categories.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseCategoryRequest $request
     * @param int $id
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function update(CourseCategoryRequest $request, $id)
    {

        try {
            DB::beginTransaction();
            $courseCategory = $this->courseCategoryService->updateCourseCategory($request->except('_wysihtml5_mode', 'course_category_image', '_token'), $id);
            if ($courseCategory) {
                // Course Category Image
                $request['course_category_id'] = $courseCategory->id;
                if ($request->hasFile('course_category_image')) {
                    $image_url = $this->courseCategoryService->courseCategoryImage($request);
                    $courseCategory->course_category_image = $image_url;
                    $courseCategory->save();
                }

                flash('Course Category updated successfully')->success();
            } else {
                flash('Failed to update Course Category')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Course Category')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            $courseCategory = $this->courseCategoryService->courseCategoryById($id);
            if ($courseCategory) {
                $courseCategory->delete();
                flash('Course Category deleted successfully')->success();
            } else {
                flash('Course Category not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-categories.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $courseCategories = $this->courseCategoryService->showAllCourseCategory($requestData)->orderBy('course_category.id', 'DESC')->get();
            return view('backend.course.courseCategory.pdf', compact('courseCategories'));
        } catch (\Exception $e) {
            flash('Course Category table not found!')->error();
            return Redirect::to('/backend/course-categories');
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
            $requestData = array_merge($companyWiseUser, $request->all());
            $courseCategories = $this->courseCategoryService->showAllCourseCategory($requestData)->orderBy('course_category.id', 'DESC')->get();
            return view('backend.course.courseCategory.excel', compact('courseCategories'));
        } catch (\Exception $e) {
            flash('Course Category table not found!')->error();
            return Redirect::to('/backend/course-categories');
        }
    }

    public function getCourseCategoryList(Request $request)
    {
        $companyWiseUser = $this->userService->user_role_display();
        $requestData = array_merge($companyWiseUser, $request->all());
        $course_categories = $this->courseCategoryService->showAllCourseCategory($requestData)->get();
        if (count($course_categories) > 0):
            $message = response()->json(['status' => 200, 'data' => $course_categories]);
        else:
            $message = response()->json(['status' => 403, 'message' => 'Unauthorised']);
        endif;
        return $message;
    }

}
