<?php
    class Api{

        public function __construct(){
  
        }
		
		 public static function getCocaf(){ 
            $record  = mysql::select('request', 
                                     'id ,coc_no', 
                                     "app='GINSURE'","id desc");
           
            return $record;
        }

        /*public static function getCocSeriesDetails(){
            $result = mysql::select('ctpl_coc_series', '*', '', 'id ASC');
            return $result;
        }*/

        /*public static function updateCocSeriesDetails($id, $post){
            $record = mysql::select('ctpl_coc_series', 'id', "id = '{$id}'");
            if(is_array($record)){   
                $fields = mysql::buildFields($post, ', ');
                if(mysql::update('ctpl_coc_series', $fields, "id = '{$id}'")){
                    $result['status']  = 'success';
                    $result['message'] = 'Record Successfully Updated';
                }else{
                    $result['status']  = 'failed';
                    $result['message'] = 'Technical error. Please try again';
                }
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'No Record Found';
            }

            return $result;
        }*/
		public static function addLog($post){
            $fields = mysql::buildFields($post, ', ');
            if(mysql::insert('postlog', $fields)){
                $result['id']      = mysql::insertedId();
                $result['status']  = 'success';
                $result['message'] = 'New record saved';
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'Technical error. Please try again';
            }

            return $result;
        }

        public static function addRequest($post){
            $fields = mysql::buildFields($post, ', ');
            if(mysql::insert('request', $fields)){
                $result['id']      = mysql::insertedId();
                $result['status']  = 'success';
                $result['message'] = 'New record saved';
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'Technical error. Please try again';
            }

            return $result;
        }

        public static function addResponse($post){
            $fields = mysql::buildFields($post, ', ');
            if(mysql::insert('response', $fields)){
                $result['status']  = 'success';
                $result['message'] = 'New record saved';
            }else{
                $result['status']  = 'failed';
                $result['message'] = 'Technical error. Please try again';
            }

            return $result;
        }

    }
?>