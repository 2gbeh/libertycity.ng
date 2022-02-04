<?php
function JSP_CAL_MKFORMAT ($dateArray, $entryFormat = 'DATE', $returnType = 'PRESET')
{
	$paramArray = array($dateArray,$entryFormat,$returnType);	
	$parseArray = array
	(
		array ('DATE','TIME'),
		JSP_ENUMS_PREDEF('MKFORMAT')
	);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$entryFormat) ||
		JSP_PARAM_PARSE($parseArray[1],$returnType)
	)
		return JSPIP;
	else 
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		foreach ($dateArray as $dates)
		{
			if ($entryFormat == $parseArray[0][0]) //DATE
			{
				//MKTIME SETTING
				$crunchArray = JSP_CRUNCH_DATE($dates,'ARRAY');
				$year = $crunchArray['year'];
				$month = $crunchArray['month'];
				$day = $crunchArray['day'];						
				$mktime = mktime(0,0,0,$month,$day,$year);				
				
				if ($returnType == $parseArray[1][0]) //PRESET
					$newArray[] = date('F j, Y',$mktime);
				else if ($returnType == $parseArray[1][1]) //LONG
					$newArray[] = date('Y/n/j/w/z',$mktime);
				else if ($returnType == $parseArray[1][2]) //SHORT
					$newArray[] = date('Y/n/j',$mktime);
				else if ($returnType == $parseArray[1][3]) //EVENT
					$newArray[] = date('l, jS \of F Y',$mktime);
				else if ($returnType == $parseArray[1][4]) //STAMP
					$newArray[] = date('YmdHis',$mktime);	
				else if ($returnType == $parseArray[1][5]) //FORMAL
					$newArray[] = date('d/m/y',$mktime);	
				else if ($returnType == $parseArray[1][6]) //LBS
				{
					$dow = date('D',$mktime);
					$substr = substr($dow,0,2);
					$upper = strtoupper($substr);					
					$newArray[] = $upper.date('dmy',$mktime);
				}
				else if ($returnType == $parseArray[1][7]) //METRO
					$newArray[] = date('l, F j, Y',$mktime);
				else if ($returnType == $parseArray[1][8]) //TELLER
					$newArray[] = date('D, M d, Y',$mktime);
				else if ($returnType == $parseArray[1][9]) //FEED
					$newArray[] = date('j M',$mktime);
				else //ETA
					$newArray[] = date('Y/n/j H:i',$mktime);					
			}
			else //TIME
			{
				//MKTIME SETTING
				$crunchArray = JSP_CRUNCH_TIME($dates,'ARRAY');
				$hour = $crunchArray['hour'];
				$minute = $crunchArray['minute'];
				$second = $crunchArray['second'];						
				$mktime = mktime($hour,$minute,$second,0,0,0);				
								
				if 
				(
					$returnType == $parseArray[1][0] || //PRESET
					$returnType == $parseArray[1][7] || //METRO
					$returnType == $parseArray[1][8] //TELLER
				)
					$newArray[] = date('h:i A',$mktime);
				else if 
				(
					$returnType == $parseArray[1][1] || //LONG
					$returnType == $parseArray[1][6] //LBS
				)
					$newArray[] = date('H:i:s',$mktime);
				else if ($returnType == $parseArray[1][3]) //EVENT
					$newArray[] = date('g A',$mktime);
				else if ($returnType == $parseArray[1][4]) //STAMP
					$newArray[] = date('His',$mktime);
				else if ($returnType == $parseArray[1][9]) //FEED
					$newArray[] = date('H:i',$mktime);
				else //SHORT,FORMAL,FEED,ETA
					$newArray[] = date('H:i',$mktime);
			}
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_CAL_MKTIME ($dateArray, $returnType)
{
	$paramArray = array($dateArray,$returnType);	
	$parseArray = array('LEAP','YEARDAY','DOM','WEEK','DOW','DAY');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;
	else 
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		foreach ($dateArray as $dates)
		{
			$crunchArray = JSP_CRUNCH_DATE($dates,'ARRAY');
			$year = $crunchArray['year'];
			$month = $crunchArray['month'];
			$day = $crunchArray['day'];						

			//MKTIME SETTING
			$mktime = mktime(0,0,0,$month,$day,$year);
			if ($returnType == $parseArray[0]) //LEAP
				$newArray[] = date("L",$mktime);		
			else if ($returnType == $parseArray[1]) //YEARDAY
				$newArray[] = date("z",$mktime);
			else if ($returnType == $parseArray[2]) //DOM
				$newArray[] = date("t",$mktime);			
			else if ($returnType == $parseArray[3]) //WEEK
				$newArray[] = date("W",$mktime);		
			else if ($returnType == $parseArray[4]) //DOW
				$newArray[] = date("w",$mktime);		
			else //DAY
				$newArray[] = date("l",$mktime);								
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_CAL_MKDATE ($dateArray, $returnType)
{
	$paramArray = array($dateArray,$returnType);	
	$parseArray = JSP_BUILD_CASE(JSP_ENUMS_PREDEF('MKDATE'));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;		
	else 
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		foreach ($dateArray as $dates)
		{
			$crunchArray = JSP_CRUNCH_DATE($dates,'ARRAY');
			$yearArray[] = $crunchArray['year'];
			$monthArray[] = $crunchArray['month'];
			$dayArray[] = $crunchArray['day'];									
		}
		$counter = 0;
		$mktime = date('Y n j');
		$mktimeYear = date('Y');
		$mktimeMonth = date('n');
		$mktimeDay = date('j');
		$mktimeWeek = date('W');		
		if ($returnType == $parseArray[0]) //TODAY
		{
			$array = JSP_CONCAT_ARRAY(array($yearArray,$monthArray,$dayArray),'Y',3);
		}
		else if ($returnType == $parseArray[1]) //YESTERDAY
		{
			$array = JSP_CONCAT_ARRAY(array($yearArray,$monthArray,$dayArray),'Y',3);
			if ($mktimeMonth == '1' && $mktimeDay == '1') //DAY 1 OF YEAR
			{
				$mktimeYear = $mktimeYear - 1;
				$mktime = $mktimeYear.' 12 31';
			}			
			else if ($mktimeMonth != '1' && $mktimeDay == '1') //DAY 1 OF MONTH
			{
				$mktimeMonth = $mktimeMonth - 1;
				$dateArray = $mktimeYear.'/'.$mktimeMonth.'/15';
				$mktimeDay = JSP_CAL_MKTIME($dateArray,'DOM');
				$mktime = $mktimeYear.' '.$mktimeMonth.' '.$mktimeDay;
			}
			else
			{
				$mktimeDay = $mktimeDay - 1;
				$mktime = $mktimeYear.' '.$mktimeMonth.' '.$mktimeDay;
			}
		}		
		else if ($returnType == $parseArray[2]) //THIS WEEK
		{
			$array = JSP_CAL_MKTIME($dateArray,'WEEK');
			$dateArray = $mktimeYear.'/'.$mktimeMonth.'/'.$mktimeDay;
			$mktime = JSP_CAL_MKTIME($dateArray,'WEEK');
		}
		else if ($returnType == $parseArray[3]) //LAST WEEK
		{
			$array = JSP_CAL_MKTIME($dateArray,'WEEK');			
			if ($mktimeWeek == '01') //WEEK 1 OF YEAR
			{
				$mktimeYear = $mktimeYear - 1;
				$dateArray = $mktimeYear.'/12/31';
				$mktime = JSP_CAL_MKTIME($dateArray,'WEEK');				
			}			
			else
			{
				$dateArray = $mktimeYear.'/'.$mktimeMonth.'/'.$mktimeDay;
				$mktime = JSP_CAL_MKTIME($dateArray,'WEEK');				
				$mktime = $mktime - 1;
				if ($mktime < 10)
					$mktime = '0'.$mktime;
			}
		}					
		else if ($returnType == $parseArray[4]) //THIS MONTH
		{
			$array = JSP_CONCAT_ARRAY(array($yearArray,$monthArray),'Y',2);
			$mktime = $mktimeYear.' '.$mktimeMonth;
		}
		else if ($returnType == $parseArray[5]) //LAST MONTH
		{
			$array = JSP_CONCAT_ARRAY(array($yearArray,$monthArray),'Y',2);
			if ($mktimeMonth == '1') //MONTH 1 OF YEAR
			{
				$mktimeYear = $mktimeYear - 1;
				$mktime = $mktimeYear.' 12';
			}
			else
			{
				$mktimeMonth = $mktimeMonth - 1;
				$mktime = $mktimeYear.' '.$mktimeMonth;				
			}
		}		
		else if ($returnType == $parseArray[6]) //THIS YEAR
		{
			$array = $yearArray;
			$mktime = $mktimeYear;
		}		
		else //LAST YEAR
		{
			$array = $yearArray;
			$mktime = $mktimeYear - 1;
		}
		
		//SETTINGS
		foreach ($array as $value)
		{
			if ($mktime == $value)
				$counter++;
		}		
		return $counter;
	}
}

function JSP_CAL_MKHOUR ($startDate, $startTime, $predefHour)
{
	$paramArray = array($startDate,$startTime,$predefHour);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		//CRUNCH DATE
		$JSP_CRUNCH_DATE = JSP_CRUNCH_DATE($startDate,'ARRAY');
		$year = $JSP_CRUNCH_DATE['year'];
		$month = $JSP_CRUNCH_DATE['month'];
		$day = $JSP_CRUNCH_DATE['day'];
		//CRUNCH TIME		
		$JSP_CRUNCH_TIME = JSP_CRUNCH_TIME($startTime,'ARRAY');		
		$hour = $JSP_CRUNCH_TIME['hour'];
		$minute = $JSP_CRUNCH_TIME['minute'];
		$second = $JSP_CRUNCH_TIME['second'];
		//LOGIC
		$derivative = $hour + $predefHour;
		$plusDays = floor($derivative / 24);
		$leftHours = floor($derivative % 24);
		//SETTINGS
		$newDay = $day + $plusDays;
		if (!$leftHours || $leftHours == 0 || $leftHours === 0 || $leftHours === '0')
			$leftHours = '00';
		else
			$leftHours = JSP_NUMBER_CASE($leftHours,'DIGIT');
		$newTime = $leftHours.':'.$minute.':'.$second;
		$newDate = date('Y/n/j',mktime(0,0,0,$month,$newDay,$year));
		return array('DATE' => $newDate,'TIME' => $newTime);
	}
}

function JSP_CAL_MKYESTER ($dateArray, $returnType)
{
	$paramArray = array($dateArray,$returnType);	
	$parseArray = array('SHORT','LONG');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;
	else 
	{
		$crunchArray = JSP_CRUNCH_DATE($dateArray,'ARRAY');
		$mktimeYear = $crunchArray['year'];
		$mktimeMonth = $crunchArray['month'];		
		$mktimeDay = $crunchArray['day'];
		if ($mktimeMonth == '1' && $mktimeDay == '1') //DAY 1 OF YEAR
		{
			$mktimeYear = $mktimeYear - 1;
			$mktime = $mktimeYear.'/12/31';
		}			
		else if ($mktimeMonth != '1' && $mktimeDay == '1') //DAY 1 OF MONTH
		{
			$mktimeMonth = $mktimeMonth - 1;
			$dateArray = $mktimeYear.'/'.$mktimeMonth.'/15';
			$mktimeDay = JSP_CAL_MKTIME($dateArray,'DOM');
			$mktime = $mktimeYear.'/'.$mktimeMonth.'/'.$mktimeDay;
		}
		else
		{
			$mktimeDay = $mktimeDay - 1;
			$mktime = $mktimeYear.'/'.$mktimeMonth.'/'.$mktimeDay;
		}
		if ($returnType == $parseArray[1]) //LONG
		{
			$mkDow = JSP_CAL_MKTIME($mktime,'DOW');
			$mkYearday = JSP_CAL_MKTIME($mktime,'YEARDAY');
			$mktime .= '/'.$mkDow.'/'.$mkYearday;
		}
		return $mktime;
	}
}

function JSP_CAL_MKWEEK ($type, $format)
{
	$paramArray = array($type,$format);	
	$parseArray = array
	(
		array ('CURRENT','PREVIOUS'),
		array ('SHORT','LONG')
	);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$type) ||
		JSP_PARAM_PARSE($parseArray[1],$format)		
	)
		return JSPIP;
	else 
	{
		$prevArray = JSP_CAL_MKMONTH('PREVIOUS',$format);
		$curArray = JSP_CAL_MKMONTH('CURRENT',$format);
		$dateArray = JSP_STACK_ARRAY(array($prevArray,$curArray));
		$mkweek = JSP_CAL_MKTIME(JSP_DATE_LONG,'WEEK');
		
		if ($type == $parseArray[0][1]) //PREVIOUS
		{
			if ($mkweek == '01')
				$mkweek = 52;
			else
				$mkweek = $mkweek - 1;			
		}
			
		//SETTINGS
		foreach ($dateArray as $dates)
		{
			if (JSP_CAL_MKTIME($dates,'WEEK') == $mkweek)
				$newArray[] = $dates;
		}
		return $newArray; 
	}	
}

function JSP_CAL_MKMONTH ($type, $format)
{
	$paramArray = array($type,$format);	
	$parseArray = array
	(
		array ('CURRENT','PREVIOUS'),
		array ('SHORT','LONG')
	);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$type) ||
		JSP_PARAM_PARSE($parseArray[1],$format)		
	)
		return JSPIP;
	else 
	{
		$mktime = JSP_DATE_LONG;
		$crunchArray = JSP_CRUNCH_DATE($mktime,'ARRAY');
		$mkyear = $crunchArray['year'];
		$mkmonth = $crunchArray['month'];
		$mkday = $crunchArray['day'];			
		$mkdow = JSP_BUTCHER_DATE($mktime,'DOW','LONG');				
		$mkyearday = JSP_BUTCHER_DATE($mktime,'YEARDAY','LONG');	
					
		if ($type == $parseArray[0][1]) //PREVIOUS MONTH
		{
			$mkmonth = $mkmonth - 1;
			if ($mkmonth < 1)
			{
				$mkyear = $mkyear - 1;
				$mkmonth = 12;
			}
			$mktime = $mkyear.'/'.$mkmonth.'/'.$mkday.'/'.$mkdow.'/'.$mkyearday;
		}
		
		//SHORT FORMAT				
		$mkdom = JSP_CAL_MKTIME($mktime,'DOM');				
		$counter = 1;
		while ($counter <= $mkdom)
		{
			$mkday = $counter;
			$shortArray[] = $mkyear.'/'.$mkmonth.'/'.$mkday;
			$counter++;
		}
		
		//LONG FORMAT
		$counter = 1;
		$mkdow = JSP_CAL_MKTIME($shortArray[0],'DOW');
		$mkyearday = JSP_CAL_MKTIME($shortArray[0],'YEARDAY');
		while ($counter <= $mkdom)
		{
			$mkday = $counter;
			$longArray[] = $mkyear.'/'.$mkmonth.'/'.$mkday.'/'.$mkdow.'/'.$mkyearday;
			$counter++;
			$mkdow++;
			if ($mkdow > 6)
				$mkdow = 0;
			$mkyearday++;
		}
		if ($format == $parseArray[1][0]) //SHORT
			return $shortArray;
		else //LONG
			return $longArray;
	}	
}

function JSP_CAL_MKSALUTE ($time)
{
	$paramArray = array($time);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if (_ISTIME($time))
		{
			$array = JSP_BUILD_ARRAY($time,':');
			$hr = $array[0];	
			if ($hr == '00' || $hr <= 11)
				$salute = 'morning';
			else if ($hr >= 12 && $hr <= 16)
				$salute = 'afternoon';
			else if ($hr >= 17 && $hr <= 19)
				$salute = 'evening';
			else 
				$salute = 'day';		
			return 'Good '.$salute;
		}
		else
			return $time;
	}
}
?>





