<?php
    class Report{

        public function __construct(){

        }

        public static function getAllApp(){
            $result = mysql::select('request GROUP BY app',
                                    'app');    
            return $result;
        }

        public static function getAllTransaction($where){
            $result = mysql::select('request req
                                     LEFT JOIN response res
                                     ON req.id = res.request_id', 
                                    'req.*,
                                     res.status,
                                     res.auth_date,
                                     res.auth_no,
                                     res.auth_type,
                                     res.chassis_no AS res_chassis_no,
                                     res.coc_no AS res_coc_no,
                                     res.engine_no AS res_engine_no,
                                     res.expiry_date AS res_expiry_date,
                                     res.inception_date AS res_inception_date,
                                     res.lto_verification_code,
                                     res.mv_file_no AS res_mv_file_no,
                                     res.mv_type AS res_mv_type,
                                     res.org_id,
                                     res.plate_no AS res_plate_no,
                                     res.premium_type,
                                     res.reg_type AS res_reg_type,
                                     res.coc_status,
                                     res.tax_type AS res_tax_type,
                                     res.username,
                                     res.vehicle_type,
                                     res.year,
                                     res.success_message,
                                     res.error_message',
                                    $where,
                                    'req.id');
            return $result;
        }

    }
?>