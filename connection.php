<?php

  define('DB_NAME', $_SERVER['RDS_DB_NAME']);
  define('DB_USER', $_SERVER['RDS_USERNAME']);
  define('DB_PASSWORD', $_SERVER['RDS_PASSWORD']);
  define('DB_HOST', $_SERVER['RDS_HOSTNAME']);
  define('DB_TABLE', 'storec');

  function connectRDS() {
    //database connection

    $DB_NAME = 'hasindatabase';
    $DB_HOST = 'hasindatabase.c0v7lriogf7u.us-east-2.rds.amazonaws.com';
    $DB_USER = 'admin';
    $DB_PASSWORD = 'Hasinmc11';
    $DBtable = 'storec';

    $dsn = 'mysql:host=' . $DB_HOST . ';dbname=' . $DB_NAME . ';charset=utf8mb4' . ';port=3306';

    try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
    //var_dump($pdo); // checks if PDO connection/object has been created
    }

    catch(PDOException $e) {
    	echo "an error has occured with DB connection ".$e->getMessage();
    }
  }


?>
