<?php
namespace database\exceptions{
    use Throwable;
    class ProductNotExist extends DatabaseException
    {
        const Message="The Product does not exist!";

        public function __construct($code = 414, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    }
}
?>