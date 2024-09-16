<?php
require_once"libraries/controllers/Articles.php";

$deleteModel = new Articles();

$deleteModel->delete();

?>