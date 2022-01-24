<?php

namespace database{

    use Exception;

class Order extends DatabaseObject{

        public function __construct(
            public int $OrderID,
            public string $Time,
            public int $CartID,
            public string $OrderStatusID,
        ){}

        public function pushToDatabase()
        {
            throw new Exception("Not Implemented!");
        }
    }
}
?>