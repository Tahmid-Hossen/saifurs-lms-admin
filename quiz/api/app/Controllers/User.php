<?php namespace App\Controllers;

use Config\Database;

class User extends BaseController
{


    public function __construct()
    {

    }


    public function getList()
    {
        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');

        // check required post data
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $loggedUserCompanyId = $this->loggedUserCompanyId($user_token);
        $limit = $this->request->getVar('limit');
        $maxRowsPerPage = $this->request->getVar('maxRowsPerPage');
        $search = $this->request->getVar('search');
        $id = $this->request->getVar('id');
        if ($user_token == null) {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "Token required";
            return json_encode($json_arr);
        }
        if ($limit == null) {
            $limit = 0;
        }
        if ($maxRowsPerPage == null) {
            $maxRowsPerPage = 30;
        }
        if ($search == null) {
            $search = '';
        }
        if ($id == null) {
            $id = '';
        }
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('userList');
        if ($authAccess != "success") {
            return $authAccess;
        }
        if ($search == '') {
            $where = "";
            if ($id != '') {
                $where = " and users.id='" . $id . "' ";
            }
            $sql = "select users.*, sq_group.group_name, roles.name as account_name from users join sq_group on sq_group.id=users.group_ids
                 join model_has_roles on users.id = model_has_roles.model_id join roles on model_has_roles.role_id = roles.id join user_details on user_details.user_id = users.id
                 where (user_details.company_id = '$loggedUserCompanyId' $where ) and users.deleted_at is null  order by users.id asc limit $limit, $maxRowsPerPage";
            $query = $db2->query($sql);
        } else {
            $query = $db2->query("SHOW COLUMNS FROM users ");
            $result = $query->getResultArray();
            $col = array();
            foreach ($result as $k => $r) {
                $col[] = "users." . $r['Field'];
            }
            $cols = implode(',', $col);
            $query = $db2->query("select users.*, sq_group.group_name, roles.name, roles.access_permissions  from users join sq_group on sq_group.id=users.group_ids join roles on roles.id=users.account_type_id  WHERE LOWER(CONCAT($cols)) LIKE LOWER('%$search%') and users.status='0' order by users.id asc  limit $limit, $maxRowsPerPage");
        }
        $result = $query->getResultArray();

        if (count($query->getResultArray()) >= 1) {
            $json_arr['status'] = "success";
            $json_arr['message'] = "";
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "No record found";
        }

        return json_encode($json_arr);
    }


    public function myInfo()
    {
        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');

        // check required post data
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $limit = $this->request->getVar('limit');
        $maxRowsPerPage = $this->request->getVar('maxRowsPerPage');
        $search = $this->request->getVar('search');
        $id = $this->request->getVar('id');
        if ($user_token == null) {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "Token required";
            return json_encode($json_arr);
        }
        if ($limit == null) {
            $limit = 0;
        }
        if ($maxRowsPerPage == null) {
            $maxRowsPerPage = 30;
        }
        if ($search == null) {
            $search = '';
        }
        if ($id == null) {
            $id = '';
        }
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('myAccount');
        if ($authAccess != "success") {
            return $authAccess;
        }
        if ($search == '') {
            $where = "";
            if ($id != '') {
                $where = " and users.id='" . $id . "' ";
            }
            $sql = "select users.*, sq_group.group_name, roles.id AS account_type_id, roles.name, roles.access_permissions from users
                inner join model_has_roles on users.id = model_has_roles.model_id
            inner join roles on model_has_roles.role_id = roles.id
    join sq_group on sq_group.id=users.group_ids
    where users.status='ACTIVE' $where order by users.id asc limit $limit, $maxRowsPerPage";
            $query = $db2->query($sql);
        } else {
            $query = $db2->query("SHOW COLUMNS FROM users ");
            $result = $query->getResultArray();
            $col = array();
            foreach ($result as $k => $r) {
                $col[] = "users." . $r['Field'];
            }
            $cols = implode(',', $col);
            $query = $db2->query("select users.*, sq_group.group_name, roles.name, roles.access_permissions  from users join sq_group on sq_group.id=users.group_ids join roles on roles.id=users.account_type_id  WHERE LOWER(CONCAT($cols)) LIKE LOWER('%$search%') and users.status='0' order by users.id asc  limit $limit, $maxRowsPerPage");
        }
        $result = $query->getResultArray();

        if (count($query->getResultArray()) >= 1) {
            $json_arr['status'] = "success";
            $json_arr['message'] = "";
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "No record found";
        }

        return json_encode($json_arr);
    }

    public function add()
    {

        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $userdata = array();
        $username = $this->request->getVar('username');
        $userdata['username'] = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $userdata['email'] = $this->request->getVar('email');
        $userdata['full_name'] = $this->request->getVar('full_name');
        $userdata['group_ids'] = $this->request->getVar('group_ids');
        $userdata['account_type_id'] = $this->request->getVar('account_type_id');
        $userdata['password'] = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);


        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('userAdd');
        if ($authAccess != "success") {
            return $authAccess;
        }
        $query = $db2->query("select id from users where status='ACTIVE' and ( username='$username' || email='$email' )  ");
        $result = $query->getResultArray();
        if (count($query->getResultArray()) >= 1) {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "Account already exist with given username or email id";

        } else {
            if ($db1->table('users')->insert($userdata)) {

                $id = $db1->insertID();
                $json_arr['status'] = "success";
                $json_arr['id'] = $id;
                $json_arr['message'] = "user added successfully";
                return json_encode($json_arr);
            } else {
                $msg = $db1->error();
                $json_arr['status'] = "failed";
                $json_arr['message'] = $msg;
                return json_encode($json_arr);
            }
        }

        return json_encode($json_arr);

    }


    public function edit()
    {

        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $userdata = array();
        $username = $this->request->getVar('username');
        $userdata['username'] = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $id = $this->request->getVar('id');
        $userdata['email'] = $this->request->getVar('email');
        $userdata['full_name'] = $this->request->getVar('full_name');
        $userdata['group_ids'] = $this->request->getVar('group_ids');
        $userdata['account_type_id'] = $this->request->getVar('account_type_id');
        $password = $this->request->getVar('password');
        if ($password != null) {
            if ($password != "") {
                $userdata['password'] = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
            }
        }

        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('userEdit');
        if ($authAccess != "success") {
            return $authAccess;
        }
        $query = $db2->query("select id from users where status='ACTIVE' and ( username='$username' || email='$email' ) and id !='$id'  ");
        $result = $query->getResultArray();
        if (count($query->getResultArray()) >= 1) {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "Account already exist with given username or email id";

        } else {
            $builder = $db1->table('users');
            $builder->where('id', $id);
            $builder->update($userdata);
            $json_arr['status'] = "success";
            $json_arr['id'] = $id;
            $json_arr['message'] = "user updated successfully";
            return json_encode($json_arr);

        }

        return json_encode($json_arr);

    }

    public function remove()
    {

        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $id = $this->request->getVar('id');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('userRemove');
        if ($authAccess != "success") {
            return $authAccess;
        }
        if ($id == null) {
            $id = '';
        }
        // protect admin user to remove
        if ($id == "1") {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "You can not remove admin user";

        } else {
            $where = "";
            if ($id != '') {
                $where = " and users.id='" . $id . "' ";
            }
            $sql = " update users set trash_status='1' where users.status='0' $where ";
            $query = $db1->query($sql);
            $json_arr['status'] = "success";
            $json_arr['message'] = "User removed successfully";
        }
        return json_encode($json_arr);


    }

    public function updateMyAccount()
    {


        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $userdata = array();
        $email = $this->request->getVar('email');
        $id = $this->request->getVar('id');
        $userdata['email'] = $this->request->getVar('email');
        $userdata['full_name'] = $this->request->getVar('full_name');
        $password = $this->request->getVar('password');
        if ($password != null) {
            if ($password != "") {
                $userdata['password'] = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);
            }
        }

        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('myAccount');
        if ($authAccess != "success") {
            return $authAccess;
        }
        $query = $db2->query("select id from users where status='ACTIVE' and ( email='$email' ) and id !='$id'  ");
        $result = $query->getResultArray();
        if (count($query->getResultArray()) >= 1) {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "Account already exist with given  email id";

        } else {
            $builder = $db1->table('users');
            $builder->where('user_token', $user_token);
            $builder->update($userdata);
            $json_arr['status'] = "success";
            $json_arr['id'] = $id;
            $json_arr['message'] = "Info updated successfully";
            return json_encode($json_arr);

        }

        return json_encode($json_arr);


    }


    public function removeMultiple()
    {

        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $id = $this->request->getVar('id');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('userRemove');
        if ($authAccess != "success") {
            return $authAccess;
        }
        if ($id == null) {
            $id = '';
        }
        $ids = explode(",", $id);
        $notRemoved = 0;
        $removed = 0;
        foreach ($ids as $k => $idi) {
            // protect admin user to remove
            if ($idi != "1") {
                $where = "";
                if ($idi != '') {
                    $where = " and users.id='" . $idi . "' ";
                }

                $sql = " update users set trash_status='1' where users.status='0' $where ";
                $query = $db1->query($sql);
                $removed += 1;
            } else {
                $notRemoved += 1;
            }
        }
        $json_arr['status'] = "success";
        $json_arr['message'] = "User removed successfully: " . $removed . ". <br>Unable to removed users: " . $notRemoved . " ";

        return json_encode($json_arr);


    }


    public function getGroupList()
    {
        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        // check required post data
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('groupList');
        if ($authAccess != "success") {
            return $authAccess;
        }
        $id = $this->request->getVar('id');
        if ($id == null) {
            $id = '';
        }
        $where = "";
        if ($id != '') {
            $where = " and sq_group.id='" . $id . "' ";
        }
        $query = $db2->query("select * from sq_group where trash_status='0'  " . $where . " order by id asc ");
        $result = $query->getResultArray();
        if (count($query->getResultArray()) >= 1) {
            $json_arr['status'] = "success";
            $json_arr['message'] = "";
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "No record found";
        }

        return json_encode($json_arr);
    }


    public function getAccountTypeList()
    {
        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        // check required post data
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('groupList');
        if ($authAccess != "success") {
            return $authAccess;
        }
        $query = $db2->query("select * from roles  order by id asc ");
        $result = $query->getResultArray();
        if (count($query->getResultArray()) >= 1) {
            $json_arr['status'] = "success";
            $json_arr['message'] = "";
            $json_arr['data'] = $result;
        } else {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "No record found";
        }

        return json_encode($json_arr);
    }


    public function removeGroup()
    {

        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $id = $this->request->getVar('id');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('groupRemove');
        if ($authAccess != "success") {
            return $authAccess;
        }
        if ($id == null) {
            $id = '';
        }
        // protect admin user to remove
        if ($id == "1") {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "You can not remove default group";

        } else {
            $query = $db2->query("select id from users where status='ACTIVE' and group_ids ='$id'  ");

            if (count($query->getResultArray()) == 0) {
                $where = "";
                if ($id != '') {
                    $where = " and sq_group.id='" . $id . "' ";
                }
                $sql = " update sq_group set trash_status='1' where sq_group.trash_status='0' $where ";
                $query = $db1->query($sql);
                $json_arr['status'] = "success";
                $json_arr['message'] = "Group removed successfully";
            } else {
                $json_arr['status'] = "failed";
                $json_arr['message'] = "Unable to remove group! <br>There are some users assigned to this group. Remove or move that users to another group.";
            }
        }
        return json_encode($json_arr);


    }


    public function addGroup()
    {

        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $userdata = array();
        $userdata['group_name'] = $this->request->getVar('group_name');


        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('groupAdd');
        if ($authAccess != "success") {
            return $authAccess;
        }

        if ($db1->table('sq_group')->insert($userdata)) {

            $id = $db1->insertID();
            $json_arr['status'] = "success";
            $json_arr['id'] = $id;
            $json_arr['message'] = "Group added successfully";
            return json_encode($json_arr);
        } else {
            $msg = $db1->error();
            $json_arr['status'] = "failed";
            $json_arr['message'] = $msg;
            return json_encode($json_arr);
        }


        return json_encode($json_arr);

    }

    public function editGroup()
    {

        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $id = $this->request->getVar('id');
        $user_token = $this->request->getVar('user_token');
        $userdata = array();
        $userdata['group_name'] = $this->request->getVar('group_name');

        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('groupEdit');
        if ($authAccess != "success") {
            return $authAccess;
        }

        $builder = $db1->table('sq_group');
        $builder->where('id', $id);
        $builder->update($userdata);
        $json_arr['status'] = "success";
        $json_arr['id'] = $id;
        $json_arr['message'] = "Group updated successfully";
        return json_encode($json_arr);


        return json_encode($json_arr);

    }

    public function removeAccountType()
    {

        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $id = $this->request->getVar('id');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('accountTypeRemove');
        if ($authAccess != "success") {
            return $authAccess;
        }
        if ($id == null) {
            $id = '';
        }
        // protect admin user to remove
        if ($id == "1") {
            $json_arr['status'] = "failed";
            $json_arr['message'] = "You can not remove default account type";

        } else {
            $where = "";
            if ($id != '') {
                $where = " and roles.id='" . $id . "' ";
            }
            $sql = "delete from roles $where ";
            $query = $db1->query($sql);
            $json_arr['status'] = "success";
            $json_arr['message'] = "Account removed successfully";
        }
        return json_encode($json_arr);


    }


    public function dashboardStat()
    {
        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
		
		//$db2 = Database::connect();
        // check required post data
		dd($this->request->getVar('id'));
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
		//echo 'token '.$user_token;
		//die;
        $loggedUserCompanyId = $this->loggedUserCompanyId($user_token);
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('dashboardStat');
        if ($authAccess != "success") {
            return $authAccess;
        }
        $userData = array();
        $query = $db2->query("select count(users.id) as nor from users
            inner join user_details on user_details.user_id = users.id
where (user_details.company_id = $loggedUserCompanyId) and users.deleted_at is null ");
        $user = $query->getRowArray();
        $userData['user'] = $user['nor'];
		
        $query = $db2->query("select count(id) as nor from sq_question where trash_status='0' ");
        $question = $query->getRowArray();
        $userData['question'] = $question['nor'];

        $query = $db2->query("select count(id) as nor from sq_quiz where trash_status='0' ");
        $quiz = $query->getRowArray();
        $userData['quiz'] = $quiz['nor'];

        $query = $db2->query("select count(id) as nor from sq_result where trash_status='0' ");
        $result = $query->getRowArray();
        $userData['result'] = $result['nor'];

        $json_arr['status'] = "success";
        $json_arr['data'] = $userData;


        return json_encode($json_arr);

    }

    public function setting()
    {
        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        // check required post data
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('setting');
        if ($authAccess != "success") {
            return $authAccess;
        }
        $userData = array();
        $query = $db2->query("select * from sq_setting order by order_by asc ");
        $setting = $query->getResultArray();


        $json_arr['status'] = "success";
        $json_arr['data'] = $setting;


        return json_encode($json_arr);

    }

    public function updateSetting()
    {
        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        // check required post data
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $authAccess = $this->authAccess('updateSetting');
        if ($authAccess != "success") {
            return $authAccess;
        }

        $fData = json_decode($this->request->getVar('fData'));
        if (isset($fData[0])) {
            $fData = $this->makeRequiredArrayFormat($fData);
        }
        foreach ($fData as $k => $val) {
            $sql = " update sq_setting set setting_value='$val' where setting_name='$k' ";
            $query = $db1->query($sql);
        }
        $json_arr['status'] = "success";
        $json_arr['message'] = "Settings updated";


        return json_encode($json_arr);
    }

    public function makeRequiredArrayFormat($arr)
    {

        $narr = array();
        foreach ($arr as $k => $val) {

            if (isset($narr[$val->name])) {
                if (is_array($narr[$val->name])) {
                    $narr[$val->name][] = $val->value;
                } else {
                    $narr[$val->name] = array($narr[$val->name], $val->value);
                }
            } else {
                $narr[$val->name] = $val->value;
            }

        }
        return $narr;
    }

    public function clearToken()
    {
        $db1 = Database::connect('writeDB');
        $db2 = Database::connect('readDB');
        // check required post data
        $json_arr = array();
        $user_token = $this->request->getVar('user_token');
        $validateToken = $this->validateToken();
        if ($validateToken != "success") {
            return $validateToken;
        }
        $user_token_new = "logout-" . time();
        $sql = " update users set user_token='$user_token_new' where users.user_token='$user_token' ";
        $query = $db1->query($sql);

        $json_arr['status'] = "success";
        $json_arr['data'] = "Account logged out";


        return json_encode($json_arr);
    }
}
