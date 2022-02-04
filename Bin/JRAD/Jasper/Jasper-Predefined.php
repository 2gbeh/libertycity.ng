<?php
function JSP_CTYPE ($string)
{
	$paramArray = array(JSP_TRUEPUT($string));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{	
		if (strlen($string) == 1) 
		{
			if (is_numeric($string))
				return 1; //numeric
			else if (ctype_alpha($string))
				return 2; //alphabetic
			else if ($string == ' ')
				return 5; //whitespace
			else
				return 4; //sxter
		}
		else 
		{
			if (strlen($string))
				$array = JSP_BUILD_STR($string); //string parsed
			else
			{
				$string = JSP_DROP_ARRAY($string,''); //array parsed
				$array = JSP_BUILD_STR($string);
			}
			$sizeof = count($array);
			$num = $alpha = $wsp = $sxter = 0;
			foreach ($array as $value)
			{
				if (is_numeric($value))
					$num++;
				if (ctype_alpha($value))
					$alpha++;
				if ($value == ' ')
					$wsp++;
				if 
				(
					!is_numeric($value) && 
					!ctype_alpha($value) &&
					$value != ' '
				)
					$sxter++;					
			}
			if ($num == $sizeof)
				return 1;
			else if ($alpha == $sizeof)
				return 2;
			else if ($wsp == $sizeof)
				return 5;		
			else if ($sxter == $sizeof)
				return 4;								
			else
				return 3; //alpha-numeric
		}
	}
}

function JSP_ATYPE ($array)
{
	$paramArray = array($array);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		foreach ($array as $key => $value)
		{
			if (strlen($value) || $value == '')
				return 1;
			else
				return 2;
		}
	}
}

function JSP_PERCOF ($total, $fraction, $returnType = 'PERC')
{		
	$paramArray = array($total,JSP_TRUEPUT($fraction),$returnType);
	$parseArray = array('PERC','FRAC');	
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$returnType))
		return JSPIP;
	else
	{
		if ($returnType == $parseArray[0]) //PERC
		{
			$perc = ($fraction * 100) / $total;
			$output = round($perc).'%';
		}
		else //FRAC
		{
			$frac = ($total * $fraction) / 100;
			$output = round($frac);
		}
		return $output;
	}
}

function JSP_ASCII ($param)
{
	$paramArray = array($param);
	$parseArray = array('UP','DOWN','NAIRA');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_FORMAT($parseArray,$param)) 
		return JSPIP;		
	else
	{		
		if ($param == $parseArray[0]) //UP
			$output = '<span id="up">&#8250;</span>';		
		if ($param == $parseArray[1]) //DOWN
			$output = '<span id="down">&#8250;</span>';
		if ($param == $parseArray[2]) //NAIRA
			$output = '&#8358;';
		return '<div class="JSP_ASCII">'.$output.'</div>';
	}
}

function JSP_MAILER ($mailArray)
{
	$paramArray = array($mailArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		$from = $mailArray[0];
		$to = $mailArray[1];
		$subject = $mailArray[2];
		$message = $mailArray[3];
		$scrname = $mailArray[4];
		if ($scrname)
			$headers = 'From: $scrname <$from>'.'\r\n';
		else 
			$headers = 'From: $from'.'\r\n';

		$headers .= 'Reply-To: $from'.'\r\n';
		$headers .= "X-Mailer: PHP/".phpversion();		
		mail($to,$subject,$message,$headers);
		return 1;
	}
}

function JSP_SMSER ($smsArray)
{
	$paramArray = array($smsArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (count($smsArray) != 4)
		return JSPIP;		
	else 
	{
		$smsArray[2] = JSP_DROP_CASE($smsArray[2]);
		//convert carrier name to carrier domain
		if ($smsArray[2] == "airtel")
			$smsArray[2] = "@sms.airtelap.com"; 
		else if ($smsArray[2] == "etisalat")
			$smsArray[2] = "@sms.etisalat.com"; 
		else if ($smsArray[2] == "glo")
			$smsArray[2] = "@sms.gloworld.com"; 
		else if ($smsArray[2] == "mtn")
			$smsArray[2] = "@sms.co.za";
		else
			return JSPIL; //invalid carrier name
		//check for mulitple recipient
		if (count($smsArray[1]) > 1)
		{
			//append carrier domain to number
			foreach ($smsArray[1] as $key => $number)
				$newArray[] = $number.$smsArray[2];
			$smsArray[1] = $newArray;
			//build csv for mulitple recipient
			$smsClause = JSP_CONSTRUCT($smsArray[1],'CSV');
			$smsArray[1] = $smsClause;
		}
		else
			$smsArray[1] .= $smsArray[2];
		//set mail function param
		$from = $smsArray[0];
		$to = $smsArray[1];
		$subject = '';
		$message = $smsArray[3];	
		$headers = "From: $from\r\n";
		//check no-reply
		if (JSP_CTYPE($from) == 1)				
			$headers .= "Reply-To: $from\r\n";
		$headers .= "X-Mailer: PHP/".phpversion();
//		mail($to,$subject,$message,$headers);
//		return 1;		
		return array ($to,$subject,wordwrap($message,70),$headers);		
	}
}
?>
