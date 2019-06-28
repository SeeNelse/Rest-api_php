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
                                            LEFT JOIN ".MYSQL_TABLE_BRAND." 
                                            ON ".MYSQL_TABLE_CARS.".brand_id = ".MYSQL_TABLE_BRAND.".id");
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

  public function getCarsByParams($array) 
  {
    $tempArray = [
      'year_production' => $array['year'],
      'model' => $array['model'],
      'engine_capacity' => $array['engine'],
      'max_speed' => $array['max_speed'],
      'color' => $array['color'],
      'price' => $array['price'],
    ];
    if ($tempArray['year_production'] && $this->dbConnect) {
      $queryParams = '';
      forEach($tempArray as $key => $item) {
        if ($item) {
          $queryParams .= MYSQL_TABLE_CARS.'.'.$key." = '$item' AND ";
        }
      }
      $formatPos = strpos($queryParams, '/.');
      if ($formatPos) {
        $queryParams = substr(trim($queryParams), 0, $formatPos) . "'";
      } else {
        $queryParams = substr(trim($queryParams), 0, -4);
      }
      $querySend = $this->dbConnect->prepare("SELECT * FROM ".MYSQL_TABLE_CARS." WHERE ".$queryParams);
      $result = $this->queryExecute($querySend);
      return $result;
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