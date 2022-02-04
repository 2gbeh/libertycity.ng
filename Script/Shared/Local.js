// JavaScript Document
//alert("Server request recieved!");
function DRA_SEARCH_CLEAR ()
{
	document.getElementById('keyword').value = '';
}

function DRA_SEARCH_TOGGLE ()
{
	var dom = document.getElementsByClassName('search')[0];
	var y_state, x_state = dom.style.visibility;
	if (!x_state || x_state == 'hidden')
		y_state = 'visible';
	else
		y_state = 'hidden';
	document.getElementsByClassName('search')[0].style.visibility = y_state;
}

function DRA_LOOP_MANTRA ()
{
	var target = document.getElementById('DRA_LOOP_MANTRA_TARGET');	
	var dom = document.getElementsByClassName('DRA_LOOP_MANTRA')[0]
	var array = dom.querySelectorAll('li');
	var current = dom.getAttribute('CURRENT');	
	var sizeof = array.length, pointer;

	pointer = parseInt(current) + 1;
	if (pointer > sizeof)
	{
		target.innerHTML = 'Only on Libertycity';
		return 1;
	}
			
	dom.setAttribute('current',pointer);		
	var index = pointer - 1;
	var property = array[index].innerHTML;
	target.innerHTML = 'All the <b>' + property + '</b> you love';	
	setTimeout(DRA_LOOP_MANTRA,1000);	
}

function DRA_LOOP_OTIS ()
{
	var target = document.getElementById('DRA_LOOP_OTIS_TARGET');	
	var dom = document.getElementsByClassName('DRA_LOOP_OTIS')[0];
	var current = dom.getAttribute('CURRENT');		
	var end = dom.getAttribute('END');	
	var pointer = parseInt(current) + 100000;
	
	if (pointer > end)
	{
		target.innerHTML = end;	
		return 1;
	}
	
	dom.setAttribute('current',pointer);		
	target.innerHTML = pointer;
	setTimeout(DRA_LOOP_OTIS,80);	
}