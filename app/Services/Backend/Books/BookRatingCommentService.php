<?php


namespace App\Services\Backend\Books;


use App\Repositories\Backend\Books\BookRatingCommentRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class BookRatingCommentService
{
    /**
     * @var BookRatingCommentRepository
     */
    private $bookRatingCommentRepository;

    /**
     * BookRatingCommentService constructor.
     * @param BookRatingCommentRepository $bookRatingCommentRepository
     */
    public function __construct(BookRatingCommentRepository $bookRatingCommentRepository)
    {
        $this->bookRatingCommentRepository = $bookRatingCommentRepository;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createBookRatingComment($input)
    {
        try {
            $input = array_merge($input, ['user_id' => auth()->user()->id]);
            return $this->bookRatingCommentRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Book Rating Comment not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateBookRatingComment($input, $id)
    {
        try {
            $branch = $this->bookRatingCommentRepository->find($id);
            $this->bookRatingCommentRepository->update($input, $id);
            return $branch;
        } catch (ModelNotFoundException $e) {
           \Log::error('Book Rating Comment not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteBookRatingComment($id)
    {
        return $this->bookRatingCommentRepository->delete($id);
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllBookRatingComment($input)
    {
        return $this->bookRatingCommentRepository->bookRatingCommentFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function bookRatingCommentById($id)
    {
        return $this->bookRatingCommentRepository->find($id);
    }
}
