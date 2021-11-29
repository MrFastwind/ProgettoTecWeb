<?php
function LoadClasses()
{
    foreach (glob($_SERVER['DOCUMENT_ROOT']."/lib/**/*.php") as $filename){
        include_once($filename);
    }
}
spl_autoload_register(function($className) {

	$className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
	include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/' . $className . '.php';
});

?>