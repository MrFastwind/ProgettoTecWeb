<?php
    require_once("./bootstrap.php");

    if(isset($_POST["productName"]) && isset($_POST["productDescription"]) && isset($_POST["quantity"]) && isset($_POST["price"]) && isset($_POST["category"])){
        $user = $_SESSION["User"];
        $dbm->getRequests()->createProduct($_POST["productName"], $_POST["productDescription"], "IMG_DIR/{$_POST["productName"]}.png", $_POST["quantity"], $_POST["price"], $user->UserID, $_POST["category"]);
        $templateParams["success"] = "Prodotto aggiunto";
    }

    $templateParams["title"] = "Vendi";
    $templateParams["name"] = "vendor_section.php";
    $categories = $dbm->getFactory()->getCategories();

    require("./template/base.php");
?>