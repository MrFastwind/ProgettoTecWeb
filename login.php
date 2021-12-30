<?php

use function shop\login;

require_once("./bootstrap.php");

    if(isset($_POST["username"]) && isset($_POST["password"])){
        $result = login($_POST["username"], $_POST["password"], $dbm);
        if(!$result){
            $templateParams["erroreLogin"] = "Username o password errati";
        }
        else{
            registerLoggedUser($result);
        }
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