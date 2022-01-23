<?php
namespace database\exceptions{
    use Throwable;
    class NoUser extends DatabaseException
    {
        public function __construct($message="It's not a user",$code = 404, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }
}
?>
