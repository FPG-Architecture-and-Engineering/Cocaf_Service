<?php
    class AccountController{

        public function __construct() {

        }

        public function login(){

            checkLoggedIn('false');

            $data = array();

            if(isset($_POST['submit'])){ 
                
                $field['username'] = htmlEncode($_POST['username']);
                $field['password'] = htmlEncode($_POST['password']);       

                $data = checkRequiredPost(array('username', 'password'));
                if(!array_key_exists('error', $data)){   

                    $adServer = "ad.fpgins.com";
                    $ldapconn = ldap_connect($adServer) or die("Could not connect to LDAP server.");
                    $username = $field['username'];
                    $password = $field['password'];
                    $ldapuser = 'fpgins\\'.$username;
                    $ldaptree = "DC=ad,DC=fpgins,DC=com";
                    $filter   = "(samaccountname=$username)";
                    $find     = array("sn", "givenname", "samaccountname", "mail", "title");

                    if($ldapconn){

                        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

                        $ldapbind = @ldap_bind($ldapconn, $ldapuser, $password);// or die ("Error trying to bind: ".ldap_error($ldapconn));

                        if($ldapbind){

                            $result = ldap_search($ldapconn, $ldaptree, $filter, $find) or die ("Error in search query: ".ldap_error($ldapconn));
                                      ldap_sort($ldapconn, $result, "sn");
                            $data   = ldap_get_entries($ldapconn, $result);
                            
                            unset($field['password']);
                            $return = Account::ldap($field['username']);
                            if($return['status'] == 'success'){
                                //session_regenerate_id(TRUE); 

                                $_SESSION['login_session']      = $return['record']['id'].date('YmdHis');
                                $_SESSION['login_account_id']   = $return['record']['id'];

                                ldap_close($ldapconn);
                                header('location: /');  
                            }else{
                                promptMessage('message', $return['message'], 'danger');
                            } 

                            //ldap_close($ldapconn);
                            //header('location: /');  
                        }else{
                            ldap_close($ldapconn);
                            promptMessage('message', 'Username or Password is incorrect. Please try again or Please contact Service Desk for reset password.', 'danger');
                        }
                    }else{
                        ldap_close($ldapconn);
                        promptMessage('message', 'Cannot connect to server. Please check whether the Network or Active directory is available', 'danger');
                    }

                    //ldap_close($ldapconn);
                }
                
            } 

            views('account.login', $data);

        }

        public function logout(){

            checkLoggedIn('true');

            Account::logout();

            views('account.logout');

        }

        public function user(){

            checkLoggedIn('true');

            $data = array();

            $data['user']       = Account::getAll();
            $data['role']       = Account::getRole();
            $data['role_list']  = '';

            if (!empty($data['role'])) {
                $ctr_role = 1;
                $arr_list_role = array();
                foreach($data['role'] as $key_list_role => $value_list_role){
                    if(!in_array($value_list_role['id'], $arr_list_role)){ 

                        if($ctr_role < count($data['role'])){
                            $connector = '+';
                        }else{
                            $connector = '';
                        }

                        $data['role_list'] .= $value_list_role['id'].'_'.$value_list_role['name'].$connector;

                        array_push($arr_list_role, $value_list_role['id']);
                    }

                    $ctr_role++;
                } 
            }

            views('account.user', $data);

        }

        public function user_json(){

            checkLoggedIn('true');
            
            if (isset($_POST) && !empty($_POST)) {

                $result = array();

                $id = htmlEncode($_POST['id']);

                $array_display = array('edit', 'view');

                if (!empty($_POST['id']) && isset($_POST['action']) && in_array($_POST['action'], $array_display)) {

                    $record = Account::getRecordById($id);
                    if (is_array($record)) {    
                        foreach ($record as $key => $value) {
                            $result['id']           = htmlDecode($value['id']);
                            $result['role_id']      = htmlDecode($value['role_id']);
                            $result['first_name']   = htmlDecode($value['first_name']);
                            $result['middle_name']  = htmlDecode($value['middle_name']);
                            $result['last_name']    = htmlDecode($value['last_name']);
                            $result['username']     = htmlDecode($value['username']);
                            $result['email']        = htmlDecode($value['email']);
                            $result['mobile_no']    = htmlDecode($value['mobile_no']);
                            $result['local_no']     = htmlDecode($value['local_no']);
                        }
                    }

                } elseif (!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {

                    $result = Account::deleteRecord($id);
                    
                } else {

                    $field['first_name']    = htmlEncode($_POST['first_name']);
                    $field['middle_name']   = htmlEncode($_POST['middle_name']);
                    $field['last_name']     = htmlEncode($_POST['last_name']);
                    $field['full_name']     = htmlEncode($_POST['first_name']).' '.htmlEncode($_POST['middle_name']).' '.htmlEncode($_POST['last_name']);

                    $field['username']      = htmlEncode($_POST['username']);
                    $field['email']         = htmlEncode($_POST['email']);
                    $field['mobile_no']     = htmlEncode($_POST['mobile_no']);
                    $field['local_no']      = htmlEncode($_POST['local_no']);

                    if (isset($_POST['role_id'])) {
                        $list_role = $_POST['role_id'];
                        $ctr_role  = 1;
                        foreach($list_role as $item_role){
                            if($ctr_role == 1){
                                $role_id  = $item_role;
                            }else{
                                $role_id .= htmlEncode('-'.$item_role);
                            }
                            $ctr_role++;
                        }
                    } else {
                        $role_id = '';
                    }
                    $field['role_id'] = $role_id;

                    $data = checkRequiredPost(array('username', 'email'));
                    if (!array_key_exists('error', $data)) {
                        if (!empty($id)) {
                            $field['updated_by']    = ACCOUNT_ID;
                            $field['updated_when']  = saveDateTime();

                            $result = Account::editRecord($id, $field);
                        } else {
                            $field['created_by']    = ACCOUNT_ID;
                            $field['created_when']  = saveDateTime();

                            $result = Account::addRecord($field);
                        }
                    }

                }
                
            } else {

                $result['status']   = 'forbidden';
                $result['message']  = 'Access to this resource on the server is denied';

            }
            
            header('Content-Type: application/json');
            echo json_encode($result);

        }

        public function delete_json(){

            checkLoggedIn('true');

            if (isset($_POST) && !empty($_POST) && isset($_POST['id']) && !empty($_POST['id'])) {

                $record = Account::profile(htmlEncode($_POST['id']));
                if (is_array($record)) {

                    $result = Account::deleteRecord(htmlEncode($_POST['id']));
                    if (!empty($record[0]['photo'])) {
                        unlink(uploadFile('account', $record[0]['photo']));
                    }

                } else {

                    $result['status']   = 'failed';
                    $result['message']  = 'No Record Found';

                }

            } else {

                $result['status']   = 'forbidden';
                $result['message']  = 'Access to this resource on the server is denied';

            }

            header('Content-Type: application/json');
            echo json_encode($result);

        }

        public function role(){

            checkLoggedIn('true');

            $data = array();

            $data = Account::getRole();

            views('account.role', $data);  
        }

        public function role_json(){

            checkLoggedIn('true');

            if (isset($_POST) && !empty($_POST)) {

                if (!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'edit') {

                    $record = Account::getRoleById(htmlEncode($_POST['id']));
                    if (is_array($record)) {    
                        foreach($record as $key => $value){
                            $result['id']   = htmlDecode($value['id']);
                            $result['name'] = htmlDecode($value['name']);
                        }
                    }

                } elseif(!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {

                    $result = Account::deleteRole(htmlEncode($_POST['id']));
                    
                } else {

                    $field['id']    = htmlEncode($_POST['id']);
                    $field['name']  = htmlEncode($_POST['name']);

                    $data = checkRequiredPost(array('name'));
                    if (!array_key_exists('error', $data)) {  
                        if (!empty($_POST['id'])) {
                            $field['updated_by']    = ACCOUNT_ID;
                            $field['updated_when']  = saveDateTime();

                            $result = Account::editRole($field['id'], $field);
                        } else {
                            unset($field['id']);
                            $field['created_by']    = ACCOUNT_ID;
                            $field['created_when']  = saveDateTime();

                            $result = Account::addRole($field);
                        }
                    }

                }
                
            } else {

                $result['status']   = 'forbidden';
                $result['message']  = 'Access to this resource on the server is denied';

            }
            
            header('Content-Type: application/json');
            echo json_encode($result);

        }

        public function profile(){

            checkLoggedIn('true');

            $data = array();

            $data['profile']    = recastArray(Account::getRecordById(ACCOUNT_ID));
            $data['role']       = Account::getRole();

            if (isset($_POST['submit'])) {
                $field['mobile_no']    = htmlEncode($_POST['mobile_no']);
                $field['local_no']     = htmlEncode($_POST['local_no']);
                $field['updated_when'] = saveDateTime();

                if (!empty($_FILES['file_1']['name'])) {

                    $file           = $_FILES['file_1'];
                    $file_name      = $_FILES['file_1']['name'];
                    $file_size      = $_FILES['file_1']['size'];
                    $file_tmp       = $_FILES['file_1']['tmp_name'];
                    $file_type      = $_FILES['file_1']['type'];   
                    $file_ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $file_new_name  = ACCOUNT_ID.'_'.dateTimeAsId().'.'.$file_ext; 
                    $extensions     = array('jpg', 'jpeg', 'png');
         
                    if (!in_array($file_ext, $extensions)) {
                        $data['error']['file_1'] = requiredPrompt('File format is not allow');
                    } else {
                        if (move_uploaded_file($file_tmp, uploadFile('account', $file_new_name))) {
                            if (!empty($_POST['file_1_hidden'])) {
                                unlink(uploadFile('account', $_POST['file_1_hidden']));
                            }
                            $field['photo']        = $file_new_name;  
                            $data['user']['photo'] = $file_new_name;
                        } else {
                            promptMessage('message', 'Technical error. Please try again', 'failed');
                        }
                    }

                } else {

                    if (isset($_POST['file_1_delete'])) {
                        $field['photo'] = '';  
                        unlink(uploadFile('account', $_POST['file_1_hidden']));
                    } else {
                        $data['user']['photo'] = htmlEncode($_POST['file_1_hidden']);
                    }

                }

                if (!array_key_exists('error', $data)) {
                    $return = Account::editRecord(ACCOUNT_ID, $field); 
                    alertAndRedirect($return['message'], '/account/profile/');
                }

            }

            views('account.profile', $data);

        }

    }
?>