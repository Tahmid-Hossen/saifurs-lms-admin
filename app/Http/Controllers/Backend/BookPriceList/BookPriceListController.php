<?php

namespace App\Http\Controllers\Backend\BookPriceList;

use App\Http\Requests\Backend\BookPriceList\StoreBookPriceListRequest;
use App\Models\Backend\BookPriceList\BookPriceList;
use App\Services\Backend\BookPriceList\BookPriceListService;
use App\Services\Backend\User\UserService;
use App\Http\Controllers\Controller;

use CodeIgniter\HTTP\RedirectResponse;
use Illuminate\Http\Request;
use Exception;

class BookPriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $bookPriceListService;
    private $userService;
   public function __construct(BookPriceListService $bookPriceListService, UserService $userService)
    {
        $this->middleware( 'auth' );
        $this->bookPriceListService = $bookPriceListService;
        $this->userService = $userService;
    }

    public function index(Request $request)

    {
        try {

           $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : \Utility::$displayRecordPerPage;
            $bookpricelists = $this->bookPriceListService->ShowAllBookPriceList()->paginate($request->display_item_per_page);

            return view('backend.bookpricelist.index', compact('bookpricelists'));

         /*   $bookpricelists = BookPriceList::all();
            dd($bookpricelists);
            return view('backend.bookpricelist.index', compact('bookpricelists'));*/


        }
        catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Book Price List table not found!' )->error();
            return redirect( route( 'bookpricelist.index' ) );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('backend.bookpricelist.create');
        }
        catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Book Price List table not found!' )->error();
            return redirect( route( 'bookpricelist.index' ) );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookPriceListRequest $request)
    {
        try {
            $bookpricelist = $this->bookPriceListService->bookPriceListCustomInsert($request->except( '_token'));

            if ($bookpricelist) {
                flash( 'Book Price List has been Successfully Created' )->success();
            } else {
                flash( 'Failed to Create a Book Price List' )->error();
            }
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to Create a Book Price List' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'bookpricelist.index' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookPriceList  $bookPriceList
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $bookPriceList = $this->bookPriceListService->showBookPriceListByID($id);
            return view( 'backend.bookpricelist.show', compact('bookPriceList') );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "Book Price List data not found!" )->error();
            return redirect( route( 'bookpricelist.index' ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookPriceList  $bookPriceList
     * @return \Illuminate\Http\Response
     */
  public function edit($id)
    {
        try {
            $bookpriceList = $this->bookPriceListService->showBookPriceListByID( $id );
            return view( 'backend.bookpricelist.edit', [
                'bookpricelist'    => $bookpriceList,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "Book Price List data not found!" )->error();
            return redirect( route( 'bookpricelist.index' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookPriceList  $bookPriceList
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBookPriceListRequest $request, $id)
    {
        try {
            $bookpricelist= $this->bookPriceListService->bookPriceListCustomUpdate( $request->except( '_token' ), $id );
            if ( $bookpricelist ) {
                flash( 'Book Price List has been updated Successfully' )->success();
                return redirect( route( 'bookpricelist.index' ) );
            }
        } catch ( Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to update Book Price List' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'bookpricelist.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookPriceList  $bookPriceList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auth_user = $this->userService->whoIS($_REQUEST);
        if (isset($auth_user)
            && isset($auth_user->id)
            && $auth_user->id == auth()->user()->id) {
            try {
                if ($book = $this->bookPriceListService->showBookPriceListByID($id)) {
                    $this->bookPriceListService->deleteBookPriceList($id);
                }
                flash('Book Price List deleted successfully')->success();

            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                flash('Book Price List not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('bookpricelist.index');
    }
}
