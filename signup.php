<?php

use function shop\login;
use function shop\registerClient;

require_once("./bootstrap.php");

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])){
        registerClient($_POST["username"], $_POST["password"], $_POST["email"], $dbm);
        registerLoggedUser(login($_POST["username"], $_POST["password"], $dbm));
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