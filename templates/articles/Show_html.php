
<h1 class="article-title"><?= $article['title']; ?></h1><br>

<p class="article-title"><?= $article['introduction']; ?></p><br>

<p class="article-title">poster le  <?= $article['created_at'];?></p><br>



<?php

// Afficher les commentaires
if (!empty($commentaires)) {
    echo"<h3>"."il y'a ".$nombre_de_commentaire." de reaction"."</h3>";
 
    echo "<div class='comments' classe='commentaire'>";
    foreach ($commentaires as $commentaire) {
        echo "<div class='comment'>";
       
        echo "<p class='comment-content'>"."commentaire de: " . $commentaire['username'] . "</p>";
        echo "<p class='comment-content'>" . $commentaire['content_user'] . "</p>";
        echo "<p class='comment-date'>" . $commentaire['created_at'] . "</p>";
        if($_SESSION['role'] == 'admin'){
            echo '<a href="delete_comment?id=' . $commentaire['id'] .
                '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce commentaire ?!\')">Supprimer</a>';
        }
        echo"<br>" . "<br>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p>Aucun commentaire pour cet article.</p>"; 
}

?>

<?php 
// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['auth'])) {
    ?>

    <form action="save-comment" method="POST" class="comment-form">
        <p><?= $erreur; ?></p>
        <h3 class="comment-form-heading"> Vous voulez reagir ? N'hesitez pas bros !</h3><br>

        <textarea name="content" cols="30" rows="10" placeholder="Votre commentaire ..."
        class="comment-form-content"></textarea><br>

        <input type="hidden" name="article_id" value="<?= $article['id']; ?>"><br>
        <input type="hidden" name="user_id" value="<?= $_SESSION['auth']['id']; ?>"><br>

        <button class="comment-form-submit">COMMENTER !</button><br>
    </form>

<?php 
} else {
    // Rediriger vers register.php si l'utilisateur n'est pas connecté
    echo '<p>Veuillez vous connecter ou vous inscrire pour commenter.</p>';
    echo '<a href="register.php">S\'inscrire</a> | <a href="login.php">Se connecter</a>';
}
?>
</div>