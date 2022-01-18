<?php
    require_once("./bootstrap.php");

    $templateParams["title"] = "Home";
    $templateParams["name"] = "home.php";
    $templateParams["prodotti"] = $dbm->getRequests()->getRandomProducts($n=4);

    require("./template/base.php");
?>