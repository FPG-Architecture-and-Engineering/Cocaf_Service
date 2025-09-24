<?php
    class System{

        public function __construct(){
  
        }

        public static function getConfiguration(){
            $result = mysql::select('configuration', '*', '', 'id ASC');
            return $result;
        }

        public static function getConfigurationById($id){
            $result = mysql::select('configuration', '*', "id = '{$id}'");
            return $result;
        }

        public static function getConfigurationByApp($app){
            $result = mysql::select('configuration', '*', "app = '{$app}'");
            return $result;
        }

        public static function addConfiguration($post){
            $app = $post['app'];

            $exist = self::getConfigurationByApp($app);
            if(empty($exist)){       
                $fields = mysql::buildFields($post, ', ');
                if(mysql::insert('configuration', $fields)){
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

        public static function editConfiguration($id, $post){
            $record = self::getConfigurationById($id);
            if(is_array($record)){
                $app = $post['app'];

                $exist = mysql::select('configuration', 'id', "id != '{$id}' AND app = '{$app}'");
                if(empty($exist)){
                    $fields = mysql::buildFields($post, ', ');
                    if(mysql::update('configuration', $fields, "id = '{$id}'")){
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

        public static function deleteConfiguration($id){  
            if(mysql::delete('configuration', "id = '{$id}'")){
                $result['status']   = 'success';
                $result['message']  = 'Record successfully deleted';
            }else{
                $result['status']   = 'failed';
                $result['message']  = 'No record found'; 
            }
            return $result;
        }

        public static function getAllAccountByAccountId($account_id){
            $result = mysql::select('account', 'first_name, last_name, email', "id IN ({$account_id})", 'id ASC');
            return $result;
        }

        public static function getEmailNotification(){
            $result = mysql::select('email_notification', '*', '', 'id ASC');
            return $result;
        }

        public static function getEmailNotificationById($id){
            $result = mysql::select('email_notification', '*', "id = '{$id}'");
            return $result;
        }

        public static function getEmailNotificationByApp($app){
            $result = mysql::select('email_notification', '*', "app = '{$app}'");
            return $result;
        }

        public static function addEmailNotification($post){
            $app = $post['app'];

            $exist = self::getEmailNotificationByApp($app);
            if(empty($exist)){       
                $fields = mysql::buildFields($post, ', ');
                if(mysql::insert('email_notification', $fields)){
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

        public static function editEmailNotification($id, $post){
            $record = self::getEmailNotificationById($id);
            if(is_array($record)){
                $app = $post['app'];

                $exist = mysql::select('email_notification', 'id', "id != '{$id}' AND app = '{$app}'");
                if(empty($exist)){
                    $fields = mysql::buildFields($post, ', ');
                    if(mysql::update('email_notification', $fields, "id = '{$id}'")){
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

        public static function deleteEmailNotification($id){  
            if(mysql::delete('email_notification', "id = '{$id}'")){
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