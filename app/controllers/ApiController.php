<?php
    class ApiController{

        private static $username  = NULL;
        private static $password  = NULL;

        public function __construct(){

            checkLoggedIn('none');

            if (isset($_POST['app']) && !empty($_POST['app'])) {

                includeModel('System');

                $system = recastArray(System::getConfigurationByApp(htmlEncode(strtoupper($_POST['app']))));
                if (!empty($system)) {

                    self::$username = htmlDecode($system['username']);
                    self::$password = htmlDecode($system['password']);

                } else {

                    $return['code']     = '400';
                    $return['message']  = 'Bad Request (Application does not exist)';

                    header('Access-Control-Allow-Origin', '*');
                    header('Content-Type: application/json');
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            } else {

                $return['code']     = '400';
                $return['message']  = 'Bad Request (Missing app field)';

                header('Access-Control-Allow-Origin', '*');
                header('Content-Type: application/json');
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

        }
		
		public function cocaf(){



		}


        public function validate(){
			
            if ((isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == self::$username) && (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] == self::$password)) {

                $data = array();

                if (isset($_POST['transaction_type']) && $_POST['transaction_type'] == 'NEW') {

                    $data = checkRequiredPost(array('transaction_type', 'transaction_id', 'coc_no', 'plate_no', 'mv_file_no', 'engine_no', 'chassis_no', 'inception_date', 'expiry_date', 'mv_type', 'mv_prem_type',  'tax_type', 'assured_name', 'assured_tin', 'created_name'));

                } elseif (isset($_POST['transaction_type']) && $_POST['transaction_type'] == 'RENEWAL') {

                    $data = checkRequiredPost(array('transaction_type', 'transaction_id', 'coc_no', 'plate_no', 'mv_file_no', 'inception_date', 'expiry_date', 'mv_type', 'mv_prem_type',  'tax_type', 'assured_name', 'assured_tin', 'created_name'));

                } elseif (isset($_POST['transaction_type']) && $_POST['transaction_type'] == 'VERIFY') {

                    $data = checkRequiredPost(array('transaction_type', 'transaction_id', 'coc_no', 'created_name'));

                } else {

                    $return['code']                 = '400';
                    $return['message']              = 'Bad Request';
                    $return['data']['errorMessage'] = 'Transaction type does not exist';

                    header('Access-Control-Allow-Origin', '*');
                    header('Content-Type: application/json');
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

                if (!array_key_exists('error', $data)) {

                    $field['app']                   = strtoupper($_POST['app']);
                    $field['transaction_type']      = $_POST['transaction_type'];
                    $field['transaction_id']        = $_POST['transaction_id'];
                    $field['coc_no']                = $_POST['coc_no'];
                    $field['created_name']          = $_POST['created_name'];

                    if ($_POST['transaction_type'] == 'NEW') {

                        $field['engine_no']         = $_POST['engine_no'];
                        $field['chassis_no']        = $_POST['chassis_no'];
						 $field['plate_no']          = $_POST['plate_no'];
                        $field['mv_file_no']        = $_POST['mv_file_no'];
                        $field['inception_date']    = date('m/d/Y', strtotime($_POST['inception_date']));
                        $field['expiry_date']       = date('m/d/Y', strtotime($_POST['expiry_date']));
                        $field['mv_type']           = $_POST['mv_type'];
                        $field['mv_prem_type']      = $_POST['mv_prem_type'];
                        $field['tax_type']          = $_POST['tax_type'];
                        $field['assured_name']      = $_POST['assured_name'];
                        $field['assured_tin']       = $_POST['assured_tin'];

                        $return = self::register($field);

                    } elseif ($_POST['transaction_type'] == 'RENEWAL') {
						
						
						$field['engine_no']         = $_POST['engine_no'];
                        $field['chassis_no']        = $_POST['chassis_no'];
                        $field['plate_no']          = $_POST['plate_no'];
                        $field['mv_file_no']        = $_POST['mv_file_no'];
                        $field['inception_date']    = date('m/d/Y', strtotime($_POST['inception_date']));
                        $field['expiry_date']       = date('m/d/Y', strtotime($_POST['expiry_date']));
                        $field['mv_type']           = $_POST['mv_type'];
                        $field['mv_prem_type']      = $_POST['mv_prem_type'];
                        $field['tax_type']          = $_POST['tax_type'];
                        $field['assured_name']      = $_POST['assured_name'];
                        $field['assured_tin']       = $_POST['assured_tin'];
                        $return = self::renewal($field);
						
						
						Api::addLog(Array("data"=>json_encode($field)));


                    } elseif ($_POST['transaction_type'] == 'VERIFY') {

                        $return = self::verify($field);

                    }

                } else {

                    $return['code']                 = '400';
                    $return['message']              = 'Bad Request';
                    $return['data']['errorMessage'] = 'Missing fields';

                }

            } else {

                $return['code']     = '401';
                $return['message']  = 'Unauthorized';

                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');

            }

            header('Access-Control-Allow-Origin', '*');
            header('Content-Type: application/json');
            echo json_encode($return, JSON_PRETTY_PRINT);

        }
		public function test(){
			
			echo "sanity check";
			
		}

        public function register($field){

            if ((isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == self::$username) && (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] == self::$password)) {

				$configuration = Configuration::general();
                $field_request['app']               = htmlEncode($field['app']);
                $field_request['transaction_type']  = htmlEncode($field['transaction_type']);
                $field_request['transaction_id']    = htmlEncode($field['transaction_id']);
                $field_request['reg_type']          = htmlEncode('N');
                $field_request['coc_no']            = htmlEncode($field['coc_no']);
                $field_request['plate_no']          = htmlEncode($field['plate_no']);
                $field_request['mv_file_no']        = htmlEncode($field['mv_file_no']);
                $field_request['engine_no']         = htmlEncode($field['engine_no']);
                $field_request['chassis_no']        = htmlEncode($field['chassis_no']);
                $field_request['inception_date']    = htmlEncode($field['inception_date']);
                $field_request['expiry_date']       = htmlEncode($field['expiry_date']);
                $field_request['mv_type']           = htmlEncode($field['mv_type']);
                $field_request['mv_prem_type']      = htmlEncode($field['mv_prem_type']);
                $field_request['tax_type']          = htmlEncode($field['tax_type']);
                $field_request['assured_name']      = htmlEncode($field['assured_name']);
                $field_request['assured_tin']       = htmlEncode($field['assured_tin']);
                $field_request['created_name']      = htmlEncode($field['created_name']);
                $field_request['created_when']      = saveDateTime();
				
				
				if($field['app']=="CEBUANA"){
					$username=$configuration['COCAF_USERNAME1'];
					$password=$configuration['COCAF_PASSWORD1'];
				}else{
					$username=$configuration['COCAF_USERNAME'];
					$password=$configuration['COCAF_PASSWORD'];
					
					
				} 
                
                $request = Api::addRequest($field_request);
				
				
                $xml = 
                    '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.isap.com/">
                        <soapenv:Header />
                        <soapenv:Body>
                            <api:register>
                                <arg0>
                                    <username>'.$username.'</username>
                                    <password>'.$password.'</password>
                                    <regType>N</regType>
                                    <cocNo>'.$field['coc_no'].'</cocNo>
                                    <plateNo></plateNo>
                                    <mvFileNo></mvFileNo>
                                    <engineNo>'.$field['engine_no'].'</engineNo>
                                    <chassisNo>'.$field['chassis_no'].'</chassisNo>
                                    <inceptionDate>'.$field['inception_date'].'</inceptionDate>
                                    <expiryDate>'.$field['expiry_date'].'</expiryDate>
                                    <mvType>'.$field['mv_type'].'</mvType>
                                    <mvPremType>'.$field['mv_prem_type'].'</mvPremType>
                                    <taxType>'.$field['tax_type'].'</taxType>
                                    <assuredName>'.$field['assured_name'].'</assuredName>
                                    <assuredTin>'.$field['assured_tin'].'</assuredTin>
                                </arg0>
                            </api:register>
                        </soapenv:Body>
                    </soapenv:Envelope>';
                error_log($xml, 3, getDocumentRoot().'/upload/log/'.dateTimeAsId().'-cocaf-request-'.$field['transaction_id'].'.txt');

                $api = cURLApiRestXML($configuration['COCAF_API_URL'].'cocRegistration', $xml);

                error_log(json_encode($api, JSON_PRETTY_PRINT), 3, getDocumentRoot().'/upload/log/'.dateTimeAsId().'-cocaf-response-'.$field['transaction_id'].'.txt');

                $field_response['request_id']       = htmlEncode($request['id']);
                $field_response['app']              = htmlEncode($field['app']);
                $field_response['transaction_type'] = htmlEncode($field['transaction_type']);
                $field_response['transaction_id']   = htmlEncode($field['transaction_id']);
                $field_response['created_when']     = saveDateTime();

                if (strpos($api, 'cURL API Error') !== false) {

                    $return['code']                 = '400';
                    $return['message']              = 'Bad Request';
                    $return['transaction_id']       = $field['transaction_id'];
                    $return['data']['errorMessage'] = 'Failure to connect to API. '.$api;

                    $field_response['code']             = '400';
                    $field_response['message']          = 'Bad Request';
                    $field_response['status']           = 'failed';
                    $field_response['error_message']    = htmlEncode('Failure to connect to API. '.$api);

                } else {

                    $response = cleanXMLResponse($api);

                    if (isset($response->Body->registerResponse->return)) {

                        $result = $response->Body->registerResponse->return;
                        if (isset($response->Body->registerResponse->return->successMessage)) {

                            $return['code']             = '200';
                            $return['message']          = 'OK';
                            $return['transaction_id']   = $field['transaction_id'];
                            $return['data']             = $result;

                            $field_response['code']             = '200';
                            $field_response['message']          = 'OK';
                            $field_response['status']           = 'success';
                            $field_response['auth_no']          = htmlEncode($result->authNo);
                            $field_response['coc_no']           = htmlEncode($result->cocNo);
                            $field_response['premium_type']     = htmlEncode($result->premiumType);
                            $field_response['success_message']  = htmlEncode($result->successMessage);

                        } else {

                            $return['code']             = '400';
                            $return['message']          = 'Bad Request';
                            $return['transaction_id']   = $field['transaction_id'];
                            $return['data']             = $result;

                            $field_response['code']             = '400';
                            $field_response['message']          = 'Bad Request';
                            $field_response['status']           = 'failed';
                            $field_response['error_message']    = htmlEncode($result->errorMessage);

                        }

                    } else {

                        $return['code']                 = '400';
                        $return['message']              = 'Bad Request';
                        $return['transaction_id']       = $field['transaction_id'];
                        $return['data']['errorMessage'] = 'Failure to connect to COCAF API. There\'s an error while parsing the retuned data.';

                        $field_response['code']             = '400';
                        $field_response['message']          = 'Bad Request';
                        $field_response['status']           = 'failed';
                        $field_response['error_message']    = htmlEncode('Failure to connect to COCAF API. There\'s an error while parsing the retuned data.');

                    }

                }

                Api::addResponse($field_response);

                includeModel('System');
                $email = recastArray(System::getEmailNotificationByApp(htmlEncode($field['app'])));
                if (!empty($email)) {

                    $account_id = "'".str_replace("-", "', '", $email['account_id'])."'";
                    $account = System::getAllAccountByAccountId($account_id);
                    if (!empty($account)) {

                        $to = array();
                        foreach ($account as $key => $value) {
                            array_push($to, $value['email']);
                        }

                        includeDefault('notification');
                        Notification::sendEmail($to, 'COCAF Authentication', Notification::transaction($field_request, $field_response));

                    }

                }

            } else {

                $return['code']     = '401';
                $return['message']  = 'Unauthorized';

                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');

            }

            return $return;

        }

        public function renewal($field){

            if ((isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == self::$username) && (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] == self::$password)) {

                $configuration = Configuration::general();

                $field_request['app']               = htmlEncode($field['app']);
                $field_request['transaction_type']  = htmlEncode($field['transaction_type']);
                $field_request['transaction_id']    = htmlEncode($field['transaction_id']);
                $field_request['reg_type']          = htmlEncode('R');
                $field_request['coc_no']            = htmlEncode($field['coc_no']);
                $field_request['plate_no']          = htmlEncode($field['plate_no']);
                $field_request['mv_file_no']        = htmlEncode($field['mv_file_no']);
				
                if($field['engine_no']!=""){
				$field_request['engine_no']         = htmlEncode($field['engine_no']);					
				}else{
				$field['engine_no']         = "X";
				$field_request['engine_no']         = "X";						
				
				}
				if($field['chassis_no']!=""){
                $field_request['chassis_no']        = htmlEncode($field['chassis_no']);
				}else{
				$field['chassis_no']         = "X";						
				$field_request['chassis_no']         = "X";						
				}
                $field_request['inception_date']    = htmlEncode($field['inception_date']);
                $field_request['expiry_date']       = htmlEncode($field['expiry_date']);
                $field_request['mv_type']           = htmlEncode($field['mv_type']);
                $field_request['mv_prem_type']      = htmlEncode($field['mv_prem_type']);
                $field_request['tax_type']          = htmlEncode($field['tax_type']);
                $field_request['assured_name']      = htmlEncode($field['assured_name']);
                $field_request['assured_tin']       = htmlEncode($field['assured_tin']);
                $field_request['created_name']      = htmlEncode($field['created_name']);
                $field_request['created_when']      = saveDateTime();
if($field['app']=="CEBUANA"){
					$username=$configuration['COCAF_USERNAME1'];
					$password=$configuration['COCAF_PASSWORD1'];
				}else{
					$username=$configuration['COCAF_USERNAME'];
					$password=$configuration['COCAF_PASSWORD'];
				}

                $request = Api::addRequest($field_request);
							
                $xml = 
                    '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.isap.com/">
                        <soapenv:Header />
                        <soapenv:Body>
                            <api:register>
                                <arg0>
                                    <username>'.$username.'</username>
                                    <password>'.$password.'</password>
                                    <regType>R</regType>
                                    <cocNo>'.$field['coc_no'].'</cocNo>
                                    <plateNo>'.$field['plate_no'].'</plateNo>
                                    <mvFileNo>'.$field['mv_file_no'].'</mvFileNo>
                                    <engineNo>'.$field['engine_no'].'</engineNo>
                                    <chassisNo>'.$field['chassis_no'].'</chassisNo>
                                    <inceptionDate>'.$field['inception_date'].'</inceptionDate>
                                    <expiryDate>'.$field['expiry_date'].'</expiryDate>
                                    <mvType>'.$field['mv_type'].'</mvType>
                                    <mvPremType>'.$field['mv_prem_type'].'</mvPremType>
                                    <taxType>'.$field['tax_type'].'</taxType>
                                    <assuredName>'.$field['assured_name'].'</assuredName>
                                    <assuredTin>'.$field['assured_tin'].'</assuredTin>
                                </arg0>
                            </api:register>
                        </soapenv:Body>
                    </soapenv:Envelope>';

                error_log($xml, 3, getDocumentRoot().'/upload/log/'.dateTimeAsId().'-cocaf-request-'.$field['transaction_id'].'.txt');

                $api = cURLApiRestXML($configuration['COCAF_API_URL'].'cocRegistration', $xml);

                error_log(json_encode($api, JSON_PRETTY_PRINT), 3, getDocumentRoot().'/upload/logs/'.dateTimeAsId().'-cocaf-response-'.$field['transaction_id'].'.txt');

                $field_response['request_id']       = htmlEncode($request['id']);
                $field_response['app']              = htmlEncode($field['app']);
                $field_response['transaction_type'] = htmlEncode($field['transaction_type']);
                $field_response['transaction_id']   = htmlEncode($field['transaction_id']);
                $field_response['created_when']     = saveDateTime();

                if (strpos($api, 'cURL API Error') !== false) {

                    $return['code']                 = '400';
                    $return['message']              = 'Bad Request';
                    $return['transaction_id']       = $field['transaction_id'];
                    $return['data']['errorMessage'] = 'Failure to connect to API. '.$api;

                    $field_response['code']             = '400';
                    $field_response['message']          = 'Bad Request';
                    $field_response['status']           = 'failed';
                    $field_response['error_message']    = htmlEncode('Failure to connect to API. '.$api);

                } else {

                    $response = cleanXMLResponse($api);

                    if (isset($response->Body->registerResponse->return)) {

                        $result = $response->Body->registerResponse->return;
                        if (isset($response->Body->registerResponse->return->successMessage)) {

                            $return['code']             = '200';
                            $return['message']          = 'OK';
                            $return['transaction_id']   = $field['transaction_id'];
                            $return['data']             = $result;                            

                            $field_response['code']             = '200';
                            $field_response['message']          = 'OK';
                            $field_response['status']           = 'success';
                            $field_response['auth_no']          = htmlEncode($result->authNo);
                            $field_response['coc_no']           = htmlEncode($result->cocNo);
                            $field_response['plate_no']         = htmlEncode($result->plateNo);
                            $field_response['premium_type']     = htmlEncode($result->premiumType);
                            $field_response['success_message']  = htmlEncode($result->successMessage);

                        } else {

                            $return['code']             = '400';
                            $return['message']          = 'Bad Request';
                            $return['transaction_id']   = $field['transaction_id'];
                            $return['data']             = $result;

                            $field_response['code']             = '400';
                            $field_response['message']          = 'Bad Request';
                            $field_response['status']           = 'failed';
                            $field_response['error_message']    = htmlEncode($result->errorMessage);

                        }

                    } else {

                        $return['code']                 = '400';
                        $return['message']              = 'Bad Request';
                        $return['transaction_id']       = $field['transaction_id'];
                        $return['data']['errorMessage'] = 'Failure to connect to COCAF API. There\'s an error while parsing the retuned data.';

                        $field_response['code']             = '400';
                        $field_response['message']          = 'Bad Request';
                        $field_response['status']           = 'failed';
                        $field_response['error_message']    = htmlEncode('Failure to connect to COCAF API. There\'s an error while parsing the retuned data.');

                    }

                }

                Api::addResponse($field_response);

                includeModel('System');
                $email = recastArray(System::getEmailNotificationByApp(htmlEncode($field['app'])));
                if (!empty($email)) {

                    $account_id = "'".str_replace("-", "', '", $email['account_id'])."'";
                    $account = System::getAllAccountByAccountId($account_id);
                    if (!empty($account)) {

                        $to = array();
                        foreach ($account as $key => $value) {
                            array_push($to, $value['email']);
                        }

                        includeDefault('notification');
                        Notification::sendEmail($to, 'COCAF Authentication', Notification::transaction($field_request, $field_response));

                    }

                }

            } else {

                $return['code']     = '401';
                $return['message']  = 'Unauthorized';

                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');

            }

            return $return;

        }

        public function verify($field){

            if ((isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == self::$username) && (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] == self::$password)) {

                $configuration = Configuration::general();

                $field_request['app']               = htmlEncode($field['app']);
                $field_request['transaction_type']  = htmlEncode($field['transaction_type']);
                $field_request['transaction_id']    = htmlEncode($field['transaction_id']);
                $field_request['coc_no']            = htmlEncode($field['coc_no']);
                $field_request['created_name']      = htmlEncode($field['created_name']);
                $field_request['created_when']      = saveDateTime();

                $request = Api::addRequest($field_request);
				if($field['app']=="CEBUANA"){
					$username=$configuration['COCAF_USERNAME1'];
					$password=$configuration['COCAF_PASSWORD1'];
				}else{
					$username=$configuration['COCAF_USERNAME'];
					$password=$configuration['COCAF_PASSWORD'];
				} 
                $xml = 
                    '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:api="http://api.isap.com/">   
                        <soapenv:Header />   
                        <soapenv:Body>
                            <api:verify>
                                <arg0>
                                    <username>'.$username.'</username>
                                    <password>'.$password.'</password>
                                    <cocNo>'.$field['coc_no'].'</cocNo>
                                </arg0>
                            </api:verify>
                        </soapenv:Body>
                    </soapenv:Envelope>';

                error_log($xml, 3, getDocumentRoot().'/upload/log/'.dateTimeAsId().'-cocaf-request-'.$field['transaction_id'].'.txt');

                $api = cURLApiRestXML($configuration['COCAF_API_URL'].'cocVerification', $xml);

                error_log(json_encode($api, JSON_PRETTY_PRINT), 3, getDocumentRoot().'/upload/log/'.dateTimeAsId().'-cocaf-response-'.$field['transaction_id'].'.txt');

                if ($_POST['app'] == 'COCAF') $return['id'] = $request['id'];

                $field_response['request_id']           = $request['id'];
                $field_response['app']                  = htmlEncode($field['app']);
                $field_response['transaction_type']     = htmlEncode($field['transaction_type']);
                $field_response['transaction_id']       = htmlEncode($field['transaction_id']);
                $field_response['created_when']         = saveDateTime();

                if (strpos($api, 'cURL API Error') !== false) {

                    $return['code']                 = '400';
                    $return['message']              = 'Bad Request';
                    $return['transaction_id']       = $field['transaction_id'];
                    $return['data']['errorMessage'] = 'Failure to connect to API. '.$api;

                    $field_response['code']             = '400';
                    $field_response['message']          = 'Bad Request';
                    $field_response['status']           = 'failed';
                    $field_response['error_message']    = htmlEncode('Failure to connect to API. '.$api);

                } else {

                    $response = cleanXMLResponse($api);

                    if (isset($response->Body->verifyResponse->return)) {

                        $result = $response->Body->verifyResponse->return;
                        if (!isset($response->Body->verifyResponse->return->errorMessage)) {

                            $return['code']             = '200';
                            $return['message']          = 'OK';
                            $return['transaction_id']   = $field['transaction_id'];
                            $return['data']             = $result;

                            $field_response['code']                     = '200';
                            $field_response['message']                  = 'OK';
                            $field_response['status']                   = 'success';
                            $field_response['auth_date']                = htmlEncode($result->authDate);
                            $field_response['auth_no']                  = htmlEncode($result->authNo);
                            $field_response['auth_type']                = htmlEncode($result->authType);
                            $field_response['chassis_no']               = htmlEncode($result->chassisNo);
                            $field_response['coc_no']                   = htmlEncode($result->cocNo);
                            $field_response['engine_no']                = htmlEncode($result->engineNo);
                            $field_response['expiry_date']              = htmlEncode($result->expiryDate);
                            $field_response['inception_date']           = htmlEncode($result->inceptionDate);
                            $field_response['lto_verification_code']    = htmlEncode($result->ltoVerificationCode);
                            $field_response['mv_file_no']               = htmlEncode($result->mvFileNo);
                            $field_response['mv_type']                  = htmlEncode($result->mvType);
                            $field_response['org_id']                   = htmlEncode($result->orgId);
                            $field_response['plate_no']                 = htmlEncode($result->plateNo);
                            $field_response['premium_type']             = htmlEncode($result->premiumType);
                            $field_response['reg_type']                 = htmlEncode($result->regType);
                            $field_response['coc_status']               = htmlEncode($result->status);
                            $field_response['tax_type']                 = htmlEncode($result->taxType);
                            $field_response['username']                 = htmlEncode($result->username);
                            $field_response['vehicle_type']             = htmlEncode($result->vehicleType);
                            $field_response['year']                     = htmlEncode($result->year);

                        } else {

                            $return['code']             = '400';
                            $return['message']          = 'Bad Request';
                            $return['transaction_id']   = $field['transaction_id'];
                            $return['data']             = $result;

                            $field_response['code']             = '400';
                            $field_response['message']          = 'Bad Request';
                            $field_response['status']           = 'failed';
                            $field_response['error_message']    = htmlEncode($result->errorMessage);

                        }

                    } else {

                        $return['code']                 = '400';
                        $return['message']              = 'Bad Request';
                        $return['transaction_id']       = $field['transaction_id'];
                        $return['data']['errorMessage'] = 'Failure to connect to COCAF API. There\'s an error while parsing the retuned data.';

                        $field_response['code']             = '400';
                        $field_response['message']          = 'Bad Request';
                        $field_response['status']           = 'failed';
                        $field_response['error_message']    = 'Failure to connect to COCAF API. There\'s an error while parsing the retuned data.';

                    }

                }

                Api::addResponse($field_response);

                includeModel('System');
                $email = recastArray(System::getEmailNotificationByApp(htmlEncode($field['app'])));
                if (!empty($email)) {

                    $account_id = "'".str_replace("-", "', '", $email['account_id'])."'";
                    $account = System::getAllAccountByAccountId($account_id);
                    if (!empty($account)) {

                        $to = array();
                        foreach ($account as $key => $value) {
                            array_push($to, $value['email']);
                        }

                        includeDefault('notification');
                        Notification::sendEmail($to, 'COCAF Authentication', Notification::transaction($field_request, $field_response));

                    }

                }

            } else {

                $return['code']     = '401';
                $return['message']  = 'Unauthorized';

                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');

            }

            return $return;

        }

    }
?>