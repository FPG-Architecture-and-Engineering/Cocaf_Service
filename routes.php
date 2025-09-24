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

    );

    if(array_key_exists($controller, $controllers)){
        if(in_array($view, $controllers[$controller])){
            call($controller, $view);
        }else{
            call('page', 'error404');
        }
    }else{
        call('page', 'error404');
    }
?>  
