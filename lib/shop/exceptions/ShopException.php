<?php
namespace shop\exceptions{

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
}
?>