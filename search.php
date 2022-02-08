<?php
    require_once("./bootstrap.php");

    if(isset($_GET["search"])){
        $products = $dbm->getFactory()->getProductsLike($_GET["search"], 0, 10);
    }

    $templateParams["title"] = "Prodotti";
    $templateParams["name"] = "products_section.php";

    require("./template/base.php");
?>