<?php
	class Master{

		public function __construct(){
		
		}

        public static function getMvType(){
            $result  = mysql::select('master_mv_type', '*', '', 'name ASC'); 
            return $result;
        }

        public static function getMvTypeById($id){
            $result = mysql::select('master_mv_type', '*', "id = '{$id}'");
            return $result;
        }

        public static function addMvType($post){
            $name = $post['name'];

            $exist = mysql::select('master_mv_type', '*', "name = '{$name}'");
            if(empty($exist)){
                $fields = mysql::buildFields($post, ', ');
                if(mysql::insert('master_mv_type', $fields)){
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

        public static function editMvType($id, $post){
            $record = self::getMvTypeById($id);
            if(is_array($record)){
                $name = $post['name'];

                $exist = mysql::select('master_mv_type', 'id', "id != '{$id}' AND name = '{$name}'");
                if(empty($exist)){
                    $fields = mysql::buildFields($post, ", ");
                    if(mysql::update('master_mv_type', $fields, "id = '{$id}'")){
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

        public static function deleteMvType($id){
            if(mysql::delete('master_mv_type', "id = '{$id}'")){
                $result['status']   = 'success';
                $result['message']  = 'Record successfully deleted';
            }else{
                $result['status']   = 'failed';
                $result['message']  = 'No record found'; 
            }
            return $result;
        }

        public static function getPremiumType(){
            $result = mysql::select('master_premium_type', '*', '', 'name ASC');
            return $result;
        }

        public static function getPremiumTypeById($id){
            $result = mysql::select('master_premium_type', '*', "id = '{$id}'");
            return $result;
        }

        public static function addPremiumType($post){
            $name = $post['name'];

            $exist = mysql::select('master_premium_type', '*', "name = '{$name}'");
            if(empty($exist)){
                $fields = mysql::buildFields($post, ', ');
                if(mysql::insert('master_premium_type', $fields)){
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

        public static function editPremiumType($id, $post){
            $record = self::getPremiumTypeById($id);
            if(is_array($record)){
                $name = $post['name'];

                $exist = mysql::select('master_premium_type', 'id', "id != '{$id}' AND name = '{$name}'");
                if(empty($exist)){
                    $fields = mysql::buildFields($post, ", ");
                    if(mysql::update('master_premium_type', $fields, "id = '{$id}'")){
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

        public static function deletePremiumType($id){  
            if(mysql::delete('master_premium_type', "id = '{$id}'")){
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