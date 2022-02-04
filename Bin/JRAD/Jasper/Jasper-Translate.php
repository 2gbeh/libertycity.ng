<?php
function JSP_TRANS_DATE ($array, $returnType = 'PRESET', $pointer)
{
	$paramArray = array($array,$returnType,JSP_TRUEPUT($pointer));	
	$parseArray = JSP_ENUMS_PREDEF('MKFORMAT');
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;		
	else
	{
		//ARRANGE
		$array = JSP_BUILD_CSV($array);

		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array[$pointer] as $key => $value)
				$array[$pointer][$key] = JSP_CAL_MKFORMAT($value,'DATE',$returnType);
		}
		else
		{
			$ARRAY_KEYS = array_keys($array);
			$_pointer = $ARRAY_KEYS[$pointer];
			$array[$_pointer] = JSP_CAL_MKFORMAT($_pointer,'DATE',$returnType);
		}
		return $array;		
	}	
}

function JSP_TRANS_TIME ($array, $returnType = 'PRESET', $pointer)
{
	$paramArray = array($array,$returnType,JSP_TRUEPUT($pointer));	
	$parseArray = JSP_ENUMS_PREDEF('MKFORMAT');
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;		
	else
	{
		//ARRANGE
		$array = JSP_BUILD_CSV($array);

		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array[$pointer] as $key => $value)
				$array[$pointer][$key] = JSP_CAL_MKFORMAT($value,'TIME',$returnType);
		}
		else
		{
			$ARRAY_KEYS = array_keys($array);
			$_pointer = $ARRAY_KEYS[$pointer];
			$array[$_pointer] = JSP_CAL_MKFORMAT($_pointer,'TIME',$returnType);
		}
		return $array;		
	}	
}

function JSP_TRANS_TELLER ($array)
{
	$paramArray = array(JSP_TRUEPUT($array));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if (_ISDATE($array))
			return JSP_CAL_MKFORMAT($array,'DATE','TELLER');
		else if (_ISTIME($array))
			return JSP_CAL_MKFORMAT($array,'TIME','TELLER');
		else if (_ISLIN($array))
		{
			foreach ($array as $key => $value)
				$newArray[$key] = JSP_TRANS_TELLER($value);
			return $newArray;
		}
		else if (_ISDIM($array))
		{
			foreach ($array as $index => $assoc_array)
			{			
				foreach ($assoc_array as $key => $value)
					$newArray[$index][$key] = JSP_TRANS_TELLER($value);
			}
			return $newArray;			
		}
		else
			return $array;
	}
}

function JSP_TRANS_RID ($array, $table, $field, $pointer = '*')
{
	$paramArray = array($array,$table,$field,$pointer);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		//ARRANGE
		$array = JSP_BUILD_CSV($array);			
		if (JSP_ATYPE($array) == 2)
		{
			if (count(JSP_BUILD_CSV($pointer)) != 1)
			{
				//TRANS MULITPLE
				foreach (JSP_BUILD_CSV($pointer) as $index)
				{
					foreach ($array[$index] as $key => $value)
					{
						$JSP_FETCH_BYID = JSP_FETCH_BYID($table,$value);
						if (!JSP_ERROR_CATCH($JSP_FETCH_BYID))
							$array[$index][$key] = $JSP_FETCH_BYID[$field];
					}
				}
			}			
			else
			{
				foreach ($array[$pointer] as $key => $value)
				{
					$JSP_FETCH_BYID = JSP_FETCH_BYID($table,$value);
					if (!JSP_ERROR_CATCH($JSP_FETCH_BYID))
						$array[$pointer][$key] = $JSP_FETCH_BYID[$field];
				}
			}
		}
		else
		{
			$ARRAY_KEYS = array_keys($array);
			if ($pointer == '*')
			{
				foreach ($array as $key => $id)
				{
					$row = JSP_FETCH_BYID($table,$id);
					$array[$key] = $row[$field];
				}
			}
			else if (count(JSP_BUILD_CSV($pointer)) != 1)
			{
				foreach (JSP_BUILD_CSV($pointer) as $index)
				{
					$_pointer = $ARRAY_KEYS[$index];					
					$JSP_FETCH_BYID = JSP_FETCH_BYID($table,$array[$_pointer]);
					if (!JSP_ERROR_CATCH($JSP_FETCH_BYID))			
						$array[$_pointer] = $JSP_FETCH_BYID[$field];
				}
			}
			else
			{			
				$_pointer = $ARRAY_KEYS[$pointer];
				$JSP_FETCH_BYID = JSP_FETCH_BYID($table,$array[$_pointer]);
				if (!JSP_ERROR_CATCH($JSP_FETCH_BYID))			
					$array[$_pointer] = $JSP_FETCH_BYID[$field];
			}
		}
		return $array;
	}
}

function JSP_TRANS_IP ($array, $table, $field, $pointer)
{
	$paramArray = array($array,$table,$field,JSP_TRUEPUT($pointer));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$ipArray = _BYCOL($table,'ip');
		$array = JSP_BUILD_CSV($array);
		if (_ISDIM($array))
		{
			foreach ($array[$pointer] as $key => $ip)
			{
				if (in_array($ip,$ipArray))
				{
					$row = JSP_SSQL_LAST($table,'ip',$ip);
					$array[$pointer][$key] = $row[$field];
				}
			}
			return $array;
		}
		else
		{
			$array_keys = array_keys($array);
			$realkey = $array_keys[$pointer];
			$ip = $array[$realkey];
			if (in_array($ip,$ipArray))
			{
				$row = JSP_SSQL_LAST($table,'ip',$ip);				
				$array[$realkey] = $row[$field];
			}
			return JSP_CRUNCH_ARRAY($array);
		}	
	}
}

function JSP_TRANS_GLOB ($array, $glob, $pointer)
{
	$paramArray = array($array,$glob,JSP_TRUEPUT($pointer));	
	$parseArray = JSP_GLOBAL_RECORDS('map','fields');	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$glob))
		return JSPIP;		
	else
	{
		//ARRANGE
		$array = JSP_BUILD_CSV($array);		
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array[$pointer] as $key => $value)
				$array[$pointer][$key] = JSP_GLOBAL_RECORDS($glob,$value);
		}
		else
		{
			$ARRAY_KEYS = array_keys($array);
			$_pointer = $ARRAY_KEYS[$pointer];			
			$array[$_pointer] = JSP_GLOBAL_RECORDS($glob,$array[$_pointer]);
		}
		return $array;
	}
}

function JSP_TRANS_QUAKER ($array, $pointer)
{
	$paramArray = array($array,JSP_TRUEPUT($pointer));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		//ARRANGE
		$array = JSP_BUILD_CSV($array);			
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array[$pointer] as $key => $value)
			{
				if ($value == '0')
					$array[$pointer][$key] = 'access';
				else if ($value == '1')
					$array[$pointer][$key] = 'action';
				else
					$array[$pointer][$key] = $value;
			}
		}
		else
		{
			$ARRAY_KEYS = array_keys($array);
			$_pointer = $ARRAY_KEYS[$pointer];				
			if ($array[$_pointer] == '0')
				$array[$_pointer] = 'access';
			else if ($array[$_pointer] == '1')
				$array[$_pointer] = 'action';
			else
				$array[$_pointer] = $value;
		}
		return $array;
	}
}

function JSP_TRANS_ENUMS ($array, $function = 'GENERIC', $param = 'STATE', $pointer)
{
	$paramArray = array($array,$function,$param,JSP_TRUEPUT($pointer));	
	$parseArray = array('GENERIC','DATE','PREDEF');
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$function))
		return JSPIP;		
	else
	{
		//ARRANGE
		$array = JSP_BUILD_CSV($array);			
		if ($function == $parseArray[0]) //GENERIC
			$JSP_ENUMS = JSP_ENUMS_GENERIC($param);
		else if ($function == $parseArray[1]) //DATE
			$JSP_ENUMS = JSP_ENUMS_DATE($param);			
		else //PREDEF
			$JSP_ENUMS = JSP_ENUMS_PREDEF($param);			

		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array[$pointer] as $key => $value)
				$array[$pointer][$key] = $JSP_ENUMS[$value];
		}
		else
		{
			$ARRAY_KEYS = array_keys($array);
			$_pointer = $ARRAY_KEYS[$pointer];
			$array[$_pointer] = $JSP_ENUMS[$_pointer];
		}
		return $array;		
	}
}

function JSP_TRANS_PREDEF ($array, $predefArray, $pointer)
{
	$paramArray = array($array,$predefArray,JSP_TRUEPUT($pointer));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		//ARRANGE
		$array = JSP_BUILD_CSV($array);
		$JSP_ENUMS = $predefArray;

		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array[$pointer] as $key => $value)
				$array[$pointer][$key] = $JSP_ENUMS[$value];
		}
		else
		{
			$ARRAY_KEYS = array_keys($array);
			$_pointer = $ARRAY_KEYS[$pointer];
			$array[$_pointer] = $JSP_ENUMS[$_pointer];
		}
		return $array;		
	}	
}

function JSP_TRANS_LINK ($array)
{
	$paramArray = array($array);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$array = JSP_BUILD_CSV($array);
		if (_ISDIM($array))
		{
			foreach ($array as $index => $assoc_array)
			{
				foreach ($assoc_array as $key => $value)
				{
					if (_ISLINK($value))
						$array[$index][$key] = '<a href="'.$value.'" class="anchor">'.$value.'</a>';
				}
			}
			return _CRUNCH($array);
		}
		else
		{
			$newArray[0] = $array;
			return JSP_TRANS_LINK($newArray);
		}
	}
}

function JSP_TRANS_JUMBO ($array, $pointer)
{
	$paramArray = array($array,JSP_TRUEPUT($pointer));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$array = JSP_BUILD_CSV($array);
		if (_ISDIM($array))
		{
			foreach ($array[$pointer] as $key => $value)
			{
				if (is_numeric($value))
					$array[$pointer][$key] = JSP_BUILD_JUMBO($value);
			}
			return $array;
		}
		else
		{
			$array_keys = array_keys($array);
			$realkey = $array_keys[$pointer];
			$value = $array[$realkey];
			if (is_numeric($value))
				$array[$realkey] = JSP_BUILD_JUMBO($value);
			return $array;
		}	
	}
}

function JSP_TRANS_DENOM ($array, $pointer)
{
	$paramArray = array($array,JSP_TRUEPUT($pointer));	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$array = JSP_BUILD_CSV($array);
		if (_ISDIM($array))
		{
			foreach ($array[$pointer] as $key => $value)
			{
				if (is_numeric($value))
					$array[$pointer][$key] = JSP_BUILD_DENOM($value);
			}
			return $array;
		}
		else
		{
			$array_keys = array_keys($array);
			$realkey = $array_keys[$pointer];
			$value = $array[$realkey];
			if (is_numeric($value))
				$array[$realkey] = JSP_BUILD_DENOM($value);
			return $array;
		}	
	}
}

function JSP_TRANS_WRAP ($array, $pointer, $strlen = 160)
{
	$paramArray = array($array,$pointer,$strlen);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$array = JSP_BUILD_CSV($array);
		if (_ISDIM($array))
		{
			foreach ($array[$pointer] as $key => $value)
				$array[$pointer][$key] = JSP_WRAP_STR($value,$strlen);
			return $array;
		}
		else
		{
			if ($pointer == '*')
			{
				foreach ($array as $key => $value)
					$array[$key] = JSP_WRAP_STR($value,$strlen);
				return $array;				
			}
			else
			{
				$array_keys = array_keys($array);
				$realkey = $array_keys[$pointer];
				$value = $array[$realkey];
				if (is_numeric($value))
					$array[$realkey] = JSP_WRAP_STR($value,$strlen);
				return $array;
			}
		}			
	}
}

function JSP_TRANS_TEXTAREA ($array, $pointer)
{
	$paramArray = array($array,$pointer);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$array = JSP_BUILD_CSV($array);
		if (_ISDIM($array))
		{
			foreach ($array[$pointer] as $key => $value)
				$array[$pointer][$key] = nl2br($value);
			return $array;
		}
		else
		{
			if ($pointer == '*')
			{
				foreach ($array as $key => $value)
					$array[$key] = nl2br($value);
				return $array;				
			}
			else
			{
				$array_keys = array_keys($array);
				$realkey = $array_keys[$pointer];
				$value = $array[$realkey];
				if (is_numeric($value))
					$array[$realkey] = nl2br($value);
				return $array;
			}
		}			
	}
}

function JSP_TRANS_PAGI ($ini, $rtype = 'START')
{
	$paramArray = array(JSP_TRUEPUT($ini),$rtype);	
	$parseArray = array('START','END');	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$rtype))
		return JSPIP;		
	else
	{
		$end = $ini * 10;
		$start = $end - 9;
		if ($rtype == $parseArray[0])
			return $start;
		else
			return $end;
	}
}

?>

