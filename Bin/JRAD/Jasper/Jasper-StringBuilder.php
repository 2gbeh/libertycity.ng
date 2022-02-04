 <?php
function JSP_PREP_STR ($array, $type)
{
	$paramArray = array($array,$type);
	$parseArray = array ('CSV','REQUEST','SCRIPT','ESCAPE');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;			
	else
	{
		if ($type == $parseArray[0]) //CSV
		{
			$count = count($array);
			for ($i = 0; $i < $count; $i++)
				$appendCsv .= $array[$i].',';
			return substr($appendCsv,0,-1);				
		}
		else if ($type == $parseArray[1]) //REQUEST
		{
			foreach ($array[0] as $key => $value)
				$concat[] = $value.'='.$array[1][$key].'&';
			$drop = JSP_DROP_ARRAY($concat,'');
			$substr = substr($drop,0,-1);
			return $substr;
		}
		else if ($type == $parseArray[2]) //SCRIPT
			return str_replace(' ','%20',$array);
		else //ESCAPE
			return _ESCAPE($array);
	}
}

function JSP_BUTCHER_DATE ($date, $object, $format)
{
	$paramArray = array($date,$object,$format);
	$parseArray = array
	(
		array ('YEAR','MONTH','MONTH SHORT','MONTH FULL','DAY','DOW','DOW SHORT','DOW FULL','YEARDAY'),	
		array ('SHORT','LONG')		
	);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$object) ||
		JSP_PARAM_PARSE($parseArray[1],$format)		
	) 
		return JSPIP;		
	else 
	{
		$monthArray = array (JSP_ENUMS_DATE('MONTH_LONG'),JSP_ENUMS_DATE('DOW_LONG'));	
		if ($format == $parseArray[1][0]) //SHORT
		{
			$minStrlen = strlen('90/1/1');		
			$maxStrlen = strlen('1990/12/31');
			$septor = 2;
		}
		else //LONG
		{
			$minStrlen = strlen('90/1/1/0/1');		
			$maxStrlen = strlen('1990/12/31/6/366');
			$septor = 4;			
		}
		
		for ($div = 0; $div <= $septor; $div++)
		{
			$dateLength = strlen($date);
			$dateArray[$div] = JSP_BUTCHER_STR($date,'/','RIGHT');

			$arrayLength = strlen($dateArray[$div]) + 1; //+slash sign
			$newLength = $dateLength - $arrayLength;
			$date = substr($date,-$newLength,$dateLength);
		}
	
		if ($object == $parseArray[0][0]) //YEAR
			return $dateArray[0];
		else if ($object == $parseArray[0][1]) //MONTH
			return $dateArray[1];
		else if ($object == $parseArray[0][2]) //MONTH SHORT
		{
			$element = $monthArray[0][($dateArray[1])-1];
			$truncate = substr($element,-strlen($element),3);
			return $truncate;
		}
		else if ($object == $parseArray[0][3]) //MONTH FULL
			return $monthArray[0][($dateArray[1])-1];
		else if ($object == $parseArray[0][4]) //DAY
			return $dateArray[2];
		else if ($object == $parseArray[0][5]) //DOW
			return $dateArray[3];
		else if ($object == $parseArray[0][6]) //DOW SHORT
		{
			$element = $monthArray[1][$dateArray[3]];
			$truncate = substr($element,-strlen($element),3);
			return $truncate;
		}
		else if ($object == $parseArray[0][7]) //DOW FULL
			return $monthArray[1][$dateArray[3]];
		else //YEARDAY
			return $dateArray[4];
	}
}

function JSP_BUTCHER_TIME ($time, $object, $format)
{
	$paramArray = array($time,$object,$format);
	$parseArray = array
	(
		array ('HOUR','MINUTE','SECOND','MERIDIEM'),	
		array ('SHORT','LONG')		
	);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$object) ||
		JSP_PARAM_PARSE($parseArray[1],$format)		
	) 
		return JSPIP;		
	else 
	{
		if ($format == $parseArray[1][1]) //LONG
		{
			$minStrlen = strlen('1:01:01');		
			$maxStrlen = strlen('00:00:00');
			$septor = 2;
		}
		else //SHORT
		{
			if ($object == $parseArray[0][2]) //SECOND
				return JSPIL;
			$minStrlen = strlen('1:01');		
			$maxStrlen = strlen('00:00');
			$septor = 1;
		}
	
		if (substr_count($time,':') != $septor)
			return JSPIP;
		else
		{
			for ($div = 0; $div <= $septor; $div++)
			{
				$timeLength = strlen($time);
				$timeArray[$div] = JSP_BUTCHER_STR($time,':','RIGHT');
				$arrayLength = strlen($timeArray[$div]) + 1; //+colon sign
				$newLength = $timeLength - $arrayLength;
				$time = substr($time,-$newLength,$timeLength);
			}
		}		
		
		if ($object == $parseArray[0][0]) //HOUR
			return $timeArray[0];
		else if ($object == $parseArray[0][1]) //MINUTE
			return $timeArray[1];
		else if ($object == $parseArray[0][2]) //SECOND
			return $timeArray[2];
		else //MERIDIEM
		{
			if ($timeArray[0] > 11)
				return 'PM';
			else
				return 'AM';
		}
	}
}

function JSP_BUILD_CSV ($string)
{
	$paramArray = array(JSP_TRUEPUT($string));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if (strlen($string))
		{
			$array = JSP_BUILD_ARRAY($string,',');
			return $array; 
		}
		else
			return $string;
	}
}

function JSP_BUILD_DENOM ($number, $object = 'BASIC')
{	
	$GLOBALS['JSPGVN'] = $number;
	$GLOBALS['JSPGVS'] = $strlen = strlen($number);
	$GLOBALS['JSPGVO'] = $object;
	$valueArray = array ('thousand','million','billion','trillion');		
	$paramArray = array($number,$object);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		if 
		(
			$GLOBALS['JSPGVO'] != 'BASIC' && 
			$GLOBALS['JSPGVO'] != 'UNITS'
		)
			return JSPIF;
		else if (!is_numeric($number))
			return JSPIF;
		else if ($number < 0)
			return JSPIF;
		else if 
		(
			$strlen > 1 && 
			substr($number,-$strlen,1) == 0
		)
			return JSPIF;
		else if ($strlen > 15)
			return 'z';
		else
		{
			$breaks = 3;				
			$append = ',';
			$unitCall = 0;				
			$units = 'units';		
			$newStrlen = $GLOBALS['JSPGVS'];
			$bwd = $newStrlen;
			$fwd = $newStrlen - $breaks;
			if (($newStrlen % $breaks) == 0) //i.e multiples of 3
				$permut = (floor($newStrlen / $breaks) - 1);
			else
				$permut = floor($newStrlen / $breaks);
			for ($i = $permut; $i >= 0; $i--)
			{
				$csvArray[$i] = $append.substr($number,-$breaks,$newStrlen);
				$unitArray[$i] = substr($number,-$breaks,$newStrlen).' '.$units;					
				$number = substr($number,-$bwd,$fwd);						
				$newStrlen = strlen($number);			
				$bwd -= $breaks;
				$fwd -= $breaks;
				if ($newStrlen <= 3)
					$append = '';
				if ($i == $permut)
					$units = $valueArray[$unitCall].', and ';					
				else
					$units = $valueArray[$unitCall].', ';												
				$unitCall += 1;				
			}
			$element = 0;
			do
			{
				$basicCapture .= $csvArray[$element];
				$unitCapture .= $unitArray[$element];			
				++$element;
			}
			while ($element < sizeof($csvArray));
			
			$number = $GLOBALS['JSPGVN'];
			$strlen = $GLOBALS['JSPGVS'];
					
			if ($GLOBALS['JSPGVO'] == 'UNITS')
			{	
				if ($number == 1)
					return $number.' unit';		
				else if 
				(
					$number > 1 && 
					$strlen < 3
				)
					return $number.' units';						
				else if ($strlen == 3)
				{
					if (substr($number,-2,1) > 0)
						return substr($number,-3,1).' hundred and '.substr($number,-2,2).' units';		
					else 
						return $number.' units';
				}
				else // >4
					return $unitCapture;
			}
			else //basic
			{
				if ($strlen <= 3)
					return $number;
				else 
					return $basicCapture;
			}
		}
	}
}

function JSP_BUILD_JUMBO ($number)
{	
	$GLOBALS['JSPGVN'] = $number;
	$GLOBALS['JSPGVS'] = $strlen = strlen($number);
	$paramArray = array(JSP_TRUEPUT($number));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($number) || $number < 0)
		return JSPIP;
	else if ($strlen > 1 && substr($number,-$strlen,1) == 0)
		return JSPIL;		
	else 
	{
		if ($strlen > 15)
			return 'z';
		else if ($strlen <= 3)
			return $number;
		else
		{
			if (JSP_COMPARE_STRLEN($number,'4,6','{}'))
			{
				$alpha = 'k';
				$zeros = 3;	
				if (JSP_BUILD_JUMBO_SCANNER($zeros,$GLOBALS['JSPGVN'],$GLOBALS['JSPGVS']) == 1)
				{
					$truncate = substr($number,-$strlen,($strlen-$zeros));
					return $append = $truncate.$alpha;
				}	
				else
				{
					if ($strlen == 4)
					{
						$zeros = 2;
						if (JSP_BUILD_JUMBO_SCANNER($zeros,$GLOBALS['JSPGVN'],$GLOBALS['JSPGVS']) == 1)
						{	
							$firstNo = substr($number,-$strlen,1);
							$secondNo = substr($number,-($strlen-1),1);
							return $append = $firstNo.'.'.$secondNo.$alpha;						
						}
						else
							return $number; 
					}
					else if ($strlen == 5)
					{
						$reserve = substr($number,-$strlen,2);
						$hotNumber = substr($number,-$zeros,1);
						if ($hotNumber != 0)			
							return $append = $reserve.'.'.$hotNumber.$alpha;
						else 
							return $append = $reserve.$alpha;
					}			
					else //6
						return $append = substr($number,-$strlen,$zeros).$alpha;			
				}		
			}
			else if (JSP_COMPARE_STRLEN($number,'7,9','{}'))
			{
				$alpha = 'm';
				$zeros = 6;	
				if (JSP_BUILD_JUMBO_SCANNER($zeros,$GLOBALS['JSPGVN'],$GLOBALS['JSPGVS']) == 1)
				{
					$truncate = substr($number,-$strlen,($strlen-$zeros));
					return $append = $truncate.$alpha;
				}
				else
				{
					if ($strlen == 7)
					{
						$reserve = substr($number,-$strlen,1);
						$hotNumber = substr($number,-$zeros,1);
						if ($hotNumber != 0)			
							return $append = $reserve.'.'.$hotNumber.$alpha;
						else 
							return $append = $reserve.$alpha;
					}		
					else if ($strlen == 8)
					{
						$reserve = substr($number,-$strlen,2);
						$hotNumber = substr($number,-$zeros,1);
						if ($hotNumber != 0)			
							return $append = $reserve.'.'.$hotNumber.$alpha;
						else 
							return $append = $reserve.$alpha;
					}			
					else //9
					{
						$reserve = substr($number,-$strlen,3);
		
							return $append = $reserve.$alpha;
					}	
				}		
			}	
			else if (JSP_COMPARE_STRLEN($number,'10,12','{}'))
			{
				$alpha = 'b';
				$zeros = 9;	
				if (JSP_BUILD_JUMBO_SCANNER($zeros,$GLOBALS['JSPGVN'],$GLOBALS['JSPGVS']) == 1)
				{
					$truncate = substr($number,-$strlen,($strlen-$zeros));
					return $append = $truncate.$alpha;
				}
				else
				{
					if ($strlen == 10)
					{
						$reserve = substr($number,-$strlen,1);
						$hotNumber = substr($number,-$zeros,1);
						if ($hotNumber != 0)			
							return $append = $reserve.'.'.$hotNumber.$alpha;
						else 
							return $append = $reserve.$alpha;
					}		
					else if ($strlen == 11)
					{
						$reserve = substr($number,-$strlen,2);
						$hotNumber = substr($number,-$zeros,1);
						if ($hotNumber != 0)			
							return $append = $reserve.'.'.$hotNumber.$alpha;
						else 
							return $append = $reserve.$alpha;
					}			
					else //12
					{
						$reserve = substr($number,-$strlen,3);
							return $append = $reserve.$alpha;
					}	
				}		
			}	
			else //i.e if (JSP_COMPARE_STRLEN($number,'13,15','{}'))
			{
				$alpha = 't';
				$zeros = 12;	
				if (JSP_BUILD_JUMBO_SCANNER($zeros,$GLOBALS['JSPGVN'],$GLOBALS['JSPGVS']) == 1)
				{
					$truncate = substr($number,-$strlen,($strlen-$zeros));
					return $append = $truncate.$alpha;
				}
				else
				{
					if ($strlen == 13)
					{
						$reserve = substr($number,-$strlen,1);
						$hotNumber = substr($number,-$zeros,1);
						if ($hotNumber != 0)			
							return $append = $reserve.'.'.$hotNumber.$alpha;
						else 
							return $append = $reserve.$alpha;
					}		
					else if ($strlen == 14)
					{
						$reserve = substr($number,-$strlen,2);
						$hotNumber = substr($number,-$zeros,1);
						if ($hotNumber != 0)			
							return $append = $reserve.'.'.$hotNumber.$alpha;
						else 
							return $append = $reserve.$alpha;
					}			
					else //15
					{
						$reserve = substr($number,-$strlen,3);
							return $append = $reserve.$alpha;
					}	
				}		
			}
		}
	}
}

function JSP_BUILD_JUMBO_SCANNER ($count, $number, $strlen)
{
	$paramArray = array($count,$number,$strlen);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$lastZeros = substr($number,-$count,$strlen);
		if (substr_count($lastZeros,'0') == $count)
			return 1;
		else
			return 0;
	}
}

function JSP_NAME_TUPLES ($entry, $setArray)
{
	$paramArray = array($entry,$setArray);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$entry = JSP_CRUNCH_WHITESPACE($entry);
		$entryArray = JSP_BUILD_ARRAY($entry,' ');		
		$setArray = JSP_BUILD_CSV($setArray);
		if (count($entryArray) == 3)
		{
			$orderArray = array
			(
				$entryArray[0].' '.$entryArray[1].' '.$entryArray[2],
				$entryArray[0].' '.$entryArray[2].' '.$entryArray[1],
				$entryArray[1].' '.$entryArray[0].' '.$entryArray[2],
				$entryArray[1].' '.$entryArray[2].' '.$entryArray[0],
				$entryArray[2].' '.$entryArray[0].' '.$entryArray[1],
				$entryArray[2].' '.$entryArray[1].' '.$entryArray[0]
			);
		}
		if (count($entryArray) == 2)
		{
			$orderArray = array
			(
				$entryArray[0].' '.$entryArray[1],
				$entryArray[1].' '.$entryArray[0]
			);
		}
		if (count($entryArray) == 1)
		{
			$orderArray = $entryArray;
		}	
		$JSP_SORT_MATCH = JSP_SORT_MATCH(JSP_DROP_CASE($setArray),JSP_DROP_CASE($orderArray),'VALUE');
		if (!JSP_ERROR_CATCH($JSP_SORT_MATCH))
			return 1;		
	}
}

function JSP_NAME_SPACE ($array, $returnType = 'BUILD')
{
	$paramArray = array(JSP_TRUEPUT($array));
	$parseArray = array('BUILD','DROP');		
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;		
	else
	{
		$array = JSP_BUILD_CSV($array);
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array as $index => $assoc_array)
			{
				foreach ($assoc_array as $key => $value)
				{
					$buildArray[$index][$key] = str_replace(' ','_',$value);
					$dropArray[$index][$key] = str_replace('_',' ',$value);					
				}
			}
		}
		else
		{
			foreach ($array as $key => $value)
			{
				$buildArray[$key] = str_replace(' ','_',$value);
				$dropArray[$key] = str_replace('_',' ',$value);				
			}			
		}
		if ($returnType == $parseArray[0]) //BUILD
			return JSP_CRUNCH_ARRAY($buildArray);
		else //DROP
			return JSP_CRUNCH_ARRAY($dropArray);		
	}
}

function JSP_NAME_CASE ($nameArray, $returnType = 'ABBR')
{
	$paramArray = array($nameArray,$returnType);
	$parseArray = array('FIRST','LAST','ABBR','AUTHOR','EMAIL');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$returnType)) 
		return JSPIP;			
	else
	{
		$nameArray = JSP_BUILD_CSV($nameArray);
		foreach ($nameArray as $names)
		{
			$JSP_BUILD_ARRAY = JSP_BUILD_ARRAY($names,' ');			
			if ($returnType == $parseArray[0]) //FIRST
			{
				$newArray[] = JSP_TITLE_CASE($JSP_BUILD_ARRAY[0]);
			}
			else if ($returnType == $parseArray[1]) //LAST
			{
				$newArray[] = JSP_TITLE_CASE($JSP_BUILD_ARRAY[1]);
			}
			else if ($returnType == $parseArray[2]) //ABBR
			{
				$abbr = '';
				foreach ($JSP_BUILD_ARRAY as $each)
					$abbr .= substr($each,0,1);
				$newArray[] = JSP_BUILD_CASE($abbr);
			}
			else if ($returnType == $parseArray[3]) //AUTHOR
			{
				$first = substr($JSP_BUILD_ARRAY[0],0,1);
				$last = $JSP_BUILD_ARRAY[1];				
				$newArray[] = JSP_TITLE_CASE($last.', '.$first.'.');
			}
			else
			{
				$first = substr($JSP_BUILD_ARRAY[1],0,1);
				$newArray[] = JSP_DROP_CASE($first.$JSP_BUILD_ARRAY[0]);
			}
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_NUMBER_CASE ($numberArray, $returnType = 'LBS')
{
	$paramArray = array($numberArray,$returnType);
	$parseArray = array('PRESET','LBS','UK','DIGIT');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$returnType)) 
		return JSPIP;			
	else
	{
		
		$numberArray = JSP_BUILD_CSV($numberArray);
		foreach ($numberArray as $number)
		{
			if ($returnType == $parseArray[0]) //PRESET
			{
				$a = substr($number,0,4);
				$b = substr($number,4,3);
				$c = substr($number,-4);
				$output[] = $a.' '.$b.' '.$c;				
			}
			else if ($returnType == $parseArray[1]) //LBS
			{
				$a = substr($number,1,2);
				$b = substr($number,3,4);
				$c = substr($number,-4);								
				$output[] = '<cur>+234(0)</cur> '.$a.' '.$b.' '.$c;
			}						
			else if ($returnType == $parseArray[2]) //UK
			{
				$a = substr($number,1,2);
				$b = substr($number,4,3);
				$c = substr($number,-4);
				$output[] = $a.' '.$b.' '.$c;
			}
			else //DIGIT
			{
				if ($number < 10)
					$output[] = '0'.$number;
				else
					$output[] = $number;				
			}
		}
		return JSP_CRUNCH_ARRAY($output);
	}
}

function JSP_BUILD_CASE ($array)
{
	$paramArray = array($array);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if (strlen($array))
			$array = strtoupper($array);
		if (JSP_ATYPE($array) == 1)
		{
			foreach ($array as $key => $value)
				$array[$key] = strtoupper($value);
		}
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array as $index => $assoc_array)
			{		
				foreach ($assoc_array as $key => $value)
					$array[$index][$key] = strtoupper($value);
			}
		}
		
		return $array;				
	}
}

function JSP_DROP_CASE ($array)
{
	$paramArray = array($array);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if (strlen($array))
			$array = strtolower($array);
		if (JSP_ATYPE($array) == 1)
		{
			foreach ($array as $key => $value)
				$array[$key] = strtolower($value);
		}
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array as $index => $assoc_array)
			{		
				foreach ($assoc_array as $key => $value)
					$array[$index][$key] = strtolower($value);
			}
		}
		
		return $array;				
	}
}

function JSP_TITLE_CASE ($array)
{
	$paramArray = array($array);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if (strlen($array))
			$array = ucwords($array);
		if (JSP_ATYPE($array) == 1)
		{
			foreach ($array as $key => $value)
				$array[$key] = ucwords($value);
		}
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array as $index => $assoc_array)
			{		
				foreach ($assoc_array as $key => $value)
					$array[$index][$key] = ucwords($value);
			}
		}
		
		return $array;				
	}
}

function JSP_FIND_STR ($haystack,$neddle)
{	
	$paramArray = array($haystack,JSP_TRUEPUT($neddle));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		$strlen = strlen($neddle);
		$strind = $strlen - 1;
		$res = stripos($haystack,$neddle);
		if ($res !== false)
			return array($res,($res + $strind));
	}
}

function JSP_BUILD_STR ($string)
{
	$paramArray = array($string);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$strlen = strlen($string);		
		for ($i = 1; $i <= $strlen; $i++)
		{
			$newArray[] = substr($string,0,1);
			$string = substr($string,1);
		}
		return $newArray;
	}
}

function JSP_BUTCHER_STR ($string, $mark, $direction = 'LEFT')
{
	$paramArray = array($string,JSP_TRUEPUT($mark),$direction);
	$parseArray = array('LEFT','RIGHT');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$direction)) 
		return JSPIP;		
	else 
	{
		if ($direction == $parseArray[0]) //LEFT
			return array_pop(explode($mark,$string));
		else //RIGHT
			return array_shift(explode($mark,$string));
	}
}

function JSP_WRAP_STR ($str, $wrap = 160)
{
	$paramArray = array($str,$wrap);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($wrap))
		return JSPIP;	
	else 
	{
		if (_ISSTR($str))
		{
			$array = JSP_BUILD_STR($str);
			foreach ($array as $key => $value)
			{
				if ($key < $wrap)
					$prostr[] = $value;
			}
			return JSP_DROP_ARRAY($prostr).'...';
		}
		else
			return $str;
	}
}

function JSP_WRAP_WORD ($str, $wrap = 60)
{
	$paramArray = array($str,$wrap);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($wrap))
		return JSPIP;	
	else 
	{
		if (_ISSTR($str))
		{
			$array = JSP_BUILD_ARRAY($str,' ');
			foreach ($array as $key => $value)
			{
				if ($key < $wrap)
					$prostr[] = $value;
			}
			return JSP_DROP_ARRAY($prostr,' ').'...';
		}
		else
			return $str;
	}
}

function JSP_COUNT_WORD ($str)
{
	$paramArray = array($str);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		if (_ISSTR($str))
		{
			$wordArray = JSP_BUILD_ARRAY($str,' ');
			$wordCount = count($wordArray);
			$xterSum = 0;
			foreach ($wordArray as $word)
			{
				$xterArray = JSP_BUILD_STR($word);
				$xterSum += count($xterArray);
			}
			
			$map['PAGE'] = '';
			$map['WORD'] = $wordCount;
			$map['XTER_NOSPACE'] = $xterSum;
			$map['XTER_SAPCE'] = $xterSum + ($wordCount - 1);
			$map['PARAGRAPH'] = '';
			$map['LINE'] = '';			

			foreach ($map as $key => $value)
			{
				if (_ISSTR($value))
					$newMap[$key] = _DENOM($value);
				else
					$newMap[$key] = $value;
			}
			return $newMap;
		}
	}
}

function JSP_CROP_STR ($string, $from, $to)
{
	$paramArray = array($string,$from,$to);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		$newStr = array_pop(explode($from,$string));
		return array_shift(explode($to,$newStr));
	}
}

function JSP_CROP_STRPOS ($str, $index, $logic)
{
	$paramArray = array($str,JSP_TRUEPUT($index),$logic);	
	$parseArray = array('<','>','<=','>=','{}','><');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$logic)) 
		return JSPIP;
	else 
	{
		if (_ISSTR($str))
		{
			$array = JSP_BUILD_STR($str);
			if (_ISLIN($index))
			{
				$index[0] += 1;
				$index[1] += 1;
			}
			else
				$index += 1;
			$arith = JSP_SORT_ARITH($array,$index,$logic);
			return JSP_DROP_ARRAY($arith);
		}
		else
			return $str;
	}
}

function JSP_TRIM_STR ($string, $from, $to)
{
	$paramArray = array($string,JSP_TRUEPUT($from),$to);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		$array = JSP_BUILD_STR($string);
		$arrayKeys = array_keys($array);
		if (in_array($from,$arrayKeys) && in_array($to,$arrayKeys))
			$output = JSP_SORT_TRIM($array,$from,$to,'KEY');
		return JSP_DROP_ARRAY($output,'');
	}
}

function JSP_NOZERO_STR ($entry)
{	
	$paramArray = array(JSP_TRUEPUT($entry));		
	if (JSP_PARAM_FORMAT($paramArray) || !strlen($entry)) 
		return JSPIF;
	else
	{		
		$entry = JSP_BUILD_STR($entry);
		foreach ($entry as $key => $value)
		{
			if ($value == '0')
				$hotkeys[] = $key;
		}
		$JSP_SORT_EXCLUDE = JSP_SORT_EXCLUDE($entry,$hotkeys,'KEY');
		return JSP_DROP_ARRAY($JSP_SORT_EXCLUDE,'');
	}
}

function JSP_RANGE_STR ($value, $from, $to)
{	
	$paramArray = array($value,JSP_TRUEPUT($from),$to);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($value) || !is_numeric($from) || !is_numeric($to))
		return JSPIP;	
	else if ($from >= $to) 
		return JSPIL;
	else
	{					
		if ($value >= $from && $value <= $to)
				return 1;
	}
}

function JSP_COMPARE_STRLEN ($string, $length, $logic)
{		
	$paramArray = array($string,$length,$logic);
	$parseArray = array('<','>','<=','>=','==','!=','{}','><');	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	if (JSP_PARAM_PARSE($parseArray,$logic))		
		return JSPIP;
	else 
	{
		$s = strlen($string);
		$l = $length;
		if ($logic == $parseArray[0]) //<
		{
			if ($s < $l)
				return 1;
		}	
		else if ($logic == $parseArray[1]) //>
		{
			if ($s > $l)
				return 1;
		}
		else if ($logic == $parseArray[2]) //<=
		{
			if ($s <= $l)
				return 1;
		}
		else if ($logic == $parseArray[3]) //>=
		{
			if ($s >= $l)
				return 1;
		}			
		else if ($logic == $parseArray[4]) //==
		{
			if ($s == $l)
				return 1;
		}
		else if ($logic == $parseArray[5]) //!==
		{
			if ($s != $l)
				return 1;
		}
		else if ($logic == $parseArray[6]) //{}
		{
			$l = _CSV($l);
			if ($s >= $l[0] && $s <= $l[1])
				return 1;
		}
		else if ($logic == $parseArray[7]) //><
		{
			$l = _CSV($l);
			if ($s > $l[0] && $s < $l[1])
				return 1;
		}
	$paramArray = array($string,$length,$logic);						
	}
}

?>



