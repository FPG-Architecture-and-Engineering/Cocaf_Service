<?php
    class SystemController{

        public function __construct() {

            checkLoggedIn('true');

            if (!accessGranted(['1'])) {
                header('Location: /page-not-found/');
            }

        }
        
        public function configuration(){

            $data = array();

            $data = System::getConfiguration();

            views('system.configuration', $data);

        }

        public function configuration_json(){

            if (isset($_POST) && !empty($_POST)) {

                if (!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'edit') {

                    $record = System::getConfigurationById(htmlEncode($_POST['id']));
                    if (is_array($record)) {    
                        foreach($record as $key => $value){
                            $result['id']       = htmlDecode($value['id']);
                            $result['app']      = htmlDecode($value['app']);
                            $result['username'] = htmlDecode($value['username']);
                            $result['password'] = htmlDecode($value['password']);
                        }
                    }

                } elseif(!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {

                    $result = System::deleteConfiguration(htmlEncode($_POST['id']));
                    
                } else {

                    $field['id']        = htmlEncode($_POST['id']);
                    $field['app']       = htmlEncode($_POST['app']);
                    $field['username']  = htmlEncode($_POST['username']);
                    $field['password']  = htmlEncode($_POST['password']);

                    $data = checkRequiredPost(array('app', 'username', 'password'));
                    if (!array_key_exists('error', $data)) {  
                        if (!empty($_POST['id'])) {
                            $field['updated_by']    = ACCOUNT_ID;
                            $field['updated_when']  = saveDateTime();

                            $result = System::editConfiguration($field['id'], $field);
                        } else {
                            unset($field['id']);
                            $field['created_by']    = ACCOUNT_ID;
                            $field['created_when']  = saveDateTime();

                            $result = System::addConfiguration($field);
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

        public function emailNotification(){

            $data = array();

            includeModel(['Account']);

            $data['email']  = System::getEmailNotification();
            $data['user']   = Account::getAll();
            $data['app']    = System::getConfiguration();

            if (!empty($data['email'])) {
                foreach ($data['email'] as $key => $value) {

                    $account_id = "'".str_replace("-", "', '", $value['account_id'])."'";
                    $account = System::getAllAccountByAccountId($account_id);

                    $account_list = '';
                    if (!empty($account)) {
                        foreach ($account as $key_account => $value_account) {
                            $account_list .= '<i class="fa fa-caret-right"></i> '.htmlDecode($value_account['first_name']).' '.htmlDecode($value_account['last_name']).'<br>';
                        }
                    }

                    $data['email'][$key]['users'] = $account_list;

                }
            }

            views('system.email-notification', $data);

        }

        public function emailNotification_json(){

            if (isset($_POST) && !empty($_POST)) {

                if (!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'edit') {

                    $record = System::getEmailNotificationById(htmlEncode($_POST['id']));
                    if (is_array($record)) {    
                        foreach($record as $key => $value){
                            $result['id']           = htmlDecode($value['id']);
                            $result['app']          = htmlDecode($value['app']);
                            $result['account_id']   = htmlDecode($value['account_id']);
                        }
                    }

                } elseif(!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {

                    $result = System::deleteEmailNotification(htmlEncode($_POST['id']));
                    
                } else {

                    $field['id']            = htmlEncode($_POST['id']);
                    $field['app']           = htmlEncode($_POST['app']);
                    $field['account_id']    = implode('-', $_POST['account_id']);

                    $data = checkRequiredPost(array('app'));
                    if (!array_key_exists('error', $data)) {  
                        if (!empty($_POST['id'])) {
                            $field['updated_by']    = ACCOUNT_ID;
                            $field['updated_when']  = saveDateTime();

                            $result = System::editEmailNotification($field['id'], $field);
                        } else {
                            unset($field['id']);
                            $field['created_by']    = ACCOUNT_ID;
                            $field['created_when']  = saveDateTime();

                            $result = System::addEmailNotification($field);
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

    }
?>