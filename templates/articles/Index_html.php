<h1>liste des article</h1>
<div>
    <?php foreach($articles as $article) : ?>

        <h2> <?= $article['title']?> </h2>
        <p> <?= $article['introduction'] ?> </p>
        
        <a href="article.php?id=<?=$article['id'] ?>">voir plus</a>

    <?php endforeach ?>
</div>
