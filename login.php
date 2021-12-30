<?php


require_once("./bootstrap.php");

    if(isset($_POST["username"]) && isset($_POST["password"])){
        $user = $shop->getUserManager()->login($_POST["username"], $_POST["password"]); //TODO: add error message in case of wrong pw
        registerLoggedUser($result);
    }

    if(isUserLoggedIn()){
        $templateParams["title"] = "Home";
        $templateParams["name"] = "home.php";
    }
    else{
        $templateParams["title"] = "Login";
        $templateParams["name"] = "login-form.php";
    }

    require("./template/base.php");
?>