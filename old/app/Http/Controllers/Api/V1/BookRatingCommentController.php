<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Backend\Books\BookRatingCommentService;
use App\Services\Backend\Books\BookService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;

class BookRatingCommentController
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
        UserService $userService,
        CompanyService $companyService,
        BookService $bookService
    )
    {
        $this->bookRatingCommentService = $bookRatingCommentService;
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $request['book_rating_by_id'] = isset($request['book_rating_by_id'])?$request['book_rating_by_id']:'DESC';
            $request['is_approved'] = isset($request['is_approved'])?$request['is_approved']:'YES';
            $request['book_rating_comment_status'] = isset($request['book_rating_comment_status'])?$request['book_rating_comment_status']:'ACTIVE';
            //$companyWiseUser = $this->userService->user_role_display_for_api();
            $companyWiseUser = array();
            $requestData = array_merge($companyWiseUser,$request->all());
            $data['bookRatingComments'] = $this->bookRatingCommentService->showAllBookRatingComment($requestData)->paginate($request->display_item_per_page);
            //$data['books'] = $this->bookService->getAllBook($requestData)->get();
            //$data['companies'] = $this->companyService->showAllCompany($requestData)->get();
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = true;
            $data['message'] = 'Book Rating Comment table not found!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $bookRatingComment = $this->bookRatingCommentService->createBookRatingComment($request->except('_token', '_wysihtml5_mode'));
            if ($bookRatingComment) {
                $data['bookRatingComment'] = $bookRatingComment;
                $data['status'] = true;
                $data['message'] = 'Book Rating Comment created successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to create Book Rating Comment';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to create Book Rating Comment!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $bookRatingComment = $this->bookRatingCommentService->bookRatingCommentById($id);
            $data['bookRatingComment'] = $bookRatingComment;
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Book Rating Comment data not found!!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $bookRatingComment = $this->bookRatingCommentService->updateBookRatingComment($request->except('_token', '_wysihtml5_mode'), $id);
            if ($bookRatingComment) {
                $data['bookRatingComment'] = $bookRatingComment;
                $data['status'] = true;
                $data['message'] = 'Book Rating Comment Updated successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to update Book Rating Comment';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to Updated Book Rating Comment!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $bookRatingComment = $this->bookRatingCommentService->bookRatingCommentById($id);
                if ($bookRatingComment) {
                    $bookRatingComment->delete();
                    $data['status'] = true;
                    $data['message'] = 'Book Rating Comment deleted successfully';
                }else{
                    \DB::rollback();
                    $data['status'] = false;
                    $data['message'] = 'Book Rating Comment not found!';
                }
            }else{
                $data['status'] = false;
                $data['message'] = 'You Entered Wrong Password!';
            }
            \DB::commit();
        } catch ( \Exception $e ) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Book Rating Comment not found!!';
        }
        return response()->json($data,200);
    }

}
