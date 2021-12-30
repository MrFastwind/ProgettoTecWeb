<?php

require_once("./bootstrap.php");

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])){
        $user = $shop->getUserManager()->registerClient($_POST["username"], $_POST["password"], $_POST["email"]); //TODO: add error message in case of invalid email
        registerLoggedUser($user);
    }

    if(isUserLoggedIn()){
        $templateParams["title"] = "Home";
        $templateParams["name"] = "home.php";
    }
    else{
        $templateParams["title"] = "Sign up";
        $templateParams["name"] = "signup_form.php";
    }

    require("./template/base.php");

?>