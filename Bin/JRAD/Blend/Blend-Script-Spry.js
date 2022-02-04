// JavaScript Document
function BLN_SPRY_SWAP (pri_id, sec_id)
{
	var pri_dom = document.getElementById(pri_id);	
	var sec_dom = document.getElementById(sec_id);
	var sec_state = sec_dom.style.display;
	if (!sec_state || sec_state == 'none')
	{
		pri_display = 'none';		
		sec_display = 'block';
	}
	else
	{
		pri_display = 'block';
		sec_display = 'none';
	}
	pri_dom.style.display = pri_display;
	sec_dom.style.display = sec_display;	
}

function JSP_SPRY_LOAD ()
{
	var target = document.getElementById('JSP_SPRY_LOAD_TARGET');
	var property, dot = target.innerHTML;
	
	if (!dot || dot == null)
		property = '.';
	else if (dot == '.')
		property = '..';
	else if (dot == '..')
		property = '...';
	else
		property = '';
	
	target.innerHTML = property;
	setTimeout(JSP_SPRY_LOAD,500);	
}

function BLN_SPRY_KNOB (pri_id, sec_id)
{
	var div = document.getElementById('BLN_SPRY_KNOB_' + pri_id + sec_id);
	var pri_img = document.getElementById('BLN_SPRY_KNOB_' + pri_id);
	var sec_img = document.getElementById('BLN_SPRY_KNOB_' + sec_id);
	var pri_dom = document.getElementById(pri_id);	
	var sec_dom = document.getElementById(sec_id);	
	var sec_state = sec_dom.style.display;
	var pri_display, sec_display;
	if (!sec_state || sec_state == 'none')
	{
		pri_img, pri_display = 'none';		
		sec_img, sec_display = 'inline-block';
	}
	else
	{
		pri_img, pri_display = 'inline-block';		
		sec_img, sec_display = 'none';
	}
	pri_img.style.display = pri_dom.style.display = pri_display;
	sec_img.style.display = sec_dom.style.display = sec_display;
}

function BLN_SPRY_SWITCH (target)
{
	var property;
	var state = document.getElementById(target).style.display;
	if (!state || state == 'none')
		property = 'block';
	else
		property = 'none';		
	document.getElementById(target).style.display = property;
}

function BLN_SPRY_ISWITCH (target, dom, on, off)
{
	var property, text;
	var state = document.getElementById(target).style.display;
	if (!state || state == 'none')
		property = 'block', text = off;
	else
		property = 'none', text = on;		
	document.getElementById(target).style.display = property;		
	document.getElementById(dom).innerHTML = text;			
}

function BLN_SPRY_DRAWER (param)
{
	var dom = document.getElementsByClassName('JSP_SPRY_DRAWER');
	var checkbox = document.getElementById('JSP_SPRY_DRAWER_CHECKBOX');		
	var icon = document.getElementById('JSP_SPRY_DRAWER_ICON');		
	var target = document.getElementsByClassName('JSP_SPRY_DRAWER_TARGET');
	var container = document.getElementsByClassName('container');
	
	var estate = dom[0].getAttribute('ESTATE');
	var status, symbol, i_state, t_state;	
	
	if (param == 'onResize')
	{
		if (window.innerWidth <= estate)
		{
			if (checkbox.checked == true)
			{
				symbol = '&times;';
				t_state = 'inline-block';
			}
			else
			{
				symbol = '&equiv;';				
				t_state = 'none';
			}
			icon.innerHTML = symbol;
			i_state = 'inline-block';
			target[0].setAttribute('id','JSP_SPRY_DRAWER_MENU');
			//UNFOCUS
//			for (i = 0; i < container.length; i++)
//			{
//				container[i].onclick = function () 
//				{
//					if (checkbox.checked == true)
//					{
//						target[0].style.display = 'none';
//						icon.innerHTML = '&equiv;';
//						checkbox.checked = false;
//					}
//				};			
//			}			
		}
		else
		{
			i_state = 'none';
			t_state = 'inline-block';
			target[0].removeAttribute('id');			
		}		
		icon.style.display = i_state
		target[0].style.display = t_state;
	}
	else if (param == 'onClick')
	{
		if (checkbox.checked == true)
		{
			status = false;
			symbol = '&equiv;';
			t_state = 'none';
		}
		else
		{
			status = true;
			symbol = '&times;';
			t_state = 'inline-block';			
		}		
		checkbox.checked = status;
		icon.innerHTML = symbol;
		target[0].style.display = t_state;
	}
	else
		return estate;
}

function BLN_SPRY_IMENU (param)
{
	var dt = document.querySelectorAll('.JSP_SPRY_IMENU dt');
	var dd = document.querySelectorAll('.JSP_SPRY_IMENU dd');
	if (param === null)
	{
		for (var i = 0; i < dt.length; i++)
			dt[i].setAttribute('onClick','BLN_SPRY_IMENU(' + i + ')');
	}
	else
	{
		if (dd[param].style.display == 'block')
			dd[param].style.display = 'none';
		else
		{
			for (var i = 0; i < dd.length; i++)
				dd[i].style.display = 'none';
			dd[param].style.display = 'block';
		}
	}
}

function BLN_SPRY_SUBMENU (param)
{
	var div = document.querySelectorAll('.JSP_SPRY_SUBMENU_TARGET');
	var list = document.querySelectorAll('.JSP_SPRY_SUBMENU li');
	var attr = document.getElementsByClassName('JSP_SPRY_SUBMENU');
	var bgcolor = attr[0].getAttribute('BGCOLOR');
	for (var i = 0; i < div.length; i++)
	{
		div[i].style.display = 'none';
		list[i].style.backgroundColor = bgcolor;
	}
	div[param].style.display = 'block';
	list[param].style.backgroundColor = '#666';	
}

function BLN_SPRY_PASSWORD ()
{
	var target = document.getElementById('password');	
	var dom = document.getElementById('JSP_SPRY_PASSWORD');	
	if (target.getAttribute('type') == 'password')
	{
		target.setAttribute('type','text');
		dom.setAttribute('title','Hide Password');
	}
	else
	{
		target.setAttribute('type','password');	
		dom.setAttribute('title','Show Password');		
	}
}

function BLN_SPRY_TEXTAREA ()
{
	var dom = document.getElementsByClassName('JSP_FORMS_TEXTAREA');
	dom[0].removeAttribute('style');
	dom[0].innerHTML = '';
}

function BLN_SPRY_PROSLIDE ()
{
	var dom = document.getElementsByClassName('JSP_SPRY_CAROUSEL')[0];	
	var transition = dom.getAttribute('TRANSITION');
	setTimeout(BLN_SPRY_CAROUSEL,transition);		
}

function BLN_SPRY_CAROUSEL ()
{
	var dom = document.getElementsByClassName('JSP_SPRY_CAROUSEL')[0];	
	var target = document.getElementsByClassName('JSP_SPRY_CAROUSEL_TARGET')[0];
	var imageArray = dom.querySelectorAll('li');
	var selection = dom.getAttribute('SELECTION');
	var transition = dom.getAttribute('TRANSITION');
	var current = dom.getAttribute('CURRENT');	
	var sizeof = imageArray.length, pointer;
	if (selection == 'RANDOM')
		pointer = Math.floor((Math.random() * sizeof) + 1);	
	else
	{
		pointer = parseInt(current) + 1;
		if (pointer > sizeof)
			pointer = 1;
		dom.setAttribute('current',pointer);	
	}
	var index = pointer - 1;
	var property = 'url(' + imageArray[index].innerHTML + ')';
	if (window.innerWidth <= BLN_SPRY_DRAWER('Estate'))
		target.style.height = '5em';
	else
		target.style.height = '15em';
	target.style.backgroundImage = property;
	setTimeout(BLN_SPRY_CAROUSEL,transition);		
}

function BLN_SPRY_COUNTDOWN ()
{
	var dom = document.getElementsByClassName('JSP_SPRY_COUNTDOWN')[0];	
	var endDate = dom.getAttribute('MKDATE'); //Jan 5, 2018 15:37:25
	var countDownDate = new Date(endDate).getTime();
	var x = setInterval
	(
		function () 
		{			
			var now = new Date().getTime();
			var distance = countDownDate - now;
			
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			var target = document.getElementById('JSP_SPRY_COUNTDOWN_TARGET');
			target.querySelector('#day').innerHTML = BLN_NUMBER_CASE(days);
			target.querySelector('#hour').innerHTML = BLN_NUMBER_CASE(hours);
			target.querySelector('#min').innerHTML = BLN_NUMBER_CASE(minutes);
			target.querySelector('#sec').innerHTML = BLN_NUMBER_CASE(seconds);
			
			if (distance < 0) 
			{				
				clearInterval(x);			
				BLN_REQUEST_SET('JSP_SPRY_COUNTDOWN','true');
			}
		}, 
		1000
	);	
}

function BLN_SPRY_FLASHCARD ()
{
 	var sprys = document.getElementsByClassName('JSP_SPRY_FLASHCARD');
	for (var i = 0; i < sprys.length; i++)
	{
		var dom = sprys[i];		
		var imageArray = dom.querySelectorAll('li');		
		var selection = dom.getAttribute('SELECTION');
		var current = dom.getAttribute('CURRENT');	
		var sizeof = imageArray.length, pointer;
		if (selection == 'RANDOM')
			pointer = Math.floor((Math.random() * sizeof) + 1);	
		else
		{
			pointer = parseInt(current) + 1;		
			if (pointer > sizeof)
				pointer = 1;
			dom.setAttribute('current',pointer);	
		}
		var index = pointer - 1;
		var property = 'url(' + imageArray[index].innerHTML + ')';	
		document.getElementsByClassName('JSP_SPRY_FLASHCARD_TARGET')[i].style.backgroundImage = property;
	}
	setTimeout(BLN_SPRY_FLASHCARD,5000);
}

function BLN_SPRY_FIREFLY (param)
{
 	var sprys = document.getElementsByClassName('JSP_SPRY_FIREFLY');
	for (var i = 0; i < sprys.length; i++)
	{
		var dom = sprys[i];		
		var imageArray = dom.querySelectorAll('li');
		//IF NO IMAGE FOUND
		if (!imageArray[0])
		{
			var popup = document.getElementsByClassName('JSP_SPRY_FIREFLY_POPUP')[i];			
			var target = document.getElementsByClassName('JSP_SPRY_FIREFLY_TARGET')[i];
			target.removeAttribute('onClick');
			popup.style.display = 'block'						
		}
		else
		{
			var sizeof = imageArray.length;		
			var pointer = Math.floor((Math.random() * sizeof) + 1);	
			var index = pointer - 1;		
			var property = 'url(' + imageArray[index].innerHTML + ')';			
			document.getElementsByClassName('JSP_SPRY_FIREFLY_TARGET')[i].style.backgroundImage = property;
		}		
	}
	setTimeout(BLN_SPRY_FIREFLY,30000);				
}

