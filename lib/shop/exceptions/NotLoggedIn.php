<?php
namespace shop\exceptions{

    use Throwable;

    class NotLoggedIn extends ShopException{
        public function __construct($code = 501, Throwable $previous = null) {
            parent::__construct("User not logged in!", $code, $previous);
        }

        public function getCartID(){
            return $this->cart;
        }
    }
}
?>