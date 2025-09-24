<?php
    class PageController{
        

        public function __construct() {
            checkLoggedIn('true');
        }

        public function home(){
            views('page.home'); 
        }

        public function help(){
            views('page.help'); 
        }

        public function error400(){
            views('page.error-400');  
        }

        public function error401(){
            views('page.error-401'); 
        }

        public function error403(){
            views('page.error-403'); 
        }

        public function error404(){
            views('page.error-404'); 
        }

        public function error500(){
            views('page.error-500'); 
        }   

        public function comingSoon(){
            views('page.coming-soon'); 
        }  
        
        public function documentation(){
            views('page.documentation'); 
        }  

        public function information(){
            views('page.information'); 
        }  
  
        public function underMaintenance(){
            views('page.under-maintenance'); 
        }

    }
?>