<?php
namespace Models;


abstract class Model{
    protected $pdo;
    protected $table;

    public function __construct() {
        $this->pdo = \Database::getpdo();
    }
    public function get_info($id){
    
        $sql= $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        
        $sql->execute(compact('id'));
    
        
        return $item = $sql->fetch();
    }

    public function delete($id_article){
        $sql = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $sql->execute([$id_article]);
        return $sql-> rowCount();
    }
    public function find_all(?string $order=""){
        
        $sql="SELECT * FROM {$this->table}";
        // ORDER BY created_at DESC

        if($order){
            $sql .=" ORDER BY ". $order;  
        }
        $resultats = $this->pdo->query($sql);
        $articles = $resultats->fetchAll();
        return $articles;
    }
    function clean_input($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }  

 
}