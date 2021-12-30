<?php
function isActive($pagename){
    if(basename($_SERVER['PHP_SELF'])==$pagename){
        echo " class='active' ";
    }
}

function getIdFromName($name){
    return preg_replace("/[^a-z]/", '', strtolower($name));
}

function isUserLoggedIn(){
    return !empty($_SESSION['username']);
}

function registerLoggedUser($user){
    $_SESSION["username"] = $user->Username;
    $_SESSION["isClient"] = $user->isClient;
    $_SESSION["isVendor"] = $user->isVendor;
}

?>