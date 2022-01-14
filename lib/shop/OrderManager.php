<?php
namespace shop{

    use database\DatabaseManager;
    use shop\exceptions\NoItemsInOrder;

class OrderManager{
        function __construct(private DatabaseManager $dbm){}

        public function makeOrdinationByUser(int $user):bool{
            $cart = $this->dbm->getFactory()->getUserCart($user);
            if(empty($cart->Items)){
                throw new NoItemsInOrder($cart->CartID);
            }
            return $this->dbm->getRequests()->createOrderFromUserCart($user);
        }
    }
}
?>