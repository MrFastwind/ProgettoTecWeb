<?php

const DEFAULT_IMAGE="noimage.png";

function retrieveImage(string $imagePath, string $dir):string{
    $imagePath = str_replace("/","",$imagePath);
    if(file_exists($dir.DIRECTORY_SEPARATOR.$imagePath)){
        return $dir.$imagePath;
    }
    return $dir.DEFAULT_IMAGE;
}
?>