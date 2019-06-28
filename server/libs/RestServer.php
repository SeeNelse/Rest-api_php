<?php

include 'config.php';
include 'CarShop.php';
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
  private $reqMethod;

  public function __construct()
  {
    // Разбиваем ссылку
    $this->url = $_SERVER['REQUEST_URI'];
    $this->position = strpos($this->url, 'api');
    $this->linkRequest = substr($this->url, $this->position);
    list($this->apiDir, $this->className, $this->methodName, $this->value, $this->format) = explode('/', $this->linkRequest);
    // класс и метод с большой буквы
    $this->className = ucfirst($this->className); 
    $this->methodName = ucfirst($this->methodName);


    if (!$this->format && $this->value == '.json' ||
        !$this->format && $this->value == '.txt' ||
        !$this->format && $this->value == '.html' ||
        !$this->format && $this->value == '.xml') { // проверяем на наличие формата и значения
      $this->format = $this->value;
      $this->value = null;
    }


    // Метод запроса
    // $this->reqMethod = $_SERVER['REQUEST_METHOD'];

    if (!$_GET) {
      $this->getCarsData();
    } else {
      if ($_GET['model'] || $_GET['year'] || $_GET['engine'] ||
          $_GET['color'] || $_GET['max_speed'] || $_GET['price']) {
        $this->getCarsByParams();
      }
    }
  }

  public function getCarsData() {
    $currentClass = new $this->className;
    if ($this->value != null && $this->value < 1) {
      $this->getError(1, $this->format);
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
      }
      return new View($data, $this->format);
    }
  }

  public function getCarsByParams() {
    $currentClass = new $this->className;
    $data = $currentClass->getCarsByParams($_GET);
    return new View($data, $this->format);
  }

  public function getError($no, $format = null) {
    if ($no == 1) {
      switch($format)
      {
        case '.txt':
          header('Content-type: text/plain');
          header('Status: 204 No Content');
          print_r('Error: Incorrect value');
          break;
        case '.html':
          header('Content-type: text/html');
          header('Status: 204 No Content');
          print_r('<div>Error: Incorrect value</div>');
          break;
        case '.xml':
          header('Content-type: application/xml');
          header('Status: 204 No Content');
          print_r($this->toXmlError('Incorrect value'));
          break;
        default:
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
          header('Content-type: text/plain');
          header('Status: 404 Not found');
          print_r('Error: Not found');
          break;
        case '.html':
          header('Content-type: text/html');
          header('Status: 404 Not found');
          print_r('<div>Error: Not found</div>');
          break;
        case '.xml':
          header('Content-type: application/xml');
          header('Status: 404 Not found');
          print_r($this->toXmlError('Not found'));
          break;
        default:
          header('Content-Type: application/json');
          header('Status: 404 Not found');
          $arrTemp = ['Error' => 'Not found'];
          print_r(json_encode($arrTemp));
          break;
        }
      }
  }

  private function toXmlError($error) {
    $xmlError = new SimpleXMLElement('<error/>');
    $xmlError->addChild('error-message', $error);
    return $xmlError->asXML();
  }

}