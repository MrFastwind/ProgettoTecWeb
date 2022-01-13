<?php
namespace database\exceptions{

    use Throwable;

    class NoCart extends DatabaseException{
        public function __construct($user,$code = 404, Throwable $previous = null) {
            parent::__construct("User '$user' doesn't have a cart", $code, $previous);
        }
    }
}
?>