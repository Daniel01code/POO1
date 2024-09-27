<?php

class Database{

    private static $instance = null;

    public static function getpdo(){
        if(self::$instance===null){
            $dsn = 'mysql:host=127.0.0.1;dbname=blogphp-stage2024;charset=utf8';
            $user = 'root';
            $pass = '';
            
            try {
                self::$instance = new PDO($dsn, $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            
            } catch(PDOException $error ) {
                echo 'Une erreur est survenue : '.$error->getMessage();
            }
        }
        return self::$instance;
    } 
    
}



    

?>