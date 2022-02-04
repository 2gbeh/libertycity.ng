// JavaScript Document
function BLN_VALIDATE (entry, type)
{
	if (type == 'WHITESPACE') //WHITESPACE
	{
		return /\s/g.test(entry);	
	}
	if (type == 'EMAIL') //EMAIL
	{
		var atpos = entry.indexOf("@");
		var dotpos = entry.lastIndexOf(".");
		if 
		(
			atpos < 1 || 
			dotpos < (atpos + 2) || 
			(dotpos + 2) >= entry.length
		)
			return false;
	}	
	if (type == 'NUMBER') //NUMBER
	{
		return !isNaN(entry);	
	}
}