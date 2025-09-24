<?php
    class TransactionController{

        public function __construct(){

            checkLoggedIn('true');

        }

        public function all(){

            views('transaction.all');

        }

        public function all_json(){

            $draw               = htmlEncode($_POST['draw']);
            $row                = htmlEncode($_POST['start']);
            $rowperpage         = htmlEncode($_POST['length']);
            $columnIndex        = htmlEncode($_POST['order'][0]['column']);
            $columnName         = htmlEncode($_POST['columns'][$columnIndex]['data']);
            $columnSortOrder    = htmlEncode($_POST['order'][0]['dir']);
            $searchValue        = htmlEncode($_POST['search']['value']);

            $searchQuery = '';
            if ($searchValue != '') {
                $searchQuery = '(
                    req.app LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.transaction_type LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.transaction_id LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.coc_no LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.plate_no LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.mv_file_no LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.engine_no LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.chassis_no LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.inception_date LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.expiry_date LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.mv_type LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.mv_prem_type LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.tax_type LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.assured_name LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.assured_tin LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.created_name LIKE "%'. htmlEncode($searchValue) .'%" OR
                    req.created_when LIKE "%'. htmlEncode($searchValue) .'%" OR
                    res.status LIKE "%'. htmlEncode($searchValue) .'%" OR
                    res.success_message LIKE "%'. htmlEncode($searchValue) .'%" OR
                    res.error_message LIKE "%'. htmlEncode($searchValue) .'%"
                )';
            }

            $totalRecords = Transaction::getAllTransactionCount()[0]['all_rows'];
            $totalRecordwithFilter = Transaction::getAllTransactionSearchFilter($searchQuery)[0]['all_rows'];
            $totalFilteredRecords = Transaction::getAllTransactionServerSideWithFilter(
                $searchQuery, 
                $columnName == '' ? 'id ASC' : $columnName.' '.$columnSortOrder, 
                $rowperpage == -1 ? '' : $row.','.$rowperpage
            );

            $data = array();

            if (!empty($totalFilteredRecords)) {
                foreach ($totalFilteredRecords as $key => $value) {

                    $action =
                        '<form name="view_'.htmlDecode($value['id']).'" action="/transaction/view/" method="post">
                            <input name="id" type="hidden" value="'.htmlDecode($value['id']).'">
                        </form>
                        <a href="/transaction/view/" class="btn btn-sm btn-list btn-teal" title="View: '.htmlDecode($value['transaction_id']).'" onClick="document.forms[\'view_'.htmlDecode($value['id']).'\'].submit(); return false;"><i class="fa fa-file-text-o"></i></a>';

                    $data[] = array(
                        'app'               => htmlDecode($value['app']),
                        'transaction_type'  => htmlDecode($value['transaction_type']),
                        'transaction_id'    => htmlDecode($value['transaction_id']),
                        'coc_no'            => htmlDecode($value['coc_no']),
                        'plate_no'          => (!empty($value['plate_no'])) ? htmlDecode($value['plate_no']) : '-',
                        'mv_file_no'        => (!empty($value['mv_file_no'])) ? htmlDecode($value['mv_file_no']) : '-',
                        'engine_no'         => (!empty($value['engine_no'])) ? htmlDecode($value['engine_no']) : '-',
                        'chassis_no'        => (!empty($value['chassis_no'])) ? htmlDecode($value['chassis_no']) : '-',
                        'inception_date'    => (!empty($value['inception_date'])) ? htmlDecode($value['inception_date']) : '-',
                        'expiry_date'       => (!empty($value['expiry_date'])) ? htmlDecode($value['expiry_date']) : '-',
                        'mv_type'           => htmlDecode($value['mv_type']),
                        'mv_prem_type'      => htmlDecode($value['mv_prem_type']),
                        'tax_type'          => htmlDecode($value['tax_type']),
                        'assured_name'      => htmlDecode($value['assured_name']),
                        'assured_tin'       => htmlDecode($value['assured_tin']),
                        'created_name'      => htmlDecode($value['created_name']),
                        'created_when'      => htmlDecode($value['created_when']),
                        'status'            => htmlDecode(ucwords($value['status'])),
                        'success_message'   => htmlDecode($value['success_message']),
                        'error_message'     => htmlDecode($value['error_message']),
                        'action'            => $action
                    );

                }
            }

            $response = array(
                'draw'              => intval($draw),
                'recordsFiltered'   => $totalRecordwithFilter,
                'recordsTotal'      => $totalRecords,
                'aaData'            => $data
            );  

            echo json_encode($response);

        }

        public function register(){

            if (!accessGranted(['2'])) {
                header('Location: /page-not-found/');
            }

            $data = array();

            includeModel(['Master', 'System']);

            $data['mv_type']        = Master::getMvType();
            $data['premium_type']   = Master::getPremiumType();

            if (isset($_POST) && !empty($_POST)) {

                $cocaf = recastArray(System::getConfigurationByApp('COCAF'));
                if (!empty($cocaf)) {

                    $field['app']               = 'COCAF';
                    $field['transaction_type']  = $_POST['transaction_type'];
                    $field['transaction_id']    = $_POST['transaction_id'];
                    $field['coc_no']            = $_POST['coc_no'];
                    $field['created_name']      = ACCOUNT_FIRSTNAME.' '.ACCOUNT_LASTNAME;

                    if ($_POST['transaction_type'] == 'NEW') {

                        $field['engine_no']         = $_POST['engine_no'];
                        $field['chassis_no']        = $_POST['chassis_no'];
                        $field['inception_date']    = date('m/d/Y', strtotime($_POST['inception_date']));
                        $field['expiry_date']       = date('m/d/Y', strtotime($_POST['expiry_date']));
                        $field['mv_type']           = $_POST['mv_type'];
                        $field['mv_prem_type']      = $_POST['mv_prem_type'];
                        $field['tax_type']          = $_POST['tax_type'];
                        $field['assured_name']      = $_POST['assured_name'];
                        $field['assured_tin']       = $_POST['assured_tin'];

                    } elseif ($_POST['transaction_type'] == 'RENEWAL') {

                        $field['plate_no']          = $_POST['plate_no'];
                        $field['mv_file_no']        = $_POST['mv_file_no'];
                        $field['inception_date']    = date('m/d/Y', strtotime($_POST['inception_date']));
                        $field['expiry_date']       = date('m/d/Y', strtotime($_POST['expiry_date']));
                        $field['mv_type']           = $_POST['mv_type'];
                        $field['mv_prem_type']      = $_POST['mv_prem_type'];
                        $field['tax_type']          = $_POST['tax_type'];
                        $field['assured_name']      = $_POST['assured_name'];
                        $field['assured_tin']       = $_POST['assured_tin'];

                    }

                    $result = cURLApiRestPOST('https://ph-cocaf.fpgins.com/api/cocaf/validate/', htmlDecode($cocaf['username']), htmlDecode($cocaf['password']), $field);

                    self::view(array('id' => $result['id']));
                    die();

                }

            }

            views('transaction.register', $data);

        }

        public function view($field = ''){

            if ((isset($_POST['id']) && !empty($_POST['id'])) || !empty($field)) {

                $data = array();

                $id = (!empty($field)) ? htmlEncode($field['id']) : htmlEncode($_POST['id']);

                $data['request']    = recastArray(Transaction::getTransactionRequestById($id));
                $data['response']   = recastArray(Transaction::getTransactionResponseByRequestId($id));

                if (empty($data['request']) && empty($data['response'])) {
                    header('location: /transaction/all/');
                }

                views('transaction.view', $data);

            } else {

                header('location: /transaction/all/');

            }
            
        }

    }
?>