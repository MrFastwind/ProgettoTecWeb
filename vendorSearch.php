<?php
    require_once("./bootstrap.php");

    $categories = $dbm->getFactory()->getCategories();
    $templateParams['name'] = "vendorSearch_section.php";
    $templateParams['title'] = "Cerca...";

    require("./template/base.php");
?>