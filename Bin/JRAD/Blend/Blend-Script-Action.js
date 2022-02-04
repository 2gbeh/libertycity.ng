// JavaScript Document
function BLN_ACTION_EDIT (id)
{
	BLN_REQUEST_SET('BLN_ACTION_EDIT',id);
}

function BLN_ACTION_DELETE (message, id)
{
	var message = BLN_TRUEPUT(message,'string');
	var output = confirm(message);
	if (output == true)
		BLN_HEADER_APPEND('BLN_ACTION_DELETE',id);
}

function BLN_ACTION_VIEW (id)
{
	BLN_HEADER_APPEND('BLN_ACTION_VIEW',id);
}

function BLN_ACTION_SELECT ()
{
	var checkbox_all = document.getElementById('BLN_ACTION_SELECT_ALL');
	var checkbox_one = document.getElementsByClassName('BLN_ACTION_SELECT_EACH');
	var checkbox_status;
	if (checkbox_all.checked == false)
		checkbox_status = false;
	else
		checkbox_status = true;
	for (var i = 0; i < checkbox_one.length; i++)
		checkbox_one[i].checked = checkbox_status;
}

function BLN_ACTION_IOPTION (id)
{		
	var dom = document.getElementById(id),
	option = dom.options[dom.selectedIndex],
	value = option.value;
	if (value == "0")
		value = 'NULL';
	BLN_HEADER_APPEND(id,value);
}

function BLN_ACTION_ALBUM (id)
{
	BLN_REQUEST_SET('BLN_ACTION_ALBUM',id);
}

function BLN_ACTION_LOGOUT (request)
{
	request += "&CORE_APPSTATE_LOGOUT=true";
	BLN_HEADER_SET(request);
}

function BLN_ACTION_ILOGOUT (request)
{
	request += "&CORE_APPSTATE_ILOGOUT=true";
	BLN_HEADER_SET(request);
}


