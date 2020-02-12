<?php

  require('phpClasses/connection.php');
  $connection = new db;
  $pdo = $connection->connectLOCAL();
  //$pdo = $connection->connectRDS();
  try {
    $dataPoints = array();
    $labelTime = array();
    $sql = "SELECT * FROM beverages LIMIT 30";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $results = array();
    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

    foreach($results as $row)
    {
      array_push($labelTime, $row['Date']);
      array_push($dataPoints, $row['Stonewall']);
    }

    $timeANDpoints = array($dataPoints,$labelTime);
    echo json_encode($timeANDpoints);
    exit();

  } catch (PDOException $e) {
    echo $e->getMessage();
  } catch (Exception $e) {
    echo "nothing caught from query";
  }
?>
