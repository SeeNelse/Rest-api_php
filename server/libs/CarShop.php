<?php

class CarShop
{
  private $error;

  public function __construct()
  {
    try {
      $this->dbConnect = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DB, MYSQL_USER, MYSQL_PASS);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      print_r($this->error);
    }
  }

  public function getCars($id = null) 
  {
    if ($this->dbConnect) {
      if (!$id) {
        $querySend = $this->dbConnect->prepare("SELECT ".MYSQL_TABLE_CARS.".id, ".MYSQL_TABLE_CARS.".model, ".MYSQL_TABLE_BRAND.".brand FROM ".MYSQL_TABLE_CARS." INNER JOIN ".MYSQL_TABLE_BRAND." ON ".MYSQL_TABLE_BRAND.".id = ".MYSQL_TABLE_CARS.".brand_id");
        return $this->queryExecute($querySend);
      } else {
        $querySend = $this->dbConnect->prepare("SELECT 
        ".MYSQL_TABLE_CARS.".id,
        ".MYSQL_TABLE_BRAND.".brand,
        ".MYSQL_TABLE_CARS.".model,
        ".MYSQL_TABLE_CARS.".year_production,
        ".MYSQL_TABLE_CARS.".engine_capacity,
        ".MYSQL_TABLE_CARS.".max_speed,
        ".MYSQL_TABLE_CARS.".color,
        ".MYSQL_TABLE_CARS.".price
        FROM ".MYSQL_TABLE_CARS." 
        INNER JOIN ".MYSQL_TABLE_BRAND." 
        ON ".MYSQL_TABLE_CARS.".brand_id = ".MYSQL_TABLE_BRAND.".id 
        WHERE ".MYSQL_TABLE_CARS.".id = $id");
        $result = $this->queryExecute($querySend);
        return $result;
      }
    } else {
      return false;
    }
    
    
  }




  private function queryExecute($query) 
  {
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

}