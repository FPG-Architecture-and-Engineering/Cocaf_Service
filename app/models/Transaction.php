<?php
    class Transaction{

        public function __construct(){
        
        }

        public static function getAllTransactionCount($where = ''){
            $result = mysql::select('request', 
                                    'COUNT(id) AS all_rows',
                                    $where);
            return $result;
        }

        public static function getAllTransactionSearchFilter($where = ''){
            $result = mysql::select('request req
                                     LEFT JOIN response res
                                     ON req.id = res.request_id', 
                                    'COUNT(req.id) AS all_rows',
                                    $where);
            return $result;
        }

        public static function getAllTransactionServerSideWithFilter($where = '', $orderby = '', $limit = ''){
            $result = mysql::select('request req
                                     LEFT JOIN response res
                                     ON req.id = res.request_id', 
                                    'req.*,
                                     res.code,
                                     res.message,
                                     res.status,
                                     res.success_message,
                                     res.error_message',
                                    $where,
                                    $orderby,
                                    $limit);
            return $result;
        }

        public static function getTransactionRequestById($id){
            $result = mysql::select('request', '*', "id = '{$id}'");
            return $result;
        }

        public static function getTransactionResponseByRequestId($request_id){
            $result = mysql::select('response', '*', "request_id = '{$request_id}'");
            return $result;
        }

    }
?>