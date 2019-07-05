<?php

class View
{

  public function __construct($data, $format = null)
  {
    $this->formatCheck($format, $data);
  }

  public function formatCheck($format, $data) {
    switch($format)
    {
      case '.txt':
        header("Access-Control-Allow-Origin: *");
        header('Content-type: text/plain');
        header('Status: 200 OK');
        print_r($this->toTxt($data));
        break;
      case '.html':
        header("Access-Control-Allow-Origin: *");
        header('Content-type: text/html');
        header('Status: 200 OK');
        print_r($this->toHtml($data));
        break;
      case '.xml':
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/xml');
        header('Status: 200 OK');
        print_r($this->toXml($data));
        break;
      default:
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT");
        header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");
        header('Content-type: *');
        header('Status: 200 OK');
        print_r(json_encode($data));
        break;
    }
  }

  private function toTxt($data) {
    $respTxt = '';
    forEach($data as $keyNo => $carItem) {
      $respTxt .= "[$keyNo: ";
      forEach($carItem as $keyName => $item) {
        $respTxt .= '['.$keyName.':'.$item."],";
      }
      $respTxt = substr($respTxt, 0, -1);
      $respTxt .= "], \n";
    }
    $respTxt = substr($respTxt, 0, -3);
    return $respTxt;
  }

  private function toHtml($data) {
    $respHtml = '<div>';
    forEach($data as $keyNo => $carItem) {
      $respHtml .= "<ul><h4>$keyNo</h4>";
      forEach($carItem as $keyName => $item) {
        $respHtml .= "<li>$keyName : $item</li>";
      }
      $respHtml .= '</ul>';
    }
    $respHtml .= '</div>';
    return $respHtml;
  }

  private function toXml($data) {
    $respXml = new SimpleXMLElement('<cars/>');
    forEach($data as $keyNo => $carItem) {
      $carElement = $respXml->addChild('car');
      forEach($carItem as $keyName => $item) {
        $carElement->addChild($keyName, $item);
      }
    }
    return $respXml->asXML();
  }

}