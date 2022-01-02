<?php
namespace database{


    abstract class DatabaseObject{
        
        abstract public function pushToDatabase();

        public function getAsArray(){
            return (array)$this;
        }
    }

}


?>