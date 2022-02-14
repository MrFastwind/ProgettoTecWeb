<?php
    require_once("./bootstrap.php");

    if($shop->getUserManager()->isUserLogged() && $shop->getUserManager()->getSessionUser()->isClient){
        $user = $_SESSION["User"];
        $cart = $dbm->getFactory()->getUserCart($user->UserID);
        if(isset($_POST["product"]) && isset($_POST["quantity"])){
            $dbm->getRequests()->addItemToCart($cart->CartID, $_POST["product"], $_POST["quantity"]);
            $templateParams["cartSuccess"] = "Prodotto aggiunto al carrello correttamente";
            header("location: /cart.php");
        }
    }
    else{
        header("location: /login.php");
    }
?>