<?php
    require_once("./bootstrap.php");

    $templateParams["title"] = "Home";
    $templateParams["name"] = "home.php";
    $templateParams["prodotti"] = $dbm->getFactory()->getProducts(0, 4, true);

    require("./template/base.php");
?>