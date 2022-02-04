<?php
function CORE_SESSION_SET ($key, $value)
{
	$key = JSP_BUILD_CSV($key);
	$value = JSP_BUILD_CSV($value);		
	foreach ($key as $index => $element)
	{
		$element = CORE_SESSION_SCANNER($element);	
		$_SESSION[$element] = $value[$index];
	}
}

function CORE_SESSION_GET ($key)
{
	$key = JSP_BUILD_CSV($key);
	foreach ($key as $index => $element)
	{
		$element = CORE_SESSION_SCANNER($element);
		if (isset($_SESSION[$element]))
			$newArray[$element] = $_SESSION[$element];
	}
	return JSP_CRUNCH_ARRAY($newArray);
}

function CORE_SESSION_CLEAR ($key)
{
	$key = JSP_BUILD_CSV($key);
	foreach ($key as $index => $element)
	{
		$element = CORE_SESSION_SCANNER($element);	
		unset($_SESSION[$element]);
	}
}

function CORE_SESSION_DROP ($header)
{
	session_destroy();
	if ($header)
		_REDIR($header);
}

function CORE_SESSION_SCANNER ($key)
{
	$parseArray = array('CAA','CAU','CAT','CHA','CHU','CHT');
	if (in_array($key,$parseArray))
	{
		if ($key == $parseArray[0])
			$key = 'CORE_APPSTATE_ADMIN';
		if ($key == $parseArray[1])
			$key = 'CORE_APPSTATE_USER';
		if ($key == $parseArray[2])
			$key = 'CORE_APPSTATE_TEMP';
		if ($key == $parseArray[3])
			$key = 'CORE_HISTORY_ADMIN';
		if ($key == $parseArray[4])
			$key = 'CORE_HISTORY_USER';
		if ($key == $parseArray[5])
			$key = 'CORE_HISTORY_TEMP';
	}
	return $key;	
}

?>

