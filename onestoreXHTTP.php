<?php

  require('phpClasses/connection.php');
  $connection = new db;
  $pdo = $connection->connectLOCAL();
  //$pdo = $connection->connectRDS();

  try {
    $dataPoints = array();
    $labelTime = array();
    $table = $_POST['table'];
    $store = $_POST['store'];
    $sql = "SELECT Date, $store FROM $table LIMIT 30";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $results = array();
    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

    foreach($results as $row)
    {
      array_push($labelTime, $row['Date']);
      array_push($dataPoints, $row[$store]);
    }

    $timeANDpoints = array('dataPoints'=>$dataPoints,'labelTime'=>$labelTime);
    echo json_encode($timeANDpoints);

  } catch (PDOException $e) {
    echo $e->getMessage();
  } catch (Exception $e) {
    echo "nothing caught from query";
  }
    exit();

?>
