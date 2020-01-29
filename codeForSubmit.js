let graphTitle = document.querySelector('.graphTitle');
graphTitle.textContent = 'Title';

let inputs = document.getElementById('container').querySelectorAll('input');

inputs.forEach( (input) => {
  input.addEventListener('click',(e) => {
    if(e.target.type === 'submit') createChart();
  });
});
