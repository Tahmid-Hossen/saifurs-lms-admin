<?php

namespace App\Http\Controllers\Backend\BranchLocation;

use App\Http\Requests\Backend\BranchLocation\StoreBranch_locationRequest;
use App\Models\Backend\BranchLocation\Branch_location;
use App\Services\Backend\BranchLocation\BranchLocationService;
use App\Services\Backend\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $BranchLocationService;
    private $userService;

    public function __construct(BranchLocationService $BranchLocationService, UserService $userService)
    {
        $this->middleware( 'auth' );
        $this->BranchLocationService = $BranchLocationService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {

            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : \Utility::$displayRecordPerPage;
            $branchlocations = $this->BranchLocationService->ShowAllBranchLocation()->paginate($request->display_item_per_page);

            return view('backend.branchlocation.index', compact('branchlocations'));

        }
        catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Book Price List table not found!' )->error();
            return redirect( route( 'branchlocation.index' ) );
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
            return view('backend.branchlocation.create');
        }
        catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Branch List table not found!' )->error();
            return redirect( route( 'branchlocation.index' ) );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranch_locationRequest $request)
    {
        try {
            $branchlocation = $this->BranchLocationService->branchlocationCustomInsert($request->except( '_token'));

            if ($branchlocation) {
                flash( 'Branch Location has been Successfully Created' )->success();
            } else {
                flash( 'Failed to Create Branch Location' )->error();
            }
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to Create Branch Location' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'branchlocation.index' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch_location  $branch_location
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $branchlocation = $this->BranchLocationService->showBranchLocationByID($id);
            return view( 'backend.branchlocation.show', compact('branchlocation') );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "Branch Location data not found!" )->error();
            return redirect( route( 'branchlocation.index' ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch_location  $branch_location
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $branchlocation = $this->BranchLocationService->showBranchLocationByID( $id );
            return view( 'backend.branchlocation.edit', [
                'branchlocation'    => $branchlocation,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "Branch location Data not found!" )->error();
            return redirect( route( 'branchlocation.index' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch_location  $branch_location
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBranch_locationRequest $request, $id)
    {
        try {
            $branchlocation= $this->BranchLocationService->branchlocationCustomUpdate( $request->except( '_token' ), $id );
            if ( $branchlocation ) {
                flash( 'Branch Location has been updated Successfully' )->success();
                return redirect( route( 'branchlocation.index' ) );
            }
        } catch ( Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to update Branch Location' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'branchlocation.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch_location  $branch_location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auth_user = $this->userService->whoIS($_REQUEST);
        if (isset($auth_user)
            && isset($auth_user->id)
            && $auth_user->id == auth()->user()->id) {
            try {
                if ($book = $this->BranchLocationService->showBranchLocationByID($id)) {
                    $this->BranchLocationService->deleteBranchLocation($id);
                }
                flash('Branch Location deleted successfully')->success();

            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                flash('Branch Location not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('branchlocation.index');
    }
}
