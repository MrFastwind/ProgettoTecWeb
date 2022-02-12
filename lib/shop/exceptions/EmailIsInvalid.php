<?php
namespace shop\exceptions{

    use Throwable;

    class EmailIsInvalid extends ShopException{
        public function __construct($email,$code = 501, Throwable $previous = null) {
            parent::__construct('"'.$email."\" is not valid email!", $code, $previous);
        }
    }
}
?>