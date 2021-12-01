<?php

namespace database{

    class DatabaseUpdater
    {
        public function __construct(private DatabaseHelper $dbh)
        {}

        public function updateProduct(Product $p):bool{
            return false;
        }

        public function createProduct(Product $p):bool
        {
            return false;
        }
    }
    

}
?>