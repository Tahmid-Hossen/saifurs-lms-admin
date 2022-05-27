<?php

namespace App\Observers\Books;

use App\Models\Backend\Books\Book;
use App\Models\User;
use App\Notifications\Backend\Books\BookCreatedNotification;
use App\Services\Backend\User\UserService;

class BookObserver
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the Book "created" event.
     *
     * @param Book $book
     * @return void
     */
    public function created(Book $book)
    {
        $company_id = $book->company_id;
        $notifiableUsers = $this->userService->allUsers(['company_id' => $company_id])->get();

        foreach ($notifiableUsers as $notifiableUser) :
            $this->sendBookNotification($notifiableUser, $book);
        endforeach;
    }

    /**
     * Handle the Book "updated" event.
     *
     * @param Book $book
     * @return void
     */
    public function updated(Book $book)
    {
        //
    }

    private function sendBookNotification(User $recipientUser, Book $book)
    {
        \Log::info("Book Observer checking");
        $recipientUser->notify(new BookCreatedNotification($book));
    }
}
