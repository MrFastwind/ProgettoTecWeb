<?php

use shop\exceptions\NoItemsInOrder;

require_once("./bootstrap.php");

    try{
    $user = $_SESSION["User"];
    $shop->getOrderManager()->makeOrdinationByUser($user->UserID);
    $templateParams["cartSuccess"] = "Grazie per l'acquisto. Puoi controllare lo stato del tuo ordine attraverso le";

    $templateParams["name"] = "cart_section.php";
    $templateParams["title"] = "Carrello";

    require("./template/base.php");
    }catch(NoItemsInOrder $e){
        header("location: index.php");
    }
?>