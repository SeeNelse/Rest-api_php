<?php

// include '../../libs/CarShop.php';
include '../../libs/RestServer.php';
include '../../libs/View.php';



$obj = new RestServer();
$obj->getData();

// echo $apiDir, '-', $className, '-', $methodName, '-', $value, '-', $format;