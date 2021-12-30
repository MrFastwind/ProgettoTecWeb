<?php
function LoadClasses()
{
    foreach (glob($_SERVER['DOCUMENT_ROOT']."/lib/**/*.php") as $filename){
        include_once($filename);
    }
}
spl_autoload_register(function($className) {

    //echo "Loading Class ".$className."<br>";

	$className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $filename = $_SERVER['DOCUMENT_ROOT'] . '/lib/' . $className . '.php';
    if (is_readable($filename)) {
        include_once $filename;
    }
});



?>