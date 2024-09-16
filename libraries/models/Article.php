<?php

namespace Model;


require_once('libraries/models/Model.php');  


class Article extends Model{

    protected $table="articles";
        /**************************fonction specifices******************************************* */
    public function add(){

            $title = clean_input(filter_input(INPUT_POST, 'title', FILTER_DEFAULT));
            $slug = strtolower(str_replace(' ', '-', $title)); // Mise à jour du slug à partir du titre
            $introduction = clean_input(filter_input(INPUT_POST, 'introduction', FILTER_DEFAULT));
            $content = clean_input(filter_input(INPUT_POST, 'content', FILTER_DEFAULT));
            // var_dump($title);
            // die();
            // Validation des données
            if (empty($title) || empty($slug) || empty($introduction) || empty($content)) {
            $error = "Veuillez remplir tous les champs du formulaire !";
            } else {
            // Insertion du nouvel article dans la base de données
            $query = $this->pdo->prepare("INSERT INTO FROM {$this->table} (title, slug, introduction, content, created_at) VALUES (?, ?, ?, ?, 
            NOW())");
            $query->execute([$title, $slug, $introduction, $content]);
            }
        
    }
    public function Edit($title ,$slug , $introduction ,$content ,$articleId ){
    
            $sqlModification = "UPDATE {$this->table} SET title = ?, slug = ?, introduction= ?, content = ? WHERE id = ?";
            $rs_modif = $this->pdo->prepare($sqlModification);
            // Exécution de la requête
            $rs_modif->execute([$title, $slug, $introduction, $content, $articleId]);
            
    }
    
}