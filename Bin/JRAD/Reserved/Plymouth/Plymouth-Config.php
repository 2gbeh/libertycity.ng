<?php
function PLY_CONFIG_PLAN ($returnType)
{
	$TABLE = PLY_TABLE_PLAN;
	$JSP_FETCH_PREDEF = JSP_FETCH_PREDEF($TABLE,'*',1);	

	if ($returnType == 'COL')
		return $JSP_FETCH_PREDEF;	
	if ($returnType == 'ROW')
	{
		$recordArray = JSP_FETCH_RECORDS($TABLE);
		return JSP_FETCH_APPFIELD($TABLE,$recordArray);
	}
	if ($returnType == 'ENUMS')
	{
					
		$newArray = JSP_PUSH_ARRAY($JSP_FETCH_PREDEF[0],'N/A','CURRENT');
		foreach ($newArray as $key => $value)
		{
			$key = (array_search($value,$JSP_FETCH_PREDEF[0]));
			$enumArray[$key] = $value;
		}
		return JSP_TITLE_CASE($enumArray);
	}
	if (is_numeric($returnType))
	{		
		return _THROW(_BYID($TABLE,$returnType));
	}	

}

function PLY_CONFIG_STATUS ($returnType)
{
	$PLY_CONFIG_STATUS = array
	(
		'Default',
		'Matched to PH',
		'PH Confirmed',
		'First GH Matched',
		'First GH Confirmed',
		'Second GH Matched',
		'Second GH Confirmed',
		'Third GH Matched',
		'Third GH Confirmed',
		'Suspended'
	);	
	if ($returnType == 'ENUMS')
		return $PLY_CONFIG_STATUS;
	if (is_numeric($returnType))
		return $PLY_CONFIG_STATUS[$returnType];
}

function PLY_CONFIG_MATCH ($USER, $returnType)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$userArray = JSP_SSQL_LAST($TABLE,'user_rid',$USER);	
	$matchArray = JSP_SSQL_LAST($TABLE,'user_rid',$userArray['matched']);
	if ($returnType == 'USER')
		return $userArray;
	if ($returnType == 'MATCH')
		return $matchArray;
	if ($returnType == 'STAT')
	{
		if (PLY_MATCH_TYPE == '300')
			$STATUS = 8;
		else
			$STATUS = 6;
		$_SWITCH = _SWITCH($TABLE,'user_rid',$USER);
		if (_THROW($_SWITCH))
		{
			$_SWITCH = _DIMARRAY($_SWITCH);		
			$statArray['TOTAL'] = count($_SWITCH); //TOTAL MATCH
			$JSP_FETCH_AND = JSP_FETCH_AND($TABLE,'user_rid,status',array($USER,$STATUS),1);
			if (_THROW($JSP_FETCH_AND))
				$JSP_FETCH_AND = _DIMARRAY($JSP_FETCH_AND);
			$statArray['RECYCLE'] = count($JSP_FETCH_AND); //COMPLETED
			foreach ($_SWITCH as $assoc_array)
			{
				$PLY_CONFIG_PLAN = PLY_CONFIG_PLAN($assoc_array['plan_id']);
				$statArray['DEBIT'] += $PLY_CONFIG_PLAN['amount']; //DEBIT
				//CREDIT
				if ($assoc_array['status'] == 8) 
					$statArray['CREDIT'] += $PLY_CONFIG_PLAN['amount'] * 3;
				if ($assoc_array['status'] == 6) 
					$statArray['CREDIT'] += $PLY_CONFIG_PLAN['amount'] * 2;				
				if ($assoc_array['status'] == 4) 
					$statArray['CREDIT'] += $PLY_CONFIG_PLAN['amount'] * 1;
			}
			return $statArray;
		}
	}
}

function PLY_CONFIG_REF ($USER, $returnType)
{
	//RESOURCE
	$TABLE = PLY_TABLE_REF;	
	if ($returnType == 'TOTAL')
		return JSP_FETCH_TOTALS(array($TABLE,'ref_by',$USER));
	if ($returnType == 'WALLET')
	{
		$_SWITCH = _SWITCH($TABLE,'ref_by',$USER);
		if (_THROW($_SWITCH))
		{
			foreach (_DIMARRAY($_SWITCH) as $assoc_array)
			{
				$PLY_CONFIG_PLAN = PLY_CONFIG_PLAN($assoc_array['plan_id']);
				$JSP_PERCOF += JSP_PERCOF($PLY_CONFIG_PLAN['amount'],10,'FRAC');
			}
			return $JSP_PERCOF;
		}
	}
}

function PLY_CONFIG_TELLER ()
{
	if (JSP_FILE_ISIMAGE(PLY_MATCH_TELLER))
	{
		$base = _SWISS(JSP_FILE_UPROOT(PLY_BASE_TELLER),PLY_BASE_TELLER,'LOCALHOST');
		$basename = $base.PLY_MATCH_TELLER;
		$output = JSP_DISPLAY_GALLERY($basename).
		'Available <a class="under" onClick=BLN_PREVIEW_OPEN("'.$basename.'")>Click to view</a>';
	}
	else
		$output = 'Unavailable';
	return $output;
}


?>