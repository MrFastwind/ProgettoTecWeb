<?php
namespace database\exceptions{
    use Throwable;
    class UserExistAlready extends DatabaseException{
        const Message="The User already exist!";

        public function __construct($code = 405, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    } 
}

?>