<?php
    class Uat{

        public function __construct(){
  
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
		
		public static function getCocById($id){
            $result = mysql::select_uat('request', '*', 'transaction_id="'.$id.'"', 'id DESC');
            return $result;
        }

        public static function addRequest($post){
            $fields = mysql::buildFields($post, ', ');
            if(mysql::insert_uat('request', $fields)){
                $result['id']      = mysql::insertedId_uat();
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
            if(mysql::insert_uat('response', $fields)){
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