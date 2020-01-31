let graphTitle = document.querySelector('.graphTitle');
graphTitle.textContent = 'Title';

let inputs = document.getElementById('container').querySelectorAll('input');

inputs.forEach( (input) => {
  input.addEventListener('click',(e) => {
    if(e.target.type === 'submit') createChart();
  });
});

/*
first box has holidays
second box has date
third box has free text

second form returns the info just inputted (but it's not planned, but rather pulled from the database)
*/
