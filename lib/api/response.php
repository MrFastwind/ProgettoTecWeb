<?php
namespace api{
    class Response{
        const ERROR_NO_VALUE = "No valued as been passed";
        const ERROR_NO_ELEMENT_FOR_ID = "No element with that id";

        public static function error(string $value){
            return json_encode(array("status"=>"ERROR","value"=>$value));
        }
        
        public static function ok(mixed $value){
            return json_encode(array("status"=>"OK","value"=>$value));
        }
        
    }
    
}

?>