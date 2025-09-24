<?php
    // START
    ob_start();
    session_start();

    function baseUrl(){
        return '/'; 
    }

    function port(){
        // return '';
    }

    function getDocumentRoot(){
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /*
    function getSiteUrl(){
        return (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].port() : "http://".$_SERVER['SERVER_NAME'].port();
    }
    */
    function getSiteUrl(){
        return "http://".$_SERVER['SERVER_NAME'].port();
    }

    function getFolderUrl(){
        return "http://".$_SERVER['SERVER_NAME'].port();
    }

    function openWithChromeUrl(){
        return "http://".$_SERVER['SERVER_NAME'];
    }

    function views($file, $data=''){
        $path = explode('.', $file);
        require_once('app/views/'.$path[0].'/'.$path[1].'.php');
    }

    function viewConvertUrl($url){
        $explode = explode('-', $url);
        $ctr     = 0;
        foreach($explode as $key){
            if($ctr == 0){
                $value = $key;
            }else{
                $value .= ucwords($key);
            }
            $ctr++;
        }
        return $value;
    }
    
    function viewDiplayUrl($url){
        $value = ucwords(preg_replace('/(?<!\ )[A-Z]/', ' $0', $url));
        return $value;
    }

    function includeController($files){
        if(is_array($files)){
            foreach($files as $file){
                require_once(getDocumentRoot().'/app/controllers/'.$file.'.php');
            }
        }else{
            require_once(getDocumentRoot().'/app/controllers/'.$files.'.php');
        }
    }    

    function includeModel($files){
        if(is_array($files)){
            foreach($files as $file){
                require_once(getDocumentRoot().'/app/models/'.$file.'.php');
            }
        }else{
            require_once(getDocumentRoot().'/app/models/'.$files.'.php');
        }
    }      

    function includeCommon($files){
        if(is_array($files)){
            foreach($files as $file){
                require_once(getDocumentRoot().'/app/views/common/'.$file.'.php');
            }
        }else{
            require_once(getDocumentRoot().'/app/views/common/'.$files.'.php');
        }
    }  

    function includeLibrary($files){
        if(is_array($files)){
            foreach($files as $file){
                require_once(getDocumentRoot().'/app/library/'.$file);
            }
        }else{
            require_once(getDocumentRoot().'/app/library/'.$files);
        }
    }  

    function includeDefault($files){
        if(is_array($files)){
            foreach($files as $file){
                require_once(getDocumentRoot().'/app/default/'.$file.'.php');
            }
        }else{
            require_once(getDocumentRoot().'/app/default/'.$files.'.php');
        }
    }  

    function uploadPhoto($folder, $file){
        return getDocumentRoot().'/upload/'.$folder.'/'.$file;
    }

    function uploadFile($folder, $file){
        return getDocumentRoot().'/upload/'.$folder.'/'.$file;
    }

    function deleteFile($folder, $file){
        if(!empty($folder) && !empty($file) && file_exists(uploadFile($folder, $file))){
            unlink(uploadFile($folder, $file));
        }
    }

    //CHECK USER LOGGED IN
    function checkLoggedIn($allow){     
        switch ($allow) {
            //CAN USE IF USER LOGGED IN
            case 'true':
                if(!isset($_SESSION['login_session'])){ 
                    ob_clean();
                    header('location: /login');
                    die();
                } 
                break;  
            //CAN'T USE IF USER LOGGED IN                       
            case 'false':
                if(isset($_SESSION['login_session']) && $_SESSION['login_session'] == true){ 
                    ob_clean();
                    header('location: /');          
                    die();
                } 
                break;
            //FOR ORDINARY PAGE | CONTENT PAGE ONLY                     
            case 'none':
                //DO NOTHING
                break;              
        }   
    }
        
    //ALLOW ACCESS BASED ON ACCOUNT_TYPE
    function allowAccess($account, $users){ 
        if(is_array($users)){
            if(!in_array($account, $users)){ 
                header('location: /');  
                die(); 
            }
        }else{
            if($account <> $users){ 
                header('location: /');  
                die(); 
            }
        }
    }       

    //RESTRICT MODULE/SECTION BASED ON ACCESS ROLE
    function accessGranted($roles){
        $list = explode('-', ACCOUNT_ROLE_ID);

        $allow = false;

        if(is_array($roles)){
            foreach($roles as $role){
                if(in_array($role, $list)){
                    $allow = true;
                }
            }
        }else{
            if(in_array($roles, $list)){
                $allow = true;
            }
        }

        return $allow;
    }

    //RESTRICT MODULE/SECTION BASED ON ACCESS LEVEL
    function accessLevel($level){
        if($level == 1){
            if(in_array(ACCOUNT_TYPE, [SYSTEM_ADMINISTRATOR])){
                return true;
            }
        }elseif($level == 2){
            if(in_array(ACCOUNT_TYPE, [SYSTEM_ADMINISTRATOR, SYSTEM_PROJECT_MANAGER])){
                return true;
            }
        }elseif($level == 3){
            if(in_array(ACCOUNT_TYPE, [SYSTEM_ADMINISTRATOR, SYSTEM_PROJECT_MANAGER, SYSTEM_TEAM_MEMBER])){
                return true;
            }
        }elseif($level == 4){
            if(in_array(ACCOUNT_TYPE, [SYSTEM_VIEWER])){
                return true;
            }
        }

        return false;
    }

    //CHECK IF TWO DIFFERENT BUSINESS TYPE HAVE AT LEAST ONE EQUAL VALUE
    function escalationBusinessType($business_type_1, $business_type_2){
        $array_1 = explode('-', $business_type_1);
        $array_2 = explode('-', $business_type_2);

        $result = array_intersect($array_1, $array_2);

        if(count($result) > 0){
            return true;
        }else{
            return false;
        }       

    }

    //CHECK IF BUSINESS TYPE ARE GIVEN
    function allowBusinessType($types){
        $list = explode('-', ACCOUNT_BUSINESS_TYPE_ID);

        $allow = false;

        if(is_array($types)){
            foreach($types as $type){
                if(in_array($type, $list)){
                    $allow = true;
                }
            }
        }else{
            if(in_array($types, $list)){
                $allow = true;
            }
        }

        return $allow;
    }

    //REMOVE UN-ASSOCIATE USER BY BUSINESS TYPE
    function userBasedOnBusinessType($array){

        $list = explode('-', ACCOUNT_BUSINESS_TYPE_ID);
        
        if(count($array) > 0){
            foreach($array as $key => $value){
                
                $allow = false;
                $types = explode('-', $value['business_type_id']);
                           
                if(is_array($types)){
                    foreach($types as $type){
                        if(in_array($type, $list)){
                            $allow = true;
                        }
                    }
                }else{
                    if(in_array($types, $list)){
                        $allow = true;
                    }
                }

                if($allow == false){
                    unset($array[$key]);
                }
            }
        }
        
        return array_values($array);
    }

    //HIGHLIGHT ACTIVE CONTROLLER
    function activeController($controller='', $class=''){ 
        if(isset($_GET['controller']) && in_array($_GET['controller'], $controller)){
            echo $class;    
        }
    }   

    //HIGHLIGHT ACTIVE VIEW
    function activeView($controller='', $view='', $class=''){ 
        if(isset($_GET['controller']) && in_array($_GET['controller'], $controller) && isset($_GET['view']) && in_array($_GET['view'], $view)){
            echo $class;    
        }
    }   

    //HIGHLIGHT DASHBOARD
    function activeDashboard($class=''){ 
        if(!isset($_GET['controller']) && !isset($_GET['view'])){
            echo $class;    
        }
    }

    //MENU HIGHLIGHT ACTIVE
    function menuActive($class, $page, $variable, $value){ 
        $link = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);
        $list = explode(',', preg_replace('/\s+/', '', $page));     
        if(!empty($link) && !empty($page)){
            if(in_array($link, $list)) {
                echo 'class="'.$class.'"';      
            }           
        }else{
            if(isset($_GET[$variable]) && $_GET[$variable] == $value){
                echo 'class="'.$class.'"';  
            }
        }
    }   

    //ACCOUNT MENU HIGHLIGHT ACTIVE
    function accountMenuActive($controller, $page){ 
        if(isset($_GET['controller']) && $_GET['controller'] == $controller && isset($_GET['view']) && $_GET['view'] == $page){
            echo 'class="current"'; 
        }elseif(!isset($_GET['view']) && $page == 'home'){
            echo 'class="current"'; 
        }
    }   

    //CURRENT PAGE
    function currentPage($controller='', $page=''){ 
        if(!isset($_GET['view']) && $page == 'home'){
            return true;
        }elseif(isset($_GET['controller']) && $_GET['controller'] == $controller && isset($_GET['view']) && $_GET['view'] == $page){
            return true;
        }else{
            return false;
        }
    }   

    //TAB HIGHTLIGHT
    function tabMenu($param, $page){ 
        if(isset($_GET[$param]) && $_GET[$param] == $page){
            echo 'class="current"'; 
        }
    }   

    //FIELD DECODER
    function htmlDecode($field){
        $replacements = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $keywords = array('%09A','%09B','%09C','%09D','%09E','%09F','%09G','%09H','%09I','%09J','%09K','%09L','%09M','%09N','%09O','%09P','%09Q','%09R','%09S','%09T','%09U','%09V','%09W','%09X','%09Y','%09Z','%06a','%06b','%06c','%06d','%06e','%06f','%06g','%06h','%06i','%06j','%06k','%06l','%06m','%06n','%06o','%06p','%06q','%06r','%06s','%06t','%06u','%06v','%06w','%06x','%06y','%06z');
        // $value = stripslashes(htmlspecialchars_decode(trim($field),ENT_QUOTES)); 
        $value = str_replace($keywords,$replacements,trim($field));
        $value = str_replace(array('&#92;','&#47;'),array('\\','/'),$value);//backslashes and front slashes
        return($value);
    }

    //FIELD ENCODER
    function htmlEncode($field){
        $keywords = array('/rlike/i', '/like/i', '/select/i', '/from/i', '/then/i', '/else/i', '/end/i', '/case/i', '/when/i', '/sleep/i','/sysdate\(/i','/now\(/i','/or/i');
        $replacements = array('%06ekilr','%06ekil', '%06tceles', '%06morf', '%06neht', '%06esle', '%06dne', '%06esac', '%06nehw', '%06peels');
        $js_keyword = array('/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i','/onmouseover/i','/usvB/i','/onmouseclick/i','/window.location/i','/document.cookie/i','/alert\(/i','/javascript:/i','/url\(/i','/onerror/i','/getElementById/i','/keyword.value/i','/searchTerm/i','/innerHTML/i','/searchResult/i','/innerText/i','/img.src/i','/onload\(/');
        $field = preg_replace($js_keyword,'',$field);
        // $field = str_replace('"','',$field); //remove double quote 
        $field = preg_replace_callback($keywords,
                    function($match){
                        $letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
                        $encodedLetters = array('%09A','%09B','%09C','%09D','%09E','%09F','%09G','%09H','%09I','%09J','%09K','%09L','%09M','%09N','%09O','%09P','%09Q','%09R','%09S','%09T','%09U','%09V','%09W','%09X','%09Y','%09Z','%06a','%06b','%06c','%06d','%06e','%06f','%06g','%06h','%06i','%06j','%06k','%06l','%06m','%06n','%06o','%06p','%06q','%06r','%06s','%06t','%06u','%06v','%06w','%06x','%06y','%06z');
                        return str_replace($letters,$encodedLetters,$match[0]);
                    }
                 ,$field);
        $value = htmlspecialchars(trim($field),ENT_QUOTES);
        $value = str_replace(array('\\','/'),array('&#92;','&#47;'),$value);//backslashes and front slashes

        return($value);
    }

    //PASSWORD ENCODE SPECIAL CHARACTER
    function passwordEncode($str){
      for($i=0; $i<5;$i++){
        $str=strrev(base64_encode($str)); //apply base64 first and then reverse the string
      }
      return $str;
    }
    
    //PASSWORD ENCODE SPECIAL CHARACTER
    function passwordDecode($str){
      for($i=0; $i<5;$i++){
        $str=base64_decode(strrev($str)); //apply base64 first and then reverse the string
      }
      return $str;
    }

    // STRING ENCRYPTION & DECRYPTION
    function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
    function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if($mod4){
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
    //ENCRYPT
    function encrypt($value){
        if(!$value){ return false; }

        $skey       = "a%rQ~2qWne%F!}_D;e#A%~>{";
        $text       = $value;
        $iv_size    = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv         = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted  = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
        
        return trim(safe_b64encode($encrypted));
    }
    //DECRYPT
    function decrypt($value){
        if(!$value){ return false; }

        $skey       = "a%rQ~2qWne%F!}_D;e#A%~>{";
        $crypttext  = safe_b64decode($value);
        $iv_size    = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv         = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted  = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        
        return trim($decrypted);
    }

    // META TAGS | SEO TITLE
    function metaSeoTitle($field){
        $value = ucwords(strtolower($field));
        return($value);
    }

    // META TAGS | SEO DESCRIPTION
    function metaSeoDescription($field){
        $value = function_truncate(strtolower(trim(strip_tags($field))), 150, 160);
        return($value);
    }
        
    // META TAGS | SEO KEYWORDS
    function metaSeoKeyword($field){
        $value = ucwords(strtolower($field));
        return($value);
    }

    //LIMIT WORDS DISPLAY
    function wordTruncate($input, $maxWords, $maxChars){
        $words = preg_split('/\s+/', $input);
        $words = array_slice($words, 0, $maxWords);
        $words = array_reverse($words);

        $chars = 0;
        $truncated = array();

        while(count($words) > 0){
            $fragment = trim(array_pop($words));
            $chars += strlen($fragment);

            if($chars > $maxChars) break;

            $truncated[] = $fragment;
        }

        $result = implode($truncated, ' ');

        return $result . ($input == $result ? '' : '...');
    }

    //CLEAN URL STRING
    function urlClean($string) {
       $string = str_replace('/', ' ', $string); // Replaces all spaces with hyphens.
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '-', strtolower($string)); // Replaces multiple hyphens with single one.
    }

    //CLEAN NAME STRING
    function nameClean($string) {
       $string = str_replace('/', ' ', $string); // Replaces all spaces with hyphens.
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '-', strtolower($string)); // Replaces multiple hyphens with single one.
    }

    //CLEAN CODE NUMNER
    function numberClean($string) {
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '', strtolower($string)); // Replaces multiple hyphens with single one.
    }

    //CLEAN MONEY VALUE
    function moneyClean($value){
        return str_replace( ',', '', $value);
    }

    //GENERATE UNIQUE IMAGE NAME
    function uniqueImageName($filename){
        $name = strtolower(safe_b64encode(substr(urlClean($filename), 0, 5).date('Ymd')));
        return $name;
    }

    //IMAGE NAME
    function getImageName($file, $post_name){   
        $split = explode ('.', $file);      
        return $split[0].$post_name.'.'.$split[1];
    }

    //COMPARE TWO ARRAYS AND REMOVE DUPLICATES VALUES
    function arrayRemoveDuplicateValues($array_1, $array_2){
        return array_values(array_diff($array_1, array_intersect($array_1, $array_2)));
    }

    //IF ARRAY KEY & VALUE IF NOT EMPTY
    function arrayKeyValueExist($array, $key){
        if(array_key_exists($key, $array)) {
            if(!empty($array[$key]) || $array[$key] != ''){
                return $array[$key];
            }
        }
    }

    //IF ARRAY KEY IS EXIST
    function arrayKeyExist($array, $key){
        if(is_array($array) && array_key_exists($key, $array)){
            return $array[$key];
        }
        return NULL;
    }

    //IF MULTIDIMENSIONAL ARRAY KEY IS EXIST RETURN VALUE
    function multiArrayKeyExist($array, $key1, $key2){
        $result = '';
        if(is_array($array) && array_key_exists($key1, $array) && !is_null($array[$key1]) && array_key_exists($key2, $array[$key1])){
            foreach ($array[$key1] as $element => $value) {
                if($key2 == $element){
                    $result = htmlDecode($value);
                }
            }

            return htmlDecode($result);
        }
        return NULL;
    }

    //CHECK IF KEY EXIST IN MULTIDIMENSIONAL ARRAY
    function multiKeyExists($array, $key) {
        if(is_array($array) && array_key_exists($key, $array)){
            // is in base array?
            if (array_key_exists($key, $array)) {
                return $array[$key];
            }
            // check arrays contained in this array
            foreach ($array as $element) {
                if (is_array($element)) {
                    if (multiKeyExists($element, $key)) {
                        //return true;
                        return $element[$key];
                    }
                }
            }
        }
        return NULL;
    }

    //COUNT TOTAL NUMBER WITH SAME VALUE IN MULTIDIMENSIONAL ARRAY
    function countArrayValue($array, $row, $value){
        $count = 0;
        for ($i = 0; $i < count($array); $i++) {
            if($array[$i][$row] == $value){
                $count++;
            }
        }

        return $count;
    }

    //BUILD GET ARRAY VARIABLES AND ENCODE
    function getVariablesEncode($array){
        if(!empty($array)){
            $result     = '';;
            $separator  = '';
            foreach($array as $key=>$value) {
                $result .= $separator . $key . '=' . $value; 
                $separator = '&'; 
            }

            return safe_b64encode($result);
        }
    }

    //BUILD GET ARRAY VARIABLES AND DECODE
    function getVariablesDecode($get){

        /*
        $str = "first=value&arr[]=foo+bar&arr[]=baz";
        parse_str($str, $output);
        echo $output['first'];  // value
        echo $output['arr'][0]; // foo bar
        echo $output['arr'][1]; // baz
        */

        $str = safe_b64decode($get);
        //$str = "first=value&arr[]=foo+bar&arr[]=baz";
        parse_str($str, $output);

        return $output;

        //$_get = getVariablesDecode($_GET['var']);
        //getVariablesEncode(array('action'=>'add','id'=>''));
    }

    //CHECK IF DEFINE VARIABLE IS NOT EMPTY, IF EMPTY RETURN NULL
    function defineValue($define){
        $value = '';
        if(isset($define) && !empty($define)){
            $value = $define;
        }
        return $value;
    }

    //MARK 'checked' THE CHECKBOX
    function loopCheckbox($array, $key, $value){
        if(array_key_exists($key, $array)) {
            $data = explode('-',$array[$key]);
            foreach($data as $row){
                if($row == $value){
                    echo ' checked ';
                }
            }
        }
    }

    //CHECK IF MULTIDIMENSIONAL ARRAY ARE EMPTY
    function checkIfArrayIsNotEmpty($array){
        $return = FALSE;
        if(is_array($array)){
            foreach($array as $value){
                if(!empty($value)){
                    $return = TRUE;
                }
            }
        }elseif(!empty($array)){
            $return = TRUE;
        }

        return $return;
    }

    //GET VARIABLE
    function getVar($get){
        $value = '';
        if(isset($_GET[$get]) && !empty($_GET[$get])){
            return htmlEncode($_GET[$get]);
        }
        return $value;
    }

    //POST VARIABLE
    function postVar($post){
        $value = '';
        if(isset($_POST[$post]) && !empty($_POST[$post])){
            return htmlEncode($_POST[$post]);
        }
        return $value;
    }

    //DATABASE SAVE DATE TIME FORMAT
    function saveDateTime(){
        return date('Y-m-d H:i:s');
    }

    //USE DATE TIME AS ID / UNIQUE 
    function dateTimeAsId(){
        return date('YmdHis');
    }

    //DATABASE SAVE DATE FORMAT
    function saveDate(){
        return date('Y-m-d');
    }

    //CHECK IF POST VARIABLE IS NOT EMPTY
    function checkRequiredPost($array){
        foreach($array as $key){
            if(isset($_POST[$key]) && empty(trim($_POST[$key]))){
                $data['error'][$key] = 'Required field';
            }else{
                $data['post'][$key] = htmlEncode($_POST[$key]);
            }
        }

        return $data;
    }

    //CONVERT ARRAY KEY
    function convertArrayKey($array, $newKey){
        if(empty($array)){
            return $array[$newKey];
        }else{
            foreach($array as $key => $value){
                $array[$newKey] = $array[$key];
                unset($array[$key]);
            }
            return $array;
        }
    }

    function recastArray($array){
        return (is_array($array) && count($array) == 1 ? $array[0] : $array);
    }

    //PRINT ARRAY NICELY
    function pre($array){
        print "<pre>";
        print_r($array);
        print "</pre>";
    }

    //CHECK IF IMAGE VARIABLE IS NOT EMPTY AND IMAGE EXISTS IN DIRECTORY
    function displayImage($file, $folder){

        $extension = pathinfo(getFolderUrl().'/'.$folder.'/'.$file, PATHINFO_EXTENSION);
        $list      = array('jpg', 'jpeg', 'png');
        
        if(in_array($extension, $list) || empty($extension)){
            if(file_exists(getDocumentRoot().'/upload/'.$folder.'/'.$file) && !empty($file)){
                $image = '/file/'.$folder.'/'.$file;
            }else{
                $image = '/public/img/no-photo.jpg';
            }
        }else{
            $image = '/public/img/no-photo-'.strtolower($extension).'.jpg';
        }
        
        return $image;
    }

    //CHECK IF IMAGE VARIABLE IS NOT EMPTY AND IMAGE EXISTS IN DIRECTORY
    function openImageInNewTab($photo, $path){
        if(!empty($photo) && getimagesize(getFolderUrl().$path.$photo)){
            $image = 'href="'.$path.$photo.'" target="_blank"';
        }else{
            $image = '';
        }
        return $image;
    }

    //CHECK IF FILE VARIABLE IS NOT EMPTY AND FILE EXISTS IN DIRECTORY
    function openFileInNewTab($file, $path){
        if(!empty($file) && file_exists(getDocumentRoot().'\upload\/'.$path.'\/'.$file)){
            $link = 'href="/file/'.$path.'/'.$file.'" target="_blank"';
        }else{
            $link = '';
        }
        return $link;
    }

    //FLASH MESSAGE PROMPT
    function promptMessage($name='', $message='', $class='success'){

        if(!empty($name)){

            if(!empty($message) && empty($_SESSION[$name])){ 
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name] );
                }
                if(!empty($_SESSION[$name.'_class'])){
                    unset($_SESSION[$name.'_class']);
                }

                $_SESSION[$name] = $message;
                $_SESSION[$name.'_class'] = $class;

            }elseif(!empty( $_SESSION[$name]) && empty($message)){
                $class = !empty($_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';

                if($class == 'success'){
                    $icon = '<i class="icon ion-ios-checkmark alert-icon tx-28 mg-t-5 mg-xs-t-0"></i>';
                }else{
                    $icon = '<i class="icon ion-ios-close alert-icon tx-28"></i>';
                }

                echo '
                        <div class="alert alert-'.$class.' flash alert-solid" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <div class="d-flex align-items-center justify-content-start">
                                '.$icon.'
                                <span>'.$_SESSION[$name].'</span>
                            </div>
                        </div>
                     ';
            }
        }

        return $name;
    }

    //UNSET FLASH MESSAGE PROMPT AFTER DISPLAY
    function flash($name){
         unset($_SESSION[$name]);
         unset($_SESSION[$name.'_class']);
    }

    //DISPLAY FLASH MESSAGE PROMPT
    function flashMessage(){
        $message = '
                    <div class="col-lg-12">
                        '.flash(promptMessage('message')).'
                    </div>
                   ';

        return $message;
    }

    //DISPLAY UPDATE OR NEW PAGE TITLE
    function managePageTitle(){
        echo (!empty(getVar('id')) ? 'Update' : 'New' );
    }

    //GET ALL WEEKDAYS BETWEEN DATE RANGE
    function allWeekdays($date_1, $date_2){
        //$date_1 = '2020-08-01';
        //$date_2 = '2020-09-07';

        $period = new DatePeriod(
            new DateTime($date_1),
            new DateInterval('P1D'),
            new DateTime($date_2)
        );

        $weekdays = [];
        foreach ($period as $key => $value) {
            if ($value->format('N') <= 5) {
                $weekdays[] = $value->format('Y-m-d');
            }  
        }

        return $weekdays;
    }

    //GET ALL WEEKENDS BETWEEN DATE RANGE
    function allWeekends($date_1, $date_2){
        //$date_1 = '2020-08-01';
        //$date_2 = '2020-09-07';

        $period = new DatePeriod(
            new DateTime($date_1),
            new DateInterval('P1D'),
            new DateTime($date_2)
        );

        $weekends = [];
        foreach ($period as $key => $value) {
            if ($value->format('N') >= 6) {
                $weekends[] = $value->format('Y-m-d');
            }  
        }

        return $weekends;
    }

    //GET THE DATES BETWEEN DATE RANGE
    function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
        $dates = [];
        $current = strtotime( $first );
        $last = strtotime( $last );

        while( $current <= $last ) {

            $dates[] = date( $format, $current );
            $current = strtotime( $step, $current );
        }

        return $dates;
    }

    //COUNT MINUTES DIFFERENCE BETWEEN TWO DATESTIME
    function differenceMinutes($dateTime_1, $dateTime_2){
        $time = new DateTime($dateTime_1); //2020-09-01 17:00:00
        $diff = $time->diff(new DateTime($dateTime_2)); //2020-09-01 17:10:00
        $minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

         return $minutes;
    }

    //COUNT DAY DIFFERENCE BETWEEN TWO DATES
    function differenceDays($date_1, $date_2){
         $datediff = strtotime($date_2) - strtotime($date_1);
         return floor($datediff/(60*60*24));
    }

    //COUNT MONTHS DIFFERENCE BETWEEN TWO DATES
    function differenceMonths($date_1, $date_2){
        $date_1   = strtotime($date_1);
        $date_2   = strtotime($date_2);
        $min_date = min($date_1, $date_2);
        $max_date = max($date_1, $date_2);
        $counter  = 0;

        while(($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date){
            $counter++;
        }

        return $counter;
    }

    //COUNT YEAR DIFFERENCE BETWEEN TWO YEARS
    function differenceYears($date_1, $date_2){
        $date_1 = new DateTime($date_1);
        $date_2 = new DateTime($date_2);

        return $date_1->diff($date_2)->format("%y");
    }

    //DISPLAY NEXT DATE
    function nextDate($format, $date, $no_days){
        return date($format, strtotime($date . ' +'.$no_days.' day'));
    }

    //DISPLAY NEXT MONTH
    function nextMonth($format, $date, $no_months){
        return date($format, strtotime($date . ' +'.$no_months.' month'));
    }

    //GET BIRTHDAY
    function birthday($birthday){
        return date_diff(date_create($birthday), date_create('now'))->y;
    }

    //MONEY FORMAT
    function formatMoney($amount){
        if($amount == '' || $amount == 0 || $amount == 0.00){
            $money = '0.00';
        }else{
            $money = number_format($amount, 2);
        }
        return $money;
    }

    //CONVERT NEGATIVE VALUE TO POSITIVE ZERO
    function convertNegativeToZero($value){
        return ((htmlEncode($value) != 0 && htmlEncode($value) != NULL) ? max(htmlEncode($value), 0) : 0);
    }

    //DATE FORMAT : BOX STYLE DISPLAY
    function dateDisplayBox($date){
        if(!empty($date)){
            return date('M d Y', strtotime(htmlEncode($date)));
        }else{
            return 'No date available';
        }
        
    }

    //DATE FORMAT : PROPER DISPLAY
    function dateDisplayFull($date){
        //if($date == '' || $date == '00/00/0000' || $date == '00-00-0000' || $date == '01/01/1970' || $date == '01-01-1970' || $date == '01/01/-0001' || $date == '01-01-0001'){
        $strtotime = strtotime($date);
        if(empty($strtotime)){
            //return '<span class="text-muted">[ NO DATE ]</span>';
            return '';
        }else{
            return date('F d, Y', strtotime(htmlEncode($date)));
        }
    }

    //DATE FORMAT : DATABASE RETURN
    function formatDateReturn($date){

        $strtotime = strtotime($date);
        if(empty($strtotime)){
            return '';
        }else{
            return date("m/d/Y", strtotime(htmlEncode($date)));
        }
    }
    
    //DATE FORMAT : PROPER DISPLAY WITH TIME
    function dateDisplayFullAndTime($date){
        return date('F d, Y', strtotime(htmlEncode($date))).' '.date('h:i:s A', strtotime(htmlEncode($date)));
    }

    //YEAR & MONTH FORMAT FOR TEMPORARY CODE
    function dateYearMonthCode($date){
        return date("ym", strtotime(htmlEncode($date)));
    }

    //YEAR & MONTH FORMAT
    function dateYearMonth($date){
        return date("Y-m", strtotime(htmlEncode($date)));
    }

    //DATE & TIME FORMAT : DATABASE
    function formatDateTimeDB($date){
        return date("Y-m-d H:i:s", strtotime(htmlEncode($date)));
    }

    //DATE FORMAT : NUMERIC DISPLAY
    function dateNumericDisplay($date){
        return date('Y/m/d', strtotime(htmlEncode($date)));
    }

    //DATE FORMAT : PROPER NUMERIC DISPLAY
    function dateProperNumeric($date){
        if(!empty($date)){
            return date('m/d/Y', strtotime(htmlEncode($date)));
        }   
    }

    //DATE FORMAT : IN DETAILS DISPLAY
    function dateDetail($date){
        return date('D, d <br> M.Y', strtotime(htmlEncode($date)));
    }

    //DATE FORMAT : AS OF 
    function dateAsOf($date){
        return date('d F Y', strtotime(htmlEncode($date))); 
    }

    //DATE FORMAT : DATABASE FORMAT
    function dateSaveDB($date){
        return date('Y-m-d', strtotime(htmlEncode($date))); 
    }

    //TIME FORMAT : PROPER TIME DISPLAY
    function timeDisplayFull($date){
        return date('H:i:s', strtotime(htmlEncode($date)));
    }

    //TIME FORMAT : AM PM
    function timeDisplay($date){
        return date('h:i:s A', strtotime(htmlEncode($date)));
    }

    //DATE & TIME FORMAT : REPORT
    function reportDateTime($date){
        return date("m-d-Y H:i", strtotime(htmlEncode($date)));
    }

    //ADD ZERO
    function formatNumber($value, $number=4){
        return str_pad($value, $number, "0", STR_PAD_LEFT);
    }

    //CHECK MINIMUM AND MAXIMUM
    function minMax($minimum, $maximum){
        if($maximum < $minimum){
            return "Maximum is less than to minimum ($minimum minimum)";
        }
        return TRUE;
    }

    function alertAndRedirect($message, $location){
        $alert = "<script>
                    alert('".$message."'); 
                    window.location.href='".$location."';
                  </script>"; 
        echo $alert;
    }

    function forbiddenRedirect(){
        $alert = "<script>
                    alert('Access to this resource on the server is denied'); 
                    window.location.href='/';
                  </script>"; 
        echo $alert;
    }

    function refreshPage(){
        return '<meta http-equiv="refresh" content="0">';
    }

    function redirectPage($location){
        return '<meta http-equiv="refresh" content="0" url="'.$location.'">';
    }

    function percentAmount($amount, $percent){
        if($amount != '' || $amount != 0 & $percent != '' || $percent != 0){
            $total = ($percent/100)*$amount;
        }else{
            $total = '0.00';
        }
        return $total;
    }

    //GENERATE RANDOM CODE
    function generateRandomCode($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string     = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

    //GENERATE RANDOM NUMBER CODE
    function generateRandomNumber($length = 6) {
        $characters = '0123456789';
        $string     = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }
    
    function cURLApi($url){
        $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL             => $url,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_ENCODING        => "",
                CURLOPT_MAXREDIRS       => 10,
                CURLOPT_TIMEOUT         => 0,
                CURLOPT_FOLLOWLOCATION  => false,
                CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST  => false,
                CURLOPT_SSL_VERIFYPEER  => false,
				CURLOPT_CUSTOMREQUEST   => "GET"
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if($err){
            return "cURL Claim Error #:" . $err;
        }else{
            return json_decode($response, true);
        } 
    }

    function cURLApiRestPOST($url, $username, $password, $parameter){

        $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL             => $url,
                    CURLOPT_RETURNTRANSFER  => true,
                    CURLOPT_SSL_VERIFYHOST  => false,
                    CURLOPT_SSL_VERIFYPEER  => false,
                    CURLOPT_ENCODING        => '',
                    CURLOPT_MAXREDIRS       => 10,
                    CURLOPT_TIMEOUT         => 120,
                    CURLOPT_FOLLOWLOCATION  => true,
                    CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST   => 'POST',
                    CURLOPT_POSTFIELDS      => $parameter,
                    CURLOPT_HTTPHEADER      => array(
                        'Authorization: Basic '.base64_encode($username.':'.$password)
                    )
                ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Claim Error #:" . $err;
        } else {
            return json_decode($response, true);
        }

    }

    function cURLApiRestXML($url, $parameter){

        $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL             => $url,
                    CURLOPT_RETURNTRANSFER  => true,
                    CURLOPT_SSL_VERIFYHOST  => false,
                    CURLOPT_SSL_VERIFYPEER  => false,
                    CURLOPT_ENCODING        => 'UTF-8',
                    CURLOPT_MAXREDIRS       => 10,
                    CURLOPT_TIMEOUT         => 60,
                    CURLOPT_FOLLOWLOCATION  => false,
                    CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST   => 'POST',
                    CURLOPT_POSTFIELDS      => $parameter,
                    CURLOPT_HTTPHEADER      => array(
                        'Content-Type: application/xml'
                    )
                ));

        $response   = curl_exec($curl);
        $err        = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return 'cURL API Error #: '.$err;
        } else {
            return $response;
        } 

    }

    function cleanXMLResponse($response){

        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 'ns1:'], '', $response);
        return simplexml_load_string($clean_xml);

    }
?>