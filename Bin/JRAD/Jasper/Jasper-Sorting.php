 <?php
function JSP_SORT_KEY ($array, $key, $logic = 1)
{	
	$paramArray = array($array,JSP_TRUEPUT($key),JSP_TRUEPUT($logic));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($logic) || $logic > 1)	
		return JSPIP;							
	else 
	{
		$array = JSP_BUILD_CSV($array);	
		$_key = JSP_BUILD_STR($key);				
		foreach ($array as $i => $e)
		{
			$_i = JSP_BUILD_STR($i);			
			if ($_i == $_key)
				$inArray[$i] = $e;
			else 
				$noArray[$i] = $e;
		}
		if 
		(
			$logic == 1 && empty($inArray) || 
			$logic == 0 && empty($noArray)
		)
			return JSPON;
		else if ($logic == 1)
			return $inArray;
		else
			return $noArray;	
	}
}

function JSP_SORT_VALUE ($array, $value, $logic = 1)
{
	$paramArray = array($array,JSP_TRUEPUT($value),JSP_TRUEPUT($logic));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($logic) || $logic > 1)	
		return JSPIP;			
	else
	{
		$array = JSP_BUILD_CSV($array);			
		$_value = JSP_BUILD_STR($value);					
		foreach ($array as $i => $e)
		{
			$_e = JSP_BUILD_STR($e);
			if ($_e == $_value)
				$inArray[$i] = $e;
			else
				$noArray[$i] = $e;
		}
		if 
		(
			$logic == 1 && empty($inArray) || 
			$logic == 0 && empty($noArray)
		)
			return JSPON;
		else if ($logic == 1)
			return $inArray;
		else
			return $noArray;
	}
}

function JSP_SORT_FIRST ($array, $type = 'KEY')
{
	$paramArray = array($array,$type);
	$parseArray = array('KEY','VALUE');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;		
	else 
	{
		$array = JSP_BUILD_CSV($array);
		foreach ($array as $key => $value)
		{
			if ($type == $parseArray[0]) //KEY
				return $key;
			else //VALUE
				return $value;		
		}
	}
}

function JSP_SORT_LAST ($array, $type = 'KEY')
{
	$paramArray = array($array,$type);
	$parseArray = array('KEY','VALUE');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;		
	else 
	{
		$array = JSP_BUILD_CSV($array);
		foreach ($array as $key => $value)
		{
			$lastKey = $key;
			$lastValue = $value;
		}
		if ($type == $parseArray[0]) //KEY
			return $lastKey;
		else //VALUE
			return $lastValue;
	}
}

function JSP_SORT_TAILBACK ($array)
{
	$paramArray = array($array);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$strlen = count($array);
		$arrayKeys = array_keys($array);
		$frsKey = current($arrayKeys);		
		$frsValue = current($array);
		$lasKey = end($arrayKeys);
		$lasValue = end($array);

		for ($i = 0; $i <= $strlen; $i++)
		{
			if ($i == 0)
				$newArray[$lasKey] = $lasValue;
			else if ($i == $strlen)
				$newArray[$frsKey] = $frsValue;
			else
				$newArray[$arrayKeys[$i]] = $array[$arrayKeys[$i]];
		}
		return $newArray;
	}
}

function JSP_SORT_POSITION ($array, $position)
{
	$paramArray = array($array,$position);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$amount = count($array);
		$factor = $amount % 2;
		$half = $amount / 2;
		if (!is_numeric($position))		
		{	
			if ($position == 'FIRST')
				return $array[0];
			else if ($position == 'LAST')
				echo $array[$amount - 1];										
			else 
			{
				if 
				(
					(
						$position == 'MIDDLE' || 
						$position == 'MEDIAN'
					) && 
					$factor != 0
				) //odd
				{
					return $array[floor($half)];
				}
				else if ($position == 'MIDDLE' && $factor == 0)  //even
					return JSPON;
				else if ($position == 'MEDIAN' && $factor == 0) //even
					return array ($array[$half - 1],$array[$half]);
				else
					return JSP_ERROR_LOG('typo');		
			}
		}
		else
		{
			if ($position <= $amount)
			{
				$position--;
				return $array[$position];
			}
			else
				return JSP_ERROR_LOG('range');				
		}		
	}
}

function JSP_SORT_REALINDEX ($array, $entry, $type)
{
	$paramArray = array($array,JSP_TRUEPUT($entry),$type);		
	$parseArray = array('KEY','VALUE');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;
	else
	{
		$array = JSP_BUILD_CSV($array);
		$array = JSP_CRUNCH_ARRAY($array);		
		$arrayKeys = array_keys($array);
		if ($type == $parseArray[0]) //KEY
		{
			if (!in_array($entry,$arrayKeys))
				return JSPON;
			else
			{
				$counter = 1;						
				foreach ($array as $key => $value)
				{
					if ($key == $entry)
						return $counter;
					$counter++;
				}						
			}			
		}
		else //VALUE
		{
			if (!in_array($entry,$array))
				return JSPON;					
			else
			{
				$counter = 1;						
				foreach ($array as $value)
				{
					if ($value == $entry)
						return $counter;
					$counter++;
				}						
			}							
		}
	}
}

function JSP_SORT_MATCH ($uArray, $eArray, $type = 'VALUE')
{
	$paramArray = array($uArray,$eArray,$type);	
	$parseArray = array ('KEY','VALUE');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;			
	else
	{
		$uArray = JSP_BUILD_CSV($uArray);
		$eArray = JSP_BUILD_CSV($eArray);			
		foreach ($uArray as $key => $value)
		{
			$forkey = JSP_SORT_VALUE($eArray,$key,1);
			$forval = JSP_SORT_VALUE($eArray,$value,1);			
			if (!JSP_ERROR_CATCH($forkey))
				$keyArray[$key] = $value;
			if (!JSP_ERROR_CATCH($forval))
				$valueArray[$key] = $value;				
		}
		if 
		(
			$type == $parseArray[0] && empty($keyArray) || 
			$type == $parseArray[1] && empty($valueArray)
		)
			return JSPON;		
		if ($type == $parseArray[0]) //KEY
			return $keyArray;
		else //VALUE
			return $valueArray;
	}
}

function JSP_SORT_INTERSECT ($uArray, $eArray, $type)
{
	$paramArray = array($uArray,$eArray,$type);	
	$parseArray = array ('KEY','VALUE');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;			
	else
	{
		$uArray = JSP_BUILD_STR($uArray);
		$eArray = JSP_BUILD_STR($eArray);
		$array_intersect = array_intersect($uArray,$eArray);						
		if ($type == $parseArray[0]) //KEY
			return array_keys($array_intersect);
		else //VALUE
			return $array_intersect;
	}
}

function JSP_SORT_OCCUR ($array, $value, $type = 'PERC')
{
	$paramArray = array($array,JSP_TRUEPUT($value),$type);		
	$parseArray = array('REAL','PERC');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;
	else
	{
		$count = count($array);
		$newArray = JSP_SORT_VALUE($array,$value,1);
		if (!JSP_ERROR_CATCH($newArray))
			$real = count($newArray);
		else
			$real = 0;
		if ($type == $parseArray[1]) //PERC
		{
			$perc = ($real * 100) / $count;
			$round = round($perc);
			return $round.'%';
		}
		else
			return $real;
	}
}

function JSP_SORT_UNIQUE ($array, $keystone = 'PRE')
{
	$paramArray = array($array,$keystone);	
	$parseArray = array('NEW','PRE');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$keystone))
		return JSPIP;	
	else
	{
		$csv = JSP_BUILD_CSV($array);
		$case = JSP_DROP_CASE($csv);
		$whitespace = _FILTER($case);
		$newArray = array_unique($whitespace);
		if ($keystone == $parseArray[0]) //NEW
		{
			foreach ($newArray as $value)
				$_newArray[] = $value;
			return $_newArray;		
		}			
		return $newArray;
	}
}

function JSP_SORT_ORDER ($array, $order = 'DSC', $keystone = 'PRE')
{
	$paramArray = array($array,$order,$keystone);	
	$parseArray = array(array('ASC','DSC'),array('PRE','NEW'));		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$order) || 
		JSP_PARAM_PARSE($parseArray[1],$keystone)
	)
		return JSPIP;													
	else
	{
		$array = JSP_BUILD_CSV($array);
		if ($keystone == $parseArray[1][1]) //NEW
		{
			if ($order == $parseArray[0][0]) //ASC
				sort($array);
			else
				rsort($array); //DSC
		}		
		else 
		{
			if ($order == $parseArray[0][0]) //ASC
				asort($array);
			else
				arsort($array);
		}
		return $array;
	}
}

function JSP_SORT_SCROLL ($pointer, $scroll_frame = 3)
{
	$paramArray = array($pointer,$scroll_frame);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{	
		$x = 0;
		$y = 1;
		foreach (range(1,15) as $i)
		{
			$x++;
			$scroll_lock[$i] = $y;
			$scroll_selected[$i] = $x;						
			if ($x == $scroll_frame)
			{
				$x = 0;
				$y = $i + 1;
			}
		}
		$lock = $scroll_lock[$pointer];
		$selected = $scroll_selected[$pointer];
		return array('BY' => $lock,'TO' => $selected);
	}
}

function JSP_SORT_LIMIT ($array, $limit, $type = 1)
{
	$paramArray = array($array,$limit,JSP_TRUEPUT($type));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if ($type > 1)
		return JSPIP;	
	else
	{
		$array = JSP_BUILD_CSV($array);					
		if ($type == 0)
		{
			if (!is_numeric($limit))
				return JSPIL;
			$counter = 0;				
			foreach ($array as $key => $value)
			{
				if ($counter != $limit)
				{
					$newArray[$key] = $value;
					$counter++;
				}
			}
		}
		else
		{
			if (!is_numeric($limit))
				$limit = JSP_DROP_CASE($limit);									
			if (!in_array($limit,$array))
				return JSPON;
			$counter = $pointer = 0;
			foreach ($array as $value)
			{
				$pointer++;				
				if ($value == $limit)
					$indexof = $pointer;							
			}
			foreach ($array as $key => $value)
			{
				if ($counter != $indexof)
				{
					$newArray[$key] = $value;
					$counter++;
				}
			}									
		}
		return $newArray;
	}
}

function JSP_SORT_RANGE ($array, $from, $to, $type = 'VALUE')
{
	$paramArray = array($array,JSP_TRUEPUT($from),JSP_TRUEPUT($to),$type);	
	$parseArray = array('KEY','VALUE');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;
	else
	{
		$array = JSP_BUILD_CSV($array);
		$arrayKeys = array_keys($array);
		$pointer = 0;
		foreach ($array as $key => $value)
		{
			$key = JSP_DROP_CASE($key);
			$value = JSP_DROP_CASE($value);
			$from = JSP_DROP_CASE($from);
			$to = JSP_DROP_CASE($to);
			
			if ($key == $from)
				$k_start = $pointer;
			if ($key == $to)
				$k_end = $pointer;
			if ($value == $from)
				$v_start = $pointer;
			if ($value == $to)
				$v_end = $pointer;
			$pointer++;
		}
//		return array($k_start,$k_end,$v_start,$v_end);
		foreach ($arrayKeys as $i => $e)
		{
			if ($i >= $k_start && $i <= $k_end)
				$k_output[$e] = $array[$e];
			if ($i >= $v_start && $i <= $v_end)
				$v_output[$e] = $array[$e];				
		}
		if ($k_start !== null && $k_end !== null && $type == $parseArray[0]) //KEY
			return $k_output;
		if ($v_start !== null && $v_end !== null && $type == $parseArray[1]) //VALUE			
			return $v_output;
	}
}

function JSP_SORT_TRIM ($array, $from, $to, $type = 'VALUE')
{
	$paramArray = array($array,JSP_TRUEPUT($from),JSP_TRUEPUT($to),$type);	
	$parseArray = array('KEY','VALUE');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;
	else
	{
		$array = JSP_BUILD_CSV($array);
		$arrayKeys = array_keys($array);
		$pointer = 0;
		foreach ($array as $key => $value)
		{
			$key = JSP_DROP_CASE($key);
			$value = JSP_DROP_CASE($value);
			$from = JSP_DROP_CASE($from);
			$to = JSP_DROP_CASE($to);
			
			if ($key == $from)
				$k_start = $pointer;
			if ($key == $to)
				$k_end = $pointer;
			if ($value == $from)
				$v_start = $pointer;
			if ($value == $to)
				$v_end = $pointer;
			$pointer++;
		}
//		return array($k_start,$k_end,$v_start,$v_end);
		foreach ($arrayKeys as $i => $e)
		{
			if ($i < $k_start || $i > $k_end)
				$k_output[$e] = $array[$e];
			if ($i < $v_start || $i > $v_end)
				$v_output[$e] = $array[$e];				
		}
		if ($type == $parseArray[0]) //KEY
		{
			if ($k_start !== null && $k_end !== null)
				return $k_output;
			else
				return $array;
		}
		else
		{
			if ($v_start !== null && $v_end !== null)
				return $v_output;
			else
				return $array;
		}
	}
}

function JSP_SORT_EXCLUDE ($array, $exclude, $type = 'VALUE')
{
	$paramArray = array($array,JSP_TRUEPUT($exclude),$type);
	$parseArray = array('KEY','VALUE');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;		
	else 
	{
		$array = JSP_BUILD_CSV($array);
		$exclude = JSP_BUILD_CSV($exclude);		
		foreach ($array as $key => $value)
		{
			$forkey = JSP_SORT_VALUE($exclude,$key,1);
			$forval = JSP_SORT_VALUE($exclude,$value,1);			
			if (JSP_ERROR_CATCH($forkey))
					$keyArray[$key] = $value;						
			if (JSP_ERROR_CATCH($forval))
					$valueArray[$key] = $value;						
		}
		if ($type == $parseArray[0]) //KEY
			return $keyArray;
		else //VALUE
			return $valueArray;
	}
}

function JSP_SORT_FILE ($array, $type = 'mp4')
{
	$paramArray = array($array,$type);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		$array = _CSV($array);
		foreach ($array as $key => $value)
		{
			if (_STRPOS($value,'.'.$type))
				$newArray[$key] = $value;
		}
		return $newArray;
	}
}

function JSP_SORT_SERIES ($array, $factor, $method = 'VALUE')
{
	$paramArray = array($array,$factor,$method);
	$parseArray = array(array('EVEN','ODD','SHUFFLE'),array('KEY','VALUE'));
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;		
	else if 
	(
		!is_numeric($factor) && 
		(
			JSP_PARAM_PARSE($parseArray[0], $factor) ||
			JSP_PARAM_PARSE($parseArray[1], $method)
		)				
	)
		return JSPIP;	
	else
	{
		if 
		(
			strlen($array) == 1 ||
			count($array) == 1 ||
			(
				$method == $parseArray[1][1] && //VALUE
				JSP_CTYPE($array) != 1
				
			)
		)
			return JSPIL;
		else
		{
			if ($method == $parseArray[1][0]) //KEY
			{
				foreach ($array as $key => $value)
				{
					$key = abs($key - 1);
					if (($key % 2) == 0)
						$evenKeys[] = $value;
					else
						$oddKeys[] = $value;
				}				
				if ($factor == $parseArray[0][0]) //EVEN
					return $evenKeys;
				else if ($factor == $parseArray[0][1]) //ODD
					return $oddKeys;
				else if ($factor == $parseArray[0][2]) //SHUFFLE
				{
					shuffle($array);
					return $array;						
				}
				else //int > 0
				{
					$i = 0;
					do
					{
						$intKeys[] = $array[$i];
						$i += $factor;
					}
					while ($i < count($array));
					return $intKeys;					
				}
			}
			else //VALUE
			{
				foreach ($array as $key => $value)
				{
					if ($value != 0)
					{
						if (($value % 2) == 0)
							$evenValues[] = $value;
						else
							$oddValues[] = $value;
					}
				}
				if ($factor == $parseArray[0][0]) //EVEN
					return $evenValues;				
				else if ($factor  == $parseArray[0][1]) //ODD
					return $oddValues;				
				else //SHUFFLE
					return JSPIL;
			}
		}
	}
}

function JSP_SORT_GATE ($entry, $setArray, $logic = 'OR')
{
	$paramArray = array(JSP_TRUEPUT($entry),$setArray,$logic);
	$parseArray = array('AND','OR','NOT');
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;		
	else if (JSP_PARAM_PARSE($parseArray,$logic))
		return JSPIP;		
	else	
	{
		$setArray = _CSV($setArray);
		foreach ($setArray as $element)
		{
			if ($entry == $element)
				$match++;
		}
		if ($logic == $parseArray[0] && $match == count($setArray)) //AND
			return 1;
		if ($logic == $parseArray[1] && $match) //OR
			return 1;
		if ($logic == $parseArray[2] && !isset($match)) //NOT
			return 1;			
	}
}

function JSP_SORT_LEXICON ($array, $pointer)
{
	$paramArray = array($array,JSP_TRUEPUT($pointer));
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else	
	{	
		$copy_array = $array;
		asort($copy_array[$pointer]);
		$array_keys = array_keys($copy_array[$pointer]);
		foreach ($array as $index => $assoc_array)
		{
			foreach ($array_keys as $key)
				$newArray[$index][$key] = $assoc_array[$key];
		}
		return $newArray;
	}
}

function JSP_SORT_SCHEME ($array, $keyScheme)
{
	$paramArray = array($array,JSP_TRUEPUT($keyScheme));
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else	
	{	
		$keyScheme = JSP_BUILD_CSV($keyScheme);
		foreach ($array as $index => $assoc_array)
		{
			foreach ($keyScheme as $key)
				$newArray[$index][$key] = $assoc_array[$key];
		}
		return $newArray;
	}
}

function JSP_SORT_ARITH ($array, $input, $logic)
{
	$paramArray = array($array,$input,$logic);
	$parseArray = array('*','<','>','<=','>=','==','!=','{}','><','EVEN','ODD','CURRENT','END','INDEX','KEY','VALUE','!KEY','!VALUE','FNTH','LNTH','ASC','DSC','RAND');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$logic))
		return JSPIP;	
	else
	{
		$input = JSP_BUILD_CSV($input);
		$array_keys = array_keys($array);
		$counter = 1;
		if ($logic == $parseArray[0])
			$output = $array;
		else if ($logic == $parseArray[1])
		{
			foreach ($array as $key => $value)
			{
				if ($counter < $input[0])
					$output[$key] = $value;
				$counter++;
			}
		}
		else if ($logic == $parseArray[2])
		{
			foreach ($array as $key => $value)
			{
				if ($counter > $input[0])
					$output[$key] = $value;
				$counter++;
			}
		}
		else if ($logic == $parseArray[3])
		{
			foreach ($array as $key => $value)
			{
				if ($counter <= $input[0])
					$output[$key] = $value;
				$counter++;
			}
		}
		else if ($logic == $parseArray[4])
		{
			foreach ($array as $key => $value)
			{
				if ($counter >= $input[0])
					$output[$key] = $value;
				$counter++;
			}
		}						
		else if ($logic == $parseArray[5])
		{
			foreach ($array as $key => $value)
			{
				if ($counter == $input[0])
					$output[$key] = $value;
				$counter++;
			}
		}
		else if ($logic == $parseArray[6])
		{
			foreach ($array as $key => $value)
			{
				if ($counter != $input[0])
					$output[$key] = $value;
				$counter++;
			}
		}		
		else if ($logic == $parseArray[7]) //BETWEEN {}
		{
			foreach ($array as $key => $value)
			{
				if ($counter >= $input[0] && $counter <= $input[1])
					$output[$key] = $value;
				$counter++;
			}
		}
		else if ($logic == $parseArray[8]) //WITHIN ><
		{
			foreach ($array as $key => $value)
			{
				if ($counter > $input[0] && $counter < $input[1])
					$output[$key] = $value;
				$counter++;
			}
		}		
		else if ($logic == $parseArray[9]) //EVEN
		{
			foreach ($array as $key => $value)
			{
				if (($counter % 2) == 0)
					$output[$key] = $value;
				$counter++;
			}
		}		
		else if ($logic == $parseArray[10]) //ODD
		{
			foreach ($array as $key => $value)
			{
				if (($counter % 2) == 1)
					$output[$key] = $value;
				$counter++;
			}
		}		
		else if ($logic == $parseArray[11]) //CURRENT
			$output = current($array);
		else if ($logic == $parseArray[12]) //END
			$output = end($array);			
		else if ($logic == $parseArray[13]) //INDEX
		{
			foreach ($array as $key => $value)
			{
				if (in_array($counter,$input))
					$output[$key] = $value;
				$counter++;
			}
		}			
		else if ($logic == $parseArray[14]) //KEY
		{
			//STERILIZE
			foreach ($input as $value)
			{
				if ($array[$value])
					$_input[] = $value;
			}
			foreach ($array as $key => $value)
			{
				if (in_array($key,$_input))
					$output[$key] = $value;
			}
		}
		else if ($logic == $parseArray[15]) //VALUE
		{
			foreach ($array as $key => $value)
			{
				if (in_array($value,$input))
					$output[$key] = $value;
			}
		}
		else if ($logic == $parseArray[16]) //NOT KEY
		{
			//STERILIZE
			foreach ($input as $value)
			{
				if ($array[$value])
					$_input[] = $value;
			}
			foreach ($array as $key => $value)
			{
				if (!in_array($key,$_input))
					$output[$key] = $value;
			}
		}
		else if ($logic == $parseArray[17]) //NOT VALUE
		{
			foreach ($array as $key => $value)
			{
				if (!in_array($value,$input))
					$output[$key] = $value;
			}
		}
		else if ($logic == $parseArray[18]) //FIRST nth
		{
			foreach ($array as $key => $value)
			{
				if ($counter <= $input[0])
					$output[$key] = $value;
				$counter++;
			}
		}
		else if ($logic == $parseArray[19]) //LAST nth
		{
			$diff = abs(count($array) - $input[0]);
			foreach ($array as $key => $value)
			{
				if ($counter > $diff)
					$output[$key] = $value;
				$counter++;					
			}
		}
		else if ($logic == $parseArray[20]) //ASC
		{
			asort($array);		
			$output = $array;
		}
		else if ($logic == $parseArray[21]) //DSC
		{
			arsort($array);		
			$output = $array;
		}
		else if ($logic == $parseArray[22]) //RAND
		{
			$shuffle = $array;
			shuffle($shuffle);
			foreach ($shuffle as $rand)
			{
				$key = array_search($rand,$array);
				$output[$key] = $rand;
			}
		}				
		else
			$output = $array;	
		return $output;
	}
}
?>






