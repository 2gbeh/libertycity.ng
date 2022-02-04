<?php
function JSP_FETCH_TABLES ($database = _DB)
{
	$paramArray = array($database);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$query = mysqli_query(_DBCONN(),"SHOW TABLES FROM ".$database);
		while ($array = mysqli_fetch_array($query,MYSQLI_ASSOC))
		{
			$key = array_keys($array);
			$output[] = $array[$key[0]];
		}
		mysqli_close(_DBCONN());		
		return $output;
	}
}

function JSP_FETCH_TDESC ($table = JSP_TABLE_USER)
{
	$paramArray = array($table);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$strSQL = mysqli_query(_DBCONN(),"DESCRIBE ".$table);
		while ($desc = mysqli_fetch_array($strSQL,MYSQLI_ASSOC))
			$output[] = $desc['Field'].' '.JSP_BUILD_CASE($desc['Type']);
		mysqli_close(_DBCONN());
		return $output;
	}
}

function JSP_FETCH_FIELDS ($table = JSP_TABLE_USER)
{
	$paramArray = array($table);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$query = mysqli_query(_DBCONN(),"SHOW COLUMNS FROM ".$table);
		while ($field = mysqli_fetch_object($query))
			$output[] = $field -> Field;
		mysqli_close(_DBCONN());
		return $output;
	}
}

function JSP_FETCH_RECORDS ($table = JSP_TABLE_USER)
{
	$paramArray = array($table);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$result = mysqli_query(_DBCONN(),"SELECT * FROM ".$table);
		while ($row = mysqli_fetch_row($result))
			$output[] = $row;	
		mysqli_close(_DBCONN());
		return $output;
	}
}

function JSP_FETCH_APPFIELD ($table, $array)
{
	$paramArray = array($table,$array);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{	
		$fields = JSP_FETCH_FIELDS($table);
		$array = JSP_BUILD_CSV($array);
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array as $i => $assoc_array)
				foreach ($assoc_array as $key => $value)
					$output[$i][$fields[$key]] = $value;
		}
		else
		{
			foreach ($array as $key => $value)
				$output[$fields[$key]] = $value;		
		}
		return $output;
	}
}

function JSP_FETCH_PRIKEY ($table = JSP_TABLE_USER, $rtype = 'FILTER')
{
	$paramArray = array($table,$rtype);
	$parseArray = array ('KEY','VALUE','FILTER','KOGLOB','NOGLOB');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$rtype))
		return JSPIP;			
	else
	{
		$result = mysqli_query(_DBCONN(),"DESCRIBE ".$table);
		while ($meta = mysqli_fetch_assoc($result))
			$metaArray[] = $meta;
		mysqli_close(_DBCONN());			
		foreach ($metaArray as $key => $assoc_array)
		{
			if ($assoc_array['Key'] == 'PRI')
			{
				$hotKey = $key;
				$hotValue = $assoc_array['Field'];
			}
			else
				$nonPri[] = $assoc_array['Field'];
			if ($assoc_array['Field'] == 'date')
				$glob[] = $key;
			if ($assoc_array['Field'] == 'time')
				$glob[] = $key;			
		}
		if ($rtype == $parseArray[0]) //KEY
			return $hotKey;
		else if ($rtype == $parseArray[1]) //VALUE
			return $hotValue;
		else if ($rtype == $parseArray[2]) //FILTER
			return $nonPri;
		else if ($rtype == $parseArray[3]) //KOGLOB
			return JSP_PUSH_ARRAY($glob,$hotKey,'END');
		else //NOGLOB
			return JSP_SORT_EXCLUDE($nonPri,$glob,'KEY');
	}
}

function JSP_FETCH_NUMROWS ($table = JSP_TABLE_USER)
{
	$paramArray = array($table);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$result = mysqli_query(_DBCONN(),"SELECT * FROM ".$table);
		$numrows = mysqli_num_rows($result);
		mysqli_close(_DBCONN());
		return $numrows;
	}
}

function JSP_FETCH_TOTALS ($fetchArray)
{
	$paramArray = array($fetchArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$JSP_FETCH_WHERE = JSP_FETCH_WHERE($fetchArray,1);
		if (!JSP_ERROR_CATCH($JSP_FETCH_WHERE))
		{
			if (JSP_ATYPE($JSP_FETCH_WHERE) == 1)
				return 1;
			return count($JSP_FETCH_WHERE);
		}
		else
			return 0;
	}
}

function JSP_FETCH_SUM ($table, $field)
{
	$paramArray = array($table,$field);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$column = _BYCOL($table,$field);
		if (_THROW($column))
			return array_sum($column);
		else
			return '0';
	}
}

function JSP_FETCH_LIMIT ($table, $limit, $order = 'DESC')
{
	$paramArray = array($table,$limit,$order);	
	$parseArray = array('ASC','DESC');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$order) || !is_numeric($limit)) 
		return JSPIP;		
	else
	{
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');
		$strSQL = "SELECT * FROM ".$table." ORDER BY ".$prikey." ".$order." LIMIT ".$limit;
		$query = mysqli_query(_DBCONN(),$strSQL);
		while ($array = mysqli_fetch_array($query,MYSQLI_ASSOC))
		{
			$output[$array[$prikey]] = $array;
		}
		mysqli_close(_DBCONN());		
		return $output;
	}
}

function JSP_FETCH_FIRST ($table = JSP_TABLE_USER, $rtype = 'ROW')
{
	$paramArray = array($table,$rtype);	
	$parseArray = array ('ID','ROW');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$rtype))
		return JSPIP;		
	else
	{
		$fields = JSP_FETCH_FIELDS($table);		
		$prikey = JSP_FETCH_PRIKEY($table,'KEY');
		$records = JSP_FETCH_RECORDS($table);
		$firstRow = current($records);		
		if ($rtype == $parseArray[0]) //ID
			$output = $firstRow[$prikey];		
		else
		{
			foreach ($fields as $key => $fieldname)
				$output[$fieldname] = $firstRow[$key];
		}		
		return $output;
	}
}

function JSP_FETCH_LAST ($table = JSP_TABLE_USER, $rtype = 'ROW')
{
	$paramArray = array($table,$rtype);	
	$parseArray = array ('ID','ROW');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$rtype))
		return JSPIP;		
	else
	{
		$fields = JSP_FETCH_FIELDS($table);
		$prikey = JSP_FETCH_PRIKEY($table,'KEY');		
		$records = JSP_FETCH_RECORDS($table);
		$lastRow = end($records);		
		if ($rtype == $parseArray[0]) //ID
			$output = $lastRow[$prikey];						
		else
		{
			foreach ($fields as $key => $fieldname)
				$output[$fieldname] = $lastRow[$key];
		}		
		return $output;
	}
}

function JSP_FETCH_BYID ($table, $assoc_id)
{
	$paramArray = array($table,$assoc_id);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$fetchArray[0] = $table;
		$fetchArray[1] = JSP_FETCH_PRIKEY($table,'VALUE');					
		$assoc_id = JSP_BUILD_CSV($assoc_id);
		foreach ($assoc_id as $id)
		{
			$fetchArray[2] = $id;
			$newArray = JSP_FETCH_SWITCH($fetchArray,1);
			if (!JSP_ERROR_CATCH($newArray))
				$output[] = $newArray;
		}
		return JSP_CRUNCH_ARRAY($output);
	}
}

function JSP_FETCH_BYCOL ($table, $field)
{
	$paramArray = array($table,$field);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$field = JSP_CRUNCH_PRIKEY($table,$field);
		$predef = JSP_FETCH_PREDEF($table,$field,1);
		return _CRUNCH($predef);
	}
}

function JSP_FETCH_BYROW ($table, $rowNumber)
{
	$paramArray = array($table,$rowNumber);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$rowNumber--;
		$prikey = JSP_FETCH_PRIKEY($table,'KEY');
		$JSP_FETCH_RECORDS = JSP_FETCH_RECORDS($table);
		$recordArray = $JSP_FETCH_RECORDS[$rowNumber];
		$recordPrikey = $recordArray[$prikey];
		return JSP_FETCH_BYID($table,$recordPrikey);
	}
}

function JSP_FETCH_BYEMAIL ($table, $emailAddr)
{
	$paramArray = array($table,$emailAddr);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$fetchArray[0] = $table;
		$fetchArray[1] = 'email';
		$emailAddr = JSP_BUILD_CSV($emailAddr);
		foreach ($emailAddr as $each)
		{
			$fetchArray[2] = $each;
			$newArray = JSP_FETCH_SWITCH($fetchArray,1);
			if (!JSP_ERROR_CATCH($newArray))
				$output[] = $newArray;
		}
		return JSP_CRUNCH_ARRAY($output);
	}
}

function JSP_FETCH_BYDATE ($table, $dateLogic)
{
	$paramArray = array($table,$dateLogic);
	$parseArray = JSP_BUILD_CASE(JSP_ENUMS_PREDEF('MKDATE'));
	$parseArray[] = '*';
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$dateLogic)) 
		return JSPIP;					
	else
	{
		$mainArray = JSP_CRUNCH_ARRAY(JSP_FETCH_PREDEF($table,'*',0));
		$dateArray = JSP_CRUNCH_ARRAY(JSP_FETCH_PREDEF($table,'date',1));
		
		$crunchArray = JSP_CRUNCH_DATE(JSP_DATE_SHORT,'ARRAY');
		$mkyear = $crunchArray['year'];
		$mkmonth = $crunchArray['month'];
		$mkday = $crunchArray['day'];			
		
		if ($dateLogic == $parseArray[0]) //TODAY
		{
			foreach ($dateArray as $key => $dates)
			{
				$crunchArray = JSP_CRUNCH_DATE($dates,'STR');
				if ($crunchArray == JSP_DATE_SHORT)
					$hotkey[] = $key;
			}
		}
		else if ($dateLogic == $parseArray[1]) //YESTERDAY
		{
			if ($mkmonth == 1 && $mkday == 1) //Jan 1
			{
				$mkyear = $mkyear - 1;
				$mkmonth = 12;
				$mkday = 31;
			}
			else if ($mkmonth != 1 && $mkday == 1) //Feb 1
			{
				$mkmonth = $mkmonth - 1;
				$mkdate = $mkyear.'/'.$mkmonth.'/'.$mkday;				
				$mkday = JSP_CAL_MKTIME($mkdate,'DOM');
			}
			else
				$mkday = $mkday - 1;
			$mkdate = $mkyear.'/'.$mkmonth.'/'.$mkday;
			foreach ($dateArray as $key => $dates)
			{
				$crunchArray = JSP_CRUNCH_DATE($dates,'STR');
				$mkformat = $crunchArray;
				if ($mkformat == $mkdate)
					$hotkey[] = $key;
			}
		}
		else if ($dateLogic == $parseArray[2]) //THIS WEEK
		{
			$mkdate = JSP_CAL_MKWEEK('CURRENT','SHORT');
			foreach ($dateArray as $key => $dates)
			{
				$crunchArray = JSP_CRUNCH_DATE($dates,'STR');
				$mkformat = $crunchArray;
				if (in_array($mkformat,$mkdate))
					$hotkey[] = $key;
			}
		}		
		else if ($dateLogic == $parseArray[3]) //LAST WEEK
		{
			$mkdate = JSP_CAL_MKWEEK('PREVIOUS','SHORT');
			foreach ($dateArray as $key => $dates)
			{
				$crunchArray = JSP_CRUNCH_DATE($dates,'STR');
				$mkformat = $crunchArray;
				if (in_array($mkformat,$mkdate))
					$hotkey[] = $key;
			}
		}	
		else if ($dateLogic == $parseArray[4]) //THIS MONTH
		{
			$mkdate = JSP_CAL_MKMONTH('CURRENT','SHORT');
			foreach ($dateArray as $key => $dates)
			{
				$crunchArray = JSP_CRUNCH_DATE($dates,'STR');
				$mkformat = $crunchArray;
				if (in_array($mkformat,$mkdate))
					$hotkey[] = $key;
			}
		}
		else if ($dateLogic == $parseArray[5]) //LAST MONTH
		{
			$mkdate = JSP_CAL_MKMONTH('PREVIOUS','SHORT');
			foreach ($dateArray as $key => $dates)
			{
				$crunchArray = JSP_CRUNCH_DATE($dates,'STR');
				$mkformat = $crunchArray;
				if (in_array($mkformat,$mkdate))
					$hotkey[] = $key;
			}
		}	
		else if ($dateLogic == $parseArray[6]) //THIS YEAR
		{
			foreach ($dateArray as $key => $dates)
			{
				$crunchArray = JSP_CRUNCH_DATE($dates,'ARRAY');
				$mkformat = $crunchArray['year'];
				if ($mkformat == $mkyear)
					$hotkey[] = $key;
			}
		}											
		else if ($dateLogic == $parseArray[7]) //LAST YEAR		
		{
			foreach ($dateArray as $key => $dates)
			{
				$crunchArray = JSP_CRUNCH_DATE($dates,'ARRAY');
				$mkformat = $crunchArray['year'];
				if ($mkformat == ($mkyear - 1))
					$hotkey[] = $key;
			}
		}				
		else //Asterik[ALL]
			return $mainArray;
		
		if ($hotkey)
		{
			foreach ($mainArray as $index => $assoc_array)
			{		
				foreach ($assoc_array as $key => $value)
				{
					if (in_array($key,$hotkey))
						$newArray[$index][$key] = $value;
				}
			}
			return $newArray;
		}			
	}
}

function JSP_FETCH_RID ($table, $field, $record)
{ 
	$paramArray = array($table,$field,$record);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$JSP_FETCH_PRIKEY = JSP_FETCH_PRIKEY($table,'VALUE');		
		$JSP_FETCH_SWITCH = JSP_FETCH_SWITCH(array($table,$field,$record),1);
		if (!JSP_ERROR_CATCH($JSP_FETCH_SWITCH))
		{
			if (JSP_ATYPE($JSP_FETCH_SWITCH) == 2)
			{
				foreach ($JSP_FETCH_SWITCH as $index => $assoc_array)
				{
					foreach ($assoc_array as $key => $value)
					{
						if ($key == $JSP_FETCH_PRIKEY)
							$output = $value;
					}				
				}
			}
			else
			{
				foreach ($JSP_FETCH_SWITCH as $key => $value)
				{
					if ($key == $JSP_FETCH_PRIKEY)
						$output = $value;
				}
			}
			return $output;		
		}
	}
}

function JSP_FETCH_CELLOF ($table, $cell, $assoc_id)
{ 
	$paramArray = array($table,$cell,$assoc_id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$JSP_FETCH_BYID = JSP_FETCH_BYID($table,$assoc_id);
		if (!_CATCH($JSP_FETCH_BYID))
		{
			if (JSP_ATYPE($JSP_FETCH_BYID) == 2)
			{
				foreach ($JSP_FETCH_BYID as $assoc_array)
					$newArray[] = $assoc_array[$cell];
			}
			else
				$newArray = $JSP_FETCH_BYID[$cell];
			return $newArray;				
		}
	}
}

function JSP_FETCH_WHERE ($fetchArray, $logic = 1)
{
	$paramArray = array($fetchArray,JSP_TRUEPUT($logic));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fetchArray = JSP_BUILD_CSV($fetchArray);
		if 
		(
			count($fetchArray) != 3 ||			
			!is_numeric($logic) ||
			$logic > 1
		)
			return JSPIP;
		$table = $fetchArray[0];
		$field = JSP_CRUNCH_PRIKEY($table,$fetchArray[1]);
		$record = $fetchArray[2];		
		if ($logic == 1)
			$logic = $field." = '".$record."'";
		else
			$logic = $field." != '".$record."'";
		
		$strSQL = "SELECT * FROM ".$table." WHERE ".$logic;
		$result = mysqli_query(_DBCONN(),$strSQL);
		while ($row = mysqli_fetch_row($result))
			$output[] = $row;
		mysqli_close(_DBCONN());
		return _CRUNCH($output);					
	}
}

function JSP_FETCH_SWITCH ($fetchArray, $logic = 1)
{
	$paramArray = array($fetchArray,JSP_TRUEPUT($logic));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fetchArray = JSP_BUILD_CSV($fetchArray);
		if 
		(
			count($fetchArray) != 3 ||			
			!is_numeric($logic) ||
			$logic > 1
		)
			return JSPIP;
		$table = $fetchArray[0];
		$field = JSP_CRUNCH_PRIKEY($table,$fetchArray[1]);
		$keyword = $fetchArray[2];	
		$fieldArray = JSP_FETCH_FIELDS($table);
		$rowArray = JSP_FETCH_WHERE($fetchArray,$logic);
		if (JSP_ERROR_CATCH($rowArray))
			return $rowArray;
		else
		{
			if (JSP_ATYPE($rowArray) == 2)
			{
				foreach ($rowArray as $index => $assoc_array)
				{
					foreach ($fieldArray as $key => $fieldname)
						$output[$index][$fieldname] = $assoc_array[$key];
				}
			}
			else
			{
				foreach ($fieldArray as $key => $fieldname)
					$output[$fieldname] = $rowArray[$key];
			}
			return $output;			
		}
	}
}

function JSP_FETCH_PREDEF ($table, $fieldsArray = '*', $logic = 1)
{
	$paramArray = array($table,$fieldsArray,JSP_TRUEPUT($logic));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	if (!is_numeric($logic) || $logic > 1) 
		return JSPIF;		
	else
	{
		$fieldsArray = JSP_BUILD_CSV($fieldsArray);
		foreach ($fieldsArray as $fields)
			$crunchArray[]  = JSP_CRUNCH_PRIKEY($table,$fields);
		$fieldsArray = $crunchArray;		
		$allFields = JSP_FETCH_FIELDS($table);		
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');
		$counter = 0;		

		if ($logic == 0)
			$fieldsArray = JSP_SORT_EXCLUDE($allFields,$fieldsArray,'VALUE');
		else
		{
			if ($fieldsArray[0] == '*')
				$fieldsArray = $allFields;
		}

		foreach ($fieldsArray as $i => $fieldname)
		{
			$result = mysqli_query(_DBCONN(),"SELECT $fieldname,$prikey FROM $table");
			while ($row = mysqli_fetch_row($result))
				$output[$counter][$row[1]] = $row[0];			
			$counter += 1;			
		}
		mysqli_close(_DBCONN());
		return $output;
	}
}

function JSP_FETCH_IPREDEF ($table, $fieldsArray = '*', $logic = 1)
{
	$paramArray = array($table,$fieldsArray,JSP_TRUEPUT($logic));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	if (!is_numeric($logic) || $logic > 1) 
		return JSPIF;		
	else
	{
		$predefArray = JSP_FETCH_PREDEF($table,$fieldsArray,$logic);
		foreach ($predefArray as $index => $assoc_array)
			$ipredefArray[$index] = JSP_INVERT_ARRAY($assoc_array);	
		return $ipredefArray;
	}
}

function JSP_FETCH_PRELOG ($table, $fieldsArray, $fieldslogic, $whereArray)	
{
	$paramArray = array($table,$fieldsArray,JSP_TRUEPUT($fieldslogic),$whereArray);		
	$parseArray = array('=','==','!=','<>','<','>','<=','>=');			
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($fieldslogic) || $fieldslogic > 1)	
		return JSPIP;	
	else
	{
		//SORT WHERE
		$whereArray = JSP_BUILD_CSV($whereArray);
		$whereArray[0] = JSP_CRUNCH_PRIKEY($table,$whereArray[0]);
		if (JSP_PARAM_PARSE($parseArray,$whereArray[1]))
			return JSPIP;
		if ($whereArray[1] == '==')
			$whereArray[1] = '=';
		$whereClause = $whereArray[0]." ".$whereArray[1]." '".$whereArray[2]."'";
		
		//SET FIELDS
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');		
		$fieldArray = _CSV(JSP_CRUNCH_FLOGIC($table,$fieldsArray,$fieldslogic));
		$counter = 0;
		foreach ($fieldArray as $i => $fieldname)
		{
			$strSQL = "SELECT $fieldname,$prikey FROM $table WHERE $whereClause";
			$result = mysqli_query(_DBCONN(),$strSQL);
			while ($row = mysqli_fetch_row($result))
				$output[$counter][$row[1]] = $row[0];
			$counter++;
		}
		mysqli_close(_DBCONN());
		return $output;
	}
}

function JSP_FETCH_AND ($table, $fieldsArray, $recordsArray, $logic)
{
	$paramArray = array($table,$fieldsArray,$recordsArray,JSP_TRUEPUT($logic));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($logic) || $logic > 1)	
		return JSPIP;						
	else
	{
		$predef = JSP_FETCH_PREDEF($table,$fieldsArray,1);
		$uArray = JSP_CONCAT_ARRAY($predef,'Y',count($predef));
		$csv = JSP_BUILD_CSV($recordsArray);		
		$eArray = JSP_CONCAT_ARRAY($csv,'X',count($csv));
		foreach ($uArray as $key => $value)
		{
			if ($value == $eArray)
				$found[] = $key;
			else
				$notFound[] = $key;
		}
		if ($logic == 1) 
			$idArray = $found;
		else 
			$idArray = $notFound;
		foreach ($idArray as $id)
		{
			$newArray[] = JSP_FETCH_BYID($table,$id);
		}
		return _THROW(JSP_CRUNCH_ARRAY($newArray));
	}
}

function JSP_FETCH_OR ($table, $field, $recordsArray, $logic)
{
	$paramArray = array($table,$field,$recordsArray,JSP_TRUEPUT($logic));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($logic) || $logic > 1)	
		return JSPIP;						
	else
	{
		$recordsArray = JSP_BUILD_CSV($recordsArray);
		$fieldArray = JSP_CRUNCH_ARRAY(JSP_FETCH_PREDEF($table,$field,1));
		foreach ($recordsArray as $record)
		{
			$idArray[] = array_search($record,$fieldArray);
		}
		if ($logic == 0) 
		{
			$hotkeys = JSP_SORT_EXCLUDE($fieldArray,$idArray,'KEY');
			$idArray = array_keys($hotkeys);
		}
		foreach ($idArray as $id)
		{
			$newArray[] = JSP_FETCH_BYID($table,$id);
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_FETCH_ANDOR ($table, $fieldsArray, $recordsArray, $logic)
{
	$paramArray = array($table,$fieldsArray,$recordsArray,JSP_TRUEPUT($logic));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($logic) || $logic > 1)	
		return JSPIP;						
	else
	{
		//FIELD ARRAY
		$fieldsArray = JSP_BUILD_CSV($fieldsArray);
		$andField  = $fieldsArray[0];
		$orField  = $fieldsArray[1];		
		//RECORD ARRAY
		$recordsArray = JSP_BUILD_CSV($recordsArray);
		$andRecord  = $recordsArray[0];		
		foreach ($recordsArray as $key => $value)
		{
			if ($key != 0)
				$orRecord[] = $value;
		}
		//UNIV ARRAY
		$univArray = JSP_FETCH_PREDEF($table,$fieldsArray,1);						
		$andArray = $univArray[0];
		$orArray = $univArray[1];
		//AND KEYS
		foreach ($andArray as $key => $value)
		{
			if ($value == $andRecord)
				$andKeys[] = $key;
			else
				$notAndKeys[] = $key;
		}
		if ($logic == 1)
			$andIdArray = $andKeys;
		else
			$andIdArray = $notAndKeys;
		//OR KEYS
		foreach ($orArray as $key => $value)
		{
			if (in_array($value,$orRecord))
			$orIdArray[] = $key;
		}
		//COMPARE IDS AND FETCH RECORDS
		$matchArray = JSP_SORT_MATCH($andIdArray,$orIdArray,'VALUE');
		foreach ($matchArray as $id)
		{
			$newArray[] = JSP_FETCH_BYID($table,$id);
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_FETCH_ANDNOT ($table, $fieldsArray, $recordsArray, $logic)
{
	$paramArray = array($table,$fieldsArray,$recordsArray,JSP_TRUEPUT($logic));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($logic) || $logic > 1)	
		return JSPIP;						
	else
	{
		//FIELD ARRAY
		$fieldsArray = JSP_BUILD_CSV($fieldsArray);
		$andField  = $fieldsArray[0];
		$orField  = $fieldsArray[1];		
		//RECORD ARRAY
		$recordsArray = JSP_BUILD_CSV($recordsArray);
		$andRecord  = $recordsArray[0];		
		foreach ($recordsArray as $key => $value)
		{
			if ($key != 0)
				$orRecord[] = $value;
		}
		//UNIV ARRAY
		$univArray = JSP_FETCH_PREDEF($table,$fieldsArray,1);						
		$andArray = $univArray[0];
		$orArray = $univArray[1];
		//AND KEYS
		foreach ($andArray as $key => $value)
		{
			if ($value == $andRecord)
				$andKeys[] = $key;
			else
				$notAndKeys[] = $key;
		}
		if ($logic == 1)
			$andIdArray = $andKeys;
		else
			$andIdArray = $notAndKeys;
		//OR KEYS
		foreach ($orArray as $key => $value)
		{
			if (in_array($value,$orRecord))
			$orIdArray[] = $key;
		}
		//COMPARE IDS AND FETCH RECORDS
		$matchArray = JSP_SORT_MATCH($andIdArray,$orIdArray,'VALUE');
		foreach ($matchArray as $id)
		{
			$newArray[] = JSP_FETCH_BYID($table,$id);
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_FETCH_PAGI ($table, $fieldsArray, $fieldsLogic, $range)
{
	$paramArray = array($table,$fieldsArray,JSP_TRUEPUT($fieldsLogic),$range);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($fieldsLogic) || $fieldsLogic > 1)
		return JSPIP;		
	else
	{
		$fieldsArray = JSP_BUILD_CSV($fieldsArray);		
		$range = JSP_BUILD_CSV($range);
		if (count($range) != 2 || JSP_CTYPE($range) != 1)
			return JSPIP;
		if ($range[0] > $range[1])				
			return JSPIL;
		$range[0] -= 1;
		$range[1] -= 1;					
		$predef = JSP_FETCH_PREDEF($table,$fieldsArray,$fieldsLogic);
		if (JSP_ATYPE($predef) == 2)
		{
			$arrayKeys = array_keys($predef[0]);
			foreach ($predef as $index => $assoc_array)
			{
				foreach ($arrayKeys as $i => $key)
				{
					if ($i >= $range[0] && $i <= $range[1])
						$newArray[$index][$key] = $assoc_array[$key];
				}
			}
		}
		else
		{
			$arrayKeys = array_keys($predef);
			foreach ($arrayKeys as $i => $key)
			{
				if ($i >= $range[0] && $i <= $range[1])
					$newArray[$key] = $predef[$key];
			}
		}
		return $newArray;
	}
}

function JSP_FETCH_ALL ($database = _DB)
{
	$paramArray = array($database);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$tables = JSP_FETCH_TABLES($database);
		foreach ($tables as $key => $tbname)
		{
			$fields = JSP_FETCH_FIELDS($tbname);			
			$fieldArray[$tbname] = $fields;
			$fieldCount[$tbname] = count($fieldArray[$tbname]);
			$records = JSP_FETCH_RECORDS($tbname);
			$records = JSP_FETCH_APPFIELD($tbname,$records);
			if (JSP_ERROR_CATCH($records))
				$records = null;
			$recordArray[$tbname] = $records;
			$recordCount[$tbname] = count($recordArray[$tbname]);			
		}
		$statArray = array 
		(
			'DATABASE' => count($database),
			'TABLE' => count($tables),
			'FIELD' => $fieldCount,
			'T_FIELD' => array_sum($fieldCount),
			'RECORD' => $recordCount,	
			'T_RECORD' => array_sum($recordCount)
		);
		$fetchArray = array
		(
			'DATABASE' => $database,
			'TABLE' => $tables,
			'PRIKEY' => JSP_FETCH_PRIKEY($tbname,'VALUE'),
			'FIELD' => $fieldArray,
			'RECORD' => $recordArray,
			'STAT' => $statArray,
			'MKDATE' => JSP_DATE_LONG,
			'MKTIME' => JSP_TIME_LONG			
		);	
		return $fetchArray;
	}
}
?>






