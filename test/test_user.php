<?php

namespace test{
    include ("../bootstrap.php");
    include_once("TestCase.php");

    use test\TestCase;
    use database\DatabaseManager;
    use database\User;
    use Exception;
    use shop\Shop;

    //TODO:Fix Auto deletition of user 

    class UserTest extends TestCase{

            private $user = "test_user";
            private $password = "test_user_password";
            private $email = "test@example.com";

        function __construct(private Shop $shop, private DatabaseManager $dbm){
            parent::__construct();
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

    }
    new UserTest($shop,$dbm);

}
?>