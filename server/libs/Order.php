<?php

class Order
{
  public function __construct() {
    try {
      $this->dbConnect = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DB, MYSQL_USER, MYSQL_PASS);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function setCheckout() {
    $name = $_GET['name'];
    $surname = $_GET['surname'];
    $carId = $_GET['carId'];
    $paymentType = $_GET['paymentType'];

    // Проверка на наличие машины с таким ID
    $queryCarCheck = $this->dbConnect->prepare("SELECT * FROM ".MYSQL_TABLE_CARS." WHERE id = '".$carId."'");
    $carCheckResponse = $this->queryExecute($queryCarCheck);
    if ($carCheckResponse) {
      $queryCheckout = $this->dbConnect->prepare("INSERT INTO ".MYSQL_TABLE_ORDER." (name, surname, car_id, payment) 
      VALUES ('".$name."', '".$surname."', '".$carId."', '".$paymentType."');");
      $this->queryExecute($queryCheckout);
      return true;
    } else {
      return false;
    }
  }

  public function getOrder() {
    
    return;
  }

  private function queryExecute($query) 
  {
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

}