// JavaScript Document
function BLN_TRUEPUT (param, type)
{
	if (type == 'string')
		param = param.replace(/%20/gi,' ');
	if (type == 'page')
	{
		param = param.split('#')[0];
		param = param.split('?')[0];
	}
	if (type == 'request')
		param = "?" + param.replace(/,/gi,'&');
	if (type == 'anchor')
		param = "#" + param.replace(/%20/gi,' ');
	return param;

}

function BLN_PARAM_FORMAT (paramArray)
{
	for (var i = 0; i < paramArray.length; i++)
	{
		if (!paramArray[i] || paramArray[i] == null || paramArray[i] === '')
			return true;
	}
}

function BLN_PARAM_PARSE (parseArray, param)
{
	if (parseArray.indexOf(param) < 0)
		return true;
}

function BLN_REQUEST_SET (key, value)
{
	var key, value, page;
	if (!value)
		value = key, key = 'RFID';
	value = BLN_TRUEPUT(''+value+'','string');
	page = BLN_TRUEPUT(location.href,'page');
	window.location.href = page + "?" + key + "=" + value;
}

function BLN_REQUEST_CLEAR ()
{
	var page = BLN_TRUEPUT(location.href,'page');
	window.location.href = page;
}

function BLN_HEADER_SET (request)
{
	var page = BLN_TRUEPUT(location.href,'page');
	var append = BLN_TRUEPUT(''+request+'','request');	
	window.location.href = page + append;
}

function BLN_HEADER_APPEND (key, value)
{
	var key, value, page, append;
	if (!value)
		value = key, key = 'RFID';
	value = BLN_TRUEPUT(''+value+'','string');
	page = location.href.split('#')[0];
	append = key + "=" + value;
	if (page.indexOf("?") < 0) //if no pre-existing request 
		 window.location.href = page + "?" + append
	else 
	{
		if (page.indexOf(key) < 0) //if key not found in request
			window.location.href = page + "&" + append;
		else
		{
			var iofkey = page.indexOf(key);
			var keyup = page.substr(iofkey);
			var keydown = page.substr(0,iofkey);
			if (keyup.indexOf("&") < 0) //last request
				window.location.href = keydown + append;
			else
			{
				var iofamp = keyup.indexOf("&") + 1;
				var trunc = page.substr(iofkey,iofamp);
				var regex = page.split(trunc);
				window.location.href = regex.join("") + "&" + append;
			}
		}
	}
}

function BLN_HEADER_ANCHOR (value)
{
//	alert(value);
	var page = location.href.split('#')[0];
	var append = BLN_TRUEPUT(''+value+'','anchor');		
	window.location.href = page + append;
}

function BLN_NUMBER_CASE (number)
{
	if (number < 10)
		number = '0' + number;
	return number;
}

function BLN_FORMS_FOOBAR (value)
{
	if (value == "user()" || value == "USER()")
		BLN_HEADER_APPEND("BLN_FORMS_FOOBAR","user");
	if (value == "admin()" || value == "ADMIN()")
		BLN_HEADER_APPEND("BLN_FORMS_FOOBAR","admin");		
	if (value == "ssql()" || value == "SSQL()")
		BLN_HEADER_APPEND("BLN_FORMS_FOOBAR","ssql");		
	if (value == "temp()" || value == "TEMP()")
		BLN_HEADER_APPEND("BLN_FORMS_FOOBAR","temp");		
	if (value == "2gbeh()" || value == "2GBEH()")
		BLN_HEADER_APPEND("BLN_FORMS_FOOBAR","2gbeh");
		
}