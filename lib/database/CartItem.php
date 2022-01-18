<?php
namespace database{
    use LogicException;
    class CartItem extends DatabaseObject{
        
        function __construct(
            public int $CartItemID,
            public int $CartID,
            public int $ProductID,
            public int $Quantity
        ){}

        public function pushToDatabase(){
            throw new LogicException("Not Implemented!");
        }
    }
}
?>