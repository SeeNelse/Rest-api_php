<?php
error_reporting(0); // УДАЛИТЬ!!!
// include '../../libs/CarShop.php';
include '../../libs/RestServer.php';
// include '../../libs/View.php';



$obj = new RestServer();
$obj->getCarsData();

// echo $apiDir, '-', $className, '-', $methodName, '-', $value, '-', $format;