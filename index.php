<?php
    require_once("./bootstrap.php");

    $templateParams["title"] = "Home";
    $templateParams["name"] = "home.php";
    $products = $dbm->getFactory()->getProducts(0, 4, true);

    require("./template/base.php");
?>