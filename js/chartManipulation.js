
let graphTitle = document.querySelector('.graphTitle');
graphTitle.textContent = 'Graph';

//edit these to add colors to new stores
let stonewallColor = 'rgb(255,133,10)';
let foxchaseColor = 'rgb(255,99,132)';
let warrentonColor = 'rgb(222,222,87)';
let bristowColor = 'rgb(142,255,13)';
let bjColor = 'rgb(0,255,255)';
let heritageColor = 'rgb(118,59,255)';
let eastgateColor = 'rgb(255,153,255)';

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

function fillSpecifications(storeName){
  storeList[storeName][0].label = storeName;
  storeList[storeName][0].fill = false;
  storeList[storeName][0].borderColor = eval(storeName.toLowerCase() + 'Color');
}

function createChart(timeSet, lineSpecifications) {
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
      labels: timeSet,
      datasets: lineSpecifications
  },

  // Configuration options go here
  options: {}
});
}
