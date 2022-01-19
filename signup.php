<?php

require_once("./bootstrap.php");

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])){
        $user = $shop->getUserManager()->registerClient($_POST["username"], $_POST["password"], $_POST["email"]); //TODO: add error message in case of invalid email
        $shop->getUserManager()->login($user->Username,$_POST["password"]);
    }

    if($shop->getUserManager()->isUserLogged()){
        header("location: /index.php");
    }
    else{
        $templateParams["title"] = "Sign up";
        $templateParams["name"] = "signup_form.php";
    }

    require("./template/base.php");

?>