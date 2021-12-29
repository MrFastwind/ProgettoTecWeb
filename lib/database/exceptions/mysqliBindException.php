<?php
namespace database\exceptions{
    use Throwable;
    class mysqliBindException extends DatabaseException{
        const Message="Statement bind failed!";

        public function __construct($code = 405, Throwable $previous = null) {
            parent::__construct($this::Message, $code, $previous);
        }
    }
}
?>