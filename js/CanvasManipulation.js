

let graphTitle = document.querySelector('.graphTitle');
graphTitle.textContent = 'Graph';

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



/*
first box has holidays
second box has date
third box has free text

second form returns the info just inputted (but it's not planned, but rather pulled from the database)
*/
