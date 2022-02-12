<?php
namespace test{

    use database\DatabaseManager;
    use shop\Shop;

require_once("../bootstrap.php");
require_once("TestCase.php");

    class TestProduct extends TestCase{

        function __construct(private Shop $shop, private DatabaseManager $dbm){
            parent::__construct();
        }


        public function TestObjectToArray()
        {
            $product=$this->dbm->getFactory()->getProducts();
            assert(count($product)>0,"No Product in array");
            $product = $product[0];
            //print_r($product);
            //echo "<br>";
            //print_r($product->getAsArray());
        }

    }
    new TestProduct($shop,$dbm);
}
?>