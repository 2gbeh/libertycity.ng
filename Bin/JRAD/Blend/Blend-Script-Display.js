// JavaScript Document
function BLN_DISPLAY_DOM (id, type)
{
	var id, type, dom = document.getElementById(id);
	if (type == 'OPEN')
		dom.style.display = 'block';
	else if (type == 'CLOSE')
		dom.style.display = 'none';
	else
		BLNIP();
}

function BLN_DISPLAY_DLIST (param)
{
	var dt = document.querySelectorAll('.JSP_DISPLAY_DLIST dt');
	var dd = document.querySelectorAll('.JSP_DISPLAY_DLIST dd');
	var sign = document.querySelectorAll('.JSP_DISPLAY_DLIST .sign');		
	//IF DRAWER IS ALREADY OPEN
	if (dd[param].style.display == 'block')
	{
		dd[param].style.display = 'none';
		sign[param].innerHTML = '+';			
	}
	else
	{
		for (var i = 0; i < dd.length; i++)
		{
			dt[i].style.backgroundColor = '#FFF';
			dd[i].style.display = 'none';
			sign[i].innerHTML = '+';				
		}
		dt[param].style.backgroundColor = '#F5F5F5';
		dd[param].style.display = 'block';
		sign[param].innerHTML = '-';
	}
}

function BLN_DISPLAY_ITABLE_NAV (param)
{
	var page = location.href, hash, rehash;
	var left = 'nav_left_' + param, right = 'nav_right_' + param;
	if (page.indexOf("#") < 0) //no hash
		rehash = right;
	else
	{
		var iofkey = page.indexOf('#');
		var keyup = page.substr(iofkey + 1);		
		if (keyup == right)
			rehash = left;	
		else 
			rehash = right;
	}
	var display  = page + '---' + page.length + '---' + 
	iofkey + '---' + keyup + '---' + rehash;
//	alert(display);
	BLN_HEADER_ANCHOR(rehash);
}

function BLN_PAGI_CHANGE (id)
{
	BLN_REQUEST_SET('BLN_PAGI_CHANGE',id);	
}

function BLN_PAGI_PREV ()
{
	var current = document.getElementsByClassName('JSP_DISPLAY_PAGI_HIDDEN')[0].innerHTML;
	current = current - 1;
	BLN_REQUEST_SET('BLN_PAGI_CHANGE',current);
}

function BLN_PAGI_NEXT ()
{
	var current = document.getElementsByClassName('JSP_DISPLAY_PAGI_HIDDEN')[0].innerHTML;
	current = current - 1;
	BLN_REQUEST_SET('BLN_PAGI_CHANGE',current);
}

function BLN_DISPLAY_DOWVID ()
{
 	alert('Right-click video and select "Save Video As..."');
}

function BLN_DISPLAY_ALBUM ()
{
 	var album = document.getElementsByClassName('JSP_DISPLAY_ALBUM_TARGET');
	var transition = document.getElementsByClassName('JSP_DISPLAY_ALBUM')[0].getAttribute('transition');
	for (var i = 0; i < album.length; i++)
	{	
		var listArray = document.querySelectorAll('.JSP_DISPLAY_ALBUM_TARGET ol')[i];
		var imageArray = listArray.getElementsByTagName('li');
		var pointer = Math.floor((Math.random() * imageArray.length) + 1);
		var index = pointer - 1;
		var property = 'url("' + imageArray[index].innerHTML + '")';
		album[i].style.backgroundImage = property;
	}
	setTimeout(BLN_DISPLAY_ALBUM,transition);
}

function BLN_PREVIEW_OPEN (src)
{
	var url = BLN_TRUEPUT(src,'string');
	document.getElementById('JSP_DISPLAY_PREVIEW_DIM').style.display = 
	document.getElementById('JSP_DISPLAY_PREVIEW_WRAP').style.display = "block";	
	document.getElementById('JSP_DISPLAY_PREVIEW_IMAGE').src = url;
}

function BLN_PREVIEW_CLOSE ()
{
	document.getElementById('JSP_DISPLAY_PREVIEW_DIM').style.display = 
	document.getElementById('JSP_DISPLAY_PREVIEW_WRAP').style.display = "none";
}


function BLN_MODAL_OPEN (target)
{
	var tag = document.createElement("div");
	var src = document.getElementById(target);
	tag.setAttribute("class","JSP_DISPLAY_MODAL");	
	tag.setAttribute("onClick","BLN_MODAL_CLOSE("+ target +")");
	document.body.appendChild(tag);
	src.className += " JSP_DISPLAY_MODAL_TARGET";
	src.style.display = "block";
}

function BLN_MODAL_CLOSE (target)
{
	var tag = document.getElementsByClassName("JSP_DISPLAY_MODAL");
	var src = target;
	for (i = 0; i <= tag.length; i++)
	{
		tag[i].style.display = "none";
		src.style.display = "none";
	}
}



