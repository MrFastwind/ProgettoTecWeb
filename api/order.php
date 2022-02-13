<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php");
use api\response;
use database\OrderStatus;
use database\User;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");



if(!key_exists('id',$_GET)){
    echo Response::error("No order id!");
    return;
}
$id = $_GET['id'];

$order = $dbm->getRequests()->getOrder($id);

if(empty($order)){
    echo Response::error("Order doesn't exist!");
    return;
}

$logged=$shop->getUserManager()->isUserLogged();


if(key_exists('status',$_GET)){
    if(!$logged){
        http_response_code(401);
        echo Response::error("not logged");
        return;
    }
    if(!$_SESSION["User"]->isVendor){
        http_response_code(403);
        echo Response::error("no permission");
    }

    try{
    $orderStatus = OrderStatus::getStatusByString($_GET["status"]);
    }catch(ValueError $e){
        echo Response::error($e->getMessage());
        return;
    }
    if($shop->getOrderManager()->updateOrderStatus($id,$orderStatus)){
        echo Response::ok();
    }else{
        http_response_code(503);
        echo Response::error("Internal Error");
    }
}else{
    try{
        $order=$dbm->getFactory()->getOrder($id);
        $pl;
        try{
            $userId = $dbm->getRequests()->getUserIdByCart($order->CartID);
            $user = $dbm->getFactory()->getUser($userId);
            $pl = ["status"=>$order->OrderStatusID,"user"=>$user->Username];
        }catch(User $e){
            $pl = ["status"=>$order->OrderStatusID];
        }
        echo Response::ok(data: $pl);
    }catch(Exception $e){
        echo Response::error("No order with that id");
    }
}

?>