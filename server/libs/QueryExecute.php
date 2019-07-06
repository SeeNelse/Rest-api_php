<?php

class QueryExecute
{
  public function queryExecute($query) 
  {
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
}