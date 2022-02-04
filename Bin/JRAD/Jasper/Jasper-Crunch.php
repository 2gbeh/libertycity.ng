<?php
function JSP_CRUNCH_TIME ($timeArray, $returnType = 'ARRAY')
{
	$paramArray = array($timeArray,$returnType);	
	$parseArray = array('STR','ARRAY');		
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;		
	else
	{
		$timeArray = JSP_BUILD_CSV($timeArray);
		if (JSP_ATYPE($timeArray) == 2)
		{
			foreach ($timeArray as $index => $assoc_array)
			{
				foreach ($assoc_array as $key => $times)
				{
						$strlenTimes = strlen($times);
					$hourArray[$index][] = $hour = JSP_BUTCHER_STR($times,':','RIGHT');
						$strlenHour = strlen($hour) + 1;
						$strlenDiff = $strlenTimes - $strlenHour;
						$substr = substr($times,-$strlenDiff,$strlenTimes);
					$minuteArray[$index][] = $minute = JSP_BUTCHER_STR($substr,':','RIGHT');
						$strlenMinute = strlen($minute) + 1;
						$strlenDiff = $strlenTimes - ($strlenHour + $strlenMinute);
						$substr = substr($times,-$strlenDiff,$strlenTimes);			
					//JSP_TIME_SHORT
					if ($strlenTimes <= 5)
						$secondArray[$index][] = $second = '00';				
					else	
						$secondArray[$index][] = $second = JSP_BUTCHER_STR($substr,':','RIGHT');
					$strArray[$index][$key] = $hour.':'.$minute.':'.$second;
				}				
			}
		}
		else
		{
			foreach ($timeArray as $key => $times)
			{
					$strlenTimes = strlen($times);
				$hourArray[$key] = $hour = JSP_BUTCHER_STR($times,':','RIGHT');
					$strlenHour = strlen($hour) + 1;
					$strlenDiff = $strlenTimes - $strlenHour;
					$substr = substr($times,-$strlenDiff,$strlenTimes);
				$minuteArray[$key] = $minute = JSP_BUTCHER_STR($substr,':','RIGHT');
					$strlenMinute = strlen($minute) + 1;
					$strlenDiff = $strlenTimes - ($strlenHour + $strlenMinute);
					$substr = substr($times,-$strlenDiff,$strlenTimes);
				//JSP_TIME_SHORT
				if ($strlenTimes <= 5)
					$secondArray[$key] = $second = '00';				
				else	
					$secondArray[$key] = $second = JSP_BUTCHER_STR($substr,':','RIGHT');				
				$strArray[$key] = $hour.':'.$minute.':'.$second;
			}
		}
		if ($returnType == $parseArray[0]) //STR
			return JSP_CRUNCH_ARRAY($strArray);	
		else //ARRAY
			return array('hour' => JSP_CRUNCH_ARRAY($hourArray),'minute' => JSP_CRUNCH_ARRAY($minuteArray),'second' => JSP_CRUNCH_ARRAY($secondArray));
	}
}

function JSP_CRUNCH_DATE ($dateArray, $returnType = 'ARRAY')
{
	$paramArray = array($dateArray,$returnType);	
	$parseArray = array('STR','ARRAY');		
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;		
	else
	{
		$dateArray = JSP_BUILD_CSV($dateArray);
		if (JSP_ATYPE($dateArray) == 2)
		{
			foreach ($dateArray as $index => $assoc_array)
			{
				foreach ($assoc_array as $key => $dates)
				{
						$strlenDates = strlen($dates);
					$yearArray[$index][] = $year = JSP_BUTCHER_STR($dates,'/','RIGHT');
						$strlenYear = strlen($year) + 1;
						$strlenDiff = $strlenDates - $strlenYear;
						$substr = substr($dates,-$strlenDiff,$strlenDates);
					$monthArray[$index][] = $month = JSP_BUTCHER_STR($substr,'/','RIGHT');
						$strlenMonth = strlen($month) + 1;
						$strlenDiff = $strlenDates - ($strlenYear + $strlenMonth);
						$substr = substr($dates,-$strlenDiff,$strlenDates);			
					$dayArray[$index][] = $day = JSP_BUTCHER_STR($substr,'/','RIGHT');
					$strArray[$index][$key] = $year.'/'.$month.'/'.$day;
				}				
			}
		}
		else
		{
			foreach ($dateArray as $key => $dates)
			{
					$strlenDates = strlen($dates);
				$yearArray[$key] = $year = JSP_BUTCHER_STR($dates,'/','RIGHT');
					$strlenYear = strlen($year) + 1;
					$strlenDiff = $strlenDates - $strlenYear;
					$substr = substr($dates,-$strlenDiff,$strlenDates);
				$monthArray[$key] = $month = JSP_BUTCHER_STR($substr,'/','RIGHT');
					$strlenMonth = strlen($month) + 1;
					$strlenDiff = $strlenDates - ($strlenYear + $strlenMonth);
					$substr = substr($dates,-$strlenDiff,$strlenDates);			
				$dayArray[$key] = $day = JSP_BUTCHER_STR($substr,'/','RIGHT');
				$strArray[$key] = $year.'/'.$month.'/'.$day;
			}
		}
		if ($returnType == $parseArray[0]) //STR
			return JSP_CRUNCH_ARRAY($strArray);	
		else //ARRAY
			return array('year' => JSP_CRUNCH_ARRAY($yearArray),'month' => JSP_CRUNCH_ARRAY($monthArray),'day' => JSP_CRUNCH_ARRAY($dayArray));
	}
}

function JSP_CRUNCH_WHITESPACE ($array)
{
	$paramArray = array(JSP_TRUEPUT($array));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		
		if (strlen($array))
		{
			$_array[] = $array;
			$array = $_array;
		}
		foreach ($array as $key => $value)
		{
			$hotkey = $newStr = array();		
			$JSP_BUILD_STR = JSP_BUILD_STR($value);
			foreach ($JSP_BUILD_STR as $i => $str)
			{
				//NON-WHITESPACE
				if ($str != ' ')
					$hotkey[] = $i;
			}
			$lastkey = count($hotkey) - 1;
			foreach ($JSP_BUILD_STR as $i => $str)
			{			
				if ($i >= $hotkey[0] && $i <= $hotkey[$lastkey])
					$newStr[] = $str;
			}
			$dropStr = JSP_DROP_ARRAY($newStr,'');
			if (_THROW($dropStr))
				$newArray[$key] = $dropStr;
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_CRUNCH_COMMA ($array)
{
	$paramArray = array(JSP_TRUEPUT($array));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$array = JSP_BUILD_CSV($array);
		foreach ($array as $key => $value)
		{
			$hotkey = $newStr = array();		
			$JSP_BUILD_STR = JSP_BUILD_STR($value);
			foreach ($JSP_BUILD_STR as $i => $str)
			{
				//NON-COMMA
				if ($str != ',')
					$hotkey[] = $i;
			}
			$lastkey = count($hotkey) - 1;
			foreach ($JSP_BUILD_STR as $i => $str)
			{			
				if ($i >= $hotkey[0] && $i <= $hotkey[$lastkey])
					$newStr[] = $str;
			}
			$dropStr = JSP_DROP_ARRAY($newStr,'');
			if (_THROW($dropStr))
				$newArray[$key] = $dropStr;
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_CRUNCH_ARRAY ($array)
{
	$paramArray = array(JSP_TRUEPUT($array));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$arrayKeys = array_keys($array);
		if (count($array) == 1)
			return $array[$arrayKeys[0]];			
		return $array;
	}
}

function JSP_CRUNCH_DIMARRAY ($array, $rtype = 'END')
{
	$paramArray = array($array,$rtype);
	$parseArray = array('CURRENT','END');	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$rtype))
		return JSPIP;
	else
	{
		if (_ISDIM($array))
		{
			if ($rtype == $parseArray[0]) //CURRENT
				return current($array);
			else
				return end($array);
		}
		else
			return $array;
	}
}

function JSP_CRUNCH_TEXTAREA ($textarea)
{
	$paramArray = array($textarea);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		return nl2br($textarea);
		$value = $textarea;
		$JSP_BUILD_STR = JSP_BUILD_STR($value);
		foreach ($JSP_BUILD_STR as $i => $str)
		{
			//NON-WHITESPACE
			if ($str != ' ')
				$hotkey[] = $i;
		}
		$lastkey = count($hotkey) - 1;
		foreach ($JSP_BUILD_STR as $i => $str)
		{			
			if ($i >= $hotkey[0] && $i <= $hotkey[$lastkey])
				$newStr[] = $str;
		}
		$textarea = _THROW(JSP_DROP_ARRAY($newStr,''));
		return str_replace('\r\n','<br/>',$textarea);
	}
}

function JSP_CRUNCH_DDL ($string)
{
	$paramArray = array($string);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if ($string == "<option selected='selected'></option>")
			return "<optgroup label='N/A'></optgroup>";
		return $string;		
	}
}

function JSP_CRUNCH_PRIKEY ($table, $fieldname)
{
	$paramArray = array($table,$fieldname);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if ($fieldname == 'PRIKEY')
			return JSP_FETCH_PRIKEY($table,'VALUE');
		else
			return $fieldname;
	}
}

function JSP_CRUNCH_REQUEST ($key)
{
	$paramArray = array($key);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$id = $key;
		if (isset($_GET[$id]))
		{
			if ($_GET[$id] == 'NULL')
				$_SESSION[$id] = 0;
			else
				$_SESSION[$id] = $_GET[$id];
			$selected = $_SESSION[$id];
		}
		else if (isset($_SESSION[$id]))	
			$selected = $_SESSION[$id];
		else
			$selected = 0;
		return $selected;
	}
}

function JSP_CRUNCH_FLOGIC ($table, $fieldArray, $logic)
{
	$paramArray = array($table,$fieldArray,JSP_TRUEPUT($logic));
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if ($fieldArray == '*')
			$output = JSP_FETCH_FIELDS($table);
		else if ($logic == 1)
			$output = $fieldArray;
		else
			$output = JSP_SORT_EXCLUDE(JSP_FETCH_FIELDS($table),JSP_BUILD_CSV($fieldArray),'VALUE');			
		return JSP_DROP_ARRAY($output,',');
	}	
}

function JSP_CRUNCH_ENUMS ($function = 'GENERIC', $param = 'STATE', $index)
{
	$paramArray = array($function,$param,JSP_TRUEPUT($index));	
	$parseArray = array('GENERIC','DATE','PREDEF');
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$function))
		return JSPIP;		
	else
	{
		if ($function == $parseArray[0]) //GENERIC
			$array = JSP_ENUMS_GENERIC($param);
		if ($function == $parseArray[1]) //DATE
			$array = JSP_ENUMS_DATE($param);			
		if ($function == $parseArray[2]) //PREDEF
			$array = JSP_ENUMS_PREDEF($param);					
		return $array[$index];
	}
}

function JSP_CRUNCH_PREDEF ($function, $index)
{
	$paramArray = array($function,JSP_TRUEPUT($index));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
		return $function[$index];
}

function JSP_CRUNCH_NOLINK ($array, $index)
{
	$paramArray = array($array,JSP_TRUEPUT($index));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		//https http : // www. .com .ng / ? = &
		if ($index == '*')
		{
			foreach ($array as $key => $value)
				$newArray[$key] = JSP_CRUNCH_NOLINK($value);	
			return $newArray;
		}
		else if (is_numeric($index))
		{
			$pointer = 1;
			foreach ($array as $key => $value)
			{
				if ($pointer == $index)
					$newArray[$key] = JSP_CRUNCH_NOLINK($value);	
				else
					$newArray[$key] = $value;
				$pointer++;
			}
			return $newArray;			
		}		
		else 
		{
			if (_STRPOS($array,'http'))
				$array = JSP_BUTCHER_STR($array,'://');
			if (_STRPOS($array,'www.'))
				$array = JSP_BUTCHER_STR($array,'www.');
			if (_STRPOS($array,'.'))
				$array = JSP_BUTCHER_STR($array,'.','RIGHT');
			return $array;
		}
	}
}

function JSP_CRUNCH_PRICE ($str)
{
	$paramArray = array($str);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		//$parseArray = array('n30k','30000','n30k','n30000','n30,000','30,000');
		if (_ISSTR($str))
		{
			$strArray = JSP_BUILD_STR($str);
			foreach ($strArray as $xter)
			{
				$xter = strtolower($xter);
				if ($xter == 'h')
					$xter = '00';			
				if ($xter == 'k')
					$xter = '000';
				if ($xter == 'm')
					$xter = '000000';
				if ($xter == 'b')
					$xter = '000000000';
				if ($xter == 't')
					$xter = '000000000000';
				if (is_numeric($xter))
					$newArray[] = $xter;
			}
			return $newStr = JSP_DROP_ARRAY($newArray);
		}
		else
			return $str;
	}
}
?>

