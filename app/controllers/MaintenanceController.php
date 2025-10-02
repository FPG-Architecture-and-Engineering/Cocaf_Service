<?php
class MaintenanceController {

    public function __construct() {}

    public function health() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode([
            'statusCode' => 200,
            'status'     => 'okay',
            'message'    => 'service is running 111'
        ]);

        exit; 
    }
}
?>
