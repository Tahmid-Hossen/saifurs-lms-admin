<?php


namespace App\Http\View\Composers;


use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Support\Configs\Constants;
use Illuminate\View\View;

class CompanyComposer
{
    protected $companyService;
    private $userService;

    /**
     * @param CompanyService $companyService
     * @param UserService $userService
     */
    public function __construct(CompanyService $companyService, UserService $userService)
    {
        // Dependencies are automatically resolved by the service container...
        $this->companyService = $companyService;
        $this->userService = $userService;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $auth_user = auth()->user();
        if (!empty($auth_user)) {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,['company_status' => Constants::$user_active_status]);
            $view->with('global_companies', $this->companyService->getCompanyDropDown($requestData));
        } else {
            $view->with('global_companies', []);
        }
    }
}
