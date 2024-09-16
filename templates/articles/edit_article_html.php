<div class="admin">
 <div class="article adm">
 <span style='color:#FF6600 ; font-size:4rem; text-align:center; font-weight: 
 700px;'>Adminitrateur : </span>
 </div>
 <?php
 if (isset($message)) {
 echo $message;
 }
 ?>
<h1>Éditer un article</h1>
<form method="POST" action="edit_article">

<input type="hidden" name="id" value="<?= $articleId; ?>">
<label for="title">Titre :</label>

<input type="text" name="title" id="title" value="<?= $title; ?>">
<input type="hidden" type="text" name="slug" id="slug" value="<?= $slug; ?>">
<br>

<label for="introduction">Introduction :</label>
<textarea name="introduction" id="introduction"><?= $introduction; ?></textarea>
<br>

<label for="content">Contenu :</label>
<textarea name="content" id="content"><?= $content;?></textarea>
<br>

<input type="submit" name='update' value="Éditer">
<div class="article adm">
<a href="admin_dashboard.php">retout au tableau de bord</a>
</div>
</form>

</div>
