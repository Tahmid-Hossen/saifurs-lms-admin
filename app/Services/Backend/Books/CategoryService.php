<?php

namespace App\Services\Backend\Books;

use App\Repositories\Backend\Books\CategoryRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Utility;

/**
 * Class CategoryService
 * @package App\Services\Backend\Book
 */
class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeCategory(array $input)
    {
        try {
            return $this->categoryRepository->create($input);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateCategory($input, $id)
    {
        try {
            $category = $this->categoryRepository->find($id);
            $this->categoryRepository->update($input, $id);
            return $category;
        } catch (ModelNotFoundException $e) {
            Log::error('Category not found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showCategoryByID($id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllCategory(array $filters): LengthAwarePaginator
    {
        return $this->categoryRepository
            ->getCategoryWith($filters)
            ->paginate(Utility::$displayRecordPerPage);
    }

    public function getCategoryDropDown(): array
    {
        $categories = [];
        $categories[''] = 'Select an option';
        foreach ($this->categoryRepository->allCategoryForDropdown() as $category) {
            $categories[$category->book_category_id] = $category->book_category_name;
        }
        return $categories;
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllBookCategory($input): \Illuminate\Database\Eloquent\Builder
    {
        return $this->categoryRepository->getCategoryWith($input);
    }

}
