<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Blog\BlogRequest;
use App\Services\Backend\Blog\BlogService;
use App\Services\Backend\User\UserService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Utility;

class BlogController extends Controller
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
    public function __construct(BlogService $blogService, UserService $userService)
    {
        $this->blogService = $blogService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:Utility::$displayRecordPerPage;
            $blogWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($blogWiseUser,$request->all());
            $blogs = $this->blogService->showAllBlog($requestData)->paginate($request->display_item_per_page);
            return view('backend.blog.blogs.index', compact('blogs', 'request'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Blog table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        try {
            return view('backend.blog.blogs.create');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Something wrong with Blog Data!')->error();
            return Redirect::to('/backend/blogs');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(BlogRequest $request): \Illuminate\Http\RedirectResponse
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
                    flash('Blog created successfully')->success();
                }
            } else {
                flash('Failed to create Blog')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollback();
            flash('Failed to create Blog')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('blogs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        try {
            $blog = $this->blogService->blogById($id);
            return view('backend.blog.blogs.show', compact('blog'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Blog data not found!')->error();
            return redirect()->route('blogs.index');
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
            $blog = $this->blogService->blogById($id);
            return view('backend.blog.blogs.edit', compact('blog'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Blog data not found!')->error();
            return redirect()->route('blogs.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(BlogRequest $request, $id): \Illuminate\Http\RedirectResponse
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

                flash('Blog update successfully')->success();
            } else {
                flash('Failed to update Blog')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollback();
            flash('Failed to update Blog')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $blog = $this->blogService->blogById($id);
                if ($blog) {
                    $blog->delete();
                    flash('Blog deleted successfully')->success();
                }else{
                    flash('Blog not found!')->error();
                }
            }else{
                flash('You Entered Wrong Password!')->error();
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollback();
            flash('Failed to delete Blog')->error();
        }
        return redirect()->route('blogs.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blogList(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $blogWiseUser = $this->userService->user_role_display();
            $request['blog_status'] = Constants::$user_active_status;
            $requestData = array_merge($blogWiseUser,$request->all());
            $blogs = $this->blogService->showAllBlog($requestData)->orderBy('blogs.id','DESC')->get();
            if(count($blogs)>0):
                $message = response()->json(['status' => 200, 'data'=>$blogs]);
            else:
                $message = response()->json(['status' => 404, 'message'=>'Unauthorised']);
            endif;
        } catch (\Exception $e) {
            flash('Blog table not found!')->error();
            $message = response()->json(['status' => 404, 'message'=>'Blog table not found!']);
        }

        return $message;
    }
}
