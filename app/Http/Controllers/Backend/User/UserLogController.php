<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Services\Backend\User\UserLogService;
use App\Services\UtilityService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserLogController extends Controller
{
    /**
     * @var UserLogService
     */
    private $userLogService;

    /**
     * UserLogController constructor.
     * @param UserLogService $userLogService
     */
    public function __construct(
        UserLogService $userLogService
    )
    {

        $this->userLogService = $userLogService;
    }


    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
//        dd($request->all());
        $request['create_start_date'] = !empty($request['create_start_date']) ? $request['create_start_date'] . ' 00:00:01' : '';
        $request['create_end_date'] = !empty($request['create_end_date']) ? $request['create_end_date'] . ' 23:59:59' : '';
        $userLogs = $this->userLogService->userLogs($request->all())->paginate(UtilityService::$displayRecordPerPage);
//        dd($userLogs);
        return View('backend.user.user-log.index', compact('userLogs', 'request'));
    }
}
