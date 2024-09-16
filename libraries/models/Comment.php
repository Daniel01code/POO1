<?php
namespace Model;

require_once('libraries/models/Model.php');  
 

// namespace Models;

class Comment extends Model{

    protected $table="comments";
    
    // Insertion du commentaire
    public function insert($content,$article_id,$user_auth){

        $query = $this->pdo->prepare('INSERT INTO comments SET content_user = :content, id_article = :article_id,  user_id = :user_auth,created_at = NOW()');
        $query->execute(compact( 'content', 'article_id','user_auth'));
        
    }
    public function find_comment_fot_this_article($id_article){

        /* ***********************************gestion des commentaire***************************************************************************** */
        // $sql2="SELECT * FROM comments, users, articles  
        // WHERE comments.id_article = articles.id
        //  AND comments.user_id = users.id
        //  AND id_article = ?";
        $sql2= "SELECT comments.id,comments.user_id, comments.content_user, comments.created_at, users.username FROM comments
        JOIN users ON comments.user_id = users.id WHERE id_article = ?";

        $query = $this->pdo->prepare($sql2);
    
        $query->execute([$id_article]);
        return $query= $query->fetchAll();
    }


}
