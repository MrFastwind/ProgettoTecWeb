<?php
namespace database\exceptions{

    use Exception;
    use Throwable;

    abstract class DatabaseException extends Exception{

        public function __construct($message="Generic database exception",$code = 405, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
        public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        }
    }
}
?>