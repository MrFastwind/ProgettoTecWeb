<?php
namespace test{
    include ("../bootstrap.php");
    include_once("TestCase.php");

    use database\Cart;
    use database\DatabaseManager;
    use database\exceptions\ExceedProductAvailability;
    use shop\exceptions\NoItemsInOrder;
    use shop\Shop;


    class TestOrder extends TestCase{
        private string $user = "test_user";
        private int $userid = -1;
        private int $itemid = -1;
        private Cart $cart;

        function __construct(private Shop $shop, private DatabaseManager $dbm){
            parent::__construct();
        }

        public function beforeAll()
        {
            $this->userid = $this->dbm->getFactory()->getUserBy($this->user)->UserID;
            $this->itemid = $this->dbm->getFactory()->getProducts(0,1,true)[0]->ProductID;
        }

        public function beforeEach(){
            $this->dbm->getRequests()->createCartForUser($this->userid);
            $this->cart = $this->dbm->getFactory()->getUserCart($this->userid);
        }

        public function afterEach(){
            //var_dump($this->cart);
            $this->dbm->getRequests()->deleteCart($this->cart->CartID);
        }

        public function testOrderWithEmptyCart(){
            try{
                $this->shop->getOrderManager()->makeOrdinationByUser($this->userid);
            }catch(NoItemsInOrder $e){
            }
        }

        public function testOrder(){
            //add item to product
            $this->dbm->getRequests()->changeProductQuantity($this->itemid,1);
            $this->dbm->getRequests()->addItemToCart($this->dbm->getFactory()->getUserCart($this->userid)->CartID,$this->itemid);
            assert($this->shop->getOrderManager()->makeOrdinationByUser($this->userid),"Should have made the Order");
            $this->dbm->getRequests()->deleteCartOfUser($this->userid);
            $order = $this->dbm->getRequests()->getOrderFromCart($this->cart->CartID);
            assert(!empty($order),"Order shouldn't be empty");
            assert(is_array($order),"Order should be an array");
            assert($this->dbm->getRequests()->deleteOrder($order['OrderID']),"Should have deleted the order");
        }

        public function testOrderWithExceedingQuantity(){
            $this->dbm->getRequests()->addItemToCart($this->dbm->getFactory()->getUserCart($this->userid)->CartID,$this->itemid);
            try{
            $this->shop->getOrderManager()->makeOrdinationByUser($this->userid);
            assert(false,"Should have throw ExceedProductAvailability");
            }catch(ExceedProductAvailability $e){}
        }

        public function testGetUserOrders(){
            $this->dbm->getRequests()->changeProductQuantity($this->itemid,1);
            $num = count($this->dbm->getRequests()->getAllOrderOfUser($this->userid));
            $this->dbm->getRequests()->addItemToCart($this->dbm->getFactory()->getUserCart($this->userid)->CartID,$this->itemid);
            assert($this->shop->getOrderManager()->makeOrdinationByUser($this->userid),"Should have made the Order");
            $this->dbm->getRequests()->deleteCartOfUser($this->userid);
            $order = $this->dbm->getRequests()->getOrderFromCart($this->cart->CartID);
            //var_dump($this->dbm->getRequests()->getAllOrderOfUser($this->userid));
            assert(count($this->dbm->getRequests()->getAllOrderOfUser($this->userid))-$num==1,"Should be 1");
            assert(!empty($order),"Order shouldn't be empty");
            assert(is_array($order),"Order should be an array");
            assert($this->dbm->getRequests()->deleteOrder($order['OrderID']),"Should have deleted the order");
        }

    }
    new TestOrder($shop,$dbm);


}
?>