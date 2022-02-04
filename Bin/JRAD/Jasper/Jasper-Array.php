 <?php
 function JSP_TYPE_ARRAY ($array)
{
	if (JSP_ATYPE($array) == 2)
		return 'DIM';
	else
		return 'LIN';	
}

function JSP_APEX_ARRAY ($array, $type)
{
	$paramArray = array($array,$type);	
	$parseArray = array('LOW','HIGH');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type)) 
		return JSPIP;		
	else 
	{
		$array = JSP_BUILD_CSV($array);
		if (JSP_ATYPE($array) == 1)
		{
			asort($array);			
			if ($type == $parseArray[0])
				return current($array);
			else
				return end($array);				
		}
		else
		{
			$dimArray = JSP_STACK_ARRAY($array);
			asort($dimArray);			
			if ($type == $parseArray[0])
				return current($dimArray);
			else
				return end($dimArray);							
		}		
	}
}

function JSP_BUILD_ARRAY ($string, $separator = ',')
{
	$paramArray = array($string,JSP_TRUEPUT($separator));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
		return explode($separator,$string);		
}

function JSP_BUILD_DIMARRAY ($array)
{
	$paramArray = array($array);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if (_ISSTR($array))
		{
			$newArray[0][0] = $array;
			$array = $newArray;			
		}
		if (_ISLIN($array))
		{
			foreach ($array as $key => $value)
				$newArray[0][$key] = $value;
			$array = $newArray;
		}
		return $array;
	}
}

function JSP_BUILD_TARRAY ($entry)
{
	$paramArray = array($entry);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		$tableKey = '<table';
		$thKey = '<th';		
		$trKey = '<tr';
		$tdKey = '<td';
		
		$close_table = '</table>';
		$close_th = '</th>';		
		$close_tr = '</tr>';
		$close_td = '</td>';
		
		if (_STRPOS($entry,$tableKey))
		{
			$x = _STRPOS($entry,$trKey);
			$y = _STRPOS($entry,$close_table);
			$newArray[0] = JSP_CROP_STRPOS($entry,$x,'<');
			$newArray[1] = $close_table;
			$no_table = JSP_BUTCHER_STR($entry,$newArray[0]);
			return JSP_BUILD_TARRAY($no_table);
			
		}
		else
		{
			if (_STRPOS($entry,$trKey))
			{
				return $array = JSP_BUILD_ARRAY($entry,$trKey);
			}
			else
			{
				if (_STRPOS($entry,'<td'))
				{
					$array = JSP_BUILD_ARRAY($entry,'<td');
					foreach ($array as $value)
					{
						if (_ISSTR($value))
							$newArray[] = _WSP('<td'.$value);
					}
				}
				else
					return JSPIL;
			}
		}
		return $newArray;
	}
}

function JSP_BUILD_ZARRAY ($entry)
{
	$paramArray = array($entry);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{	
		$_REMOTE = $entry;
		//GET KEY
		$key = JSP_BUILD_ARRAY($_REMOTE,'=>');
		foreach ($key as $i)
			$newKey[] = JSP_CROP_STR($i,'["','"]');
		//GET VALUE
		$value = JSP_BUILD_ARRAY($_REMOTE,') "');
		foreach ($value as $i)
		{
			$trim = JSP_BUTCHER_STR($i,'["','RIGHT');
			if (_THROW($trim))
			{
				$clearApos = JSP_BUTCHER_STR($i,'"','RIGHT');
				if (!$clearApos)
					$newValue[] = '""';
				else
					$newValue[] = $clearApos;
			}
		}
		//GET !STRING
		$string = JSP_BUILD_ARRAY($_REMOTE,'t(');
		foreach ($string as $i)
		{
			$addAst = '*'.$i;
			$noStr[] = JSP_CROP_STR($addAst,'*',')');
			if (strpos($i,'{ }'))
				$noStr[] = 'array(0) { }';
		}
		//SET ARRAY
		$noStr = JSP_POP_ARRAY($noStr,'CURRENT');
		$newValue = JSP_PUSH_ARRAY($newValue,$noStr,'END');
		foreach ($newKey as $i => $e)
		{
			if (!$newValue[$i]) //ZERO
				$newRemote[$e] = 'int(0)';
			else
				$newRemote[$e] = $newValue[$i];
		}
		return $newRemote = JSP_POP_ARRAY($newRemote,'END');
	}
}

function JSP_BUTCHER_ARRAY ($array, $mark, $direction = 'LEFT')
{
	$paramArray = array($array,JSP_TRUEPUT($mark),$direction);
	$parseArray = array('LEFT','RIGHT');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$direction)) 
		return JSPIP;		
	else 
	{
		$array = JSP_BUILD_CSV($array);
		if (JSP_ATYPE($array) == 1)
		{
			foreach ($array as $key => $value)
			{
				if ($direction == $parseArray[0]) //LEFT
					$newArray[$key] = array_pop(explode($mark,$value));
				else //RIGHT
					$newArray[$key] = array_shift(explode($mark,$value));
			}
		}
		else
		{
			foreach ($array as $index => $assoc_array)
			{						
				foreach ($assoc_array as $key => $value)
				{
					if ($direction == $parseArray[0]) //LEFT
						$newArray[$index][$key] = array_pop(explode($mark,$value));
					else //RIGHT
						$newArrayp[$index][$key] = array_shift(explode($mark,$value));
				}			
			}
		}
		return $newArray;
	}
}

function JSP_DROP_ARRAY ($array, $delimiter = '')
{
	$paramArray = array($array,JSP_TRUEPUT($delimiter));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		if (!strlen($array))
			$array = implode($delimiter,$array);
		return $array;
	}
}

function JSP_SUM_ARRAY ($array, $position)
{
	$paramArray = array($array,$position);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$array = JSP_BUILD_CSV($array);
		if (JSP_ATYPE($array) == 1)
		{
			foreach ($array as $key => $value)
			{
				if ($key == $position)
					$sum += $value;
			}
		}
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array as $index => $assoc_array)
			{		
				foreach ($assoc_array as $key => $value)
				{
					if ($key == $position)
						$sum += $value;
				}			
			}
		}
		return $sum;
	}
}

function JSP_NOZERO_ARRAY ($entry, $type = 'MILD')
{
	$paramArray = array($entry,$type);		
	$parseArray = array ('MILD','STRICT');	
	if 
	(
		JSP_PARAM_FORMAT($paramArray) || 
		strlen($entry)
	) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;					
	else
	{
		if ($type == $parseArray[0]) //MILD
		{
			foreach ($entry as $value)
			{
				if ($value != '0')
					$newArray[] = $value;
			}
			return $newArray;			
		}
		else
		{
			foreach ($entry as $value)
			{
				if ($value != '0')
				{			
					$newArray[] = JSP_NOZERO_STR($value);
				}
			}			
			return $newArray;			
		}
	}
}

function JSP_REKEY_ARRAY ($array)
{
	$paramArray = array($array);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$array = JSP_BUILD_CSV($array);
		if (JSP_ATYPE($array) == 1)
		{
			foreach ($array as $value)
				$newArray[] = $value;
		}
		else if (JSP_ATYPE($array) == 2)		
		{
			$x = 0;
			foreach ($array as $assoc_array)
			{
				$y = 0;
				foreach ($assoc_array as $value)				
				{
					$newArray[$x][$y] = $value;
					$y++;
				}
				$x++;
			}
		}
		else
			$newArray = JSPIL;
		return $newArray;
	}
}

function JSP_DEFKEY_ARRAY ($array, $keyArray)
{
	$paramArray = array($array,$keyArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$array = JSP_BUILD_CSV($array);
		$keyArray = JSP_REKEY_ARRAY($keyArray);		
		$pointer = 0;
		if (_ISLIN($array))
		{
			foreach ($array as $value)
			{
				$newKey = $keyArray[$pointer];
				$newArray[$newKey] = $value;
				$pointer++;
			}
		}
		else
		{
			foreach ($array as $index => $assoc_array)
			{
				$pointer = 0;				
				foreach ($assoc_array as $value)
				{				
					$newKey = $keyArray[$pointer];
					$newArray[$index][$newKey] = $value;
					$pointer++;
				}
			}
		}
		return $newArray;
	}
}

function JSP_DUPKEY_ARRAY ($uArray, $eArray)
{
	$paramArray = array($uArray,$eArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$uArray = JSP_BUILD_CSV($uArray);
		$eArray = JSP_BUILD_CSV($eArray);
		if (count($uArray) != count($eArray))
			return JSPIL;
		$arrayKeys = array_keys($eArray);
		$pointer = 0;		
		foreach ($uArray as $key => $value)
		{
			$newKey = $arrayKeys[$pointer];
			$newArray[$key] = $eArray[$newKey];
			$pointer++;
		}
		return $newArray;
	}
}

function JSP_STACK_ARRAY ($dimArray)
{
	$paramArray = array($dimArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		foreach ($dimArray as $assoc_array)
		{	
			foreach ($assoc_array as $value)
				$linear[] = $value;
		}
		return $linear;
	}
}

function JSP_INJECT_ARRAY ($mainArray, $subArray, $interval)
{
	$paramArray = array($mainArray,$subArray,$interval);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($interval)) 
		return JSPIP;		
	else
	{	
		$mainArray = JSP_BUILD_CSV($mainArray);
		$subArray = JSP_BUILD_CSV($subArray);				
		$subArrayKeys = array_keys($subArray);		
		$sizeofMain = count($mainArray);
		$sizeofSub = count($subArray);
		if 
		(
			JSP_ATYPE($mainArray) != 1 || 
			JSP_ATYPE($subArray) != 1 ||
			$interval > $sizeofMain
		)
			return JSPIL;			
		$counter = 1;
		$pointer = 0;		
		foreach ($mainArray as $value)
		{
			$newArray[] = $value;
			if ($counter == $interval)
			{	
				$newArray[] = $subArray[$subArrayKeys[$pointer]];			
				$counter = 0;
				$pointer++;				
			}			
			$counter++;			
		}
		foreach ($newArray as $value)
		{
			if ($value)
				$newnewArray[] = $value;
		}
		return $newnewArray;
	}
}

function JSP_CONCAT_ARRAY ($array, $axis, $limit)
{
	$paramArray = array($array,$axis,$limit);	
	$parseArray = array('X','Y');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$axis) || !is_numeric($limit))
		return JSPIP;	
	else
	{
		if ($axis == $parseArray[0]) //X
		{
			if (JSP_ATYPE($array) == 1)
			{
				if ($limit > count($array))
					return JSPIL;
				$limitArray = JSP_SORT_LIMIT($array,$limit,0);
				$newArray = JSP_DROP_ARRAY($limitArray,' ');						
			}
			else
			{
				foreach ($array as $assoc_array)
				{
					if ($limit > count($assoc_array))
						return JSPIL;
					$limitArray = JSP_SORT_LIMIT($assoc_array,$limit,0);
					$newArray[] = JSP_DROP_ARRAY($limitArray,' ');
				}
			}
		}
		else //Y
		{
			if (JSP_ATYPE($array) == 1 || $limit > count($array))
				return JSPIL;
			else
			{
				$mockid = array_keys($array[0]);
				for ($o = 0; $o < count($mockid); $o++)
				{
					for ($i = 0; $i < $limit; $i++)
						$limitArray[$mockid[$o]] .= $array[$i][$mockid[$o]].' ';
				}
				foreach ($limitArray as $key => $value)
					$newArray[$key] = substr($value,0,-1);
			}
		}
		return $newArray;
	}
}

function JSP_CONFIG_ARRAY ($array)
{
	$paramArray = array($array);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{	
		if (_ISLIN($array))
		{
			foreach ($array as $key => $value)
				$newArray[$key][] = $value;
		}
		else
		{
			foreach (current($array) as $key => $value)
			{
				foreach ($array as $index => $assoc_array)
					$newArray[$key][$index] = $assoc_array[$key];
			}
		}
		return $newArray;
	}
}

function JSP_FRAG_ARRAY ($array, $fragValue)
{
	$paramArray = array($array,$fragValue);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($fragValue)) 
		return JSPIP;		
	else
	{	
		$array = JSP_BUILD_CSV($array);	
		if (JSP_ATYPE($array) != 1 /*|| $fragValue >= count($array)*/)
			return JSPIL;
		$counter = 1;
		$index = 0;
		foreach ($array as $key => $value)
		{
			$newArray[$index][$key] = $value;
			if ($counter == $fragValue)
			{
				$newArray[$index][$key] = $value;
				$counter = 0;				
				$index++;					
			}				
			$counter++;			
		}
		return $newArray;
	}
}

function JSP_SORT_ARRAY ($array, $element, $type = 'KEY')
{
	$paramArray = array($array,$element,$type);
	$parseArray = array('KEY','VALUE');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type)) 
		return JSPIP;		
	else 
	{
		$array = _CSV($array);
		$element = _CSV($element);
		foreach ($array as $key => $value)
		{
			if ($type == $parseArray[1]) //VALUE
			{
				if (in_array($value,$element))
					$newArray[$key] = $value;
			}
			else
			{
				if (in_array($key,$element))
					$newArray[$key] = $value;
			}			
		}
		return $newArray;
	}
}

function JSP_TRIM_ARRAY ($array, $trim)
{
	$paramArray = array($array,$trim);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($trim))
		return JSPIP;	
	else 
	{
		$array = JSP_BUILD_CSV($array);			
		if (JSP_ATYPE($array) == 1)
		{
			if ($trim >= count($array))
				return JSPIL;			
			foreach ($array as $key => $value)
			{
				$key++;
				if ($key > $trim)
					$newArray[] = $value;
			}
		}
		else
		{
			foreach ($array as $index => $assoc_array)
			{
				if ($trim >= count($assoc_array))
					return JSPIL;			
				foreach ($assoc_array as $key => $value)
				{
					$key++;
					if ($key > $trim)
						$newArray[$index][] = $value;
				}
			}
		}
		return $newArray;
	}
}

function JSP_PUSH_ARRAY ($uArray, $eArray, $position = 'END')
{
	$paramArray = array($uArray,JSP_TRUEPUT($eArray),$position);
	$parseArray = array('CURRENT','END','EVEN','ODD');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$position))
		return JSPIP;	
	else 
	{
		$uArray = JSP_BUILD_CSV($uArray);
		$eArray = JSP_BUILD_CSV($eArray);
		$uKey = array_keys($uArray);
		$eKey = array_keys($eArray);
		if ($position == $parseArray[0]) //CURRENT
			$newArray = JSP_STACK_ARRAY(array($eArray,$uArray));
		else if ($position == $parseArray[1]) //END
			$newArray = JSP_STACK_ARRAY(array($uArray,$eArray));
		else if ($position == $parseArray[2]) //EVEN
		{
			$counter = 1;
			for ($i = 0; $i < count($uArray); $i++)
			{
				if (($counter % 2) == 0)
				{
					$proArray[] = $eArray[$eKey[$i - 1]];
					$proArray[] = $uArray[$uKey[$i]];
				}
				else
				{
					$proArray[] = $uArray[$uKey[$i]];
					$counter++;
				}
			}
			$proArray[] = $eArray[$eKey[$i - 1]];
		}
		else //ODD
		{
			$counter = 1;
			for ($i = 0; $i < count($uArray); $i++)
			{
				if (($counter % 2) != 0)
				{
					$proArray[] = $eArray[$eKey[$i]];
					$proArray[] = $uArray[$uKey[$i]];
				}
				else
				{
					$proArray[] = $uArray[$uKey[$i]];
					$counter++;
				}
			}
			$proArray[] = $eArray[$eKey[$i]];
		}		
		foreach ($proArray as $key => $value) //CLEAR NULL
		{
			if ($value !== null)
				$newArray[] = $value;
		}		
		return $newArray;
	}
}

function JSP_POP_ARRAY ($array, $position = 'END')
{
	$paramArray = array($array,$position);
	$parseArray = array('CURRENT','END','EVEN','ODD');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$position))
		return JSPIP;	
	else 
	{
		$array = JSP_BUILD_CSV($array);
		if ($position == $parseArray[0]) //CURRENT
			$skip[] = 1;
		else if ($position == $parseArray[1]) //END
			$skip[] = count($array);
		else if ($position == $parseArray[2]) //EVEN
		{
			$counter = 1;
			foreach ($array as $key => $value)
			{
				if (($counter % 2) != 0)
					$skip[] = $key;
				$counter++;
			}
		}
		else //ODD
		{
			$counter = 1;
			foreach ($array as $key => $value)
			{
				if (($counter % 2) == 0)
					$skip[] = $key;
				$counter++;
			}
		}		
		$pointer = 1;		
		foreach ($array as $key => $value) //SKIP HOTKEY
		{
			if (!in_array($pointer,$skip))
				$newArray[$key] = $value;
			$pointer++;
		}		
		return $newArray;
	}
}

function JSP_SHIFT_ARRAY ($uArray, $eArray, $position = 'END')
{
	$paramArray = array($uArray,JSP_TRUEPUT($eArray),$position);
	$parseArray = array('CURRENT','END');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		(
			!is_numeric($position) &&		
			JSP_PARAM_PARSE($parseArray,$position) //PARSE
		) ||
		(
			is_numeric($position) &&
			$position > (count($uArray) + 1) //BEYOND
		)
	) 
		return JSPIP;	
	else 
	{
		$uArray = JSP_BUILD_CSV($uArray);
		$eArray = JSP_BUILD_CSV($eArray);
		if ($position == $parseArray[0]) //CURRENT
			$newArray = JSP_STACK_ARRAY(array($eArray,$uArray));
		else if ($position == $parseArray[1] || $position == (count($uArray) + 1)) //END
			$newArray = JSP_STACK_ARRAY(array($uArray,$eArray));
		else
		{
			$pointer = 1;			
			foreach ($uArray as $value)
			{
				if ($pointer == $position)
					$newArray = JSP_STACK_ARRAY(array($newArray,$eArray));			
				$newArray[] = $value;			
				$pointer++;
			}
		}
		return $newArray;
	}
}

function JSP_INVERT_ARRAY ($array, $keyType = 'PRE')
{
	$paramArray = array($array,$keyType);
	$parseArray = array('PRE','NEW');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$keyType)) 
		return JSPIP;	
	else 
	{
		$array_keys = array_keys($array);
		$strlen = count($array) - 1;
		for ($i = $strlen; $i > -1; $i--)
		{
			$key = $array_keys[$i];
			$value = $array[$key];
			$preArray[$key] = $value;
			$newArray[] = $value;			
		}
		if ($keyType == $parseArray[0]) //PRESERVE KEY
			return $preArray;
		else
			return $newArray;		
	}
}

function JSP_COMPARE_ARRAY ($answerArray, $entryArray)
{
	$paramArray = array($answerArray,$entryArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$answerArray = JSP_REKEY_ARRAY(_CSV($answerArray));
		$entryArray = JSP_REKEY_ARRAY(_CSV($entryArray));
		if (count($answerArray) != count($entryArray))
			return JSPIL;

		$total = count($answerArray);
		$score = 0;
		foreach ($answerArray as $key => $value)
		{
			if ($value == $entryArray[$key])
			{
				$score++;
				$correct[] = $key + 1;
			}
			else
				$wrong[] = $key + 1;
		}
		$perc = ($score * 100)/$total.'%';
		$scoreSheet = array
		(
			'SCORE' => $score,
			'PERC' => $perc,
			'CORRECT' => $correct,
			'WRONG' => $wrong,
			'TOTAL' => $total,									
		);
		return $scoreSheet;
	}	
}
?>



