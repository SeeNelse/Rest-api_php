<?php

class User extends QueryExecute
{
  public function __construct()
  {
    try {
      $this->dbConnect = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DB, MYSQL_USER, MYSQL_PASS);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getLoginData() 
  {
    $email = $_GET['email'];
    $password = $_GET['password'];
    $logInTime = $_GET['logInTime'];
    // Проверка пароля
    $queryPassCheck = $this->dbConnect->prepare("SELECT * FROM ".MYSQL_TABLE_USERS." WHERE email = '".$email."'");
    $userCheckResponse = $this->queryExecute($queryPassCheck);
    $currentPassHahs = $userCheckResponse[0]['password'];

    if(password_verify($password, $currentPassHahs)) {
      $newToken = md5($email.time());
      $queryNewHash = $this->dbConnect->prepare("UPDATE ".MYSQL_TABLE_USERS." SET token='".$newToken."' WHERE email='".$email."'");
      $this->queryExecute($queryNewHash);
      return [
        'token' => $newToken, 
        'username' => $userCheckResponse[0]['username'], 
        'email' => $userCheckResponse[0]['email'],
        'logInTime' => $logInTime,
      ];
    } else {
      return false;
    }
  }

  public function setSignupData() 
  {
    $username = $_GET['username'];
    $password = $_GET['password'];
    $email = $_GET['email'];

    //Проверяем email
    $queryEmailCheck = $this->dbConnect->prepare("SELECT * FROM ".MYSQL_TABLE_USERS." WHERE email = '".$email."'");
    $emailCheckResponse = $this->queryExecute($queryEmailCheck);

    $password = password_hash($password, PASSWORD_DEFAULT);

    if (!$emailCheckResponse) {
      $queryRegisterSend = $this->dbConnect->prepare("INSERT INTO ".MYSQL_TABLE_USERS." (username, password, email) 
      VALUES ('".$username."', '".$password."', '".$email."');");
      if ($this->queryExecute($queryRegisterSend)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

}