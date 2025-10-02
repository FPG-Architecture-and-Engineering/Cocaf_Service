<?php
require_once('app/default/function.php');
includeDefault(['configuration', 'database']);

/* Resolve controller & view */
if (isset($_GET['controller']) && isset($_GET['view'])) {
    $controller = $_GET['controller'];
    $view       = viewConvertUrl($_GET['view']);
} else {
    $controller = 'page';
    $view       = 'home';
}

$account = ['login', 'logout'];

/* Detect JSON endpoints EARLY */
$json_suffix = '_json';
$is_json =
    (strpos($_SERVER['REQUEST_URI'], 'json') !== false) ||
    in_array($controller, ['api', 'uat', 'maintenance']) ||   // add maintenance here
    (substr($view, -strlen($json_suffix)) === $json_suffix);

/* If JSON, run router directly and EXIT BEFORE ANY LAYOUT */
if ($is_json) {
    // If any output buffers were started by function.php or elsewhere, clear them
    while (function_exists('ob_get_level') && ob_get_level() > 0) {
        ob_end_clean();
    }
    require_once('routes.php');
    exit; // <- guarantees no layout HTML
}

/* (The rest only runs for non-JSON pages) */
if (isset($_SESSION['login_account_id'])) {
    includeModel('Account');
    $profile = recastArray(Account::getRecordById($_SESSION['login_account_id']));

    define('ACCOUNT_ID',        $profile['id']);
    define('ACCOUNT_ROLE_ID',   $profile['role_id']);
    define('ACCOUNT_FIRSTNAME', $profile['first_name']);
    define('ACCOUNT_LASTNAME',  $profile['last_name']);
    define('ACCOUNT_USERNAME',  $profile['username']);
    define('ACCOUNT_EMAIL',     $profile['email']);
    define('ACCOUNT_PHOTO',     $profile['photo']);
} else {
    define('ACCOUNT_ID', ''); define('ACCOUNT_ROLE_ID', '');
    define('ACCOUNT_FIRSTNAME', ''); define('ACCOUNT_LASTNAME', '');
    define('ACCOUNT_USERNAME', '');  define('ACCOUNT_EMAIL', '');
    define('ACCOUNT_PHOTO', '');
}

/* Pick the normal HTML template */
if ($controller === 'account' && in_array($view, $account)) {
    $template = 'account';
} else {
    $template = 'main';
}

/* Include layout ONLY for non-JSON */
require_once('app/views/layout/' . $template . '.php');
