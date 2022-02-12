<?php
namespace database\exceptions{
    use Throwable;
    class ExceedProductAvailability extends DatabaseException
    {
        public function __construct($productId,$code = 404, Throwable $previous = null) {
            parent::__construct("The Product '$productId' doesn't have enough stock", $code, $previous);
        }
    }
}
?>