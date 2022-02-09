<?php
    require_once("./bootstrap.php");

    if(isset($_SESSION["User"])){
        $user = $_SESSION["User"];
        $cart = $dbm->getFactory()->getUserCart($user->UserID);
        $items = $cart->Items;
        $price = 0;
        foreach($items as $item){
            $product = $dbm->getFactory()->getProduct($item->ProductID);
            $price += ($product->Price * $product->Quantity);
        }
        $templateParams["name"] = "cart_section.php";
        $templateParams["title"] = "Carrello";
    }
    else{
        header("location: /login.php");
    }

    require("./template/base.php");
?>