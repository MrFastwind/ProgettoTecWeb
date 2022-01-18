<?php
namespace database{

    use LogicException;

class Cart extends DatabaseObject{

        function __construct(
            public int $CartID,
            public int $ClientID,
            public array $Items=array()
        ){}


        public function pushToDatabase(){
            throw new LogicException("Not Implemented!");
        }

        public function getAsArray(){
            $obj = (array)$this;
            $items = $obj["Items"];
            $obj["Items"]=array();
            foreach($items as $id => $item){
                $obj["Items"][$id] = $item;
            }
            return $obj;
        }

    }
}

?>