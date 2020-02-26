<?php

  require('phpClasses/connection.php');
  $connection = new db;
  $pdo = $connection->connectLOCAL();
  //$pdo = $connection->connectRDS();

  try {
    $dataPoints = array();
    $labelTime = array();
    $limit = $_POST['limit'];
    $table = $_POST['table'];
    $store = $_POST['store'];
    $customDate = $_POST['customDate'];
    if ($customDate=='custom') {
      $from = $_POST['from'];
      $to = $_POST['to'];
      $sql = "SELECT CAST(Date AS date) AS Date, $store FROM $table WHERE Date > '$from' AND Date < '$to' ORDER BY Date DESC LIMIT 730";
    }else {
      $sql = "SELECT CAST(Date AS date) AS Date, $store FROM $table ORDER BY Date DESC LIMIT $limit";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $results = array();
    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
    $results = array_reverse($results);

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
