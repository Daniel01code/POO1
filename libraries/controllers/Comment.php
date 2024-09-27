<?php

namespace controllers;


class Comment extends controller{
  protected $model_name = \Models\Comment::class;


    public function save(){
        session_start();
    
        $articleModel = new \Models\Article();
        
        if(!$_SESSION['auth']){
          \Http::redirect("index.php");
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
          
          $this->model->insert($content,$article_id,$user_auth);
        
          // header("Location: article.php?id=" . $article_id);
          // exit;
          \Http::redirect("article.php?id=" . $article_id);
        }        

    }

    public function delete(){

        session_start(); 
        $message="";
        
        if($_SESSION['role'] !== 'admin'){

            \Http::redirect("index.php");
        }
        
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ! Fallait préciser le paramètre id en GET !");
        }
        
        $id_comment = $_GET['id'];
        
        $commentaire = $this->model->get_info($id_comment); 
        
        if (empty($commentaire)){
            die("Aucun commentaire n'a l'identifiant $id_comment !");
        }else{
             
          $this->model->delete($id_comment);
            
          \Http::redirect("article?id=".$commentaire['id_article']);
        }
    }

}