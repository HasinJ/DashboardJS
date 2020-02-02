<?php

  require('../connection.php');
  $connection = new db;
  $pdo = $connection->connectLOCAL();
  //$pdo = $connection->connectRDS();

  try {
    $date = $_POST['date'];
    $holiday = $_POST['holiday'];
    $pdo->exec("SELECT inputDate, holiday, freetext FROM submitTEST WHERE holiday = '$holiday';")
  } catch (PDOException $e) {
    echo $e->getMessage();
  }


?>
