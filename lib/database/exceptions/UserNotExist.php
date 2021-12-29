<?php
namespace database\exceptions{
    use Throwable;
    class UserNotExist extends DatabaseException
    {
        const Message="The User does not exist!";

        public function __construct($code = 404, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    }
}
?>