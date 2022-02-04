<?php
function JSP_SPAM_ISEMAIL ($string)
{
	$string = filter_var($string,FILTER_SANITIZE_EMAIL);
	if (!filter_var($string,FILTER_VALIDATE_EMAIL) === false)
		return 1;
}

function JSP_SPAM_ISNUMBER ($string)
{
	$JSP_BUILD_STR = JSP_BUILD_STR($string);
	if ($JSP_BUILD_STR[0] == '0' && $JSP_BUILD_STR[1] > 6 && strlen($string) == 11)
		return 1;
}

function JSP_SPAM_MAILTO ($email, $subject)
{
	$paramArray = array($email,JSP_TRUEPUT($subject));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if ($subject)
		{
			$subject = str_replace(' ','%20',$subject);	
			return 'href="mailto:'.$email.'?Subject='.$subject.'" target="_new"';
		}
		else
			return 'href="mailto:'.$email.'" target="_new"';
	}
}

function JSP_SPAM_FILTER ($emailArray)
{
	$paramArray = array($emailArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$emailArray = JSP_BUILD_CSV($emailArray);
		foreach ($emailArray as $value)
		{
			//VALIDATE
			if (JSP_SPAM_ISEMAIL($value))
			{
				//LOWERCASE NO-REPEAT
				if (!in_array($value,$newArray))
					$newArray[] = strtolower($value);
			}
		}
		if ($newArray)
			return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_SPAM_DOMAIN ($email)
{
	$paramArray = array($email);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$at_domain = JSP_BUTCHER_STR($email,'@','LEFT');
		$dot_com = JSP_BUTCHER_STR($at_domain,'.','RIGHT');
		return $dot_com;
	}
}

function JSP_SPAM_GET ($returnType = 'EMAIL')
{
	$paramArray = array($returnType);
	$parseArray = array('EMAIL','NUMBER');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType)) 
		return JSPIP;
	else
	{	
		$JSP_FETCH_TABLES = JSP_FETCH_TABLES();
		foreach ($JSP_FETCH_TABLES as $table)
		{
			$JSP_FETCH_RECORDS = JSP_FETCH_RECORDS($table);
			foreach ($JSP_FETCH_RECORDS as $row)
			{
				foreach ($row as $cell)
				{
					if (JSP_SPAM_ISEMAIL($cell) && !in_array($cell,$emailArray))
						$emailArray[] = $cell;
					if (JSP_SPAM_ISNUMBER($cell) && !in_array($cell,$numberArray))
						$numberArray[] = $cell;					
				}	
			}
		}
		if ($returnType == $parseArray[0]) //EMAIL
			return $emailArray;
		else
			return $numberArray;		
	}
}

function JSP_SPAM_SET ($from, $to, $subject, $message)
{
	$paramArray = array($from,$to,$subject,$message);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		//CHECK SCRNAME
		$from = JSP_BUILD_CSV($from);
		if (count($from) == 2)
			$from = $from[0].' <'.$from[1].'>';
		else
			$from = $from[0];
		$headers = 'From: '.$from;
		if (!mail($to,$subject,$message,$headers))
			return array($to,$subject,$message,$headers);
	}
}

function JSP_SPAM_PREP ($source, $returnType = 'STAT')
{
	$paramArray = array($source, $returnType);
	$parseArray = array('ARRAY','CSV','COUNT','BATCH','STAT');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType)) 
		return JSPIP;
	else
	{
		//ARRANGE
		$sourceArray = JSP_BUILD_CSV($source);
		$newArray = JSP_SPAM_FILTER($sourceArray);
		
		//RETURN TYPE
		if ($returnType == $parseArray[0]) //ARRAY
			$output = $newArray;
		else if ($returnType == $parseArray[1]) //CSV
			$output = JSP_DROP_ARRAY($newArray,', ');
		else if ($returnType == $parseArray[2]) //COUNT
			$output = count($newArray);					
		else if ($returnType == $parseArray[3]) //BATCH
		{
			foreach ($newArray as $email)
			{
				$domain = JSP_SPAM_DOMAIN($email);
				$output[$domain][] = $email;
			}
		}	
		else //STAT
		{
			foreach ($newArray as $email)
			{
				$domain = JSP_SPAM_DOMAIN($email);
				$batch[$domain][] = $email;				
			}			
			foreach ($batch as $index => $assoc_array) 
			{ 
				$total = count($assoc_array);
				$perc = JSP_PERCOF(count($newArray),$total,'PERC');
				$insight[$index] = array('TOTAL' => $total, 'PERC' => $perc);
			}			
			$output = array
			(
				'SIZEOF' => count($newArray),
				'BATCH' => count($batch),		
				'DOMAIN' => array_keys($batch),
				'INSIGHT' => $insight
			);
		}
		return $output;	
	}
}

?>




