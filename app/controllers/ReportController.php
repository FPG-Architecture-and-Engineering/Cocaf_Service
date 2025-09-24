<?php
    class ReportController{
        
        private static $prefix_name = 'COCAF';

        public function __construct() {

            checkLoggedIn('true');

        }

        public function generation(){

            $data = array();

            $data['client'] = Report::getAllApp();

            if (isset($_POST) && !empty($_POST)) {

                $field['app']       = htmlEncode($_POST['app']);
                $field['date_from'] = date('Y-m-d H:i:s', strtotime($_POST['date_from']));
                $field['date_to']   = date('Y-m-d H:i:s', strtotime($_POST['date_to']));

                header('location: /report/export_json/?'.http_build_query($field));

            }

            views('report.generation', $data);

        }

        public function export_json(){

            includeLibrary('excel/PHPExcel.php');

            $filename = self::$prefix_name. '-Transaction-'. dateTimeAsId() .'.xlsx';

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $sheet = $objPHPExcel->getActiveSheet();


            $sheet->getStyle('A1:R2')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '1d2939')                
                    ),
                    'font' => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                    )       
                )
            );

            $sheet->getStyle('S1:AN2')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'CCE5FF')                
                    ),
                    'font' => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                    )       
                )
            );

            $sheet->setCellValue('A1', 'REQUEST')
                  ->setCellValue('S1', 'RESPONSE');

            $sheet->mergeCells('A1:R1');
            $sheet->mergeCells('S1:AN1');

            $sheet->setCellValue('A2', 'APPLICATION')
                  ->setCellValue('B2', 'TRANSACTION ID')
                  ->setCellValue('C2', 'TRANSACTION TYPE')
                  ->setCellValue('D2', 'REGISTRATION TYPE')
                  ->setCellValue('E2', 'COC NO.')
                  ->setCellValue('F2', 'PLATE NO.')
                  ->setCellValue('G2', 'MV FILE NO.')
                  ->setCellValue('H2', 'ENGINE NO.')
                  ->setCellValue('I2', 'CHASSIS NO.')
                  ->setCellValue('J2', 'INCEPTION DATE')
                  ->setCellValue('K2', 'EXPIRY DATE')
                  ->setCellValue('L2', 'MV TYPE')
                  ->setCellValue('M2', 'MV PREMIUM TYPE')
                  ->setCellValue('N2', 'TAX TYPE')
                  ->setCellValue('O2', 'ASSURED NAME')
                  ->setCellValue('P2', 'ASSURED TIN')
                  ->setCellValue('Q2', 'CREATED BY')
                  ->setCellValue('R2', 'CREATED DATE')
                  ->setCellValue('S2', 'STATUS')
                  ->setCellValue('T2', 'MESSAGE')
                  ->setCellValue('U2', 'AUTHENTICATION NO.')
                  ->setCellValue('V2', 'AUTHENTICATION DATE')
                  ->setCellValue('W2', 'AUTHENTICATION TYPE')
                  ->setCellValue('X2', 'ORGANIZATION ID')
                  ->setCellValue('Y2', 'COC NO.')
                  ->setCellValue('Z2', 'COC STATUS')
                  ->setCellValue('AA2', 'PLATE NO.')
                  ->setCellValue('AB2', 'MV FILE NO.')
                  ->setCellValue('AC2', 'ENGINE NO.')
                  ->setCellValue('AD2', 'CHASSIS NO.')
                  ->setCellValue('AE2', 'VEHICLE TYPE')
                  ->setCellValue('AF2', 'INCEPTION DATE')
                  ->setCellValue('AG2', 'EXPIRY DATE')
                  ->setCellValue('AH2', 'YEAR')
                  ->setCellValue('AI2', 'MV TYPE')
                  ->setCellValue('AJ2', 'PREMIUM TYPE')
                  ->setCellValue('AK2', 'TAX TYPE')
                  ->setCellValue('AL2', 'REGISTRATION TYPE')
                  ->setCellValue('AM2', 'LTO VERIFICATION CODE')
                  ->setCellValue('AN2', 'USERNAME');

            $row = 3;

            $app        = htmlEncode($_GET['app']);
            $date_from  = $_GET['date_from'];
            $date_to    = $_GET['date_to'];

            $where = '';
            if ($app != 'all') $where .= "res.app = '{$app}' AND ";
            $where .= "res.created_when BETWEEN '{$date_from}' AND '{$date_to}'";

            $transaction = Report::getAllTransaction($where);
            if (!empty($transaction)) {
                foreach ($transaction as $key => $value) {

                    if ($value['status'] == 'success' && $value['transaction_type'] == 'VERIFY') {
                        $message = 'COC Verification Successful!';
                    } elseif ($status['status'] == 'success') {
                        $message = htmlDecode($value['success_message']);
                    } else {
                        $message = htmlDecode($value['error_message']);
                    }

                    $sheet->setCellValue('A'.$row, htmlDecode($value['app']))
                          ->setCellValue('B'.$row, htmlDecode($value['transaction_id']))
                          ->setCellValue('C'.$row, htmlDecode($value['transaction_type']))
                          ->setCellValue('D'.$row, htmlDecode($value['reg_type']))
                          ->setCellValueExplicit('E'.$row, htmlDecode($value['coc_no']), PHPExcel_Cell_DataType::TYPE_STRING)
                          ->setCellValue('F'.$row, htmlDecode($value['plate_no']))
                          ->setCellValue('G'.$row, htmlDecode($value['mv_file_no']))
                          ->setCellValue('H'.$row, htmlDecode($value['engine_no']))
                          ->setCellValue('I'.$row, htmlDecode($value['chassis_no']))
                          ->setCellValue('J'.$row, htmlDecode($value['inception_date']))
                          ->setCellValue('K'.$row, htmlDecode($value['expiry_date']))
                          ->setCellValue('L'.$row, htmlDecode($value['mv_type']))
                          ->setCellValue('M'.$row, htmlDecode($value['mv_prem_type']))
                          ->setCellValue('N'.$row, htmlDecode($value['tax_type']))
                          ->setCellValue('O'.$row, htmlDecode($value['assured_name']))
                          ->setCellValueExplicit('P'.$row, htmlDecode($value['assured_tin']), PHPExcel_Cell_DataType::TYPE_STRING)
                          ->setCellValue('Q'.$row, htmlDecode($value['created_name']))
                          ->setCellValue('R'.$row, htmlDecode($value['created_when']))
                          ->setCellValue('S'.$row, ucwords(htmlDecode($value['status'])))
                          ->setCellValue('T'.$row, htmlDecode($message))
                          ->setCellValue('U'.$row, htmlDecode($value['auth_no']))
                          ->setCellValue('V'.$row, htmlDecode($value['auth_date']))
                          ->setCellValue('W'.$row, htmlDecode($value['auth_type']))
                          ->setCellValue('X'.$row, htmlDecode($value['org_id']))
                          ->setCellValueExplicit('Y'.$row, htmlDecode($value['res_coc_no']), PHPExcel_Cell_DataType::TYPE_STRING)
                          ->setCellValue('Z'.$row, htmlDecode($value['coc_status']))
                          ->setCellValue('AA'.$row, htmlDecode($value['res_plate_no']))
                          ->setCellValue('AB'.$row, htmlDecode($value['res_mv_file_no']))
                          ->setCellValue('AC'.$row, htmlDecode($value['res_engine_no']))
                          ->setCellValue('AD'.$row, htmlDecode($value['res_chassis_no']))
                          ->setCellValue('AE'.$row, htmlDecode($value['vehicle_type']))
                          ->setCellValue('AF'.$row, htmlDecode($value['res_inception_date']))
                          ->setCellValue('AG'.$row, htmlDecode($value['res_expiry_date']))
                          ->setCellValue('AH'.$row, htmlDecode($value['year']))
                          ->setCellValue('AI'.$row, htmlDecode($value['res_mv_type']))
                          ->setCellValue('AJ'.$row, htmlDecode($value['premium_type']))
                          ->setCellValue('AK'.$row, htmlDecode($value['res_tax_type']))
                          ->setCellValue('AL'.$row, htmlDecode($value['res_reg_type']))
                          ->setCellValue('AM'.$row, htmlDecode($value['lto_verification_code']))
                          ->setCellValue('AN'.$row, htmlDecode($value['username']));

                    $row++;

                }
            }

            $sheet->getStyle('D1:D'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // reg_type
            $sheet->getStyle('L1:L'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // mv_type
            $sheet->getStyle('M1:M'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // mv_prem_type
            $sheet->getStyle('N1:N'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // tax_type

            $sheet->getStyle('X1:X'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // org_id
            $sheet->getStyle('AE1:AE'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // vehicle_type
            $sheet->getStyle('AH1:AH'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // year
            $sheet->getStyle('AI1:AI'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // mv_type
            $sheet->getStyle('AJ3:AJ'.$sheet->getHighestRow())->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $sheet->getStyle('AK1:AK'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // tax_type
            $sheet->getStyle('AL1:AL'.$sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // reg_type


            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

                $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

                $sheet = $objPHPExcel->getActiveSheet();
                $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(true);

                foreach ($cellIterator as $cell) {
                    $sheet->getColumnDimension($cell->getColumn())->setAutoSize(15);
                }

            }

            $objPHPExcel->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $objWriter->save('php://output');

            exit;

        }

    }
?>