<?php
    require_once("./bootstrap.php");

    $templateParams["title"] = "Catalogo";
    $templateParams["name"] = "categorie.php";
    $templateParams["categorie"] = $dbm->getFactory()->getCategories();
    require("./template/base.php");
?>