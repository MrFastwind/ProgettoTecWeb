<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php");
use api\response;
use database\exceptions\DoesNotExist;
use database\exceptions\NoCart;
use database\exceptions\NotClient;

if(!$shop->getUserManager()->isUserLogged()){
    echo Response::error("User Not Logged");
    return;
}
$user = $shop->getUserManager()->getSessionUser();
try{
    $cartId=$dbm->getRequests()->getClientCartId($user->UserID);
}catch(NoCart $e){
    $dbm->getRequests()->createCartForUser($user->UserID);
    $cartId=$dbm->getRequests()->getClientCartId($user->UserID);
}catch(NotClient $e){
    echo Response::error("User is not a client");
    return;
}
//if ID is set -> set the id
if(key_exists("cart_id",$_GET)){
    $cartId=$_GET["cart_id"];
    if($dbm->getRequests()->getUserIdByCart($cartId)!=$user->UserID){
        echo Response::error("Cart doesn't exist");
        return;
    }
}

if(key_exists("product_id",$_GET)){
    $productId=$_GET["product_id"];
    
    $item = $dbm->getRequests()->getItemFromCartAndProduct($cartId,$productId);
    if(key_exists("quantity",$_GET)){
        //Setting
        $quantity=$_GET["quantity"];
        if($quantity==0){
            $dbm->getRequests()->removeItemFromCart($cartId,$productId);
            echo Response::ok("Item removed!");
            return;
        }
        
        if(empty($item)){
            $dbm->getRequests()->addItemToCart($cartId,$productId,$quantity);
            echo Response::ok("Item added!");
            return;
        }else{
            $dbm->getRequests()->updateQuantityInCart($cartId,$productId,$quantity);
            echo Response::ok("Item updated!");
            return;
        }
    }else{
        //Getting
        if(empty($item)){
            echo Response::ok("item is empty",["quantity"=>0]);
            return;
        }
        echo Response::ok("item is present",["quantity"=>$item["Quantity"]]);
        return;
    }
}else{
    if(key_exists("total",$_GET)){
        try{
            $dbm->getFactory()->getCart($cartId);
            $total = $dbm->getRequests()->calculateTotalSum($cartId);
        }catch(DoesNotExist $e){
            echo Response::error($e->getMessage());
            return;
        }
        echo Response::ok("Success",$total);
        return;
    }else{
    try{
        $cart = $dbm->getFactory()->getCart($cartId);
    }catch(DoesNotExist $e){
        echo Response::error($e->getMessage());
        return;
    }
    echo Response::ok("Success",$cart);
    return;
    }
}

?>