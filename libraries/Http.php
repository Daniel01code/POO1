<?php


class Http{
    public static function redirect(string $url){
        header("location: $url");
        exit();
    }
}