<?php
    require_once("./bootstrap.php");

    if(isset($_POST["productName"]) && isset($_POST["productDescription"]) && isset($_POST["quantity"]) && isset($_POST["price"]) && isset($_POST["category"])){
        //$dbm->addproduct();
        $templateParams["success"] = "Prodotto aggiunto";
    }

    $templateParams["title"] = "Vendi";
    $templateParams["name"] = "vendor_section.php";
    $templateParams["categories"] = $dbm->getFactory()->getCategories();

    require("./template/base.php");
?>