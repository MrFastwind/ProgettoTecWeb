<?php
namespace test{

    use database\DatabaseManager;
    use shop\Shop;

require_once("../bootstrap.php");

    class TestProduct{

        function __construct(private Shop $shop, private DatabaseManager $dbm){
        }


        public function TestObjectToArray()
        {
            $product=$this->dbm->getFactory()->getProducts();
            assert(count($product)>0,"No Product in array");
            $product = $product[0];
            print_r($product);
            echo "<br>";
            print_r($product->getAsArray());
        }

    }

    $test = new TestProduct($shop,$dbm);
    $test->TestObjectToArray();


}
?>