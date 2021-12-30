<?php
namespace database\exceptions{
    use Throwable;
    class WrongPassword extends DatabaseException
    {
        const Message="The password is wrong!";

        public function __construct($code = 403, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    }
}
?>