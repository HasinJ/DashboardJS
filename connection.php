<?php
/*
  define('DB_NAME', $_SERVER['RDS_DB_NAME']);
  define('DB_USER', $_SERVER['RDS_USERNAME']);
  define('DB_PASSWORD', $_SERVER['RDS_PASSWORD']);
  define('DB_HOST', $_SERVER['RDS_HOSTNAME']);
  define('DB_TABLE', 'storec');
*/


class db
{

  private $DB_NAME;
  private $DB_HOST;
  private $DB_USER;
  private $DB_PASSWORD;
  private $DBtable;

  private function pdo(){
    $dsn = 'mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';charset=utf8mb4' . ';port=3306';

    try {
    $pdo = new PDO($dsn, $this->DB_USER, $this->DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
    //var_dump($pdo); // checks if PDO connection/object has been created
    }

    catch(PDOException $e) {
      echo "something went wrong ".$e->getMessage();
    }
  }

  public function connectRDS() {

    $this->DB_NAME = 'hasindatabase';
    $this->DB_HOST = 'hasindatabase.c0v7lriogf7u.us-east-2.rds.amazonaws.com';
    $this->DB_USER = 'admin';
    $this->DB_PASSWORD = 'hasinmc11';
    $this->DBtable = 'storec';

    return $this->pdo();

  }

  public function connectLOCAL() {

    $this->DB_NAME = 'test';
    $this->DB_HOST = 'localhost';
    $this->DB_USER = 'root';
    $this->DB_PASSWORD = '';
    $this->DBtable = '';

    return $this->pdo();

  }

  public function getTable() {
    return $this->$DBtable;
  }
}





?>
