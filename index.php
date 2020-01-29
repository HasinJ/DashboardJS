
<?php
//grabbing query from pdo connection
$dataPoints = array();
$labelTime = array();
for ($i=0; $i < 10; $i++) {
  array_push($dataPoints, $i);
}

for ($i=0; $i > -10 ; $i--) {
  array_push($labelTime, $i);
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>

    <div id="container">
      <input type="date" name="date">
      <input type="submit" value="submit date">
    </div>

    <div class="col-md-10 offset-md-1">
      <h1 align="center" class="graphTitle"></h1>
      <canvas id="myChart"></canvas>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>

    let graphTitle = document.querySelector('.graphTitle');
    graphTitle.textContent = 'Title';

    let inputs = document.getElementById('container').querySelectorAll('input');

    inputs.forEach( (input) => {
      input.addEventListener('click',(e) => {
        if(e.target.type === 'submit') createChart();
      });
    });



    function createChart() {
      let ctx = document.getElementById('myChart').getContext('2d');
      let chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'line',

      // The data for our dataset
      data: {
          labels: <?php echo json_encode($labelTime, JSON_NUMERIC_CHECK); ?>,
          datasets: [{
              label: 'Foxchase',
  			fill: false,
              //backgroundColor: 'rgb(0, 99, 132)',
              borderColor: 'rgb(255, 99, 132)',
              data: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
          }]
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
