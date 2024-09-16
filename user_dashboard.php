<?php

session_start();
require_once"libraries/database.php";
require_once"libraries/utils.php";
require_once"libraries/models/Article.php";
    
$articleModel = new Article();


    if($_SESSION['role'] !== 'default'){

        redirect("index.php");
    }

    //recuperation des articles

 $articles = $articleModel->find_all();

// require"templates/users/user_dashboard_html.php";


render('users/user_dashboard', compact('articles'));

?>
