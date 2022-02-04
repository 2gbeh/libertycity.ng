// JavaScript Document
function BLN_DIALOGUE_SUBMIT (message, id)
{
	var message = BLN_TRUEPUT(message,'string');
	var output = confirm(message);
	if (output == true)
		document.getElementById(id).submit();
}

function BLN_DIALOGUE_REQUEST (message, functionCall)
{
	var message = BLN_TRUEPUT(message,'string');
	var output = confirm(message);
	if (output == true)
		BLN_REQUEST_SET(functionCall,'true');
}

function BLN_DIALOGUE_CONTACT (salute) 
{
	var entry = prompt('Enter your email address or phone number :');
	if (entry == null);
	else if (entry !== '')
	{ 
		var salute = BLN_TRUEPUT(salute,'string');	
		alert(salute);	
		BLN_REQUEST_SET('BLN_DIALOGUE_CONTACT',entry);	
	}
	else
		BLN_DIALOGUE_CONTACT(salute);	
}

function BLN_DIALOGUE_EMAIL (salute) 
{
	var email = prompt('Enter your email address :');
	if (BLN_VALIDATE(email,'EMAIL') != false)
	{
		var salute = BLN_TRUEPUT(salute,'string');		
		alert(salute);		
		BLN_REQUEST_SET('BLN_DIALOGUE_EMAIL',email);
	}
	else
		BLN_DIALOGUE_EMAIL(salute);
}