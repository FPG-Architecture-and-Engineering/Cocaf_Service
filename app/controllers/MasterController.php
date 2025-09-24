<?php
	class MasterController{

        public function __construct() {

            checkLoggedIn('true');

        }

        public function mvType(){

            $data = array();

            $data = Master::getMvType();

            views('master.mv-type', $data);

        }

        public function mvType_json(){

            if (isset($_POST) && !empty($_POST)) {

                if (!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'edit') {

                    $record = Master::getMvTypeById(htmlEncode($_POST['id']));
                    if (is_array($record)) {    
                        foreach($record as $key => $value){
                            $result['id']           = htmlDecode($value['id']);
                            $result['name']         = htmlDecode($value['name']);
                            $result['description']  = htmlDecode($value['description']);
                        }
                    }

                } elseif(!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {

                    $result = Master::deleteMvType(htmlEncode($_POST['id']));
                    
                } else {

                    $field['id']            = htmlEncode($_POST['id']);
                    $field['name']          = htmlEncode($_POST['name']);
                    $field['description']   = htmlEncode($_POST['description']);

                    $data = checkRequiredPost(array('name'));
                    if (!array_key_exists('error', $data)) {  
                        if (!empty($_POST['id'])) {
                            $field['updated_by']    = ACCOUNT_ID;
                            $field['updated_when']  = saveDateTime();

                            $result = Master::editMvType($field['id'], $field);
                        } else {
                            unset($field['id']);
                            $field['created_by']    = ACCOUNT_ID;
                            $field['created_when']  = saveDateTime();

                            $result = Master::addMvType($field);
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

        public function premiumType(){

            $data = array();

            $data = Master::getPremiumType();

            views('master.premium-type', $data);

        }

        public function premiumType_json(){

            if (isset($_POST) && !empty($_POST)) {

                if (!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'edit') {

                    $record = Master::getPremiumTypeById(htmlEncode($_POST['id']));
                    if (is_array($record)) {    
                        foreach($record as $key => $value){
                            $result['id']           = htmlDecode($value['id']);
                            $result['name']         = htmlDecode($value['name']);
                            $result['description']  = htmlDecode($value['description']);
                        }
                    }

                } elseif(!empty($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'delete') {

                    $result = Master::deletePremiumType(htmlEncode($_POST['id']));
                    
                } else {

                    $field['id']            = htmlEncode($_POST['id']);
                    $field['name']          = htmlEncode($_POST['name']);
                    $field['description']   = htmlEncode($_POST['description']);

                    $data = checkRequiredPost(array('name'));
                    if (!array_key_exists('error', $data)) {  
                        if (!empty($_POST['id'])) {
                            $field['updated_by']    = ACCOUNT_ID;
                            $field['updated_when']  = saveDateTime();

                            $result = Master::editPremiumType($field['id'], $field);
                        } else {
                            unset($field['id']);
                            $field['created_by']    = ACCOUNT_ID;
                            $field['created_when']  = saveDateTime();

                            $result = Master::addPremiumType($field);
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