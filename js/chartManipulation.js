
let graphTitle = document.querySelector('.graphTitle');
graphTitle.textContent = 'Graph';

//edit these to add colors to new stores
let stonewallColor = 'rgb(255,133,10)';
let foxchaseColor = 'rgb(255,99,132)';
let warrentonColor = 'rgb(255,247,8)';
let bristowColor = 'rgb(142,255,13)';
let bjColor = 'rgb(0,255,255)';
let heritageColor = 'rgb(118,59,255)';
let eastgateColor = 'rgb(255,64,166)';

function deleteCanvas(){
  let ctx = document.getElementById('myChart');
  let container = document.getElementById('container');
  if (ctx !== null) ctx.parentNode.removeChild(ctx);
}

function createCanvas() {
  let ctx = document.createElement('canvas');
  let container = document.getElementById('container');
  ctx.setAttribute('id','myChart');
  container.appendChild(ctx);
}

function createChart(x, set) {
  let ctx = document.getElementById('myChart');

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
      datasets: set
  },

  // Configuration options go here
  options: {}
});
}

function chart(targetValue, storesObject){
  storesObject[targetValue][0].label = targetValue;
  storesObject[targetValue][0].fill = false;
  storesObject[targetValue][0].borderColor = eval(targetValue.toLowerCase() + 'Color');
}

function allStores(targetArray, storesObject) {
  let result = [];
    for (var i = 1; i < targetArray.length; i++) {
      chart(targetArray[i].value, storesObject);
      result = result.concat(eval(targetArray[i].value));
    }
  return result;
}
