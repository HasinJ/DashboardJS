<?php

  //establishes connection to database using AWS
  define('DB_NAME', $_SERVER['RDS_DB_NAME']);
  define('DB_USER', $_SERVER['RDS_USERNAME']);
  define('DB_PASSWORD', $_SERVER['RDS_PASSWORD']);
  define('DB_HOST', $_SERVER['RDS_HOSTNAME']);
  define('DB_TABLE', 'storec');

  protected function connect() {
    //database connection
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    try {
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
    //var_dump($pdo); // checks if PDO connection/object has been created
    }

    catch(Exception $e) {
    	echo "an error has occured";
    }

    return $pdo;

  }

?>
