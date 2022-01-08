<?php
namespace test{

    use database\DatabaseManager;
    use shop\Shop;

    include_once("../bootstrap.php");
    include_once("TestCast.php");

    class TestOrder extends TestCase{
        private $user = "test_user";
        private $password = "test_user_password";
        private $email = "test@example.com";

        function __construct(private Shop $shop, private DatabaseManager $dbm){
            parent::__construct();
        }

        public function beforeAll()
        {
            $this->userid = $this->dbm->getFactory()->getUserBy($this->user);
        }

        public function order(){
            $this->shop->getOrderManager()->makeOrdinationByUser($this->userid);
        } 

    }
    new TestCart($shop,$dbm);


}
?>