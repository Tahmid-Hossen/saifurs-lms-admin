<?php

namespace App\Http\Controllers\Backend\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Faq\StoreFaqRequest;
use App\Models\Backend\Faq\Faq;
use App\Services\Backend\Faq\FaqService;
use App\Services\Backend\User\UserService;
use CodeIgniter\HTTP\RedirectResponse;
use Illuminate\Http\Request;
use Exception;

class FaqController extends Controller
{
    /**
     * @var FaqService
     */
    private $faqService;
    private $userService;

    /**
     * FaqController constructor.
     * @param FaqService $faqService
     * @param UserService $userService
     */
    public function __construct(FaqService $faqService, UserService $userService)
    {
        $this->middleware( 'auth' );
        $this->faqService = $faqService;
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : \Utility::$displayRecordPerPage;
            $filters = $request->query();

            $faqs = $this->faqService->ShowAllFaq($filters)->paginate($request->display_item_per_page);
            return view('backend.faq.index', compact('faqs'));

        }
        catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Faq table not found!' )->error();
            return redirect( route( 'faq.index' ) );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function create()
    {
        try{
            return view('backend.faq.create');
        }
        catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Faq table not found!' )->error();
            return redirect( route( 'faq.index' ) );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function store(StoreFaqRequest $request)
    {
        try {
            $banner = $this->faqService->faqCustomInsert($request->except( '_token'));
            if ($banner) {
                    flash( 'Faq has been Successfully Created' )->success();
            } else {
                flash( 'Failed to Create a Faq' )->error();
            }
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to Create a Faq' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'faq.index' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $faq = $this->faqService->showFaqByID($id);
            return view( 'backend.faq.show', compact('faq') );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "Faq's data not found!" )->error();
            return redirect( route( 'faq.index' ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Backend\Faq\Faq  $faq
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function edit($id)
    {
        try {
            $faq = $this->faqService->showFaqByID( $id );
            return view( 'backend.faq.edit', [
                'faq'    => $faq,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "Faq's data not found!" )->error();
            return redirect( route( 'faq.index' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Backend\Faq\Faq  $faq
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function update(StoreFaqRequest $request, $id)
    {
        try {
            $faq = $this->faqService->faqCustomUpdate( $request->except( '_token' ), $id );
            if ( $faq ) {
                flash( 'A Faq has been updated Successfully' )->success();
                return redirect( route( 'faq.index' ) );
            }
        } catch ( Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to update Faq' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'faq.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Backend\Faq\Faq  $faq
     * @return RedirectResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function destroy($id)
    {
        $auth_user = $this->userService->whoIS($_REQUEST);
        if (isset($auth_user)
            && isset($auth_user->id)
            && $auth_user->id == auth()->user()->id) {
            try {
                if ($book = $this->faqService->showFaqByID($id)) {
                    $this->faqService->deleteFaq($id);
                }
                flash('Faq deleted successfully')->success();

            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                flash('Faq not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('faq.index');
    }
}
