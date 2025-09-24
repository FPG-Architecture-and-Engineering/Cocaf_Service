<?php
    require_once('app/default/function.php');
    includeDefault(['configuration', 'database']);

    if(isset($_GET['controller']) && isset($_GET['view'])){
        $controller = $_GET['controller'];
        $view       = viewConvertUrl($_GET['view']);
    }else{
        $controller = 'page';
        $view       = 'home';
    }

    $account = array('login', 'logout');

    if(strpos($_SERVER['REQUEST_URI'], 'json') !== false || in_array($controller, array('api', 'uat'))){
        $template = 'json';
    }else{
        if($controller == 'account' && in_array($view, $account)){
            $template = 'account';
        }else{
            $template = 'main';
        }
    }

    /*
    $account_id                     = '1000';
    $_SESSION['login_session']      = $account_id.date('YmdHis');
    $_SESSION['login_account_id']   = $account_id;
    */

    if(isset($_SESSION['login_account_id'])){

        includeModel('Account');
        $profile = recastArray(Account::getRecordById($_SESSION['login_account_id']));

        define('ACCOUNT_ID', $profile['id']);
        define('ACCOUNT_ROLE_ID', $profile['role_id']);
        define('ACCOUNT_FIRSTNAME', $profile['first_name']);
        define('ACCOUNT_LASTNAME', $profile['last_name']);
        define('ACCOUNT_USERNAME', $profile['username']);
        define('ACCOUNT_EMAIL', $profile['email']);
        define('ACCOUNT_PHOTO', $profile['photo']);

    }else{

        define('ACCOUNT_ID', '');
        define('ACCOUNT_ROLE_ID', '');
        define('ACCOUNT_FIRSTNAME', '');
        define('ACCOUNT_LASTNAME', '');
        define('ACCOUNT_USERNAME', '');
        define('ACCOUNT_EMAIL', '');
        define('ACCOUNT_PHOTO', '');

    }

    require_once('app/views/layout/'.$template.'.php');
?>
