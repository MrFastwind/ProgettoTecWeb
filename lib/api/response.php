<?php
namespace api{
    class Response{
        const ERROR_NO_VALUE = "No valued as been passed";
        const ERROR_NO_ELEMENT_FOR_ID = "No element with that id";

        public static function error(string $message="Bad Request", mixed $data=null){
            $json = array("status"=>"ERROR","message"=>$message);
            if (!empty($data)){
                $json["data"]=$data;
            }
            return json_encode($json,JSON_PRETTY_PRINT);
        }
        
        public static function ok(string $message="Success",mixed $data=null){
            $json = array("status"=>"OK","message"=>$message);
            if (!empty($data)){
                $json["data"]=$data;
            }
            return json_encode($json,JSON_PRETTY_PRINT);
        }
        
    }
    
}

?>