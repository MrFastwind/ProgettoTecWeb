<?php

use database\exceptions\UserNotExist;
use database\exceptions\WrongPassword;

require_once("./bootstrap.php");

    if(isset($_POST["username"]) && isset($_POST["password"])){
        try{
        $user = $shop->getUserManager()->login($_POST["username"], $_POST["password"]);
        }catch(WrongPassword $e){
            $templateParams["erroreLogin"] = "Password sbagliata";
        }catch(UserNotExist $e){
            $templateParams["erroreLogin"] = "User non esiste";
        }
    }

    if($shop->getUserManager()->isUserLogged()){
        header("location: /index.php");
    }
    else{
        $templateParams["title"] = "Login";
        $templateParams["name"] = "login_form.php";
    }

    require("./template/base.php");
?>