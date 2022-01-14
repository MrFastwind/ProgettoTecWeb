<?php
namespace test{
    include ("../bootstrap.php");
    include_once("TestCase.php");

    use database\Cart;
    use database\DatabaseManager;
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
            $order = $this->dbm->getRequests()->getOrderFromCart($this->cart->CartID);
            if(!empty($order)){
                $this->dbm->getRequests()->deleteOrder($order['OrderID']);
            }
            
            $this->dbm->getRequests()->deleteCartOfUser($this->userid);
        }

        public function testOrderWithEmptyCart(){
            try{
                $this->shop->getOrderManager()->makeOrdinationByUser($this->userid);
            }catch(NoItemsInOrder $e){
            }
        }

        public function testOrder(){
            $this->dbm->getRequests()->addItemToCart($this->dbm->getFactory()->getUserCart($this->userid)->CartID,$this->itemid);
            assert($this->shop->getOrderManager()->makeOrdinationByUser($this->userid),"Should have made the Order");
        }

    }
    new TestOrder($shop,$dbm);


}
?>