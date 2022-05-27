<?php


namespace App\Repositories\Backend\Books;


use App\Models\Backend\Books\BookRatingComment;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class BookRatingCommentRepository extends Repository
{

    public function model()
    {
        return BookRatingComment::class;
    }

    public function bookRatingCommentFilterData($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('books', 'books.book_id', '=', 'book_rating_comments.book_id');
        $query->leftJoin('users', 'users.id', '=', 'book_rating_comments.user_id');
        $query->leftJoin('user_details', 'users.id', '=', 'user_details.user_id');

        if (isset($filters['search_text']) && $filters['search_text']) {
            $query->orWhere('books.book_name', 'like', "%{$filters['search_text']}%");
        }

        //book_id
        if (!empty($filters['book_id'])) {
            $query->where('books.book_id', '=', $filters['book_id']);
        }
        //company_id
        if (!empty($filters['company_id'])) {
            $query->where('books.company_id', '=', $filters['company_id']);
        }
        //name
        if (!empty($filters['name'])) {
            $query->where('books.book_name', 'like', "%{$filters['name']}%");
        }
        //author
        if (!empty($filters['author'])) {
            $query->where('books.author', 'like', "%{$filters['author']}%");
            $query->orWhere('books.contributor', 'like', "%{$filters['author']}%");
        }

        //author
        if (!empty($filters['author'])) {
            $query->where('books.author', 'like', "%{$filters['author']}%");
        }
        //user_id
        if (!empty($filters['user_id'])) {
            $query->where('book_rating_comments.user_id', '=', $filters['user_id']);
        }

        //book rating sorting by id
        if (!empty($filters['book_rating_by_id'])) {
            $query->orderBy('book_rating_comments.id', $filters['book_rating_by_id']);
        }

        $query->select([
            'books.book_name',
            'users.name', 'users.username',
            'user_details.first_name', 'user_details.last_name',
            \DB::raw('IFNULL(IF(user_details.user_detail_photo REGEXP "https?", user_details.user_detail_photo, CONCAT("'.url('/').'",user_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS user_detail_photo'),
            'book_rating_comments.*',
            \DB::raw('CONVERT_TZ(book_rating_comments.created_at, "+00:00", "+06:00") AS created_at')
        ]);
        return $query;
    }
}
