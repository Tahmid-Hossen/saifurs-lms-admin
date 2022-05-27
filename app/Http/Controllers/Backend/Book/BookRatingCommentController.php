<?php

namespace App\Http\Controllers\Backend\Book;

use App\Http\Controllers\Controller;
use App\Services\Backend\Books\BookRatingCommentService;
use App\Services\Backend\Books\BookService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BookRatingCommentController extends Controller
{
    /**
     * @var BookRatingCommentService
     */
    private $bookRatingCommentService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var BookService
     */
    private $bookService;

    /**
     * BookRatingCommentController constructor.
     * @param BookRatingCommentService $bookRatingCommentService
     * @param UserService $userService
     * @param CompanyService $companyService
     * @param BookService $bookService
     */
    public function __construct(
        BookRatingCommentService $bookRatingCommentService,
        UserService              $userService,
        CompanyService           $companyService,
        BookService              $bookService
    )
    {
        $this->middleware('auth');
        $this->bookRatingCommentService = $bookRatingCommentService;
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $requestData['is_ebook'] = 'no';
            $bookRatingComments = $this->bookRatingCommentService->showAllBookRatingComment($requestData)->paginate($request->display_item_per_page);
            $books = $this->bookService->getAllBook($requestData)->get();
            $companies = $this->companyService->showAllCompany($requestData)->get();
            return view('backend.book.book-rating-comments.index', compact('companies', 'books', 'request', 'bookRatingComments'));
        } catch (\Exception $e) {
            flash('Book Rating Comment table not found!')->error();
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
            $request['company_id'] = isset($companyWiseUser['company_id']) ? $companyWiseUser['company_id'] : null;
            $companies = $this->companyService->showAllCompany($request)->get();
            $books = $this->bookService->getAllBook($request)->get();
            return view('backend.book.book-rating-comments.create', compact('books', 'companies'));
        } catch (\Exception $e) {
            flash('Something wrong with Book Rating Comment Data!')->error();
            return Redirect::to('/backend/book-rating-comments');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $bookRatingComment = $this->bookRatingCommentService->createBookRatingComment($request->except('_token', '_wysihtml5_mode'));
            if ($bookRatingComment) {
                flash('Book Rating Comment created successfully')->success();
            } else {
                flash('Failed to create Book Rating Comment')->error();
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            flash('Failed to create Book Rating Comment')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('book-rating-comments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $bookRatingComment = $this->bookRatingCommentService->bookRatingCommentById($id);
            return view('backend.book.book-rating-comments.show', compact('bookRatingComment'));
        } catch (\Exception $e) {
            flash('Book Rating Comment data not found!!')->error();
            return redirect()->route('book-rating-comments.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['company_id'] = isset($companyWiseUser['company_id']) ? $companyWiseUser['company_id'] : null;
            $bookRatingComment = $this->bookRatingCommentService->bookRatingCommentById($id);
            $companies = $this->companyService->showAllCompany($request)->get();
            $books = $this->bookService->getAllBook($request)->get();
            return view('backend.book.book-rating-comments.edit', compact('books', 'companies', 'bookRatingComment'));
        } catch (\Exception $e) {
            flash('Something wrong with Book Rating Comment Data!')->error();
            return Redirect::to('/backend/book-rating-comments');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
            $bookRatingComment = $this->bookRatingCommentService->updateBookRatingComment($request->except('_token', '_wysihtml5_mode'), $id);
            if ($bookRatingComment) {
                flash('Book Rating Comment Updated successfully')->success();
            } else {
                flash('Failed to update Book Rating Comment')->error();
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            flash('Failed to Updated Book Rating Comment')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('book-rating-comments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            $bookRatingComment = $this->bookRatingCommentService->bookRatingCommentById($id);
            if ($bookRatingComment) {
                $bookRatingComment->delete();
                flash('Book Rating Comment deleted successfully')->success();
            } else {
                flash('Book Rating Comment not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('book-rating-comments.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $bookRatingComments = $this->bookRatingCommentService->showAllBookRatingComment($requestData)->get();
            return view('backend.book.book-rating-comments.pdf', compact('bookRatingComments'));
        } catch (\Exception $e) {
            flash('Book Rating Comment table not found!')->error();
            return Redirect::to('/backend/branches');
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
            $requestData = array_merge($companyWiseUser, $request->all());
            $bookRatingComments = $this->bookRatingCommentService->showAllBookRatingComment($requestData)->get();
            return view('backend.book.book-rating-comments.excel', compact('bookRatingComments'));
        } catch (\Exception $e) {
            flash('Book Rating Comment table not found!')->error();
            return Redirect::to('/backend/branches');
        }
    }

}
