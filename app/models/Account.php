<?php
    class Account{

        public function __construct(){
  
        }

        public static function ldap($username){ 
            $record  = mysql::select('account', 
                                     '*', 
                                     "username = '{$username}' AND status = 'Active'");
            if(is_array($record) ){
                $result['record']  = recastArray($record);

                $result['status']  = 'success';
                $result['message'] = 'Welcome';
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'Invalid Username or Password. Please try again';
            } 

            return $result;
        }

        public static function logout(){
            mysql::disconnect();
        }

        public static function getAll($start = '', $limit = ''){    
            $startLimit = (trim($start) != "" && trim($limit) != "") ? $start.', '.$limit : '';
            $result = mysql::select('account', 
                                    '*', 
                                    '',
                                    'full_name ASC',
                                    $startLimit);
            return $result;
        }

        public static function getRecordById($id){
            $result = mysql::select('account', 
                                    '*', 
                                    "id = '{$id}'");
            return $result;
        }

        public static function addRecord($post){
            $email      = $post['email'];
            $username   = $post['username'];

            $exist = mysql::select('account', '*', "email = '{$email}' OR username = '{$username}'");
            if(empty($exist)){       
                $fields = mysql::buildFields($post, ', ');
                if(mysql::insert('account', $fields)){
                    $result['status']  = 'success';
                    $result['message'] = 'New record saved';
                }else{
                    $result['status']  = 'failed';
                    $result['message'] = 'Technical error. Please try again';
                }
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'Record already exists';
            }

            return $result;
        }

        public static function editRecord($id, $post){
            $record = self::getRecordById($id);
            if(is_array($record)){

                $email      = $post['email'];
                $username   = $post['username'];

                $exist = mysql::select('account', 'id', "id != '{$id}' AND (email = '{$email}' OR username = '{$username}')");
                if(empty($exist)){
                    $fields = mysql::buildFields($post, ', ');
                    if(mysql::update('account', $fields, "id = '{$id}'")){
                        $result['status']  = 'success';
                        $result['message'] = 'Record successfully updated';
                    }else{
                        $result['status']  = 'failed';
                        $result['message'] = 'Technical error. Please try again';
                    }
                } else {
                    $result['status']  = 'failed';
                    $result['message'] = 'Record already exists';
                }
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'No record found';
            }

            return $result;
        }

        public static function deleteRecord($id){
            if(mysql::delete('account', "id = '{$id}'")){
                $result['status']   = 'success';
                $result['message']  = 'Record successfully deleted';
            }else{
                $result['status']   = 'failed';
                $result['message']  = 'Technical error. Please try again';
            }

            return $result;
        }

        public static function getRole(){
            $result = mysql::select('account_role', '*', '', 'name ASC');
            return $result;
        }

        public static function getRoleById($id){
            $result = mysql::select('account_role', '*', "id = '{$id}'");
            return $result;
        }

        public static function addRole($post){
            $name = $post['name'];

            $exist = mysql::select('account_role', '*', "name = '{$name}'");
            if(empty($exist)){
                $fields = mysql::buildFields($post, ', ');
                if(mysql::insert('account_role', $fields)){
                    $result['status']  = 'success';
                    $result['message'] = 'New record saved';
                }else{
                    $result['status']  = 'failed';
                    $result['message'] = 'Technical error. Please try again';
                }
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'Record already exists';
            }
            return $result;
        }

        public static function editRole($id, $post){
            $record = self::getRoleById($id);
            if(is_array($record)){
                $name = $post['name'];

                $exist = mysql::select('account_role', 'id', "id != '{$id}' AND name = '{$name}'");
                if(empty($exist)){
                    $fields = mysql::buildFields($post, ", ");
                    if(mysql::update('account_role', $fields, "id = '{$id}'")){
                        $result['status']  = 'success';
                        $result['message'] = 'Record successfully updated';
                    }else{
                        $result['status']  = 'failed';
                        $result['message'] = 'Technical error. Please try again';
                    }
                } else {
                    $result['status']  = 'failed';
                    $result['message'] = 'Record already exists';
                }
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'No record found';
            }

            return $result;
        }

        public static function deleteRole($id){  
            if(mysql::delete('account_role', "id = '{$id}'")){
                $result['status']   = 'success';
                $result['message']  = 'Record successfully deleted';
            }else{
                $result['status']   = 'failed';
                $result['message']  = 'No record found'; 
            }
            return $result;
        }

    }
?>