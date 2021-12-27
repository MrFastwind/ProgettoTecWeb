<?php
    require_once("./bootstrap.php");

    if(isset($_POST["username"]) && isset($_POST["password"])){
        $result = $dbh->checkLogin($_POST["username"], $_POST["password"]);
        if(count($result)==0){
            $templateParams["erroreLogin"] = "Username o password errati";
        }
        //else{
            //registerLoggedUser($result[0]);//
        //}
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