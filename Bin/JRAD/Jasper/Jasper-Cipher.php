<?php
function JSP_CIPHER_ENCTYPE ($string)
{
	$paramArray = array(JSP_TRUEPUT($string));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$strlen = strlen($string);
		$cap = round((70 * $strlen)/100);
		$_string = JSP_BUILD_STR($string);
		foreach ($_string as $str)
		{
			if (array_search($str,JSP_CIPHER_SYSTEM('DECODE')))
				$match[] = $str;
		}
		if (count($match) < $cap)
			return 1;
	}
}

function JSP_CIPHER_SYSTEM ($enctype = 'ENCODE')
{
	$parseArray = array('ENCODE','DECODE');		
	if (JSP_PARAM_PARSE($parseArray,$enctype))
		return JSPIP;	
	else
	{
		$cryptoSystem = array 
		(
			"ENCODE" => array
			(
				'/=','/!','/#','/+','/3','/*','/%','/:','/8','/;','/,','/_','/@','/?','/9','/0','/1','/4','/-','/5','/7','/$','/2','/.','/6','/&',
				'\=','\!','\#','\+','\3','\*','\%','\:','\8','\;','\,','\_','\@','\?','\9','\0','\1','\4','\-','\5','\7','\$','\2','\.','\6','\&',
				'~','(',')','{','}','[',']','<','>','^'
			),
			"DECODE" => array
			(
				'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
				'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
				'1','2','3','4','5','6','7','8','9','0'
			)			
		);
		return $cryptoSystem[$enctype];
	}
}

function JSP_CIPHER_ENCODE ($string)
{
	$paramArray = array(JSP_TRUEPUT($string));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if (!JSP_CIPHER_ENCTYPE($string))
		{
			$JSP_CIPHER_SYSTEM_ENCODE = JSP_CIPHER_SYSTEM('ENCODE');		
			$_string = JSP_BUILD_STR($string);
			//GET DECODE KEYS
			foreach ($_string as $value)
			{
				$decodeMap = array_search($value,JSP_CIPHER_SYSTEM('DECODE'));
				if (!$decodeMap)
					$hotKeys[] = $value;
				else
					$hotKeys[] = $decodeMap;
			}
			//MATCH DECODE KEYS TO ENCODE MAP
			foreach ($hotKeys as $value)
			{
				$encodeMap = $JSP_CIPHER_SYSTEM_ENCODE[$value];
				if (!$encodeMap)
					$newStr[] = $value;
				else	
					$newStr[] = $encodeMap;
			}
			return JSP_DROP_ARRAY($newStr,'');
		}
		else
			return $string;
	}
}
	
function JSP_CIPHER_DECODE ($string)
{
	$paramArray = array(JSP_TRUEPUT($string));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{	
		if (JSP_CIPHER_ENCTYPE($string))
		{		
			$upper = '/';
			$lower = '\ ';
			$lower = substr($lower,0,1);
			$JSP_CIPHER_SYSTEM_DECODE = JSP_CIPHER_SYSTEM('DECODE');		
			$_string = JSP_BUILD_STR($string);
			//PAIR SLASH
			foreach ($_string as $key => $value)
			{
				$prev = $_string[$key - 1];
				if ($value == $upper || $value == $lower)
					$xter[] = $value.$_string[$key + 1];
				else if ($prev == $upper || $prev == $lower);
				else
					$xter[] = $value;
			}
			//GET ENCODE KEYS			
			foreach ($xter as $value)
			{
				$encodeMap = array_search($value,JSP_CIPHER_SYSTEM('ENCODE'));
				if (!$encodeMap)
					$hotKeys[] = $value;
				else
					$hotKeys[] = $encodeMap;
			}
			//MATCH ENCODE KEYS TO DECODE MAP		
			foreach ($hotKeys as $value)
			{
				$decodeMap = $JSP_CIPHER_SYSTEM_DECODE[$value];
				if (!$decodeMap && $decodeMap != '0')
					$newStr[] = $value;
				else	
					$newStr[] = $decodeMap;
			}						
			return JSP_DROP_ARRAY($newStr,'');
		}
		return $string;
	}
}

function JSP_CIPHER_ARRAY ($array, $enctype = 'ENCODE')
{
	$paramArray = array($array,$enctype);	
	$parseArray = array('ENCODE','DECODE');		
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$enctype))
		return JSPIP;
	else
	{
		foreach ($array as $key => $value)
		{
			if ($enctype == $parseArray[0]) //ENCODE
				$array[$key] = JSP_CIPHER_ENCODE($value);
			else
				$array[$key] = JSP_CIPHER_DECODE($value);
		}
		return $array;
	}
}

function JSP_CIPHER_USSD ($string)
{	
	$paramArray = array($string);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_CTYPE($string) != 2)
		return JSPIP;		
	else
	{
		if (!strlen($string))
			$string = JSP_DROP_ARRAY($string);		
		$string = JSP_BUILD_STR($string);
		$string = JSP_DROP_CASE($string);
		foreach ($string as $value)
		{
			if (JSP_CIPHER_USSD_SCANNER($value,1,3))
				$tollfree[] = 2;
			else if (JSP_CIPHER_USSD_SCANNER($value,4,6))
				$tollfree[] = 3;			
			else if (JSP_CIPHER_USSD_SCANNER($value,7,9))
				$tollfree[] = 4;			
			else if (JSP_CIPHER_USSD_SCANNER($value,10,12))
				$tollfree[] = 5;			
			else if (JSP_CIPHER_USSD_SCANNER($value,13,15))
				$tollfree[] = 6;			
			else if (JSP_CIPHER_USSD_SCANNER($value,16,19))
				$tollfree[] = 7;
			else if (JSP_CIPHER_USSD_SCANNER($value,20,22))
				$tollfree[] = 8;			
			else //if (JSP_SCANNER_USSD($value,23,26))
				$tollfree[] = 9;							
		}
		return JSP_DROP_ARRAY($tollfree,'');
	}
}

function JSP_CIPHER_USSD_SCANNER ($value, $from, $to)
{
	$paramArray = array($value,$from,$to);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		$cryptoSystem = range('a','z');						
		$scanner = JSP_SORT_RANGE($cryptoSystem,$from,$to,0);
		if (in_array($value,$scanner))
			return 1;
	}
}	

function JSP_CIPHER_TABLE ($table, $fieldArray)
{
	$paramArray = array($table,$fieldArray);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if ($fieldArray == '*')
			$fieldArray = JSP_FETCH_PRIKEY($table,'FILTER');
		else
			$fieldArray = JSP_BUILD_CSV($fieldArray);
		foreach ($fieldArray as $field)
		{
			$recordsArray = JSP_FETCH_PREDEF($table,$field,1);
			foreach ($recordsArray[0] as $prikey => $record)
			{
				$ENCODE = JSP_CIPHER_ENCODE($record);
				JSP_CRUD_UPDATE($table,$field,$ENCODE,array('PRIKEY',$prikey,1));
			}
		}
		return 1;
	}
}

function JSP_CIPHER_TRANS ($array, $enctype = 'ENCODE', $pointer)
{
	$paramArray = array($array,$enctype,JSP_TRUEPUT($pointer));
	$parseArray = array('ENCODE','DECODE');		
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$enctype))
		return JSPIP;		
	else
	{
		//ARRANGE
		$array = JSP_BUILD_CSV($array);	
		if (JSP_ATYPE($array) == 2)
		{
			if ($pointer == '*')
			{
				//TRANS ALL				
				foreach ($array as $index => $assoc_array)
				{
					foreach ($assoc_array as $key => $value)
					{
						if ($enctype == $parseArray[0]) //ENCODE
							$array[$index][$key] = JSP_CIPHER_ENCODE($value);
						else
							$array[$index][$key] = JSP_CIPHER_DECODE($value);
					}
				}
			}
			else if (count(JSP_BUILD_CSV($pointer)) != 1)
			{
				//TRANS MULTIPLE
				foreach (JSP_BUILD_CSV($pointer) as $index)
				{
					foreach ($array[$index] as $key => $value)
					{
						if ($enctype == $parseArray[0]) //ENCODE
							$array[$index][$key] = JSP_CIPHER_ENCODE($value);
						else
							$array[$index][$key] = JSP_CIPHER_DECODE($value);
					}
				}
			}
			else
			{	
				//TRANS SINGLE	
				foreach ($array[$pointer] as $key => $value)
				{
					if ($enctype == $parseArray[0]) //ENCODE					
						$array[$pointer][$key] = '<span class="censor">'.JSP_CIPHER_ENCODE($value).'</span>';
					else
						$array[$pointer][$key] = JSP_CIPHER_DECODE($value);						
				}
			}
		}
		else
		{
			$ARRAY_KEYS = array_keys($array);			
			if ($pointer == '*')
			{
				foreach ($array as $key => $value)
				{
					if ($enctype == $parseArray[0]) //ENCODE
						$array[$key] = JSP_CIPHER_ENCODE($value);					
					else
						$array[$key] = JSP_CIPHER_DECODE($value);
				}
			}		
			else if (count(JSP_BUILD_CSV($pointer)) != 1)
			{
				foreach (JSP_BUILD_CSV($pointer) as $value)
				{
					$_pointer = $ARRAY_KEYS[$value];
					if ($enctype == $parseArray[0]) //ENCODE
						$array[$_pointer] = JSP_CIPHER_ENCODE($array[$_pointer]);	
					else
						$array[$_pointer] = JSP_CIPHER_DECODE($array[$_pointer]);	
				}
			}
			else
			{
				$_pointer = $ARRAY_KEYS[$pointer];
				if ($enctype == $parseArray[0]) //ENCODE
					$array[$_pointer] = JSP_CIPHER_ENCODE($array[$_pointer]);
				else
					$array[$_pointer] = JSP_CIPHER_DECODE($array[$_pointer]);					
			}
		}
		return $array;
	}
}

?>

