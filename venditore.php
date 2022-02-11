<?php

    require_once("./bootstrap.php");

    if(isset($_POST["productName"]) && isset($_POST["productDescription"]) && isset($_POST["quantity"]) && isset($_POST["price"]) && isset($_POST["category"])){
        $imageName = str_replace("/","",$_POST["productName"]);
        $user = $_SESSION["User"];
        $categoryId = array_search($_POST["category"],$dbm->getFactory()->getCategories());
        $dbm->getRequests()->createProduct($_POST["productName"], $_POST["productDescription"], "$imageName", $_POST["quantity"], $_POST["price"], $user->UserID, $categoryId);
        $templateParams["success"] = "Prodotto aggiunto";
    }

    $templateParams["title"] = "Vendi";
    $templateParams["name"] = "vendor_section.php";
    $categories = $dbm->getFactory()->getCategories();

    require("./template/base.php");
?>