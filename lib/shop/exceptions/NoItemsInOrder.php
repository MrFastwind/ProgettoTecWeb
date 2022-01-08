<?php
namespace shop\exceptions{

    use Throwable;

    class NoItemsInOrder extends ShopException{
        public function __construct(protected $cart,$code = 501, Throwable $previous = null) {
            parent::__construct("No items in Order!", $code, $previous);
        }

        public function getCartID(){
            return $this->cart;
        }
    }
}
?>