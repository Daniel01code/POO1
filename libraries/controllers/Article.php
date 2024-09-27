<?php


namespace controllers; 



class Article extends controller{

    protected $model_name = \Models\Article::class;
    public function index(){

        $articles = $this->model->find_all();

        // require"templates/articles/index_html.php";

        \Renderer::render('articles/index', compact('articles'));
    }
    public function show(){
        session_start();
        $erreur="";

        $commentModel = new \Models\Comment();
            
        $id_article = intval($_GET['id']);

        //$article_id = filter_input(INPUT_GET, 'id' , FILTER_VALIDATE_INT);//filtre l'id

        if($id_article===null || $id_article===false){
            die("vous dever préciser un paramètre id valide de l'url !");
        }

        $article = $this->model->get_info($id_article,"articles");

        // nombre de commentaires
        $nombre_de_commentaire= count($commentModel->find_comment_fot_this_article($id_article));

        //on fouille les commentaires consernant l'article
        $commentaires = $commentModel->find_comment_fot_this_article($id_article);


        // require"templates/articles/show_html.php";

        \Renderer::render('articles/show', compact('article','commentaires','nombre_de_commentaire','erreur'));

    }
    public function delete(){
        session_start(); 

        $message="";

        if($_SESSION['role'] !== 'admin'){

            \Http::redirect("index.php");
        }

        if(isset($_GET['id'])){
            $id_article =  (intval( $_GET['id']));

            if($this->model->delete($id_article)> 0){
                $message ="<p class='success'>delete success</p>";
                
                \Http::redirect("admin_dashboard.php");

            }else{
                $message ="auccun livre touvé";
                \Http::redirect("admin_dashboard.php");
            }

        }else{
            echo" entrer dans l'url une id valide";
        }

            
    }

    public function updates(){

        session_start();


        if($_SESSION['role'] !== 'admin'){
            header("Location: index.php");
            exit();
        }

        $message = "";
        // Récupération des informations d'un article à modifier
        if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)){

        $articleId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        $article = $this->model->get_info($articleId );
        
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
        function clean_input($data){
            return htmlspecialchars(stripslashes(trim($data)));
        }
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

            $this->model->Edit($title ,$slug , $introduction ,$content ,$articleId );
            // Message de succès
            $message = "<p style='text-align:center; color: #fff;padding:20px; background:green;margin-top:10px; width:300px'> 
            Étudiant modifié avec success</p>";
        }
        }

        \Renderer::render('articles/edit_article', compact('message','title','slug','introduction','content','articleId'));


    }
    public function dashbordadmin(){
        $erreur="";
        session_start();

        if($_SESSION['role'] !== 'admin'){
            
            \Http::redirect('index.php');
        }
        /*************************pour ajouter un article***************************************** */
            if (isset($_POST['add_article'])) {
            
                $this->model->add();
            }
        

        // Configuration
        $articlesPerPage = 6; // Nombre d'articles par page
        // Utilisation de filter_input pour une meilleure sécurité
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        // Récupération des articles depuis votre source de données
        $allArticles = $this->model->find_all("created_at DESC"); // Fonction pour récupérer tous les articles
        $totalArticles = count($allArticles); // Nombre total d'articles
        // Calcul du nombre total de pages
        $totalPages = ceil($totalArticles / $articlesPerPage);
        // Vérification de la validité de la page demandée
        $page = max(1, min($page, $totalPages));
        // Calcul des indices de début des articles à afficher
        $startIndex = ($page - 1) * $articlesPerPage;
        // Récupération des articles à afficher pour la page actuelle
        $articles = array_slice($allArticles, $startIndex, $articlesPerPage);
        

        \Renderer::render('admin/admin_dashboard', compact('articles','allArticles','totalPages','page','startIndex','totalArticles','articlesPerPage'));


    }

}