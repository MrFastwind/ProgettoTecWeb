<?php
namespace database\exceptions{
    use Throwable;
    class DoesNotExist extends DatabaseException
    {
        public function __construct($message="object doesn't exist",$code = 404, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }
}
?>