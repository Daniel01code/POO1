<?php

spl_autoload_register(function($class_name){

    $class_name = str_replace("\\","/",$class_name);
// require_once"libraries/controllers/Article.php"; 
    require_once("libraries/$class_name.php");
});