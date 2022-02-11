<?php
    require_once("./bootstrap.php");

    if(isset($_GET['vendorChoice'])){
        $vendorChoice = $dbm->getFactory()->getProduct($_GET['vendorChoice']);
        $categories = $dbm -> getFactory()->getCategories();
        $templateParams["name"] = "modifica_section.php";
        $templateParams["title"] = "modifica";
        if(isset($_POST["productDescription"]) && isset($_POST["quantity"]) && isset($_POST["price"])){
            $dbm->getRequests()->changeProductPrice($vendorChoice->ProductID, $_POST['price']);
            $dbm->getRequests()->changeProductQuantity($vendorChoice->ProductID, $_POST['quantity']);
            $dbm->getRequests()->changeProductDescription($vendorChoice->ProductID, $_POST["productDescription"]);

            $templateParams['success'] = "Prodotto modificato correttamente";
            $vendorChoice = $dbm->getFactory()->getProduct($_GET['vendorChoice']);
        }
    }

    require("./template/base.php");
?>