<?php

  require('phpClasses/connection.php');
  $connection = new db;
  $pdo = $connection->connectLOCAL();
  //$pdo = $connection->connectRDS();

  try {
    $limit = $_POST['limit'];
    $table = $_POST['table'];
    $dataPointsKeys = $_POST['stores'];
    //temp
    //$dataPointsKeys = ['Foxchase','Stonewall'];
    $dataPoints = array();
    $dataPoints = array_fill(0, count($dataPointsKeys), array()); //fills with empty arrays for array_combine
    $labelTime = array();

    //date because it differs too much from collecting all data
    $sql = "SELECT CAST(Date AS date) AS Date FROM $table LIMIT $limit";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = array();
    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

    foreach($results as $row)
    {
      array_push($labelTime, $row['Date']);
    }

    //dataPoints
    $sql = "SELECT * FROM $table LIMIT $limit";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = array();
    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

    for ($i=1; $i < count($dataPointsKeys); $i++) {
      foreach($results as $row)
      {
        array_push($dataPoints[$i], $row[ $dataPointsKeys[$i] ]);
      }
    }

    $dataPoints = array_combine($dataPointsKeys, $dataPoints); //label data

    $timeANDpoints = array('dataPoints'=>$dataPoints,'labelTime'=>$labelTime);
    echo json_encode($timeANDpoints);

  } catch (PDOException $e) {
    echo $e->getMessage();
  } catch (Exception $e) {
    echo "nothing caught from query";
  }
    exit();

?>
