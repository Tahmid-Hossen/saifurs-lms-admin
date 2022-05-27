<?php

namespace App\Http\Controllers\Backend\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Books\BookRequest;
use App\Services\Backend\Books\BookService;
use App\Services\Backend\Books\CategoryService;
use App\Services\Backend\Common\KeywordService;
use App\Services\Backend\User\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;
use Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Utility;

/**
 * Class BookController
 * @package App\Http\Controllers\Backend\Book
 */
class BookController extends Controller
{
    /**
     * @var BookService
     */
    private $bookService;

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var KeywordService
     */
    private $keywordService;
    /**
     * @var
     */
    private $userService;

    /**
     * BookController constructor.
     * @param BookService $bookService
     * @param CategoryService $categoryService
     * @param KeywordService $keywordService
     * @param UserService $userService
     */
    public function __construct(
        BookService     $bookService,
        CategoryService $categoryService,
        KeywordService  $keywordService,
        UserService     $userService
    )
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
        $this->keywordService = $keywordService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : \Utility::$displayRecordPerPage;
        $request['sorting_order'] = isset($request['sorting_order']) ? $request['sorting_order'] : 'DESC';
        $inputs = $request->query();
        $filters = array_merge($inputs, ['is_ebook' => 'NO'], $this->dateRangePicker($inputs));

        $books = $this->bookService->getAllBook($filters)->with(['company', 'category'])->paginate($request->display_item_per_page);
        return view('backend.book.book.index', [
            'books' => $books,
            'categories' => $this->categoryService->getCategoryDropDown(),
            'inputs' => $request->query(),
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.book.book.create', [
            'categories' => $this->categoryService->getCategoryDropDown(),
            'keywords' => $this->keywordService->getKeywordDropDown(),
            'types' => $this->bookService->getEbookTypeDropDown()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $bookRequest
     * @return RedirectResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function store(BookRequest $bookRequest): RedirectResponse
    {
        $image_path = $this->bookService->getUploadedImage($bookRequest);
        $ebook_file = $this->bookService->getUploadedFile($bookRequest);
            if (!empty($image_path) && $ebook_file !== false) {
                \DB::beginTransaction();
                try {
                    $book = $this->bookService->getRequestDataFormatted($bookRequest->except('_token'), $image_path, $ebook_file);
                    $keywords = $this->keywordService->getAllKeywordId($bookRequest->input('book_keywords.*'));
                    $this->bookService->storeBook($book, $keywords);
                    \DB::commit();

                    flash('Book created successfully', 'success');
                    return redirect()->route('books.index');

                } catch (Exception $exception) {
                    \Log::error($exception->getMessage());
                    \DB::rollBack();

                    flash('Failed to create new book!', 'error');
                    return redirect()->back()->withInput($bookRequest->all());
                }
            } else {
                flash('Failed to upload Image!', 'error');
                return redirect()->back()->withInput($bookRequest->all());
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
            $book = $this->bookService->showBookByID($id);

            return view('backend.book.book.show', [
                'book' => $book
            ]);

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            flash('Book Not Found', 'error');
            return redirect()->route('books.index');
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
            $book = $this->bookService->showBookByID($id);
            return view('backend.book.book.edit', [
                'book' => $book,
                'categories' => $this->categoryService->getCategoryDropDown(),
                'keywords' => $this->keywordService->getKeywordDropDown(),
                'types' => $this->bookService->getEbookTypeDropDown()
            ]);

        } catch (Exception $exception) {

            Log::error($exception->getMessage());
            flash('Book Not Found', 'error');
            return redirect()->route('books.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookRequest $bookRequest
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public
    function update(BookRequest $bookRequest, int $id): RedirectResponse
    {
        $image_path = $this->bookService->getUploadedImage($bookRequest);
        if (!empty($image_path)) {
            try {
                $book = $this->bookService->getRequestDataFormatted($bookRequest->except('_token'), $image_path);
                $keywords = $this->keywordService->getAllKeywordId($bookRequest->input('book_keywords.*'));
                $this->bookService->updateBook($id, $book, $keywords);
                flash('Book data updated successfully', 'success');
                return redirect()->route('books.index');

            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                flash('Failed to update book info!', 'error');
                return redirect()->back()->withInput($bookRequest->all());
            }
        } else {
            flash('Failed to upload Image!', 'error');
            return redirect()->back()->withInput($bookRequest->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public
    function destroy(int $id): RedirectResponse
    {
        $auth_user = $this->userService->whoIS($_REQUEST);
        if (isset($auth_user)
            && isset($auth_user->id)
            && $auth_user->id == auth()->user()->id) {
            try {
                if ($book = $this->bookService->showBookByID($id)) {
                    $this->bookService->deleteBook($id);
                }
                flash('Book deleted successfully')->success();

            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                flash('Book not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('books.index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     * @throws Exception
     */
    public
    function pdf(Request $request)
    {
        try {
            $request['sorting_order'] = isset($request['sorting_order']) ? $request['sorting_order'] : 'DESC';
            $inputs = $request->query();
            $filters = array_merge($inputs, ['is_ebook' => 'NO'], $this->dateRangePicker($inputs));

            return view('backend.book.book.pdf', [
                'books' => $this->bookService->getAllBook($filters)->with(['company', 'category'])->get()
            ]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            flash('No Books Found For Export');
            return redirect()->route('books.index');
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public
    function excel(Request $request)
    {
        try {
            $request['sorting_order'] = isset($request['sorting_order']) ? $request['sorting_order'] : 'DESC';
            $inputs = $request->query();
            $filters = array_merge($inputs, ['is_ebook' => 'NO'], $this->dateRangePicker($inputs));

            return view('backend.book.book.excel', [
                'books' => $this->bookService->getAllBook($filters)->with(['company', 'category'])->get()
            ]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            flash('No Books Found For Export');
            return redirect()->route('books.index');
        }
    }

    /**
     * Display a listing of the ebook resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public
    function ebookList(Request $request)
    {
        $request['sorting_order'] = isset($request['sorting_order']) ? $request['sorting_order'] : 'DESC';
        $inputs = $request->query();
        $filters = array_merge($inputs, ['is_ebook' => 'NO'], $this->dateRangePicker($inputs));

        return view('backend.book.ebook.index', [
            'ebooks' => $this->bookService->getAllBook($filters)->with(['company', 'category'])->paginate(Utility::$displayRecordPerPage),
            'categories' => $this->categoryService->getCategoryDropDown(),
            'inputs' => $this->dateRangePicker($inputs),
            'filters' => $filters,
            'ebook_list' => true,
        ]);
    }

    /**
     *
     * @param int $id
     * @return RedirectResponse|BinaryFileResponse
     */
    public
    function download(int $id)
    {
        try {
            $book = $this->bookService->showBookByID($id);
            $filename = (\Str::kebab($book->book_name))
                . '-by-' . (\Str::kebab($book->author))
                . '-' . basename($book->storage_path);
            $headers = array(
                'Content-Type: application/pdf',
            );
            return \Response::download(public_path($book->storage_path), $filename, $headers);

        } catch (Exception $exception) {

            Log::error($exception->getMessage());
            flash('Book Not Found', 'error');
            return redirect()->back(302);
        }
    }

}
