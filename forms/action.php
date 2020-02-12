<?php

  require('../phpClasses/connection.php');
  $connection = new db;
  $pdo = $connection->connectLOCAL();
  //$pdo = $connection->connectRDS();


// this is for creating the table if it doesn't exist
/*
  $sql = 'CREATE TABLE submitTEST(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    inputDate DATE,
    holiday VARCHAR(30) NOT NULL,
    freetext TEXT(1000)
  )';

  try {
    $pdo->exec($sql);
    echo 'table creation successful!';
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
*/

try {

  $date = $_POST['date'];
  $holiday = $_POST['holiday'];
  $freetext = $_POST['freetext'];
  $pdo->exec("INSERT INTO submitTEST (inputDate, holiday, freetext)
  VALUES ('$date', '$holiday', '$freetext')");

  echo "submitted successfully!";

} catch (PDOException $e) {
  echo $e->getMessage();
}



?>
