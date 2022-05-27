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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Utility;

/**
 * Class BookController
 * @package App\Http\Controllers\Backend\Book
 */
class EBookController extends Controller
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
       $request['is_ebook'] = 'YES';
        $filters = $request->query();

        $books = $this->bookService->getAllBook($filters)->paginate($request->display_item_per_page);
        return view('backend.book.ebook.index', [
            'ebooks' => $books,
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
        return view('backend.book.ebook.create', [
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

        if ($image_path != false && $ebook_file !== false) {
            \DB::beginTransaction();
            try {
                $book = $this->bookService->getRequestDataFormatted($bookRequest->except('_token'), $image_path, $ebook_file);
                $keywords = $this->keywordService->getAllKeywordId($bookRequest->input('book_keywords.*'));
                $this->bookService->storeBook($book, $keywords);
                \DB::commit();

                flash('EBook created successfully', 'success');
                return redirect()->route('ebooks.index');

            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                \DB::rollBack();

                flash('Failed to create new Ebook!', 'error');
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
            $ebook = $this->bookService->showBookByID($id);
            return view('backend.book.ebook.show', [
                'ebook' => $ebook
            ]);

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            flash('EBook Not Found', 'error');
            return redirect()->route('ebooks.index');
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
            $ebook = $this->bookService->showBookByID($id);
            return view('backend.book.ebook.edit', [
                'ebook' => $ebook,
                'categories' => $this->categoryService->getCategoryDropDown(),
                'keywords' => $this->keywordService->getKeywordDropDown(),
                'types' => $this->bookService->getEbookTypeDropDown()
            ]);

        } catch (Exception $exception) {

            Log::error($exception->getMessage());
            flash('EBook Not Found', 'error');
            return redirect()->route('ebooks.index');
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
    public function update(BookRequest $bookRequest, int $id): RedirectResponse
    {

        $image_path = $this->bookService->getUploadedImage($bookRequest);
        $ebook_file = $this->bookService->getUploadedFile($bookRequest);
        if ($image_path != false) {
            try {
                $book = $this->bookService->getRequestDataFormatted($bookRequest->except('_token'), $image_path, $ebook_file);
                $keywords = $this->keywordService->getAllKeywordId($bookRequest->input('book_keywords.*'));
                $this->bookService->updateBook($id, $book, $keywords);
                flash('EBook data updated successfully', 'success');
                return redirect()->route('ebooks.index');

            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                flash('Failed to update Ebook info!', 'error');
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
    public function destroy(int $id): RedirectResponse
    {
        $auth_user = $this->userService->whoIS($_REQUEST);
        if (isset($auth_user)
            && isset($auth_user->id)
            && $auth_user->id == auth()->user()->id) {
            try {
                if ($ebook = $this->bookService->showBookByID($id)) {
                    $this->bookService->deleteBook($id);
                }
                flash('EBook deleted successfully')->success();

            } catch (ModelNotFoundException $exception) {
                Log::error($exception->getMessage());
                flash('EBook not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('ebooks.index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     * @throws Exception
     */
    public function pdf(Request $request)
    {
        try {
            $inputs = $request->query();
            $filters = array_merge($inputs, ['is_ebook' => 'YES'], $this->dateRangePicker($inputs));

            return view('backend.book.ebook.pdf', [
                'books' => $this->bookService->getAllBook($filters)->get()
            ]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            flash('No Books Found For Export');
            return redirect()->route('ebooks.index');
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $inputs = $request->query();
            $filters = array_merge($inputs, ['is_ebook' => 'YES'], $this->dateRangePicker($inputs));

            return view('backend.book.ebook.excel', [
                'books' => $this->bookService->getAllBook($filters)->get()
            ]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            flash('No Books Found For Export');
            return redirect()->route('ebooks.index');
        }
    }

    /**
     * Display a listing of the ebook resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function ebookList(Request $request)
    {
        $inputs = $request->query();
        $filters = array_merge($inputs, ['is_ebook' => 'YES'], $this->dateRangePicker($inputs));

        return view('backend.book.ebook.index', [
            'ebooks' => $this->bookService->getAllBook($filters)->paginate(Utility::$displayRecordPerPage),
            'categories' => $this->categoryService->getCategoryDropDown(),
            'inputs' => $this->dateRangePicker($inputs),
            'filters' => $filters
        ]);
    }

    /**
     *
     * @param int $id
     * @return RedirectResponse|BinaryFileResponse
     */
    public function download(int $id)
    {
        try {
            $book = $this->bookService->showBookByID($id);

            $fileinfo = pathinfo(public_path($book->storage_path));

            $filename = (\Str::kebab($book->book_name))
                . '-by-' . (\Str::kebab($book->author))
                . '-' . basename($fileinfo['basename']);

            $headers = array('Content-Type: ' . \Utility::getHeaderContentType($fileinfo['extension']));

            return \Response::download(public_path($book->storage_path), $filename, $headers);

        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            flash('EBook Not Found', 'error');
            return redirect()->back();
        }
    }
}
