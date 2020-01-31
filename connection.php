<?php

  protected $DB_NAME;
  protected $DB_HOST;
  protected $DB_USER;
  protected $DB_PASSWORD;
  protected $DBtable;

  protected function connectRDS() {
    //database connection

    $this->DB_NAME = 'hasindatabase';
    $this->DB_HOST = 'hasindatabase.c0v7lriogf7u.us-east-2.rds.amazonaws.com';
    $this->DB_USER = 'admin';
    $this->DB_PASSWORD = 'hasinmc11';
    $this->DBtable = 'storec';

    $dsn = 'mysql:dbname=' . $this->DB_NAME . ';host=' . $this->DB_HOST;

    try {
    $pdo = new PDO($dsn, $this->DB_USER, $this->DB_PASSWORD);
    //var_dump($pdo); // checks if PDO connection/object has been created
    }

    catch(Exception $e) {
    	echo "an error has occured with DB connection";
    }

    return $pdo;
  }


?>
