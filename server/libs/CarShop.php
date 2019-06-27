<?php

class CarShop
{

  public function __construct()
  {
    try {
      $this->dbConnect = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DB, MYSQL_USER, MYSQL_PASS);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
    }
  }

  public function getCarshop() {
    echo 123123;
    return true;
  }

}