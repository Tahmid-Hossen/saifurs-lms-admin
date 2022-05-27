<?php

namespace App\Services\Backend\Books;

use App\Models\Backend\Books\Book;
use App\Repositories\Backend\Books\EBookRepository;
use App\Services\FileUploadService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Utility;

/**
 * Class BookService
 * @package App\Services\Backend\Book
 */
class EBookService
{
    /**
     * @var EBookRepository
     */
    private $ebookRepository;

    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * BookService constructor.
     * @param EBookRepository $ebookRepository
     * @param FileUploadService $uploadService
     */
    public function __construct(EBookRepository $ebookRepository, FileUploadService $uploadService)
    {
        $this->ebookRepository = $ebookRepository;
        $this->fileUploadService = $uploadService;
    }

    /**
     * Get all Book
     *
     * @param array $filters
     *
     * @return Builder
     */
    public function getAllEBook(array $filters): Builder
    {
        return $this->ebookRepository->getEBookWith($filters);
    }

    /**
     * @param $input
     * @return string|null
     * @throws Exception
     */
    public function uploadPreviewImage($input)
    {
        try {
            $data = [
                'image' => $input,
                'image_name' => 'ebook-thumbs-' . microtime(true),
                'destination' => Utility::$imageUploadPath['book_preview_image'],
                'width' => Utility::$bookImageSize['width'],
                'height' => Utility::$bookImageSize['height']
            ];

            return $this->fileUploadService->savePhoto($data);

        } catch (Exception $exception) {
           \Log::error($exception->getMessage());
            return false;
        }
    }

    /**
     * @param array $input
     * @param array $pivot
     * @return Book|false
     */
    public function storeBook(array $input, array $pivot)
    {
        try {
            $book = $this->ebookRepository->create($input);
            return $this->ebookRepository->manageKeywords($book, $pivot);
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @param $data
     * @param $keywords
     * @return Book|false
     */
    public function updateBook($id, $data, $keywords)
    {
        try {
            $book = $this->ebookRepository->find($id);
            $this->ebookRepository->update($data, $id);
            return $this->ebookRepository->manageKeywords($book, $keywords);
        } catch (ModelNotFoundException $e) {
           \Log::error('Book not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showBookByID($id)
    {
        return $this->ebookRepository->find($id);
    }




}
