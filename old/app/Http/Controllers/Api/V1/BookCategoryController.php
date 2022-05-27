<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\Backend\Books\CategoryRequest;
use App\Services\Backend\Books\CategoryService;
use App\Services\Backend\User\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Utility;

class BookCategoryController
{
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * BookCategoryController constructor.
     * @param CategoryService $categoryService
     * @param UserService $userService
     */
    public function __construct(CategoryService $categoryService, UserService $userService)
    {
        $this->categoryService = $categoryService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $book_categories = $this->categoryService->getAllCategory($request->all());
            if($book_categories):
                $data['book_categories'] = $book_categories;
                $data['request'] = $request->all();
                $data['status'] = true;
            else:
                $data['request'] = $request->all();
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            $data['request'] = $request->all();
            $data['status'] = false;
            $data['message'] = 'Book Category table Not Found';
        }
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): \Illuminate\Http\JsonResponse
    {
        $data['status'] = true;
        $data['message'] = 'Book Category table Found';
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $categoryRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $categoryRequest): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            //Add Default Active Status
            $category = [
                'book_category_name' => $categoryRequest->name,
                'book_category_status' => Utility::$statusText[$categoryRequest->status],
            ];

            $book_category = $this->categoryService->storeCategory($category);
            if ($book_category) {
                $data['book_category'] = $book_category;
                $data['status'] = true;
                $data['message'] = 'Book Category created successfully';
            } else {
                $data['book_category'] = null;
                $data['status'] = false;
                $data['message'] = 'Failed to create Book Category';
            }
            DB::commit();
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            DB::rollback();
            $data['request'] = $categoryRequest->all();
            $data['status'] = false;
            $data['message'] = 'Failed to create new Book Category!';
        }
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $book_category = $this->categoryService->showCategoryByID($id);
            if ($book_category) {
                $data['book_category'] = $book_category;
                $data['status'] = true;
            } else {
                $data['book_category'] = null;
                $data['status'] = false;
                $data['message'] = 'Book Category data not found';
            }
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            $data['status'] = false;
            $data['message'] = 'Book Category Not Found';
        }
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $book_category = $this->categoryService->showCategoryByID($id);
            if ($book_category) {
                $data['book_category'] = $book_category;
                $data['status'] = true;
            } else {
                $data['book_category'] = null;
                $data['status'] = false;
                $data['message'] = 'Book Category data not found';
            }
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            $data['status'] = false;
            $data['message'] = 'Book Category Not Found';
        }
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $categoryRequest
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $categoryRequest, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            //Add Default Active Status
            $category = [
                'book_category_name' => $categoryRequest->name,
                'book_category_status' => Utility::$statusText[$categoryRequest->status],
            ];

            $book_category_update = $this->categoryService->updateCategory($category, $id);
            if ($book_category_update) {
                $data['book_category'] = $book_category_update;
                $data['status'] = true;
                $data['message'] = 'Book Category updated successfully';
            } else {
                $data['book_category'] = null;
                $data['status'] = false;
                $data['message'] = 'Failed to Update Book Category';
            }
            DB::commit();
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            DB::rollback();
            $data['status'] = false;
            $data['message'] = 'Failed to update Category Content!';
        }
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            try {
                $category = $this->categoryService->showCategoryByID($id);

                if ($category->totalRelatedBooks() == 0) {
                    if ($this->categoryService->deleteCategory($id)):
                        $data['status'] = true;
                        $data['message'] = 'Book Category deleted successfully';
                    else:
                        $data['status'] = false;
                        $data['message'] = 'Failed to Delete Book Category';
                    endif;
                } else {
                    $data['status'] = false;
                    $data['message'] = 'Book category has some book assigned. <b>Please remove them first</b>';
                }
            } catch (Exception $exception) {
                \Log::error($exception->getMessage());
                $data['status'] = false;
                $data['message'] = 'Book Category not found!';
                flash('Book Category not found!')->error();
            }
        } else {
            $data['status'] = false;
            $data['message'] = 'You Entered Wrong Password!';
        }
        return response()->json($data, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookCategoryList(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $book_category = $this->categoryService->showAllBookCategory($request->all())->get();
            if(count($book_category)>0):
                $jsonReturn = response()->json(['status' =>true, 'data'=>$book_category]);
            else:
                $jsonReturn = response()->json(['status' =>false, 'message'=>'Data Not Found']);
            endif;
        }catch (\Exception $e){
            \Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message'=>'Book Category table not found!'], 200);
        }
        return $jsonReturn;
    }
}
