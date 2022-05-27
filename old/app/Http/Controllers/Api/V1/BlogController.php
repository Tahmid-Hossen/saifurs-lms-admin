<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\Blog\BlogRequest;
use App\Services\Backend\Blog\BlogService;
use App\Services\Backend\User\UserService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Utility;

class BlogController
{
    /**
     * @var BlogService
     */
    private $blogService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param BlogService $blogService
     * @param UserService $userService
     */
    public function __construct(BlogService $blogService, UserService $userService){

        $this->blogService = $blogService;
        $this->userService = $userService;
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
            $request->display_item_per_page = $request->display_item_per_page ?? \Utility::$displayRecordPerPage;
/*            $request['blog_publish_start_date_time'] = '20201-01-01 00:00:01';
            $request['blog_publish_end_date_time'] = date('Y-m-d H:i:s');*/
            $request['blog_status'] = "ACTIVE";
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $blogs = $this->blogService->showAllBlog($requestData)->paginate($request->display_item_per_page);
            $data['blogs'] = $blogs;
            $data['request'] = $request->all();
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = 'Blog table not found!';
            $data['request'] = $request->all();
            $data['status'] = false;
        }
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): \Illuminate\Http\JsonResponse
    {
        try {
            $data['message'] = 'Blog table found!';
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = 'Something wrong with Blog Data!';
            $data['status'] = false;
        }
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(BlogRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $blog = $this->blogService->createBlog($request->except('blog_logo', '_token'));
            if ($blog) {
                // Blog Logo
                $request['blog_id'] = $blog->id;
                if ($request->hasFile('blog_logo')) {
                    $image_url = $this->blogService->blogLogo($request);
                    $blog->blog_logo = $image_url;
                    $blog->save();
                }
                $data['blog'] = $blog;
                $data['message'] = 'Blog created successfully!';
                $data['status'] = true;
            } else {
                $data['message'] = 'Failed to create Blog!';
                $data['status'] = false;
            }
            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollback();
            $data['message'] = 'Failed to create Blog!';
            $data['status'] = false;
        }
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $blog = $this->blogService->blogById($id);
            $data['blog'] = $blog;
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = 'Blog data not found!';
            $data['status'] = false;
        }
        return response()->json($data,200);
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
            $blog = $this->blogService->blogById($id);
            $data['blog'] = $blog;
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = 'Blog data not found!';
            $data['status'] = false;
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(BlogRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $blog = $this->blogService->updateBlog($request->except('blog_logo', '_token'), $id);
            if ($blog) {
                // Blog Logo
                $request['blog_id'] = $blog->id;
                if ($request->hasFile('blog_logo')) {
                    $image_url = $this->blogService->blogLogo($request);
                    $blog->blog_logo = $image_url;
                    $blog->save();
                }
                $blog->fresh();
                $data['blog'] = $blog;
                $data['message'] = 'Blog update successfully!)';
                $data['status'] = true;
            } else {
                $data['message'] = 'Failed to update Blog(!';
                $data['status'] = false;
            }
            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollback();
            $data['message'] = 'Failed to update Blog!';
            $data['status'] = false;
        }
        return response()->json($data,200);
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
        try {
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $blog = $this->blogService->blogById($id);
                if ($blog) {
                    $blog->delete();
                    $data['message'] = 'Blog deleted successfully!)';
                    $data['status'] = true;
                }else{
                    $data['message'] = 'Blog not found(!';
                    $data['status'] = false;
                }
            }else{
                $data['message'] = 'You Entered Wrong Password!';
                $data['status'] = false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $data['message'] = 'Failed to deleted Blog!';
            $data['status'] = false;
        }
        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blogList(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $blogWiseUser = $this->userService->user_role_display_for_api();
            $request['blog_publish_start_date_time'] = '20201-01-01 00:00:01';
            $request['blog_publish_end_date_time'] = date('Y-m-d H:i:s');
            $request['blog_status'] = Constants::$user_active_status;
            $requestData = array_merge($blogWiseUser,$request->all());
            $blogs = $this->blogService->showAllBlog($requestData)->orderBy('blogs.id','DESC')->get();
            if(count($blogs)>0):
                $data['blogs'] = $blogs;
                $data['request'] = $request->all();
                $data['status'] = true;
            else:
                $data['message'] = 'Failed to find Blog!';
                $data['status'] = false;
            endif;
        } catch (\Exception $e) {
            $data['message'] = 'Blog table not found!';
            $data['status'] = false;

        }
        return response()->json($data,200);
    }
}
