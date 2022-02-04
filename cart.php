<?php
    require_once("./bootstrap.php");

    if(isset($_SESSION["User"])){
        $user = $_SESSION["User"];
        $cart = $dbm->getFactory()->getUserCart($user->UserID);
        $items = $cart->Items;
        $requests = $dbm->getRequests();
        $templateParams["name"] = "cart_section.php";
        $templateParams["title"] = "Carrello";
    }
    else{
        header("location: /login.php");
    }

    require("./template/base.php");
?>