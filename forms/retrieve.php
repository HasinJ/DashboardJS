<?php

  require('../phpClasses/connection.php');
  $connection = new db;
  $pdo = $connection->connectLOCAL();
  //$pdo = $connection->connectRDS();

  try {
    $date = $_POST['date'];
    $holiday = $_POST['holiday'];

    $sql = "SELECT inputDate, holiday, freetext FROM submitTEST WHERE inputDate = :inputDate AND holiday = :holiday";
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array('inputDate' => $date, 'holiday' => $holiday)); //same as bind
    /*$stmt->bindParam(':holiday', $holiday);
    $stmt->execute();*/
    $results = array();
    $results = ($stmt->fetch(PDO::FETCH_ASSOC));
    if ($results == NULL) {
      throw new Exception();
    }
    foreach ($results as $result) {
      echo $result;
      echo '<br>';
    }

  } catch (PDOException $e) {
    echo $e->getMessage();
  } catch (Exception $e) {
    echo "nothing for this date/holiday";
  }



?>
