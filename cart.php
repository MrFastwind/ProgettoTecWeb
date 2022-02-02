<?php
    require_once("./bootstrap.php");

    if(isset($_SESSION["User"])){
        $user = $_SESSION["User"];
        $templateParams["cart"] = $dbm->getFactory()->getUserCart($user->UserID);
    }
    else{
        $templateParams["name"] = "login.php";
    }

    require("./template/base.php");
?>