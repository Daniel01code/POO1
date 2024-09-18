<?php
namespace controllers;

abstract class controller{

    protected $model;
    protected $model_name;

    public function __construct(){
        $this->model=new $this->model_name;
    }

}
