<?php
function render(string $path,array $variables = []){

    // ['var1' => 1, 'var2' => 2, 'var3' => 3];

    // 'var1' =1
    // 'var2' =2
    // 'var3' =3

    extract($variables);
    //debut du tampon de la page de sortie
    ob_start();

    //contenu de la page
    require"templates/" .$path. "_html.php";

    //recuperation du contenu tempon

    $pagecontent = ob_get_clean();

    //inclusion du template de la page de sortie
    require"templates/layout_html.php";

}
/*fonction de direction vers la page d'acceuille */

function redirect(string $url){
    header("location: $url");
    exit();
}


