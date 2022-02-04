<?php
error_reporting(E_ALL ^ E_DEPRECATED);

function JSP_ERROR_HANDLER ($errorNumber, $errorString, $errorFile, $errorLine) {}
set_error_handler ("JSP_ERROR_HANDLER");

function JSP_TRUEPUT ($entry)
{
	if (JSP_ATYPE($entry) == 1)
	{		
		foreach ($entry as $key => $value)
		{
			if ($value == '0' || $value == '' || $value == ' ')
				$entry[$key] = 1;		
		}
	}
	else if (JSP_ATYPE($entry) == 2)
	{
		foreach ($entry as $index => $assoc_array)	
		{
			foreach ($assoc_array as $key => $value)
			{
				if ($value == '0' || $value == '' || $value == ' ')
					$entry[$index][$key] = 1;		
			}			
		}	
	}	
	else
	{	
		if ($entry == '0' || $entry == '' || $entry == ' ')
			$entry = 1;
	}
	return $entry;
}

function JSP_PARAM_FORMAT ($paramArray)
{
	foreach ($paramArray as $value)
	{
		if ($value === null || $value === '' || $value === ' ')
			return 1;
	}
}

function JSP_PARAM_PARSE ($parseArray, $param)
{
	if (!in_array($param,$parseArray))
		return 1;
}

function JSP_ERROR_LOG ($type)
{
	$paramArray = array ($type);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if ($type == 'true')
			return 'query is true';
		else if ($type == 'false')
			return 'query is false';			
		else if ($type == 'empty')
			return 'entry is empty';
		else if ($type == 'option')
			return 'no option selected';
		else if ($type == 'regex')
			return 'bad regex';	
		else if ($type == 'strlen')
			return 'min/max string length exceeded';	
		else if ($type == 'range')
			return 'min/max range exceeded';				
		else if ($type == 'cap')
			return 'maximum limit exceeded';							
		else if ($type == 'cat')
			return 'category not found';
		else if ($type == 'typo')
			return 'spellcheck error';		
		else if ($type == 'required')
			return 'required field is empty';		
		else if ($type == 'type' || $type == 'datatype')
			return 'invalid data type';								
		else if ($type == 'format')
			return 'invalid format';
		else if ($type == 'lang')
			return 'language control is on';		
		else if ($type == 'object')
			return 'not found';
		else if ($type == 'logical')
			return 'logical error';	
		else if ($type == 'parse')
			return 'parse error';	
		else
			return 'error log undefined';
	}
}

function JSP_ERROR_CATCH ($parse)
{
	$exceptions = array(JSPIF,JSPIP,JSPIL,JSPON);
	if (in_array($parse,$exceptions))
			return 1;
}

function JSP_ERROR_THROW ($parse)
{
	if (_ISSTR($parse))
		$pointer = $parse;
	else if (_ISLIN($parse))
		$pointer = current($parse);
	else if (_ISDIM($parse))
		$pointer = current($parse[0]);

	if 
	(
		$pointer !== null && 
		!JSP_ERROR_CATCH($pointer) && 
		JSP_CTYPE($pointer) != 5
	)
		return $parse;	
}

function JSP_ERROR_FILTER ($parse, $returnType)
{
	$parseArray = array
	(
		0,
		'Not found',
		'Not specified',
		'No records found',
		'Empty',
		'N/A'
	);
	if (!$parse)
		return $parseArray[$returnType];
	else
		return $parse;
}
?>

