<?php

namespace database{
    class Product{
        
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
    }
    
}



?>