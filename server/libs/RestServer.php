<?php

include 'CarShop.php';

class RestServer
{

  private $url;
  private $position;
  private $linkRequest;
  private $apiDir;
  private $className;
  private $methodName;
  private $value;
  private $format;

  public function __construct()
  {
    $this->url = $_SERVER['REQUEST_URI'];
    $this->position = strpos($this->url, 'api');
    $this->linkRequest = substr($this->url, $this->position);
    list($this->apiDir, $this->className, $this->methodName, $this->value, $this->format) = explode('/', $this->linkRequest);
    $this->className = ucfirst($this->className);
  }

  public function getData() {
    
    echo 'get'.{$this->className}.();
    return true;
  }

}