<?php
    require_once("./bootstrap.php");

    if(isset($_POST["search"])){
        $templateParams["prodotti"] = $dbm->getFactory()->getProductsLike($_POST["search"], 0, 10);
    }

    $templateParams["title"] = "Prodotti";
    $templateParams["name"] = "products_section.php";

    require("./template/base.php");
?>