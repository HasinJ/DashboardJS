

<?php
require('code.php');
$graphObj->setLimit(5);
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

			<select id="itemSelection">
				<option value="beverages">Beverages</option>
				<option value="donuts">Donuts</option>
				<option value="bagels">Bagels</option>
			</select>

			<select id="storeSelection">
				<option value="allStores">All Stores</option>
				<option value="Foxchase">Foxchase</option>
				<option value="Stonewall">Stonewall</option>
        <option value="Warrenton">Warrenton</option>
        <option value="Bristow">Bristow</option>
        <option value="BJ">BJ</option>
        <option value="Heritage">Heritage</option>
        <option value="Eastgate">Eastgate</option>
			</select>

    </div>

    <div id="dateContainers" align='center' style="margin-bottom: 20px;">

      <select id="dateSelection">
        <option value=30>Last 30 Days</option>
        <option value=60>Last 60 Days</option>
        <option value="custom">Custom..</option>
      </select><br>

      <div style="margin-top:10px;">
        <label id="from" hidden>To: <input type="date"></label>
        <label id="to" hidden> From: <input type="date"></label>
      </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
		<script src="js/chartManipulation.js"></script>

    <script>

    const storeSelection = document.getElementById('storeSelection');
    const itemSelection = document.getElementById('itemSelection');
    const dateSelection = document.getElementById('dateSelection');
    const fromDate = document.getElementById('from');
    const toDate = document.getElementById('to');


    let labelTime, request, result, xhttp, storeList, limit=30;


    //HTTPrequest SPECIFIC string creation
    let POSTlist = new Array();
    for (let i = 1; i < storeSelection.length; i++) {
      POSTlist[i] = 'stores[]=' + encodeURIComponent(storeSelection[i].value);
    }
    POSTlist = POSTlist.join('&');

    storeSelection.addEventListener('change',storeListener);
    itemSelection.addEventListener('change',storeListener);
    dateSelection.addEventListener('change',changeLimit);

    function changeLimit(event) {
      if (event.target.value == 'custom') {
        fromDate.removeAttribute('hidden');
        toDate.removeAttribute('hidden');
      } else {
        limit = event.target.value;
        storeListener();
      }

    }

    function storeListener(){
      if (storeSelection.value !== 'allStores') {
        oneStore(storeSelection.value, itemSelection.value, limit);
      }else {
        allStores(POSTlist, itemSelection.value, limit);
      }
    }

    //on load/default
    emptyVariables();
    allStores(POSTlist, 'beverages', limit);
    storeSelection.value = 'allStores';
    itemSelection.value = 'beverages';
    dateSelection.value = '30';

    function oneStore(store, item, limit) {
      deleteCanvas();
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function(){
        if (this.readyState==4 && this.status==200) {
          storeList[store][0].data= JSON.parse(xhttp.responseText)['dataPoints'];
          fillSpecifications(store);
          labelTime=JSON.parse(xhttp.responseText)['labelTime'];

          createChart(labelTime, storeList[store]);
          emptyVariables();
        }
      };
      xhttp.open('POST', 'onestoreXHTTP.php', true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send('table='+item+'&store='+store+'&limit='+limit);
    }

    function allStores(stores, item, limit) {
      deleteCanvas();
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState==4 && this.status==200) {
          request = JSON.parse(xhttp.responseText)['dataPoints'];
          labelTime = JSON.parse(xhttp.responseText)['labelTime'];
          for (let property in storeList) {
            storeList[property][0].data = request[property];
            fillSpecifications(property);
            result = result.concat(storeList[property]);
          }
          createChart(labelTime,result);
          emptyVariables();
        }
      };
      xhttp.open('POST', 'allstoresXHTTP.php', true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send('table='+item+'&stores[]='+stores+'&limit='+limit);
    }

    //after creating a column in database, add to this in order to include a new store (also need to edit colors)
    function emptyVariables(){
      storeList = {
        'Foxchase': [{}]
        , 'Stonewall' : [{}]
        , 'Warrenton' : [{}]
        , 'Bristow' : [{}]
        , 'BJ' : [{}]
        , 'Heritage' : [{}]
        , 'Eastgate' : [{}]
      };
      result = [];
    }



    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
