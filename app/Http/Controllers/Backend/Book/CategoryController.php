<?php

namespace App\Http\Controllers\Backend\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Books\CategoryRequest;
use App\Services\Backend\Books\CategoryService;
use App\Services\Backend\User\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Log;
use Utility;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Backend\Book
 */
class CategoryController extends Controller
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
     * CategoryController constructor.
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
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $inputs = $request->query();
        $filters = array_merge($inputs, $this->dateRangePicker($inputs));

        return view('backend.book.category.index', [
            'categories' => $this->categoryService->getAllCategory($filters),
            'inputs' => $request->query()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backend.book.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $categoryRequest
     * @return RedirectResponse
     */
    public function store(CategoryRequest $categoryRequest): RedirectResponse
    {
        try {
            //Add Default Active Status
            $category = [
                'company_id' => $categoryRequest->company_id,
                'book_category_name' => $categoryRequest->name,
                'book_category_status' => Utility::$statusText[$categoryRequest->status],
            ];

            $this->categoryService->storeCategory($category);
            flash('Book Category created successfully', 'success');
            return redirect()->route('categories.index');

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            flash('Failed to create new Category!', 'error');
            return redirect()->back()->withInput($categoryRequest->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id)
    {
        try {
            $category = $this->categoryService->showCategoryByID($id);

            return view('backend.book.category.show', [
                'category' => $category
            ]);

        } catch (Exception $exception) {

            Log::error($exception->getMessage());
            flash('Category Not Found', 'error');
            return redirect()->route('categories.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        try {
            $category = $this->categoryService->showCategoryByID($id);
            return view('backend.book.category.edit', [
                'category' => $category
            ]);

        } catch (Exception $exception) {

            Log::error($exception->getMessage());
            flash('Category Not Found', 'error');
            return redirect()->route('categories.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $categoryRequest
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CategoryRequest $categoryRequest, int $id): RedirectResponse
    {
        try {
            //Add Default Active Status
            $category = [
                'company_id' => $categoryRequest->company_id,
                'book_category_name' => $categoryRequest->name,
                'book_category_status' => Utility::$statusText[$categoryRequest->status],
            ];

            $this->categoryService->updateCategory($category, $id);
            flash('Category content Updated', 'success');
            return redirect()->route('categories.index');

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            flash('Failed to update Category Content!', 'error');
            return redirect()->back()->withInput($categoryRequest->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            try {
                $category = $this->categoryService->showCategoryByID($id);

                if ($category->totalRelatedBooks() == 0) {

                    if ($this->categoryService->deleteCategory($id))
                        flash('Book Category deleted successfully', 'success');
                    else
                        flash('Failed to Delete Book Category', 'error');
                } else {
                    flash('Book category has some book assigned. <b>Please remove them first</b>', 'error');
                }
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                flash('Book Category not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('categories.index');
    }
}
