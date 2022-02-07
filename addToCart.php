<?php
    require_once("./bootstrap.php");

    if($shop->getUserManager()->isUserLogged()){
        $user = $_SESSION["User"];
        $cart = $dbm->getFactory()->getUserCart($user->UserID);
        if(isset($_POST["product"]) && isset($_POST["quantity"])){
            $dbm->getRequests()->addItemToCart($cart->CartID, $_POST["product"], $_POST["quantity"]);
            $templateParams["cartSuccess"] = "Prodotto aggiunto al carrello correttamente";
            header("location: /cart.php"); //TODO: il buraz non deve finire nel carrello
        }
    }
    else{
        header("location: /login.php");
    }
?>