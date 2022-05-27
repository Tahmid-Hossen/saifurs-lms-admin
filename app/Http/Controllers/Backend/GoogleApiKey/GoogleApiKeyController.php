<?php

namespace App\Http\Controllers\Backend\GoogleApiKey;

use App\Http\Requests\Backend\GoogleApiKey\StoreGoogleApiKeyRequest;
use App\Models\Backend\GoogleApiKey\GoogleApiKey;
use App\Http\Controllers\Controller;
use App\Services\Backend\GoogleApiKey\GoogleApiKeyService;
use App\Services\Backend\User\UserService;
use Illuminate\Http\Request;
use Exception;

class GoogleApiKeyController extends Controller
{

    /**
     * @var GoogleApiKeyService
     */
    private $googleApiKeyService;
    private $userService;

    /**
     * FaqController constructor.
     * @param GoogleApiKeyService $googleApiKeyService
     * @param UserService $userService
     */
    public function __construct(GoogleApiKeyService $googleApiKeyService, UserService $userService)
    {
        $this->middleware( 'auth' );
        $this->googleApiKeyService = $googleApiKeyService;
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : \Utility::$displayRecordPerPage;
            //$filters = $request->query();

            $googleApiKeys = $this->googleApiKeyService->ShowAllGoogleApiKey()->get();
            //$googleApiKeys = GoogleApiKey::all();
            //dd($googleApiKeys);
            return view('backend.googleApiKey.index', compact('googleApiKeys'));

        }
        catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'GoogleApiKey table not found!' )->error();
            return redirect( route( 'googleApiKey.index' ) );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGoogleApiKeyRequest $request)
    {
        try {
            $googleApiKey = $this->googleApiKeyService->googleApiKeyCustomInsert($request->except( '_token'));

            if ($googleApiKey) {
                flash( 'GoogleApiKey has been Successfully Inserted' )->success();
            } else {
                flash( 'Failed to Inserted GoogleApiKey' )->error();
            }
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to Inserted GoogleApiKey' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'googleApiKey.index' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GoogleApiKey  $googleApiKey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $googleApiKey = $this->googleApiKeyService->showGoogleApiKeyByID($id);
            return view( 'backend.googleApiKey.show', compact('googleApiKey') );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "GoogleApiKey data not found!" )->error();
            return redirect( route( 'googleApiKey.index' ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoogleApiKey  $googleApiKey
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $googleApiKey = $this->googleApiKeyService->showGoogleApiKeyByID($id);
            return view( 'backend.googleApiKey.edit', [
                'googleApiKey'    => $googleApiKey,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "GoogleApiKey data not found!" )->error();
            return redirect( route( 'googleApiKey.index' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoogleApiKey  $googleApiKey
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGoogleApiKeyRequest $request, $id)
    {
        try {
            $googleApiKey= $this->googleApiKeyService->googleApiKeyCustomUpdate( $request->except( '_token' ), $id );
            if ( $googleApiKey ) {
                flash( 'GoogleApiKey has been updated Successfully' )->success();
                return redirect( route( 'googleApiKey.index' ) );
            }
        } catch ( Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to update GoogleApiKey' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'googleApiKey.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoogleApiKey  $googleApiKey
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoogleApiKey $googleApiKey)
    {
        //
    }
}
