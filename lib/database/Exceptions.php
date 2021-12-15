<?php
namespace database{

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

    class WrongPassword extends DatabaseException
    {
        const Message="The password is wrong!";

        public function __construct($code = 403, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    }

    class UserNotExist extends DatabaseException
    {
        const Message="The User does not exist!";

        public function __construct($code = 404, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    }

    class ProductNotExist extends DatabaseException
    {
        const Message="The Product does not exist!";

        public function __construct($code = 405, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    }
    
    class mysqliBindException extends DatabaseException{
        const Message="Statement bind failed!";

        public function __construct($code = 405, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    }
}
?>