<?php
$erreur="";
session_start();
require_once"libraries/utils.php";
require_once"libraries/models/Article.php";
    
$articleModel = new Article();


    // var_dump($_SESSION['role']);
    // die();
    if($_SESSION['role'] !== 'admin'){
        header("Location: index.php");
        exit();
    }
/*************************pour ajouter un article***************************************** */
    if (isset($_POST['add_article'])) {
    
        $articleModel->add();
    }
  

// Configuration
$articlesPerPage = 6; // Nombre d'articles par page
// Utilisation de filter_input pour une meilleure sécurité
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
// Récupération des articles depuis votre source de données
$allArticles = $articleModel->find_all("created_at DESC"); // Fonction pour récupérer tous les articles
$totalArticles = count($allArticles); // Nombre total d'articles
// Calcul du nombre total de pages
$totalPages = ceil($totalArticles / $articlesPerPage);
// Vérification de la validité de la page demandée
$page = max(1, min($page, $totalPages));
// Calcul des indices de début des articles à afficher
$startIndex = ($page - 1) * $articlesPerPage;
// Récupération des articles à afficher pour la page actuelle
$articles = array_slice($allArticles, $startIndex, $articlesPerPage);
   
// require"templates/admin/admin_dashboard_html.php";

render('admin/admin_dashboard', compact('articles','allArticles','totalPages','page','startIndex','totalArticles','articlesPerPage'));


?>

