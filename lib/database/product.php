<?php

namespace database{

    use Exception;

class Product extends DatabaseObject{
        
        public function __construct(
            public int $ProductID,
            public string $Name,
            public string $Image,
            public string $Description,
            public int $Quantity,
            public int $Price,
            public string $Vendor,
            public string $Category


        )
        {}
        
        /**
         * getAsArray
         *
         * @return array
         *//*
        public function getAsArray():array{
            return array($this);
        }*/

        public function pushToDatabase()
        {
            throw new Exception("Not Implemented!");
        }
    }
    
}



?>