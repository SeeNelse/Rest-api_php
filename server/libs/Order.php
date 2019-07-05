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

  public function setOrder() {
  
    return;
  }

  public function getOrder() {
    
    return;
  }

}