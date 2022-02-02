<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php");
use api\response;
use database\exceptions\UserNotExist;
use database\exceptions\WrongPassword;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if(key_exists("logout",$_GET) && $_GET["logout"]){
    $shop->getUserManager()->logOut();
    echo Response::ok("Logged out");
}elseif (key_exists("user",$_POST) && key_exists("password",$_POST)) {
    if ($shop->getUserManager()->isUserLogged()){
        echo Response::error("User already logged on");
        return;
    }
    try{
        $shop->getUserManager()->login($_POST["user"],$_POST["password"]);
        echo Response::ok("Logged in");
    }catch(UserNotExist $e){
        echo Response::error("User doesn't exist");
    }catch(WrongPassword $e){
        echo Response::error("Wrong password");
    }
}else{
    if($shop->getUserManager()->isUserLogged()){
        $user= $_SESSION["User"];
        echo Response::ok("logged on",$user);
    }else{
        echo Response::error("not logged");
    }
}

?>