<?php

namespace test{
    include ("../bootstrap.php");

    use database\DatabaseManager;
    use database\User;
    use shop\Shop;


    class UserTest{

            private $user = "test_user";
            private $password = "test_user_password";
            private $email = "test@example.com";

        function __construct(private Shop $shop, private DatabaseManager $dbm){
        }

        public function registerUser()
        {
            assert(is_a(
                $this->shop->getUserManager()->registerClient($this->user,$this->password,$this->email),
                "database\User"),
                "Should be of type User"
            );
        }

        public function loginUser()
        {
            assert(
                is_a(
                    $this->shop->getUserManager()->login($this->user,$this->password),
                    "database\User"),
                    "Should be of type User"
                );
            
        }

        public function runTests(){
            foreach(["registerUser","loginUser"] as $it){
                try{
                    call_user_func([$this,$it]);
                }finally{}
            }
        }

        public function legacy(){
            
        $testUser=(int)1;
        $factory=$this->dbm->getFactory();
        $user = $factory->getUser($testUser);

        var_dump($user);

        $productList = $factory->getProducts(0,5);

        var_dump($productList);
        }

    }
    (new UserTest($shop,$dbm))->runTests();

}
?>