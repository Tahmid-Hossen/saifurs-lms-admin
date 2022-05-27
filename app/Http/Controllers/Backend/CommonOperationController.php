<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommonOperationController extends Controller
{
    public function delete(Request $request)
    {
        return view('backend.layouts.common-delete', compact('request'));
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $model_path = $request->get('m');
            $primary_id = $request->get('i');
            $update_field = $request->get('f');
            $update_value = $request->get('v');

            if ($model = $model_path::find($primary_id)) {
                $model->$update_field = $update_value;
                if ($model->save()) {
                    return response(['status' => 'success'], 200);
                }
                return response(['status' => 'failed'], 422);
            }
            return response(['status' => 'not-found'], 404);
        }
        return response(['status' => 'denied'], 403);
    }
}
