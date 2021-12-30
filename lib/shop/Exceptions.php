<?php
namespace shop{

    use Exception;
    use Throwable;

    abstract class ShopException extends Exception{

        public function __construct($message="Generic shop exception",$code = 400, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
        public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        }
    }
    
    class EmailIsInvalid extends ShopException{
        public function __construct($email,$code = 501, Throwable $previous = null) {
            parent::__construct('"'.$email."\" is not valid email!", $code, $previous);
        }

    }
}
?>