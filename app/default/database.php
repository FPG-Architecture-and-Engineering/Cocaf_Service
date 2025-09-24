<?php
    class MySql{

        private static $connection      = NULL;
        private static $connection_uat  = NULL;
        private static $result          = NULL;
        private static $sql             = NULL;
        private static $error           = NULL;
        private static $prefix          = '';

        public static function connect(){
            // LIVE DATABASE
            $server_port    = 'localhost';
            $database       = 'cocaf';
            $username       = 'root';
            $password       = 'Sys@dmin_cocaf';

            self::$connection = mysqli_connect($server_port, $username, $password, $database) or self::debug(mysqli_connect_error());
            return self::$connection;
        }

        public static function connect_uat(){
            // UAT DATABASE
            $server_port    = 'localhost';
            $database       = 'cocaf_uat';
            $username       = 'root';
            $password       = 'Sys@dmin_cocaf';

            self::$connection_uat = mysqli_connect($server_port, $username, $password, $database) or self::debug(mysqli_connect_error());
            return self::$connection_uat;
        }

        public static function disconnect(){
            mysqli_close(self::connect());
        }

        public static function debug($error){
            echo '<b>MySQL ERROR:</b>'.$error; 
        }

        public static function select($table, $fields, $where = '', $orderby = '', $limit = ''){
            $row        = NULL;
            $where      = (trim($where) != '') ? "WHERE {$where}" : $where;
            $orderby    = (trim($orderby) != '') ? "ORDER BY {$orderby}" : $orderby;
            $limit      = (trim($limit) != '') ? "LIMIT {$limit}" : $limit;
            $result     = mysqli_query(self::connect(), "SELECT {$fields} FROM ".self::$prefix.$table." {$where} {$orderby} {$limit}");

            if($result){
                while($fetchrow = mysqli_fetch_assoc($result)) $row[] = $fetchrow;
                mysqli_free_result($result);
            }else{
                self::debug(mysqli_error(self::$connection));
            }

            return $row;
        }

        public static function insert($table, $fields, $where = ''){
            $where = (trim($where) != '') ? "WHERE {$where}" : $where;
            $query = mysqli_query(self::connect(), "INSERT INTO ".self::$prefix.$table." SET {$fields} {$where}") or self::debug(mysqli_error(self::$connection));

            if($query){
                return true;
            }
            return false;
        }

        public static function update($table, $fields, $where = ''){
            $where = (trim($where) != '') ? "WHERE {$where}" : $where;
            $query = mysqli_query(self::connect(), "UPDATE ".self::$prefix.$table." SET {$fields} {$where}") or self::debug(mysqli_error(self::$connection));

            if($query){
                return true;
            }
            return false;
        }

        public static function delete($table, $where = ''){
            $where = (trim($where) != "") ? "WHERE {$where}" : $where;
            $query = mysqli_query(self::connect(), "DELETE FROM ".self::$prefix.$table." {$where}") or self::debug(mysqli_error(self::$connection));

            return $query;
        }

        public static function count($table, $fields, $where = ''){
            $where = (trim($where) != "") ? "WHERE {$where}" : $where;
            $query = mysqli_query(self::connect(), "SELECT {$fields} FROM ".self::$prefix.$table." {$where}") or self::debug(mysqli_error(self::$connection));

            $count = mysqli_num_rows($query);

            return $count;
        }   

        public static function query($query){
            $row    = NULL;
            $result = mysqli_query(self::connect(), $query);

            if($result){
                while($fetchrow = mysqli_fetch_assoc($result)) $row[] = $fetchrow;
                mysqli_free_result($result);
            }else{
                self::debug(mysqli_error(self::$connection));
            }
            
            return $row;
        }   
        
        public static function insertedId(){
            return mysqli_insert_id(self::$connection);
        }

        public static function buildFields($post, $sep = ' '){
            $count  = 0;
            $fields = ''; 
            foreach($post as $key => $value){

                if($count == 0){
                    $fields .= "{$key}='{$value}'";
                }else{
                    $fields .= $sep."{$key}='{$value}'";
                }

                $count++;
            }
            return $fields;
        }

        public static function select_uat($table, $fields, $where = '', $orderby = '', $limit = ''){
            $row        = NULL;
            $where      = (trim($where) != '') ? "WHERE {$where}" : $where;
            $orderby    = (trim($orderby) != '') ? "ORDER BY {$orderby}" : $orderby;
            $limit      = (trim($limit) != '') ? "LIMIT {$limit}" : $limit;
            $result     = mysqli_query(self::connect_uat(), "SELECT {$fields} FROM ".self::$prefix.$table." {$where} {$orderby} {$limit}");

            if($result){
                while($fetchrow = mysqli_fetch_assoc($result)) $row[] = $fetchrow;
                mysqli_free_result($result);
            }else{
                self::debug(mysqli_error(self::$connection_uat));
            }

            return $row;
        }

        public static function insert_uat($table, $fields, $where = ''){
            $where = (trim($where) != '') ? "WHERE {$where}" : $where;
            $query = mysqli_query(self::connect_uat(), "INSERT INTO ".self::$prefix.$table." SET {$fields} {$where}") or self::debug(mysqli_error(self::$connection_uat));

            if($query){
                return true;
            }
            return false;
        }

        public static function update_uat($table, $fields, $where = ''){
            $where = (trim($where) != '') ? "WHERE {$where}" : $where;
            $query = mysqli_query(self::connect_uat(), "UPDATE ".self::$prefix.$table." SET {$fields} {$where}") or self::debug(mysqli_error(self::$connection_uat));

            if($query){
                return true;
            }
            return false;
        }

        public static function insertedId_uat(){
            return mysqli_insert_id(self::$connection_uat);
        }
    }
?>