<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();
    }

    /**
     * @param string $user_token
     * @return mixed|null
     */
    public function loggedUserCompanyId(string $user_token)
    {
        $db = Database::connect();
        $result = $db->query("select user_details.company_id from user_details
                        join users on users.id = user_details.user_id
                        where users.user_token = '$user_token' limit 1")->getRowArray();

        return ($result['company_id'] ?? null);
    }

    /**
     * @param string $dataRequested
     * @return false|string
     */
    public function authAccess(string $dataRequested = '')
    {
        $db = Database::connect('readDB');
        $user_token = $this->request->getVar('user_token');
        $query = $db->query(" select users.id, roles.id AS account_type_id from users
            inner join model_has_roles on users.id = model_has_roles.model_id
            inner join roles on model_has_roles.role_id = roles.id where user_token='$user_token' order by roles.id asc");
        $row = $query->getRowArray();
        $account_type_id = $row['account_type_id'];
        $sql = " select * from roles where id='$account_type_id' and (FIND_IN_SET('$dataRequested',access_permissions) || FIND_IN_SET('all',access_permissions))  ";
        $query = $db->query($sql);
        if (count($query->getResultArray()) == 0) {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "Permission denied to access requested data with given user's token";
            return json_encode($json_arr);
        }
        return "success";

    }

    /**
     * @return false|string
     */
    public function validateToken()
    {
        //$db = Database::connect('readDB');
		$db = Database::connect();
        $user_token = $this->request->getVar('user_token');
        $query = $db->query(" select id from users where user_token='$user_token' ");
        if (count($query->getResultArray()) == 0) {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "Invalid token, Re-login";
            return json_encode($json_arr);
        }

        return "success";

    }
}
