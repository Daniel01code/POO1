<?php


namespace controllers; 

require_once"libraries/utils.php";
require_once"libraries/models/Article.php";
require_once"libraries/models/Comment.php";


class Articles{

    public function index(){
        $articleModel = new Article();


        $articles = $articleModel->find_all();

        // require"templates/articles/index_html.php";

        render('articles/index', compact('articles'));
    }
    public function show(){
        session_start();
        $erreur="";
            
        $articleModel = new Article();

        $commentModel = new Comment();
            
        $id_article = intval($_GET['id']);

        //$article_id = filter_input(INPUT_GET, 'id' , FILTER_VALIDATE_INT);//filtre l'id

        if($id_article===null || $id_article===false){
            die("vous dever préciser un paramètre id valide de l'url !");
        }

        $article = $articleModel->get_info($id_article,"articles");

        // nombre de commentaires
        $nombre_de_commentaire= count($commentModel->find_comment_fot_this_article($id_article));

        //on fouille les commentaires consernant l'article
        $commentaires = $commentModel->find_comment_fot_this_article($id_article);


        // require"templates/articles/show_html.php";

        render('articles/show', compact('article','commentaires','nombre_de_commentaire','erreur'));

    }
    public function delete(){
        session_start(); 

        $message="";
        
        $articleModel = new Article();

        if($_SESSION['role'] !== 'admin'){
                header("Location: index.php");
                exit();
        }

        if(isset($_GET['id'])){
            $id_article =  clean_input((intval( $_GET['id'])));

            if($articleModel->delete($id_article)> 0){
                $message ="<p class='success'>delete success</p>";
                
                redirect("admin_dashboard.php");

            }else{
                $message ="auccun livre touvé";
                redirect("admin_dashboard.php");
            }

        }else{
            echo" entrer dans l'url une id valide";
        }

            
    }

    public function updates(){

        session_start();
            
        $articleModel = new Article();


        if($_SESSION['role'] !== 'admin'){
            header("Location: index.php");
            exit();
        }

        $message = "";
        // Récupération des informations d'un article à modifier
        if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)){

        $articleId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        $article = $articleModel->get_info($articleId );
        
        if (!$article){
            echo "<p style='color: #fff;padding:20px; background:#FF6600; width:400px'>L'article n'existe pas.</p>";
        }else{
            // Récupération des données
            $title = $article['title'] ?? "";
            $slug = $article['slug'] ?? "";
            $introduction = $article['introduction'] ?? "";
            $content = $article['content'] ?? "";
        }

        }

        //verification de l'existance du contenu de la variabe message pour vouloir l'affiché
        if (isset($message)) {
        "<p style='color: #fff;padding:20px; background:#FF6600; width:400px'>$message</p>";
        }
        //traitement du formulaire de mise a jour
        if (isset($_POST['update'])) {
        // Nettoyage des entrées
        $title = clean_input(filter_input(INPUT_POST, 'title', FILTER_DEFAULT));
        $slug = strtolower(str_replace(' ', '-', $title)); // Mise à jour du slug à partir du titre
        $introduction = clean_input(filter_input(INPUT_POST, 'introduction', FILTER_DEFAULT));
        $content = clean_input(filter_input(INPUT_POST, 'content', FILTER_DEFAULT));
        $articleId = clean_input(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));
        
        // Validation des 
        
        if (empty($title) || empty($slug) || empty($introduction) || empty($content)) {
            $message = "Veuillez remplir tous les champs du formulaire !";
        } else {

            $articleModel->Edit($title ,$slug , $introduction ,$content ,$articleId );
            // Message de succès
            $message = "<p style='text-align:center; color: #fff;padding:20px; background:green;margin-top:10px; width:300px'> 
            Étudiant modifié avec success</p>";
        }
        }

        render('articles/edit_article', compact('message','title','slug','introduction','content','articleId'));


    }

}