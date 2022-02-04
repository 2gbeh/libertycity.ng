<?php
function JSP_CRUD_PREP ($array, $type)
{
	$paramArray = array($array,$type);
	$parseArray = array ('COL','ROW','SET','WHERE');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;			
	else
	{
		if ($type == $parseArray[0] || $type == $parseArray[1])
		{
			$count = count($array);
			for ($i = 0; $i < $count; $i++)
			{			
				$appendCol .= $array[$i].', ';
				$appendRow .= "'"._ESCAPE($array[$i])."', ";
			}
			if ($type == $parseArray[0]) //COL
				return substr($appendCol,0,-2);	
			else
				return substr($appendRow,0,-2);			
		}
		else if ($type == $parseArray[2]) //SET
		{
			$fieldArray = $array[0];
			if (count($fieldArray) > 1)
			{
				$recordsArray = JSP_BUILD_CSV($array[1]);
				$array_keys = array_keys($recordsArray);
				foreach ($fieldArray as $key => $field)
				{
					$record = $recordsArray[$array_keys[$key]];
					if ($record === null)
					{
						if ($field == 'page')
							$record = _PAGE;						
						else if ($field == 'ipaddress' || $field == 'ip_address' || $field == 'ipaddr' || $field == 'ip_addr' || $field == 'ip')
							$record = _IP;						
						else if ($field == 'control' || $field == 'status')
							$record = _NULL;
						else if ($field == 'date')
							$record = _DATE;
						else if ($field == 'time')
							$record = _TIME;
						else					
							$record = '';
					}
					$append .= $field." = \"".$record."\", ";
				}
			}
			else
				$append = $array[0][0]." = \"".$array[1]."\", ";
			return substr($append,0,-2);
		}
		else //WHERE
		{
			if (strlen($array[1]))
			{
				if ($array[2] == 1)
					return $array[0]." = '".$array[1]."'";
				else
					return $array[0]." != '".$array[1]."'";
			}
			else
			{
				foreach ($array[1] as $array[1])
				{
					if ($array[2] == 1)
						$append .= $array[0]." = '".$array[1]."' AND ";
					else
						$append .= $array[0]." != '".$array[1]."' AND ";
				}
				return substr($append,0,-5);
			}
		}
	}
}

function JSP_CRUD_CREATE ($table, $entryArray)
{
	$paramArray = array($table,$entryArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{		
		$entryArray = JSP_REKEY_ARRAY(_CSV($entryArray));
		$fieldArray = JSP_FETCH_PRIKEY($table,'FILTER');
		foreach ($fieldArray as $key => $value)
		{
			if (!isset($entryArray[$key]))
			{
				if ($value == 'page')
					$entryArray[$key] = _PAGE;						
				else if ($value == 'ipaddress' || $value == 'ip_address' || $value == 'ipaddr' || $value == 'ip_addr' || $value == 'ip')
					$entryArray[$key] = _IP;
				else if ($value == 'control' || $value == 'status')
					$entryArray[$key] = _NULL;
				else if ($value == 'date')
					$entryArray[$key] = _DATE;
				else if ($value == 'time')
					$entryArray[$key] = _TIME;
				else					
					$entryArray[$key] = '';
			}
		}
		$col = JSP_CRUD_PREP($fieldArray,'COL');
		$row = JSP_CRUD_PREP($entryArray,'ROW');	
		$strSQL = "INSERT INTO $table (".$col.") VALUES (".$row.")";
		if (mysqli_query(_DBCONN(),$strSQL))
		{
			mysqli_close(_DBCONN());
			return 1;
		}
	}
}

function JSP_CRUD_RETRIEVE ($table, $field, $record)
{
	$paramArray = array($table,$field,JSP_TRUEPUT($record));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fieldArray = JSP_FETCH_FIELDS($table);
		$field = JSP_CRUNCH_PRIKEY($table,$field);
		$crudArray = array($table,$field,JSP_REKEY_ARRAY($record));
		$row = JSP_FETCH_WHERE($crudArray,1);
		foreach ($fieldArray as $key => $value)
			$newArray[$value] = $row[$key];
		return $newArray;				
	}
}

function JSP_CRUD_UPDATE ($table, $fieldArray, $recordArray, $whereArray)
{
	$paramArray = array($table,$fieldArray,JSP_TRUEPUT($recordArray),$whereArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if ($fieldArray == '*')
			$fieldArray = JSP_FETCH_PRIKEY($table,'FILTER');
		else
			$fieldArray = JSP_REKEY_ARRAY(_CSV($fieldArray));

		$whereArray = JSP_BUILD_CSV($whereArray);		
		$whereArray[0] = JSP_CRUNCH_PRIKEY($table,$whereArray[0]);
		$setClause = JSP_CRUD_PREP(array($fieldArray,$recordArray),'SET');
		$whereClause = JSP_CRUD_PREP($whereArray,'WHERE');		
		$strSQL = "UPDATE $table SET ".$setClause." WHERE ".$whereClause;
		if (mysqli_query(_DBCONN(),$strSQL))
		{
			mysqli_close(_DBCONN());
			return 1;
		}

	}
}

function JSP_CRUD_DELETE ($table, $whereArray) 
{
	$paramArray = array($table,$whereArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$whereArray = JSP_BUILD_CSV($whereArray);
		$whereArray[0] = JSP_CRUNCH_PRIKEY($table,$whereArray[0]);
		$JSP_CONSTRUCT = JSP_CRUD_PREP($whereArray,'WHERE');		
		$strSQL = "DELETE FROM $table WHERE ".$JSP_CONSTRUCT;
		if (mysqli_query(_DBCONN(),$strSQL))
		{
			mysqli_close(_DBCONN());
			return 1;
		}
	}
}

?>

