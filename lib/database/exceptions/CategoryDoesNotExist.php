<?php
namespace database\exceptions{
    use Throwable;
    class CategoryDoesNotExist extends DatabaseException
    {
        public function __construct($category,$code = 404, Throwable $previous = null) {
            parent::__construct("The category '$category' doesn't exist!", $code, $previous);
        }
    }
}
?>