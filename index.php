

<?php

require('phpClasses/connection.php');
require('phpClasses/graph.php');
$connObject = new db;
try {
	$pdo = $connObject->connectLOCAL();
} catch (PDOException $e) {
	echo 'connection failed';
}



//$pdo = $connObject->connectRDS();

//to test if connection is actually working
/*
$dbhost = 'hasindatabase.c0v7lriogf7u.us-east-2.rds.amazonaws.com';
$dbport = '3306';
$dbname = 'hasindatabase';
$charset = 'utf8mb4';
$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
$username = 'admin';
$password = 'hasinmc11';

try {

	$pdo = new PDO($dsn, $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo 'good DB connection';
}
catch(PDOException $e)
{
	echo "Connection failed: <br>  ". $e->getMessage();
}
*/



//grabbing query from pdo connection
$graphObj = new graph($pdo);
$graphObj->fillLine('Foxchase');


//dummy data
/*
$dataPoints = array();
$labelTime = array();
for ($i=0; $i < 10; $i++) {
  array_push($dataPoints, $i);
}

for ($i=0; $i > -10 ; $i--) {
  array_push($labelTime, $i); //should be negative
}
*/

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title></title>
  </head>
  <body>
		<div class="col-md-12">

	    <div class="col-md-6" style="margin-top:20px;">
				<form id="putIn" action="forms/action.php" method="post">

						<input type="date" name="date">
						<select name="holiday">
							<option value="">Select Holiday</option>
							<option value="Christmas">Christmas</option>
							<option value="Valentines">Valentines</option>
							<option value="Easter">Easter</option>
						</select><br>
						<textarea style="margin-top:20px;" name="freetext" rows="1" cols="25"></textarea><br>
						<input type="submit" value="submit">

				</form>
			</div>

			<div class="col-md-6" style="margin-top:40px;">
				<form id="pullOut" action="forms/retrieve.php" method="post">

					<input type="date" name="date">
					<select name="holiday">
						<option value="">Select Holiday</option>
						<option value="Christmas">Christmas</option>
						<option value="Valentines">Valentines</option>
						<option value="Easter">Easter</option>
					</select><br>
					<input type="submit" value="retrieve">

				</form>
			</div>

		</div>

    <div id="container" class="col-md-10 offset-md-1" align='center'>
      <h1 align="center" class="graphTitle"></h1>

			<select name="beverages">
				<option value="beverages">Beverages</option>
				<option value="donuts">Donuts</option>
				<option value="bagels">Bagels</option>
			</select>

			<select name="storeSelection">
				<option value="Default">All Stores</option>
				<option value="Foxchase">Foxchase</option>
				<option value="Stonewall">Stonewall</option>
			</select>

			<input type="date" name="dateChart" value="">
      <canvas id="myChart"></canvas>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="js/CanvasManipulation.js"></script>


    <script>
		createChart(<?php echo json_encode($graphObj->getLabelTime(), JSON_NUMERIC_CHECK); ?>,
			<?php echo json_encode($graphObj->getDatapoints(), JSON_NUMERIC_CHECK); ?>,
			'Foxchase');

		deleteCanvas();

		createChart(<?php echo json_encode($graphObj->getLabelTime(), JSON_NUMERIC_CHECK); ?>,
			<?php echo json_encode($graphObj->getDatapoints(), JSON_NUMERIC_CHECK); ?>,
			'Foxchase');


    function createChart(x,y,stringLabel) {
      let ctx = document.getElementById('myChart');
			let set =
				{
					label: stringLabel,
					fill: false,
					//backgroundColor: 'rgb(0, 99, 132)',
					borderColor: 'rgb(255, 99, 132)',
					data: y
				};

			if (ctx==null) {
				createCanvas();
				ctx = document.getElementById('myChart').getContext('2d');
			}

			ctx = document.getElementById('myChart').getContext('2d');
      let chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'line',

      // The data for our dataset
      data: {
          labels: x,
          datasets:[set]
      },

      // Configuration options go here
      options: {}
  });
}
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
