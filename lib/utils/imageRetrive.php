<?php

const DEFAULT_IMAGE="noimage.jpg";

function retrieveImage(string $imagePath, string $dir):string{
    $imagePath = str_replace("/","",$imagePath);
    foreach([".jpg",".png",".jpeg",""] as $it){
        if(file_exists($_SERVER["DOCUMENT_ROOT"].$dir.DIRECTORY_SEPARATOR.$imagePath.$it)){
            return $dir.$imagePath.$it;
        }
    }
    return $dir.DEFAULT_IMAGE;
}
?>