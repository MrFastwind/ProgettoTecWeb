<?php
namespace shop{

    use database\DatabaseManager;
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
        }
        return $success;
    }
}
}
?>