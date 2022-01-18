<?php
namespace database\exceptions{
    use Throwable;
    class NotClient extends DatabaseException
    {
        public function __construct($message="It's not a client",$code = 404, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }
}
?>