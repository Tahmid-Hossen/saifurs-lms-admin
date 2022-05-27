<?php

namespace App\Http\Controllers\Backend\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Common\KeywordRequest;
use App\Services\Backend\Common\TagService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
/**
 * Class TagController
 * @package App\Http\Controllers\Backend\Common
 */
class TagController extends Controller
{
    /**
     * @var TagService
     */
    private $tagService;

    /**
     * TagController constructor.
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('backend.common.tag.index', [
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
        return view('backend.common.tag.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TagRequest $tagRequest
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $tagRequest)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view('backend.common.tag.show', [
            'services' => $this->tagService->findById($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('backend.common.tag.edit', [
            'services' => $this->tagService->findById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TagRequest $tagRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $tagRequest, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
