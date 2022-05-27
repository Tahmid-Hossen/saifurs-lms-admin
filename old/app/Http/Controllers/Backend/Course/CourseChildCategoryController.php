<?php

namespace App\Http\Controllers\Backend\Course;

use App\Http\Controllers\Controller;
use App\Services\Backend\User\BranchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Course\CourseChildCategoryRequest;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Models\Backend\Course\CourseChildCategory;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class CourseChildCategoryController extends Controller
{
    /**
    * @var CourseChildCategoryService
    */
    private $courseChildCategoryService;

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
     * @param CourseChildCategoryService $courseChildCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CompanyService $companyService
     * @param CourseCategoryService $courseCategoryService
     * @param UserService $userService
     * @param BranchService $branchService
     */
    public function __construct(
        CourseChildCategoryService $courseChildCategoryService,
        CourseSubCategoryService $courseSubCategoryService,
        CompanyService $companyService,
        CourseCategoryService $courseCategoryService,
        UserService $userService,
        BranchService $branchService
    )
    {
        $this->courseChildCategoryService = $courseChildCategoryService;
        $this->courseSubCategoryService = $courseSubCategoryService;
        $this->companyService = $companyService;
        $this->courseCategoryService = $courseCategoryService;
        $this->userService = $userService;
        $this->branchService = $branchService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.course.courseChildCategory.index', compact('companies', 'request', 'course_child_categories', 'course_sub_categories', 'course_categories', 'branches'));
        } catch (\Exception $e) {
             flash('Course Child Category table not found!')->error();
             return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();

            return view('backend.course.courseChildCategory.create', compact('companies', 'course_categories', 'course_sub_categories', 'branches'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Child Category Data!')->error();
            return Redirect::to('/backend/course-child-categories');
        }
    }

    // public function check_slug(Request $request)
    // {
    //     $slug = Str::slug($request->course_child_category_title);
    //     return response()->json(['course_child_category_slug' => $slug]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CourseChildCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $course_child_category = $this->courseChildCategoryService->createCourseChildCategory($request->except('_wysihtml5_mode', 'course_child_category_image', '_token'));
            if ($course_child_category) {
                // Course Child Category Image
                $request['course_child_category_id'] = $course_child_category->id;
                if ($request->hasFile('course_child_category_image')) {
                    $image_url = $this->courseChildCategoryService->courseChildCategoryImage($request);
                    $course_child_category->course_child_category_image = $image_url;
                    $course_child_category->save();
                }
                flash('Course Child Category created successfully')->success();
            } else {
                flash('Failed to create Course Child Category')->error();
            }
            DB::commit();
         } catch (\Exception $e) {
             DB::rollback();
             flash('Failed to create Course Child Category')->error();
             return redirect()->back()->withInput($request->all());
         }
        return redirect()->route('course-child-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $course_child_category = $this->courseChildCategoryService->courseChildCategoryById($id);
            return view('backend.course.courseChildCategory.show', compact('course_child_category'));
        } catch (\Exception $e) {
            flash('Course Child Category data not found!')->error();
            return redirect()->route('course-child-categories.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $course_child_category = $this->courseChildCategoryService->courseChildCategoryById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();

            return view('backend.course.courseChildCategory.edit', compact('course_child_category', 'companies', 'course_categories', 'course_sub_categories', 'branches'));
        } catch (\Exception $e) {
            flash('Course Child Category data not found!')->error();
            return redirect()->route('course-child-categories.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(CourseChildCategoryRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $course_child_category = $this->courseChildCategoryService->updateCourseChildCategory($request->except('_wysihtml5_mode', 'course_child_category_image', '_token'), $id);

            if ($course_child_category) {
                // Course Child Category Image
                $request['course_child_category_id'] = $course_child_category->id;
                if ($request->hasFile('course_child_category_image')) {
                    $image_url = $this->courseChildCategoryService->courseChildCategoryImage($request);
                    $course_child_category->course_child_category_image = $image_url;
                    $course_child_category->save();
                }

                flash('Course Child Category updated successfully')->success();
            } else {
                flash('Failed to update Course Child Category')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Course Child Category')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-child-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $course_child_category = $this->courseChildCategoryService->courseChildCategoryById($id);
            if ($course_child_category) {
                $course_child_category->delete();
                flash('Course Child Category deleted successfully')->success();
            }else{
                flash('Course Child Category not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-child-categories.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($requestData)->orderBy('course_child_category.id','DESC')->get();
            return view('backend.course.courseChildCategory.pdf', compact('course_child_categories'));
        } catch (\Exception $e) {
            flash('Course Child Category table not found!')->error();
            return Redirect::to('/backend/course-child-categories');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($requestData)->orderBy('course_child_category.id','DESC')->get();
            return view('backend.course.courseChildCategory.excel', compact('course_child_categories'));
        } catch (\Exception $e) {
            flash('Course Child Category table not found!')->error();
            return Redirect::to('/backend/course-child-categories');
        }
    }

    // public function statusChange($id)
    // {
    //     $data = DB::table('course_child_category')
    //             ->select('course_child_category_status')
    //             ->where('id', '=', $id)
    //             ->first();
    //     dd($data);
    //     if($data->course_child_category_status == 'ACTIVE') {
    //         $course_child_category_status = 'IN-ACTIVE';
    //     }else{
    //         $course_child_category_status = 'ACTIVE';
    //     }

    //     $status = array('course_child_category_status' => $course_child_category_status);
    //     DB::table('course_child_category')->where('id', $id)->update($status);

    //     flash('Status updated!')->success();
    //     return Redirect::to('/backend/course-child-categories');
    // }

    // public function check_slug(CourseChildCategoryRequest $request)
    // {
    //     // $slug = $this->courseChildCategoryService->createCourseChildCategory($request->course_child_category_title);
    //     $slug = $this->SlugService->createSlug(CourseChildCategory::class, 'course_child_category_slug', $request->course_child_category_title);
    //     return response()->json(['course_child_category_slug' => $slug]);
    // }

    /**
     * @param Request $request
     */
    public function change_status(Request $request)
    {
        $status = CourseChildCategory::find($request->course_child_category_id);
        $status->course_child_category_status = $request->course_child_category_status;
        $status->save();
    }

     /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCourseChildCategoryList(Request $request): JsonResponse
    {
        $companyWiseUser = $this->userService->user_role_display();
        $requestData = array_merge($companyWiseUser,$request->except('_token'));
        $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($requestData)->get()->toArray();
        if(count($course_child_categories)>0):
            $message = response()->json(['status' => 200, 'data'=>$course_child_categories]);
        else:
            $message = response()->json(['status' => 404, 'message'=>'Data Not Found']);
        endif;

        return $message;
    }

}
