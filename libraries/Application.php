<?php


class Application{

    public static function process(){

        $name_controller = "Article";

        $task ="index";

        if(!empty($_GET['controller'])){
            $name_controller = ucfirst($_GET['controller']);
        }
        if(!empty($_GET['task'])){
            $task= $_GET['task'];

        }

        $name_controller = "\controllers\\" . $name_controller;

        $controller = new $name_controller();
        $controller->$task();

    }

}