
const storeSelection = document.getElementById('storeSelection');
const itemSelection = document.getElementById('itemSelection');
const dateSelection = document.getElementById('dateSelection');
const fromDate = document.getElementById('from');
const toDate = document.getElementById('to');
const submitDates = document.getElementById('submitDates');


let labelTime, request, result, xhttp, storeList, limit=30;


//HTTPRequest SPECIFIC string creation
let POSTlist = new Array();
for (let i = 1; i < storeSelection.length; i++) {
  POSTlist[i] = 'stores[]=' + encodeURIComponent(storeSelection[i].value);
}
POSTlist = POSTlist.join('&');

storeSelection.addEventListener('change',storeListener);
itemSelection.addEventListener('change',storeListener);
dateSelection.addEventListener('change',changeLimit);
submitDates.addEventListener('click', storeListener);

function changeLimit(event) {
  if (event.target.value == 'custom') {
	fromDate.removeAttribute('hidden');
	toDate.removeAttribute('hidden');
	submitDates.removeAttribute('hidden');

  } else {
	limit = event.target.value;
	storeListener();
	fromDate.setAttribute('hidden', true);
	toDate.setAttribute('hidden', true);
	submitDates.setAttribute('hidden',true);
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
  
  if (dateSelection.value=='custom') {
	xhttp.send('table='+item+'&store='+store+'&limit='+limit+'&from='+fromDate.firstElementChild.value+'&to='+toDate.firstElementChild.value+'&customDate='+dateSelection.value);
  } else {
	xhttp.send('table='+item+'&store='+store+'&limit='+limit+'&customDate='+dateSelection.value);
  }

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

  if (dateSelection.value == 'custom') {
	xhttp.send('table='+item+'&stores[]='+stores+'&limit='+limit+'&from='+fromDate.firstElementChild.value+'&to='+toDate.firstElementChild.value+'&customDate='+dateSelection.value);
  } else {
	xhttp.send('table='+item+'&stores[]='+stores+'&limit='+limit+'&customDate='+dateSelection.value);
  }
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
