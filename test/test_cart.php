<?php

namespace test{
    include ("../bootstrap.php");

    use database\Cart;
    use database\DatabaseManager;
    use database\User;
    use database\Product;
    use shop\Shop;
    use Exception;
    use UnexpectedValueException;

class TestCart{

            private $user = "test_user";
            private $password = "test_user_password";
            private $email = "test@example.com";
            private $product = 'test_product';
            private Product $prod;
            private User $client;

        function __construct(private Shop $shop, private DatabaseManager $dbm){
        }

        public function beforeAll(){
            $this->client = $this->dbm->getFactory()->getUserBy($this->user);
            //check user exist
            //check product exist
            $products = $this->dbm->getFactory()->getProductsLike($this->product);
            if (empty($products)){
                $this->dbm->getRequests()->createProduct($this->product,$this->product,"",0,0,1,1,1);
                $products = $this->dbm->getFactory()->getProductsLike($this->product);
            }
            $this->prod = $products[0];
        }

        public function afterAll(){

        }

        public function getCartTest(){
            $cart = $this->dbm->getFactory()->getUserCart($this->client->UserID);
            assert(get_class($cart)=='database\Cart',"Not a cart?");
            if(array_key_exists($this->prod->ProductID,$cart->Items)){
                $this->dbm->getRequests()->removeItemFromCart($cart->CartID,$this->prod->ProductID);
            }
            assert($this->dbm->getRequests()->addItemToCart($cart->CartID,$this->prod->ProductID),"Should have added product to the cart!");
            $cart =$this->dbm->getFactory()->getUserCart($this->client->UserID);
            assert(array_key_exists($this->prod->ProductID,$cart->Items),"Should have the product");
            assert($this->dbm->getRequests()->updateQuantityInCart($cart->CartID,$this->prod->ProductID,5),"Should have updated product to the cart!");
            assert($this->dbm->getRequests()->removeItemFromCart($cart->CartID,$this->prod->ProductID),"Should have removed product to the cart!");
            $cart =$this->dbm->getFactory()->getUserCart($this->client->UserID);
            assert(!array_key_exists($this->prod->ProductID,$cart->Items),"Shouldn't have the product");
        }

        public function zeroItemTest(){
            $cart = $this->dbm->getFactory()->getUserCart($this->client->UserID);
            if(!array_key_exists($this->prod->ProductID,$cart->Items)){
                $this->dbm->getRequests()->addItemToCart($cart->CartID,$this->prod->ProductID);
            }
            try{
                $this->dbm->getRequests()->updateQuantityInCart($cart->CartID,$this->prod->ProductID,0);
            }catch(UnexpectedValueException $e){
            }
        }

        public function runTests(){
            $this->beforeAll();
            foreach(["getCartTest","zeroItemTest"] as $it){
                try{
                    call_user_func([$this,$it]);
                    echo "$it:OK<BR>";
                }catch(Exception $e){
                    echo "$it:Failed<BR>";
                    throw $e;
                }
            }
            $this->afterAll();
        }

    }
    (new TestCart($shop,$dbm))->runTests();

}
?>