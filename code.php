<?php

require('phpClasses/connection.php');
$connObject = new db;
try {
	$pdo = $connObject->connectLOCAL();
	//$pdo = $connObject->connectRDS();
} catch (PDOException $e) {
	echo 'connection failed';
}

//grabbing query from pdo connection


?>
