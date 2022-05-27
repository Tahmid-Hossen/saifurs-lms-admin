<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Services\Backend\Books\BookService;
use App\Services\Backend\Books\CategoryService;
use App\Services\Backend\Common\KeywordService;
use App\Services\Backend\Sale\TransactionService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use App\Models\Backend\Books\Inventory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Utility;

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
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * BookController constructor.
     * @param BookService $bookService
     * @param CategoryService $categoryService
     * @param KeywordService $keywordService
     * @param UserService $userService
     * @param CompanyService $companyService
     * @param TransactionService $transactionService
     */
    public function __construct(
        BookService $bookService,
        CategoryService $categoryService,
        KeywordService $keywordService,
        UserService $userService,
        CompanyService $companyService,
        TransactionService $transactionService
    )
    {
        $this->bookService = $bookService;
        $this->categoryService = $categoryService;
        $this->keywordService = $keywordService;
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $request->display_item_per_page = $request->display_item_per_page ?? \Utility::$displayRecordPerPage;
            $inputs = $request->query();
            $inputs['book_status'] = Constants::$user_active_status;
            $inputs['is_ebook'] = 'NO';
            //$filters = array_merge($inputs, $this->dateRangePicker($inputs));
            $filters = array_merge($inputs, array());
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $bookArray = array();
            $requestData = array_merge($companyWiseUser, $filters);
            $books = $this->bookService->getAllBook($requestData)->paginate($request->display_item_per_page);
            if (count($books) > 0):
                foreach ($books as $book):
                    $bookArray [] = $book;
                    $book->photo = $book->photo_full_path;
                    $book->photo = array_values(array_filter($book->photo));
                    $book->storage_path = $book->storage_path_full_path;
                    $book->book_total_rating_point = $book->book_rating_point;
                    $book->book_total_comment = $book->book_total_comment;
                    $book->book_total_purchases = 0;
                endforeach;
                $paginate_properties = json_decode($books->toJSON());
                $data['books']['current_page'] = $paginate_properties->current_page;
                $data['books']['data'] = $bookArray;
                $data['books']['first_page_url'] = $paginate_properties->first_page_url;
                $data['books']['from'] = $paginate_properties->from;
                $data['books']['last_page'] = $paginate_properties->last_page;
                $data['books']['last_page_url'] = $paginate_properties->last_page_url;
                $data['books']['next_page_url'] = $paginate_properties->next_page_url;
                $data['books']['path'] = $paginate_properties->path;
                $data['books']['per_page'] = $paginate_properties->per_page;
                $data['books']['prev_page_url'] = $paginate_properties->prev_page_url;
                $data['books']['to'] = $paginate_properties->to;
                $data['books']['total'] = $paginate_properties->total;
                $data['request'] = $filters;
                $data['status'] = true;
            else:
                $data['request'] = $filters;
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'Book table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(int $id): JsonResponse
    {
        try {
            $book = $this->bookService->showBookByID($id);			
			$bookstock = Inventory::where('book_id',$id)->first();
			if($bookstock!=""){
				$current_qty = $bookstock->current_qty;
			}
			else{
				$current_qty = $book->quantity;
			}
			
            $data['current_qty'] = $current_qty;
			$data['book'] = $book;
            $data['book']['language'] = \Utility::$languageList[$book->language];
            $book->photo = $book->photo_full_path;
            $book->file = $book->file_full_path;
            $book->photo = array_values(array_filter($book->photo));
            $book->storage_path = $book->storage_path_full_path;
            $book->book_total_rating_point = isset($book->book_rating_point) ? $book->book_rating_point : 0;
            $book->book_total_comment = isset($book->book_total_comment) ? $book->book_total_comment : 0;
            $book->book_total_purchases = 0;
            $bookCommentArray = array();
            if (isset($book->bookRatingCommentWithApproved)):
                foreach ($book->bookRatingCommentWithApproved as $bookComment):
                    if (isset($bookComment->user->userDetails)):
                        $bookComment->user->userDetails;
                        $bookComment->name = $bookComment->user->name;
                        $bookComment->first_name = $bookComment->user->userDetails->first_name;
                        $bookComment->last_name = $bookComment->user->userDetails->last_name;
                        $bookComment->user_detail_photo = $bookComment->user->userDetails->user_detail_photo_full_link;
                        $bookCommentArray[] = $bookComment->makeHidden('user');
                    endif;
                endforeach;
            endif;
            $data['book']['book_rating_comment_with_approved'] = $bookCommentArray;

            $ratingRatingArray = array();
            if (isset($book->bookRatingGroup)):
                foreach ($book->bookRatingGroup as $bookRatingGroup):
                    $ratingRatingArray[$bookRatingGroup->text_book_rating_stars] = \CHTML::numberFormat((($bookRatingGroup->total_book_rating_stars * 100) / $book->book_total_comment));
                endforeach;
            endif;
            //@TODO ANOTHER book_rating_group HAD A INDEX OVERWRITE
            $data['book']['book_rating_groups'] = array_merge(\Utility::$ratingStarGroup, $ratingRatingArray);
            $data['book']['type'] = $book->type;
            $data['book']['keywords'] = $book->keywords;
            $data['book']['users_list_id'] = $book->users->pluck('id');
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Book data not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the ebook resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ebookList(Request $request): JsonResponse
    {
        try {
            $inputs = $request->query();
            $inputs['book_status'] = Constants::$user_active_status;
            $inputs['is_ebook'] = 'YES';
            //$filters = array_merge($inputs, ['is_ebook' => 'YES'], $this->dateRangePicker($inputs));
            $filters = array_merge($inputs, array());
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $bookArray = array();
            $requestData = array_merge($companyWiseUser, $filters);
            $books = $this->bookService->getAllBook($requestData)->paginate(Utility::$displayRecordPerPage);
            if (count($books) > 0):
                foreach ($books as $book):
                    $bookArray [] = $book;
                    $book->photo = $book->photo_full_path;
                    $book->storage_path = $book->storage_path_full_path;
                    $book->book_total_rating_point = $book->book_rating_point;
                    $book->book_total_comment = $book->book_total_comment;
                    $book->book_total_purchases = 0;
                endforeach;
                $paginate_properties = json_decode($books->toJSON());
                $data['books']['current_page'] = $paginate_properties->current_page;
                $data['books']['data'] = $bookArray;
                $data['books']['first_page_url'] = $paginate_properties->first_page_url;
                $data['books']['from'] = $paginate_properties->from;
                $data['books']['last_page'] = $paginate_properties->last_page;
                $data['books']['last_page_url'] = $paginate_properties->last_page_url;
                $data['books']['next_page_url'] = $paginate_properties->next_page_url;
                $data['books']['path'] = $paginate_properties->path;
                $data['books']['per_page'] = $paginate_properties->per_page;
                $data['books']['prev_page_url'] = $paginate_properties->prev_page_url;
                $data['books']['to'] = $paginate_properties->to;
                $data['books']['total'] = $paginate_properties->total;
                $data['request'] = $filters;
                $data['status'] = true;
            else:
                $data['request'] = $filters;
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'E-Book table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bookList(Request $request): JsonResponse
    {
        try {
            $inputs = $request->query();
            $inputs['book_status'] = Constants::$user_active_status;
            $inputs['is_ebook'] = 'NO';
            //$filters = array_merge($inputs, ['is_ebook' => 'NO'], $this->dateRangePicker($inputs));
            $filters = array_merge($inputs, array());
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser, $filters);
            $books = $this->bookService->getAllBook($requestData)->skip(0)->take(UtilityService::$displayRecordPerPage)->get();
            if (count($books) > 0):
                foreach ($books as $book):
                    $bookArray [] = $book;
                    $book->photo = $book->photo_full_path;
                    $book->photo = array_values(array_filter($book->photo));
                    $book->storage_path = $book->storage_path_full_path;
                    $book->book_total_rating_point = $book->book_rating_point;
                    $book->book_total_comment = $book->book_total_comment;
                    $book->book_total_purchases = 0;
                endforeach;
                $data['books'] = $bookArray;
                $data['request'] = $filters;
                $data['status'] = true;
            else:
                $data['request'] = $filters;
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'Book table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the ebook resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ebookListWithOutPagination(Request $request): JsonResponse
    {
        try {
            $inputs = $request->query();
            $inputs['book_status'] = Constants::$user_active_status;
            $inputs['is_ebook'] = 'YES';
            //$filters = array_merge($inputs, ['is_ebook' => 'YES'], $this->dateRangePicker($inputs));
            $filters = array_merge($inputs, array());

            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser, $filters);
            $books = $this->bookService->getAllBook($requestData)->skip(0)->take(UtilityService::$displayRecordPerPage)->get();
            if (count($books) > 0):
                foreach ($books as $book):
                    $bookArray [] = $book;
                    $book->photo = $book->photo_full_path;
                    $book->storage_path = $book->storage_path_full_path;
                    $book->book_total_rating_point = $book->book_rating_point;
                    $book->book_total_comment = $book->book_total_comment;
                    $book->book_total_purchases = 0;
                endforeach;
                $data['books'] = $bookArray;
                $data['request'] = $filters;
                $data['status'] = true;
            else:
                $data['request'] = $filters;
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message' => 'E-Book table not found!'], 200);
        }
        return $jsonReturn;
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

    public function assignFreeBookUser(Request $request): JsonResponse
    {

        \DB::beginTransaction();
        try {
            $jsonResponse = $this->bookService->assignTOUser($request->except('_token'));
            \DB::commit();
            return response()->json($jsonResponse, 200);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            \DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Something went wrong.'], 200);
        }
    }
}

