<?php
function JSP_MAPPER_LOGIC ($table, $counterField, $dateField)
{
	$paramArray = array($table,$counterField,$dateField);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		$fieldArray = $counterField.','.$dateField;
		$predef = JSP_FETCH_PREDEF($table,$fieldArray,1);
		$counter = $predef[0];
		$date = $predef[1];
		foreach ($counter as $key => $occur)
		{
			for ($i = 0; $i < $occur; $i++)
			{
				$dateArray[] = $date[$key];
			}
		}
		return $dateArray;
	}
}

function JSP_MAPPER_WEEK ($dateArray)
{
	$paramArray = array($dateArray);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		$array = JSP_CAL_MKWEEK('CURRENT','LONG');
		foreach ($array as $value)
		{
			$newArray[$value] = JSP_SORT_OCCUR($dateArray,$value,'REAL');
		}
		return $newArray;
	}
}


function JSP_MAPPER_UNIX ($dateArray)
{
	$paramArray = array($dateArray);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);		
		$array = JSP_MAPPER_WEEK ($dateArray);
		$prevWeek = JSP_CAL_MKWEEK('PREVIOUS','LONG');		
		$pointer = 0;
		foreach ($array as $key => $value)
		{
			if ($pointer == 0)
			{
				$newArray[end($prevWeek)] = JSP_SORT_OCCUR($dateArray,end($prevWeek),'REAL');
				$newArray[$key] = $value;				
			}
			else if ($pointer == (count($array) - 1));
			else
				$newArray[$key] = $value;
			$pointer++;
		}	
		return $newArray;
	}
}

function JSP_MAPPER_BYWEEK ($dateArray)
{
	$paramArray = array($dateArray);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		$array = JSP_MAPPER_MONTH($dateArray);
		$fragArray = JSP_FRAG_ARRAY($array,7);
		foreach ($fragArray as $index => $assoc_array)
		{
			$arrayKeys = array_keys($assoc_array);
			$newArray[$arrayKeys[0]] = array_sum($assoc_array);
		}
		return $newArray;
	}
}

function JSP_MAPPER_MONTH ($dateArray)
{
	$paramArray = array($dateArray);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		$array = JSP_CAL_MKMONTH('CURRENT','LONG');
		foreach ($array as $value)
		{
			$newArray[$value] = JSP_SORT_OCCUR($dateArray,$value,'REAL');
		}
		return $newArray;
	}
}

function JSP_MAPPER_BYMONTH ($dateArray)
{
	$paramArray = array($dateArray);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		$mkyear = date('Y');		
		$mkmonth = range(1,12);
		foreach ($dateArray as $dates)
		{
			$crunchArray = JSP_CRUNCH_DATE($dates,'ARRAY');
			$year = $crunchArray['year'];
			$month = $crunchArray['month'];
			$mkdate[] = $year.'/'.$month;
		}
		foreach ($mkmonth as $month)
		{
			$mkformat = $mkyear.'/'.$month;
			$newArray[$month] = JSP_SORT_OCCUR($mkdate,$mkformat,'REAL');
		}		
		return $newArray;
	}
}

function JSP_MAPPER_QUARTER ($dateArray)
{
	$paramArray = array($dateArray);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		$array = JSP_MAPPER_BYMONTH($dateArray);
		$fragArray = JSP_FRAG_ARRAY($array,3);
		foreach ($fragArray as $key => $assoc_array)
		{
			$key++;
			$newArray[$key] = array_sum($assoc_array);
		}
		return $newArray;
	}
}

function JSP_MAPPER_HALVES ($dateArray)
{
	$paramArray = array($dateArray);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		$array = JSP_MAPPER_QUARTER($dateArray);
		$fragArray = JSP_FRAG_ARRAY($array,2);
		foreach ($fragArray as $key => $assoc_array)
		{
			$key++;
			$newArray[$key] = array_sum($assoc_array);
		}
		return $newArray;
	}
}

function JSP_MAPPER_SCALE ($dateArray)
{
	$paramArray = array($dateArray);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		foreach ($dateArray as $dates)
		{
			$crunchArray = JSP_CRUNCH_DATE($dates,'ARRAY');	
			$yearArray[] = $crunchArray['year'];
		}
		$mkyear = JSP_BUTCHER_DATE(JSP_DATE_SHORT,'YEAR','SHORT');
		$scale = $mkyear - 4;
		$key = 1;
		for ($i = $scale; $i <= $mkyear; $i++)
		{
			$scaleArray[$key] = $i;
			$key++;
		}	
		foreach ($scaleArray as $year)
		{
			$newArray[$year] = JSP_SORT_OCCUR($yearArray,$year,'REAL');		
		}
		return $newArray;
	}
}

?>


