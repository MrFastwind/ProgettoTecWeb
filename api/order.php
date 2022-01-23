<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php");
use api\response;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if (!$shop->getUserManager()->isUserLogged()){
    Response::error("Bad Login");
}

if(!key_exists('id',$_GET)){
    Response::error("no order id!");
}

if(key_exists('status',$_GET)){
    //Set Status
    $shop->getOrderManager()->updateOrderStatus($id,$status);
}else{
    //get Status
}

?>