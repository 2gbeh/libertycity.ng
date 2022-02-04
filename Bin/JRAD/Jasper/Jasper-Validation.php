<?php
function JSP_TYPECHECK_POST ($input)
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;		
}

function JSP_FILTER_IP ($input)
{
	if (!filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false)
		return 1;
	else if (!filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false)
		return 1;
}

function JSP_FILTER_POST ($postArray)
{
	$paramArray = array($postArray);	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		foreach ($postArray as $key => $value)
		{
			if 
			(
				$key != 'hidden' && 
				$key != 'id' && 
				$key != 'terms' && 
				$key != 'checkbox' 
			)
			{
				if ($key == 'email')
					$value = strtolower($value);
				if (JSP_SORT_GATE($key,JSP_DTYPE_DATE(),'OR'))
					$value = str_replace('-','/',$value);
				$nowsp = JSP_CRUNCH_WHITESPACE($value);
				if (_THROW($nowsp))
					$newArray[$key] = JSP_TYPECHECK_POST($nowsp);
				else
					$newArray[$key] = JSP_TYPECHECK_POST($value);
			}
		}
		foreach ($newArray as $index => $assoc_array)
			$output[$index] = JSP_DROP_ARRAY($assoc_array,',');
		return $newArray;
	}
}

function JSP_FILTER_FILE ($postArray, $position = 'CURRENT', $file = 'IMAGE')
{
	$paramArray = array($postArray,$position,$file);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		$filterArray = JSP_FILTER_POST($postArray);		
		$file = strtolower($file);
		$last = end($_FILES[$file]['name']);
		if (JSP_FILE_ISFILE($last) == 1)
		{
			$filename = JSP_NAME_SPACE($last);
			$filterKey = array_keys($filterArray);
			$shiftKey = JSP_SHIFT_ARRAY($filterKey,$file,$position);
			$shiftArray = JSP_SHIFT_ARRAY($filterArray,$filename,$position);		
		
			foreach ($shiftKey as $key => $value)
				$newArray[$value] = $shiftArray[$key];
		}
		else
			$newArray = $filterArray;
			
		if (_THROW($newArray))
			return $newArray;
		else
			return JSPIP;
	}
}

function JSP_FILTER_PRICE ($postArray, $position)
{
	$paramArray = array($postArray,$position);
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else
	{
		if (is_numeric($position))
		{
			$position--;
			$array_keys = array_keys($postArray);
			$real_key = $array_keys[$position];
			$entry = $postArray[$real_key];
			$postArray[$real_key] = JSP_CRUNCH_PRICE($entry);
			return $postArray;
		}
		else if ($position == '*')
		{
			foreach ($postArray as $key => $value)
				$newArray[$key] = JSP_CRUNCH_PRICE($value);
			return $newArray;
		}
		else
			return $postArray;
	}
}

function JSP_SANITIZE_POST ($throwArray, $postArray)
{
	$paramArray = array($throwArray,$postArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$throwArray = _CSV($throwArray);
		$key = 0;		
		foreach ($postArray as $name => $value)
		{			
			//BAD EMAIL
			if ($name == 'email' && !JSP_SPAM_ISEMAIL($value))
				$catch .= $throwArray[$key].' field is invalid.<br/>';
				
			if //NOT NUMERIC 
			(
				JSP_SORT_GATE($field,JSP_DTYPE_INT(),'OR') && 
				!is_numeric($value)
			) 
				$catch .= $throwArray[$key].' field is invalid.<br/>';
			
			//INCOMPLETE
			if 
			(
				(
					$name == 'phone' && 
					strlen($value) < 11
				) || 
				(
					$name == 'acct_number' && 
					strlen($value) < 10
				) ||
				(
					JSP_SORT_GATE($name,'name,acct_name','OR') && 
					strlen($value) < 7
				)				
				
			)
				$catch .= $throwArray[$key].' field is incomplete.<br/>';
			$key++;
		} #foreach
		return $catch;
	} #else
}

function JSP_SANITIZE_TEXTAREA ($name)
{
	$paramArray = array($name);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		if ($_POST[$name] == 'Enter '.$name.' here..')
			return ucwords($name).' field is empty.';		
	}
}

function JSP_VALIDATE_POST ($table, $fieldArray, $throwArray, $postArray)
{
	$paramArray = array($table,$fieldArray,$throwArray,$postArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{	
		$fieldArray = JSP_BUILD_CSV($fieldArray);
		$throwArray = JSP_BUILD_CSV($throwArray);
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE'); //GET PRIKEY
		$switch = _BYID($table,$_POST[$prikey]); //GET POST['id']
		
		foreach ($fieldArray as $key => $field)
		{					
			//BAD EMAIL
			if ($field == 'email' && !JSP_SPAM_ISEMAIL($postArray[$field]))
				$catch .= 'Invalid '.$throwArray[$key].' format.<br/>';				
				
			if //NOT NUMERIC 
			(
				JSP_SORT_GATE($field,JSP_DTYPE_INT(),'OR') && 
				!is_numeric($postArray[$field])
			) 
				$catch .= 'Invalid '.$throwArray[$key].' format.<br/>';
			
			//INCOMPLETE
			if 
			(
				(
					$field == 'phone' && 
					strlen($postArray[$field]) < 11
				) || 
				(
					$field == 'acct_number' && 
					strlen($postArray[$field]) < 10
				)
			)
				$catch .= 'Incomplete '.$throwArray[$key].'.<br/>';
			
			//TUPLES
			if 
			(
				JSP_SORT_GATE($field,'name,acct_name','OR') && 
				JSP_SSQL_TUPLES($table,$field,$postArray[$field])
			)
			{
				if (strtolower($switch[$field]) != strtolower($postArray[$field]))
					$catch .= $throwArray[$key].' already exist.<br/>';
			}
			else
			{			
				//FIELD ALREADY EXIST
				if (_EXIST($table,$field,$postArray[$field]))
				{
					//SAFE CHECK FOR UPDATES
					if (strtolower($switch[$field]) != strtolower($postArray[$field]))
						$catch .= $throwArray[$key].' already exist.<br/>';
				}
			}
		}
		return $catch;
	}
}

function JSP_DUPLICATE_POST ($table, $fieldArray, $postArray)
{
	$paramArray = array($table,$fieldArray,$postArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');	
		foreach (_CSV($fieldArray) as $value)
		{
			$entryArray[] = $postArray[$value];
		}
		$entryArray = JSP_DROP_CASE($entryArray);		
		$entryConcat = JSP_CONCAT_ARRAY($entryArray,'X',count($entryArray));				
		$recordArray = JSP_DROP_CASE(JSP_FETCH_PREDEF($table,$fieldArray,1));
		$recordConcat = JSP_CONCAT_ARRAY($recordArray,'Y',count($recordArray));
		
		foreach ($recordConcat as $id => $value)
		{
			if ($value == $entryConcat && $id != $_POST[$prikey])
				return 'This record already exist in database.<br/>';			
		}
	}
}

?>

