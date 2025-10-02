<?php
    function call($controller, $view) {
        require_once('app/controllers/'.ucfirst($controller).'Controller.php');

        $model_url = 'app/models/'.ucfirst($controller).'.php';
        if(file_exists($model_url)){
            require_once($model_url);
        }
            
        $conClass   = ucfirst($controller).'Controller';
        $controller = new $conClass();
        $controller->{$view}();
    }

    $controllers = array(

        'account'       => ['login', 'logout', 'user', 'user_json', 'role', 'role_json', 'profile'],

        'api'           => ['validate', 'register', 'renewal', 'verify','cocaf','test'],

        'uat'           => ['validate', 'register', 'renewal', 'verify','cocaf','reprocess'],

        'transaction'   => ['all', 'all_json', 'register', 'view'],

        'report'        => ['generation', 'export_json'],

        'master'        => ['mvType', 'mvType_json', 'premiumType', 'premiumType_json'],

        'system'        => ['configuration', 'configuration_json', 'emailNotification', 'emailNotification_json'],

        'page'          => ['home', 'error400', 'error401', 'error403', 'error404', 'error500'],

        'maintenance'          => ['health'],

    );
    $json_controllers = ['maintenance'];
    $json_suffix      = '_json';

    if(array_key_exists($controller, $controllers)){
        if(in_array($view, $controllers[$controller])){
            call($controller, $view);
        if (in_array($controller, $json_controllers) || substr($view, -strlen($json_suffix)) === $json_suffix
        ) {
            exit;
        }
        }else{
            call('page', 'error404');
        }
    }else{
        call('page', 'error404');
    }
    error_log("DEBUG: controller=$controller, view=$view, uri=" . $_SERVER['REQUEST_URI']);
    if ($_SERVER['REQUEST_URI'] === '/maintenance/health' || $_SERVER['REQUEST_URI'] === '/maintenance/health/') {
        require_once('app/controllers/MaintenanceController.php');
        $controller = new MaintenanceController();
        $controller->health();
        exit; // absolutely stop here
    }

?>  
