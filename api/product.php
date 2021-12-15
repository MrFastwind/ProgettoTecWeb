<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php");
use api\response;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

define('LABEL_ID','id');
define('LABEL_SEARCH', 'search');
define('LABEL_RANDOM', 'random');
define('LABEL_START', 'start');
define('LABEL_LENGTH', 'length');




//$search = $_GET['search'];
//$random = (bool)$_GET['random'];
//$start = (int)$_GET['start'];
//$length = (int)$_GET['length'];

$random = array_key_exists(LABEL_RANDOM,$_GET)?(bool)$_GET[LABEL_RANDOM]: false;
$start = array_key_exists(LABEL_START,$_GET)?(int)$_GET[LABEL_START]:0;
$length= array_key_exists(LABEL_LENGTH,$_GET)?(int)$_GET[LABEL_LENGTH]:10;

if(array_key_exists(LABEL_ID,$_GET)){
    try{
        $product = $dbm->getFactory()->getProduct($_GET[LABEL_ID]);
        echo(Response::ok($product));
    }catch(Exception $e){
        echo(Response::error(Response::ERROR_NO_ELEMENT_FOR_ID));
    }
}elseif (array_key_exists(LABEL_SEARCH,$_GET)) {
    $dict[$query] = $_GET[LABEL_SEARCH];
    try{
        $product = $dbm->getFactory()->getProductsLike($query,$length,$start);
    }catch(Exception $e){
        echo(Response::error(Response::ERROR_NO_ELEMENT_FOR_ID));
    }
}else {
    try{
        $product = $dbm->getFactory()->getProducts($start,$length);
    }catch(Exception $e){
        echo"";
    }
    
}
