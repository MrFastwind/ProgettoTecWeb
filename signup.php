<?php

use shop\exceptions\EmailIsInvalid;

require_once("./bootstrap.php");

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])){
        try{
            $user = $shop->getUserManager()->registerClient($_POST["username"], $_POST["password"], $_POST["email"]);
            $shop->getUserManager()->login($user->Username,$_POST["password"]);
        }
        catch(EmailIsInvalid $e){
            $templateParams["erroreSignup"] = "Email non valida";
        }
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