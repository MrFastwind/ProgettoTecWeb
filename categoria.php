<?php
    require_once("./bootstrap.php");
    
    $templateParams["categorie"] = $dbm->getFactory()->getCategories();
    if(!isset($_GET["id"])|| !key_exists($_GET["id"],$templateParams["categorie"])){
        header("location: catalogo.php");
    }
    $products = $dbm->getFactory()->getProductsByCategory($_GET["id"], 0, 10);
    $templateParams["title"] = $templateParams["categorie"][$_GET["id"]];
    $templateParams["name"] = "categoria_section.php";

    require("./template/base.php");
?>