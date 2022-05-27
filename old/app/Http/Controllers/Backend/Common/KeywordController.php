<?php

namespace App\Http\Controllers\Backend\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Common\KeywordRequest;
use App\Services\Backend\Common\KeywordService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

/**
 * Class KeywordController
 * @package App\Http\Controllers\Backend\Common
 */
class KeywordController extends Controller
{
    /**
     * @var KeywordService
     */
    private $keywordService;

    /**
     * KeywordController constructor.
     * @param KeywordService $keywordService
     */
    public function __construct(KeywordService $keywordService)
    {
        $this->keywordService = $keywordService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('backend.common.keyword.index', [
            'services' => $this->keywordService->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.common.keyword.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KeywordRequest $keywordRequest
     * @return Response
     */
    public function store(KeywordRequest $keywordRequest)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view('backend.common.keyword.show', [
            'services' => $this->keywordService->findById($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('backend.common.keyword.edit', [
            'services' => $this->keywordService->findById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param KeywordRequest $keywordRequest
     * @param int $id
     * @return Response
     */
    public function update(KeywordRequest $keywordRequest, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
