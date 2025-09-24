<?php
    class Configuration{

        public function __construct(){

        }

        public static function general(){
            $value = array();

            $value['SYSTEM_NAME']                       = 'COCAF CMS';
            $value['SYSTEM_ALIAS']                      = 'COCAF CMS';
            $value['SYSTEM_VERSION']                    = '1.0';
            $value['PAGINATION']                        = 10;

            $value['MAIL_HOST']                         = '10.52.254.55';
            $value['MAIL_PORT']                         = 25;

            $value['COCAF_API_COMPANY_ID']              = '033';

            $value['COCAF_API_URL']                     = 'https://www.isapcocas.ph/isapdev2_api/services/';
            $value['COCAF_USERNAME']                    = 'FPGWEBSITE';
            $value['COCAF_PASSWORD']                    = 'debL@g1Nw3v';
            $value['COCAF_USERNAME1']                    = 'FPACCEB';
            $value['COCAF_PASSWORD1']                    = 'G12@c3SaNd13LEsS!nGS';
			
            $value['COCAF_API_URL_UAT']                 = 'https://cocaftest.isapcocas.ph/isapdev2_api/services/';
            $value['COCAF_USERNAME_UAT']                = 'DEVUAT'; // DEVTUSER
            $value['COCAF_PASSWORD_UAT']                = 'Test@1234'; // P@22werd
            
            return $value;
        }

    }
?>