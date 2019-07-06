<?php

include 'config.php';
include 'QueryExecute.php';
include 'CarShop.php';
include 'User.php';
include 'Order.php';
include 'View.php';

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
    // Разбиваем ссылку
    $this->url = $_SERVER['REQUEST_URI'];
    $this->position = strpos($this->url, 'api');
    $this->linkRequest = substr($this->url, $this->position);
    list($this->apiDir, $this->className, $this->methodName, $this->value, $this->format) = explode('/', $this->linkRequest);
    if (!$this->methodName) { // Есть ли имя метода в ссылке?
      return false;
    }
    // Класс и метод с большой буквы для дальнейшего вызова
    $this->className = ucfirst($this->className); 
    $this->methodName = ucfirst($this->methodName);
    
     // Проверяем на наличие формата и значения
    if (!$this->format && $this->value == '.json' ||
        !$this->format && $this->value == '.txt' ||
        !$this->format && $this->value == '.html' ||
        !$this->format && $this->value == '.xml') 
    {
      $this->format = $this->value;
      $this->value = null;
    }


    // Если запрос на Carshop
    if ($this->className === 'Carshop') {
      if (!$_GET) {
        $this->getCarsData();
      } else {
        if ($_GET['model'] || $_GET['year'] || $_GET['engine'] ||
            $_GET['color'] || $_GET['max_speed'] || $_GET['price']) {
          $this->getCarsByParams();
        }
      }
    }


    // Если запрос на User
    if ($this->className === 'User') {
      $positionSymbol = strpos($this->methodName, '?');
      $currentMethod = substr($this->methodName, 0, $positionSymbol);
      $currentClass = new $this->className;
      if ($currentMethod === 'Login') {
        if (
          $_GET['email'] && 
          strlen($_GET['password']) >= 4 &&
          strlen($_GET['password']) <= 30
        ) {
          $this->getLoginData($currentMethod, $currentClass);
        } else {
          return $this->getError(1, $this->format);
        }
      }
      if ($currentMethod === 'Signup') {
        if (
          strlen($_GET['username']) <= 15 && 
          strlen($_GET['username']) >= 4 && 
          $_GET['email'] && 
          strlen($_GET['password']) >= 4 &&
          strlen($_GET['password']) <= 30
        ) {
          $this->setSignupData($currentMethod, $currentClass);
        } else {
          return $this->getError(1, $this->format);
        }
      }
    }


    // Если запрос на Order
    if ($this->className === 'Order') { // проверка на формы
      $positionSymbol = strpos($this->methodName, '?');
      $currentMethod = substr($this->methodName, 0, $positionSymbol);
      $currentClass = new $this->className;
      if ($currentMethod === 'Checkout') {
        $this->setCheckout($currentMethod, $currentClass);
      } else if ($this->methodName === 'Orders') {
        if ($this->value) {
          $this->getOrder($this->methodName, $currentClass);
        } else {
          return $this->getError(1, $this->format);
        }
      }
    }
    
  }

  public function getCarsData() 
  {
    $currentClass = new $this->className;
    if ($this->value != null && $this->value < 1) {
      $this->getError(1, $this->format);
      return false;
    } else if (!$this->value) {
      $data = $currentClass->{'get'.$this->methodName}();
      if (!$data) {
        return false;
      }
      return new View($data, $this->format);
    } else {
      $data = $currentClass->{'get'.$this->methodName}($this->value);
      if (!$data) {
        return $this->getError(2, $this->format);
        return false;
      }
      return new View($data, $this->format);
    }
  }

  public function getCarsByParams() 
  {
    if (!$_GET['year']) {
      $this->getError(1, $this->format);
      return false;
    }
    $currentClass = new $this->className;
    $data = $currentClass->getCarsByParams($_GET);
    return new View($data, $this->format);
  }

  public function getLoginData($currentMethod, $currentClass) 
  {
    $data = $currentClass->{'get'.$currentMethod.'Data'}();
    if ($data) {
      return new View($data, $this->format);
    } else {
      return $this->getError(1, $this->format);
    }
  }

  public function setSignupData($currentMethod, $currentClass) 
  {
    $data = $currentClass->{'set'.$currentMethod.'Data'}();
    if ($data) {
      return new View($data, $this->format);
    } else {
      return $this->getError(1, $this->format);
    }
  }

  public function setCheckout($currentMethod, $currentClass) {
    $data = $currentClass->{'set'.$currentMethod}();
    if ($data) {
      return new View($data, $this->format);
    } else {
      return $this->getError(1, $this->format);
    }
  }

  public function getOrder($currentMethod, $currentClass) {
    $data = $currentClass->{'get'.$currentMethod}($this->value);
    if ($data) {
      return new View($data, $this->format);
    } else {
      return $this->getError(1, $this->format);
    }
  }

  public function getError($no, $format = null) 
  {
    if ($no == 1) {
      switch($format)
      {
        case '.txt':
          header("Access-Control-Allow-Origin: *"); 
          header('Content-type: text/plain');
          header('Status: 204 No Content');
          print_r('Error: Incorrect value');
          break;
        case '.html':
          header("Access-Control-Allow-Origin: *"); 
          header('Content-type: text/html');
          header('Status: 204 No Content');
          print_r('<div>Error: Incorrect value</div>');
          break;
        case '.xml':
          header("Access-Control-Allow-Origin: *"); 
          header('Content-type: application/xml');
          header('Status: 204 No Content');
          print_r($this->toXmlError('Incorrect value'));
          break;
        default:
          header("Access-Control-Allow-Origin: *");
          header("Access-Control-Allow-Credentials: true");
          header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT");
          header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");
          header('Content-Type: application/json');
          header('Status: 204 No Content');
          $arrTemp = ['Error' => 'Incorrect value'];
          print_r(json_encode($arrTemp));
          break;
      }
    }
    if ($no == 2) {
      switch($format)
      {
        case '.txt':
          header("Access-Control-Allow-Origin: *"); 
          header('Content-type: text/plain');
          header('Status: 404 Not found');
          print_r('Error: Not found');
          break;
        case '.html':
          header("Access-Control-Allow-Origin: *"); 
          header('Content-type: text/html');
          header('Status: 404 Not found');
          print_r('<div>Error: Not found</div>');
          break;
        case '.xml':
          header("Access-Control-Allow-Origin: *"); 
          header('Content-type: application/xml');
          header('Status: 404 Not found');
          print_r($this->toXmlError('Not found'));
          break;
        default:
          header("Access-Control-Allow-Origin: *"); 
          header('Content-Type: application/json');
          header('Status: 404 Not found');
          $arrTemp = ['Error' => 'Not found'];
          print_r(json_encode($arrTemp));
          break;
        }
      }
  }

  private function toXmlError($error) 
  {
    $xmlError = new SimpleXMLElement('<error/>');
    $xmlError->addChild('error-message', $error);
    return $xmlError->asXML();
  }

}