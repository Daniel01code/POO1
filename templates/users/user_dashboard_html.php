<h1>hello
    <?= isset($_SESSION["auth"]['username']) ? $_SESSION["auth"]['username'] : "" ?>
</h1>
<h1>liste des article</h1>
<div>
    <?php foreach($articles as $article) : ?>

        <h2> <?= $article['title'];?> </h2>
        <p> <?= $article['introduction']; ?> </p>
        
        <a href="article.php?id=<?= $article['id']; ?>">voir plus</a>

    <?php endforeach ?>
</div>