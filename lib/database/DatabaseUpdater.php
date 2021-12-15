<?php

namespace database{

    class DatabaseUpdater
    {
        public function __construct(private DatabaseHelper $dbh){
        }
        
        /**
         * updateProduct
         *
         * @param  Product $p
         * @return bool false if not ended well
         */
        public function updateProduct(Product $p):bool{
            return false;
        }
        
        /**
         * createProduct
         *
         * @param  Product $p
         * @return bool false if not ended well
         */
        public function createProduct(Product $p):bool
        {
            return false;
        }
    }
    

}
?>