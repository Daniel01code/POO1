<?php

$dsn = 'mysql:host=127.0.0.1;dbname=blogphp-stage2024;charset=utf8';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
   
} catch(PDOException $error ) {
    echo 'Une erreur est survenue : '.$error->getMessage();
}
?>