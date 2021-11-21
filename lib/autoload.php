<?php
function LoadClasses()
{
    foreach (glob($_SERVER['DOCUMENT_ROOT']."/lib/**/*.php") as $filename){
        include_once($filename);
    }
}
?>