<?php

namespace controllers;

require_once"libraries/utils.php";
require_once"libraries/models/Article.php";
require_once"libraries/models/Comment.php";

class Commentx{

    public function comments_save(){
        session_start();
    
        $articleModel = new Article();
        
        $commentModel = new Comment();
        if(!$_SESSION['auth']){
          redirect("index.php");
        }
        
        $user_auth = $_SESSION['auth']['id'];
        
        // var_dump($user_auth);
        // die();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
        
          $content = $_POST['content'] ?? null;
          $article_id = $_POST['article_id'] ?? null;
          //verification des donnees du formulaire
          if (!$user_auth || !$article_id || !$content) {
            die("Votre formulaire a été mal rempli !");
          }
          
          $content = htmlspecialchars($content);
          
            if (!$articleModel->get_info($article_id)) {
              die("Ho ! L'article $article_id n'existe pas boloss !");
          }
          
          $commentModel->insert($content,$article_id,$user_auth);
        
          // header("Location: article.php?id=" . $article_id);
          // exit;
          redirect("article.php?id=" . $article_id);
        }        

    }

    public function comments_delete(){

        session_start(); 
        $message="";
        
        $commentModel = new Comment();
        if($_SESSION['role'] !== 'admin'){
            header("Location: index.php");
            exit();
        }
        
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ! Fallait préciser le paramètre id en GET !");
        }
        
        $id_comment = $_GET['id'];
        
        $commentaire = $commentModel->get_info($id_comment); 
        
        if (empty($commentaire)){
            die("Aucun commentaire n'a l'identifiant $id_comment !");
        }else{
             
            $commentModel->delete($id_comment);
            
            redirect("article?id=".$commentaire['id_article']);
        }
    }

}