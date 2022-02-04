<?php
function JSP_WIDGETS_PREP ($array)
{
	$paramArray = array($array);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		foreach ($array as $key => $value)
		{
			$newArray[$key] = JSP_BUILD_JUMBO($value);
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_WIDGETS_TOTAL ($tableArray)
{
	$paramArray = array($tableArray);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$tableArray = JSP_BUILD_CSV($tableArray);
		foreach ($tableArray as $tabName)
		{
			$fetchArray = JSP_FETCH_RECORDS($tabName);
			$newArray[] = count($fetchArray);
		}
		return JSP_WIDGETS_PREP($newArray);
	}
}

function JSP_WIDGETS_SUM ($tableArray, $fieldArray)
{
	$paramArray = array($tableArray,$fieldArray);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$tableArray = JSP_BUILD_CSV($tableArray);
		$fieldArray = JSP_BUILD_CSV($fieldArray);		
		foreach ($tableArray as $key => $tabName)
		{
			$predefArray = JSP_FETCH_PREDEF($tabName,$fieldArray[$key],1);
			$newArray[] = array_sum($predefArray[0]);
		}
		return JSP_WIDGETS_PREP($newArray);
	}
}

function JSP_WIDGETS_RECENT ($table, $fieldArray)
{
	$paramArray = array($table,$fieldArray);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$fieldArray = JSP_BUILD_CSV($fieldArray);
		$fetchArray = JSP_FETCH_LAST($table,'ROW');
		if ($fieldArray[0] == '*')
			return $fetchArray;
		else
		{
			foreach ($fetchArray as $key => $value)
			{			
				if (in_array($key,$fieldArray))
					$newArray[$key] = $value;
			}
			return JSP_CRUNCH_ARRAY($newArray);
		}
	}
}

function JSP_WIDGETS_BYDATE ($tableArray, $returnType)
{
	$paramArray = array($tableArray,$returnType);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$tableArray = JSP_BUILD_CSV($tableArray);
		foreach ($tableArray as $key => $tabName)
		{
			$fetchArray = JSP_CRUNCH_ARRAY(JSP_FETCH_PREDEF($tabName,'date',1));
			$newArray[] = JSP_CAL_MKDATE($fetchArray,$returnType);			
		}
		return JSP_WIDGETS_PREP($newArray);
	}
}

function JSP_WIDGETS_PREDEF ($table, $fieldArray, $returnType)
{
	$paramArray = array($table,$fieldArray,$returnType);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$dateArray = JSP_FETCH_PREDEF($table,'date',1);
		$dateArray = JSP_CRUNCH_ARRAY($dateArray);
		$fetchArray = JSP_FETCH_PREDEF($table,$fieldArray,1);				
		foreach ($dateArray as $hotkey => $dates)
		{
			$mktime = JSP_CAL_MKDATE($dates,$returnType);			
			if ($mktime > 0)
			{
				$hotkeys[] = $hotkey;
				foreach ($fetchArray as $index => $assoc_array)
				{
					$hotArray[$index][] = $assoc_array[$hotkey];
				}
			}				
		}
		foreach ($hotArray as $index => $assoc_array)
		{
			$newArray[] = array_sum($assoc_array);
		}
		return JSP_WIDGETS_PREP($newArray);
	}
}

?>




