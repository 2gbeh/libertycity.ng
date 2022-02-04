<?php
function DRA_SSQL_SWISS ($table = JSP_TABLE_USER, $parse)
{
	$TABLE = $table;
	$predefArray = JSP_FETCH_PREDEF($TABLE,'*');
	$fieldArray = JSP_FETCH_FIELDS($TABLE);
	$parseArray = array('FIELD','NUMROWS','RECENT');
	foreach ($predefArray as $index => $assoc_array)
	{
		foreach ($assoc_array as $key => $value)
		{
			if ($index == 0)
			{
				if (JSP_SORT_GATE($value,array(JSP_SUPER_ADMIN,EMAIL),'OR'))
					$hotkeys[] = $key;
			}
		}
		foreach ($assoc_array as $key => $value)
		{		
			if (JSP_SORT_GATE($key,$hotkeys,'NOT'))
				$newArray[$index][$key] = $value;
		}	
	}
	
	if (in_array($parse,JSP_BUILD_CASE($fieldArray))) //PARAM PARSE
	{	
		if ($parse == $parseArray[0]) //FIELD
			return $fieldArray;
		else if ($parse == $parseArray[1]) //NUMROWS
			return count($newArray[0]);	
		else if ($parse == $parseArray[2]) //RECENT
			return JSP_FETCH_LAST($TABLE,'ROW');
	}
	else if (in_array($parse,JSP_BUILD_CASE($fieldArray))) //FIELD NAME
	{
		$BYCOL = _BYCOL($TABLE,JSP_DROP_CASE($parse));
		return JSP_SORT_EXCLUDE($BYCOL,$hotkeys,'KEY');
	}
	else
	{
		if (is_numeric($parse)) //ID
			return _BYID($TABLE,$parse);
		else if (_ISCHAR($parse)) //USERNAME
			return _SWITCH($TABLE,'username',$parse);
		else //ARRAY
			return $newArray;
	}
}

?>