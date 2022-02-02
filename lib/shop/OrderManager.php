<?php
namespace shop{

    use database\Cart;
    use database\DatabaseManager;
    use database\OrderStatus;
    use shop\exceptions\NoItemsInOrder;

class OrderManager{
    protected NotificationFactory $notify;
        
    function __construct(private DatabaseManager $dbm){
        $this->notify = new NotificationFactory($this->dbm->getRequests());
    }
    
    /**
     * makeOrdinationByUser
     * make order form the current user cart and send notification
     * @param  int $user
     * @return bool
     */
    public function makeOrdinationByUser(int $user):bool{
        $cart = $this->dbm->getFactory()->getUserCart($user);
        if(empty($cart->Items)){
            throw new NoItemsInOrder($cart->CartID);
        }
        $success = $this->dbm->getRequests()->createOrderFromUserCart($user);
        if($success){
            $this->notify->notifyOrderCreation($user,$this->dbm->getRequests()->getOrderFromCart($cart->CartID)['OrderID']);
            //Check Product For Out of Stock
            $this->checkLastOrder($cart);
        }
        return $success;
    }

    public function updateOrderStatus(int $orderId,OrderStatus $status):bool
    {
        //Update Status
        if(!$this->dbm->getRequests()->updateOrderStatus($orderId,$status)){
            return false;
        }
        $order = $this->dbm->getRequests()->getOrder($orderId);
        if(empty($order)){
            return true;
        }
        $userId = $this->dbm->getRequests()->getUserIdByCart($order['CartID']);
        if(!$userId){
            return true;
        }
        $this->notify->notifyOrderProgress($userId,$orderId);
        return true;

    }

    private function checkLastOrder(Cart $cart){
        $items = $cart->Items;
        foreach ($items as $key => $value) {
            $productId = $value->ProductID;
            $product = $this->dbm->getFactory()->getProduct($productId);
            if($product->Quantity<1){
                $this->notify->notifyProductOutOfStock($product);
            }
        }
    }
}
}
?>