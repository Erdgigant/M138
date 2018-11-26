<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include_once "Classes/Controller.php";
include_once "Classes/Database.php";
include_once "vendor/autoload.php";

try {
    $controller = new Controller();
    $controller->execute();
}
catch (Exception $ex){
    //TODO remove
    throw $ex;

    echo 'An Error occurred: ' . $ex->getMessage();
}