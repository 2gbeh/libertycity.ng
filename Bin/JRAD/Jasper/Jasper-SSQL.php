<?php
function JSP_SSQL_ISTABLE ($table = JSP_TABLE_USER)
{
	$paramArray = array($table);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$tableArray = JSP_DROP_CASE(JSP_FETCH_TABLES());
		if (in_array(strtolower($table),$tableArray))
			return 1;
	}
}

function JSP_SSQL_EXIST ($resource, $keyword, $schema = 'RECORD')
{
	$paramArray = array($resource,JSP_TRUEPUT($keyword),$schema);
	$parseArray = array('TABLE','FIELD','RECORD');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$schema)) 
		return JSPIP;		
	else
	{
		if ($schema == 'TABLE')
		{
			//$resource = $databaseName;
			$tableArray = JSP_FETCH_TABLES($resource);		
			if (in_array($keyword,$tableArray))
				return 1;
		}
		if ($schema == 'FIELD')
		{
			//$resource = $tableName;
			$fieldArray = JSP_FETCH_FIELDS($resource);		
			if (in_array($keyword,$fieldArray))
				return 1;
		}		
		if ($schema == 'RECORD')
		{		
			//$resource = array($tableName,$fieldName);
			$resource = JSP_BUILD_CSV($resource);
			$recordArray = JSP_FETCH_PREDEF($resource[0],$resource[1],1);
			$recordArray = JSP_CRUNCH_ARRAY($recordArray);
			if (in_array($keyword,$recordArray))
				return 1;
		}				
	}
}

function JSP_SSQL_VALID ($table, $prikey)
{
	$paramArray = array($table,$prikey);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$array = JSP_FETCH_BYCOL($table,'PRIKEY');
		if (in_array($prikey,$array))
			return 1;
	}
}

function JSP_SSQL_CLONE ($table, $fieldArray, $entryArray)
{
	$paramArray = array($table,$fieldArray,$entryArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fieldArray = JSP_BUILD_CSV($fieldArray);
		$entryArray = JSP_DROP_CASE(JSP_BUILD_CSV($entryArray));		
		$entryConcat = JSP_CONCAT_ARRAY($entryArray,'X',count($entryArray));				
		$recordArray = JSP_DROP_CASE(JSP_FETCH_PREDEF($table,$fieldArray,1));
		$recordConcat = JSP_CONCAT_ARRAY($recordArray,'Y',count($recordArray));
		if (in_array($entryConcat,$recordConcat))
			return 1;
	}
}

function JSP_SSQL_RESERVED ($array, $value, $case)
{
	$paramArray = array($array,$value,$case);
	$parseArray = array('CASE','NOCASE');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$case)) 
		return JSPIF;		
	else
	{
		$array = JSP_BUILD_CSV($array);
		$value = JSP_BUILD_CSV($value);
		if ($case == $parseArray[1]) //NOCASE
		{
			$array = JSP_DROP_CASE($array);
			$value = JSP_DROP_CASE($value);			
		}
		foreach ($array as $i)
		{
			foreach ($value as $e)
			if ($i == $e)
				return 1;
		}
	}
}

function JSP_SSQL_CELLS ()
{
	$JSP_FETCH_TABLES = JSP_FETCH_TABLES(_DB);
	foreach ($JSP_FETCH_TABLES as $table)
	{
		$JSP_FETCH_RECORDS = JSP_FETCH_RECORDS($table);
		foreach ($JSP_FETCH_RECORDS as $row)
		{
			foreach ($row as $cell)
				$JSP_SSQL_CELLS[] = $cell;
		}
	}
}

function JSP_SSQL_SEARCH ($table, $field, $keyword)
{
	$paramArray = array($table,$field,JSP_TRUEPUT($keyword));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{		
		$keyword = _ESCAPE($keyword);
		$strSQL = "SELECT * FROM $table WHERE $field LIKE '%".$keyword."%'";
		$query = mysqli_query(_DBCONN(),$strSQL);
		$pointer = 0;
		while ($array = mysqli_fetch_array($query,MYSQLI_ASSOC))
		{
			foreach ($array as $key => $value)
			{
				if (!is_numeric($key))
					$newArray[$pointer][$key] = $value;
			}			
			$pointer++;			
		}
		mysqli_close(_DBCONN());		
		if ($newArray)
			return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_SSQL_SIGNUP ($table, $entryArray, $uniqueArray)
{
	$paramArray = array($table,$entryArray,$uniqueArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$entryArray = JSP_BUILD_CSV($entryArray);
		$uniqueArray = JSP_BUILD_CSV($uniqueArray);					
		$uField = $uniqueArray[0];
		$uRecord = $uniqueArray[1];
		if (!in_array($uRecord,$entryArray))
			return JSPIL;
		if (!JSP_SSQL_EXIST(array($table,$uField),$uRecord,'RECORD'))
			return JSP_CRUD_CREATE($table,$entryArray);
	}	
}

function JSP_SSQL_SIGNIN ($table, $fieldArray, $entryArray)
{
	$paramArray = array($table,$fieldArray,$entryArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$fieldArray = JSP_BUILD_CSV($fieldArray);	 		
		$entryArray = JSP_REKEY_ARRAY(JSP_BUILD_CSV($entryArray));
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');
		$row = JSP_SSQL_LAST($table,$fieldArray[0],$entryArray[0]);
		if (_THROW($row))
		{
			if ($row[$fieldArray[1]] == $entryArray[1])
				return $row[$prikey];
			else
				return JSPIL;
		}
		else
			return JSPON;			
	}
}

function JSP_SSQL_PSWGEN ($clen, $ctype)
{
	$paramArray = array($clen,$ctype);
	$parseArray = array('NUMERIC','SAFE','STRONG');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$ctype)) 
		return JSPIP;		
	else
	{
		$pool = '';
		if ($ctype == $parseArray[2]) //STRONG
		{ 		
			#one special xter
				$array = array ('_','+','#','@','&','?','$','%');
				$sizeof = count($array) - 1;			
				$ri = mt_rand (0, $sizeof);
				$pool .= $array[$ri];			
			#one uppercase letter
				$array = range('A','Z');
				$sizeof = count($array) - 1;			
				$ri = mt_rand (0, $sizeof);
				$pool .= $array[$ri];							
			#the rest lowercase letters	
				$array = range('a','z');
				$sizeof = count($array) - 1;
				for ($i = 0; $i < ($clen - 3); $i++) 										
				{
					$ri = mt_rand (0, $sizeof);
					$pool .= $array[$ri];			
				}	 
			#one number
				$array = range('0','9');
				$sizeof = count($array) - 1;
				$ri = mt_rand (0, $sizeof);
				$pool .= $array[$ri];								
		}		
		else if ($ctype == $parseArray[1]) //SAFE
		{
			#one uppercase letter
				$array = range('A','Z');
				$sizeof = count($array) - 1;			
				$ri = mt_rand (0, $sizeof);
				$pool .= $array[$ri];			
			#the rest lowercase letters	
				$array = range('a','z');
				$sizeof = count($array) - 1;
				for ($i = 0; $i < ($clen - 2); $i++) 										
				{
					$ri = mt_rand (0, $sizeof);
					$pool .= $array[$ri];			
				}	 
			#one number
				$array = range('0','9');
				$sizeof = count($array) - 1;
				$ri = mt_rand (0, $sizeof);
				$pool .= $array[$ri];				
		}
		else //INT
		{
			$array = range('0','9');
			$sizeof = count($array) - 1;
			for ($i = 0; $i < $clen; $i++) 				
			{
				$ri = mt_rand (0,$sizeof);
				$pool .= $array[$ri];
			}
		}	
		return $pool;									
	}
}

function JSP_SSQL_PSWSET ($table, $passwordArray, $uniqueArray)
{
	$paramArray = array($table,$passwordArray,$uniqueArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;					
	else
	{
		$passwordArray = JSP_BUILD_CSV($passwordArray);		
		$oldPassword = $passwordArray[0];
		$newPassword = $passwordArray[1];					
		$uniqueArray = JSP_BUILD_CSV($uniqueArray);			
		$uField = $uniqueArray[0];
		$uRecord = $uniqueArray[1];
		$crudArray = array($table,$uField,$uRecord);
		$row = JSP_FETCH_WHERE($crudArray,1);
		if (JSP_ERROR_CATCH($row))
			return JSPON;
		else
		{
			$row = JSP_DROP_CASE($row);			
			if (in_array($oldPassword,$row))
			{
				$whereArray = array($uField,$uRecord,1);
				return JSP_CRUD_UPDATE($table,'password',$newPassword,$whereArray);
			}
			else
				return JSPIL;				
		}
	}	
}

function JSP_SSQL_PSWGET ($table, $uniqueArray)
{
	$paramArray = array($table,$uniqueArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$uniqueArray = JSP_BUILD_CSV($uniqueArray);					
		$uField = $uniqueArray[0];
		$uRecord = $uniqueArray[1];		
		if (JSP_SSQL_EXIST(array($table,$uField),$uRecord,'RECORD'))
			return JSP_FETCH_SWITCH(array($table,$uField,$uRecord),1);
	}	
}

function JSP_SSQL_GLOBSET ($table, $setArray, $assoc_id)
{
	$paramArray = array($table,$setArray,$assoc_id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{		
		$setArray = JSP_BUILD_CSV($setArray);
		$field = $setArray[0];
		$value = $setArray[1];
		$parseArray = array
		(
			JSP_GLOBAL_RECORDS('map','fields'),
			JSP_GLOBAL_RECORDS('map',$field)
		);
		if 
		(
			!in_array($field,$parseArray[0]) ||
			!in_array($value,$parseArray[1])
		)
			return JSPIP;
		$assoc_id = JSP_BUILD_CSV($assoc_id);		
		$record = JSP_GLOBAL_RECORDS($field,$value);		
		$idArray = JSP_FETCH_PREDEF($table,'PRIKEY',1);
		$idArray = JSP_CRUNCH_ARRAY($idArray);		
		if (!JSP_SSQL_EXIST($table,$field,'FIELD'))
		{
			$crudArray = array('TABLE' => $table,'FIELD' => $field);
			JSP_FOOBAR_FIELD($crudArray);
		}
		if (count($assoc_id) == 1)
		{
			if (!in_array($assoc_id[0],$idArray))
				return JSPON;			
			$whereArray = array('PRIKEY',$assoc_id[0],1);
			$output = JSP_CRUD_UPDATE($table,$field,$record,$whereArray);
		}
		else
		{
			foreach ($assoc_id as $id)
			{
				if (!in_array($id,$idArray))
					return JSPON;							
				$whereArray = array('PRIKEY',$id,1);				
				$output = JSP_CRUD_UPDATE($table,$field,$record,$whereArray);
			}
		}
		return $output;
	}
}

function JSP_SSQL_GLOBGET ($table, $getArray, $assoc_id)
{
	$paramArray = array($table,$getArray,$assoc_id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{		
		$getArray = JSP_BUILD_CSV($getArray);
		$field = $getArray[0];
		$rtype = $getArray[1];
		$parseArray = array
		(
			JSP_GLOBAL_RECORDS('map','fields'),
			array('KEY','VALUE')
		);
		if 
		(
			!in_array($field,$parseArray[0]) ||
			JSP_PARAM_PARSE($parseArray[1],$rtype)
		)
			return JSPIP;
		$assoc_id = JSP_BUILD_CSV($assoc_id);		
		$idArray = JSP_FETCH_PREDEF($table,'PRIKEY',1);
		$idArray = JSP_CRUNCH_ARRAY($idArray);
		if (!JSP_SSQL_EXIST($table,$field,'FIELD'))
			return JSPIL;
		if (count($assoc_id) == 1)
		{
			if (!in_array($assoc_id[0],$idArray))
				return JSPON;		
			$row = JSP_FETCH_BYID($table,$assoc_id[0]);
			if ($rtype == $parseArray[1][0]) //KEY
				$output = $row[$field];
			else
				$output = JSP_GLOBAL_RECORDS($field,$row[$field]);						
		}
		else
		{
			foreach ($assoc_id as $id)
			{
				if (!in_array($id,$idArray))
					return JSPON;							
				$row = JSP_FETCH_BYID($table,$id);
				if ($rtype == $parseArray[1][0]) //KEY
					$output[] = $row[$field];
				else
					$output[] = JSP_GLOBAL_RECORDS($field,$row[$field]);
			}
		}
		return $output;
	}
}

function JSP_SSQL_IPGET ()
{
	if ($_SERVER['HTTP_CLIENT_IP'])
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if ($_SERVER['HTTP_X_FORWARDED'])
		$ip = $_SERVER['HTTP_X_FORWARDED'];
	else if ($_SERVER['HTTP_FORWARDED_FOR'])
		$ip = $_SERVER['HTTP_FORWARDED_FOR'];
	else if ($_SERVER['HTTP_FORWARDED'])
		$ip = $_SERVER['HTTP_FORWARDED'];
	else if ($_SERVER['REMOTE_ADDR'])
		$ip = $_SERVER['REMOTE_ADDR'];
	else
		$ip = $_SERVER['SERVER_ADDR'];
	if (JSP_FILTER_IP($ip))
		return $ip;
}

function JSP_SSQL_IPSET ($table = JSP_TABLE_VISITOR)
{
	$paramArray = array($table);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{	
		if (_EXIST($table,'ip',_IP))
		{
			$row = _SWITCH($table,'ip',_IP);
			$counter = $row['counter'] + 1;
			$whereArray = array('ip',_IP);
			return _UPDATE_ASSOC($table,'counter,date,time',$counter,$whereArray);
		}
		else
			return _CREATE($table,array(_IP,1));
	}
}

function JSP_SSQL_IPLOG ($table, $assoc_array)
{
	$paramArray = array($table,$assoc_array);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
		return _UPDATE_ASSOC($table,'ip',_IP,$assoc_array);
}

function JSP_SSQL_FIRST ($table, $field, $record)
{
	$paramArray = array($table,$field,JSP_TRUEPUT($record));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$JSP_FETCH_SWITCH = JSP_FETCH_SWITCH(array($table,$field,$record),1);
		if (!JSP_ERROR_CATCH($JSP_FETCH_SWITCH)) 
		{
			if (JSP_ATYPE($JSP_FETCH_SWITCH) == 2)
				$JSP_FETCH_SWITCH = current($JSP_FETCH_SWITCH);
			return $JSP_FETCH_SWITCH;
		}
		else
			return JSPON;
	}
}

function JSP_SSQL_LAST ($table, $field, $record)
{
	$paramArray = array($table,$field,JSP_TRUEPUT($record));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$JSP_FETCH_SWITCH = JSP_FETCH_SWITCH(array($table,$field,$record),1);
		if (!JSP_ERROR_CATCH($JSP_FETCH_SWITCH)) 
		{
			if (JSP_ATYPE($JSP_FETCH_SWITCH) == 2)
				$JSP_FETCH_SWITCH = end($JSP_FETCH_SWITCH);
			return $JSP_FETCH_SWITCH;
		}
		else
			return JSPON;
	}
}
	
function JSP_SSQL_APPSTATE ($crudArray, $assoc_id)
{
	$paramArray = array($crudArray,$assoc_id);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$crudArray = JSP_BUILD_CSV($crudArray);
		$table = $crudArray[0];
		$field = $crudArray[1];
		$record = $crudArray[2];
		$JSP_FETCH_BYID = JSP_FETCH_BYID($table,$assoc_id);
		if ($record == $JSP_FETCH_BYID[$field])
			return 1;
	}
}

function JSP_SSQL_ROLLBACK ($table, $assoc_id)
{
	$paramArray = array($table,$assoc_id);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$row = JSP_FETCH_SWITCH(array($table,'PRIKEY',$assoc_id),1);
		$rollback = $row['status'] - 1;
		$fieldArray = 'status,date,time';
		$recArray = array($rollback,JSP_DATE_LONG,JSP_TIME_LONG);
		$whereArray = array('PRIKEY',$assoc_id,1);
		return JSP_CRUD_UPDATE($table,$fieldArray,$recArray,$whereArray); 
	}
}

function JSP_SSQL_ROLLFWD ($table, $assoc_id)
{
	$paramArray = array($table,$assoc_id);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		$row = JSP_FETCH_SWITCH(array($table,'PRIKEY',$assoc_id),1);
		$rollfwd = $row['status'] + 1;
		$fieldArray = 'status,date,time';
		$recArray = array($rollfwd,JSP_DATE_LONG,JSP_TIME_LONG);
		$whereArray = array('PRIKEY',$assoc_id,1);
		return JSP_CRUD_UPDATE($table,$fieldArray,$recArray,$whereArray); 
	}
}

function JSP_SSQL_KEYLOG ($table, $assoc_id)
{
	$paramArray = array($table,$assoc_id);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$fieldArray = array('date','time');
		$recordArray = array(JSP_DATE_LONG,JSP_TIME_LONG);
		$whereArray = array('PRIKEY',$assoc_id,1);
		return JSP_CRUD_UPDATE($table,$fieldArray,$recordArray,$whereArray);
	}	
}

function JSP_SSQL_QUAKER ($assoc_id, $type)
{
	$paramArray = array($assoc_id,$type);
	$parseArray = array('ACCESS','ACTION');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;			
	else
	{
		$table = JSP_TABLE_KEYLOG;
		$page = JSP_PAGE_NAME;		
		if ($type == $parseArray[0])
			$type = 0; 
		else 
			$type = 1;		
		$date = JSP_DATE_LONG;
		$time = JSP_TIME_LONG;		
		$dimArray = array('assoc_id VARCHAR (50)','page VARCHAR (30)','type INT (1)','date VARCHAR (16)','time VARCHAR (8)');
		if (!JSP_SSQL_ISTABLE($table))		
			JSP_FOOBAR_ITABLE($table,$dimArray);
		$entryArray = array($assoc_id,$page,$type,$date,$time);
		return JSP_CRUD_CREATE($table,$entryArray);
	}	
}

function JSP_SSQL_PAGI ($array, $pageid) 
{
	$paramArray = array($array,JSP_TRUEPUT($pageid));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric(JSP_TRUEPUT($pageid))) 
		return JSPIP;		
	else
	{		
		$pageid -= 1;
		$array = JSP_BUILD_CSV($array);
		if (JSP_ATYPE($array) == 2)
		{
			foreach ($array as $index => $assoc_array)
			{
				$fragArray = JSP_FRAG_ARRAY($assoc_array,10);
				if ($pageid <= 0) 
					$pageid = 0;
				else if ($pageid >= count($fragArray)) 
					$pageid = (count($fragArray) - 1);
				else
					$pageid = $pageid;
				$newArray[$index] = $fragArray[$pageid];
			}
		}
		else
		{
			$fragArray = JSP_FRAG_ARRAY($array,10);		
			if ($pageid <= 0) 
				$pageid = 0;
			else if ($pageid >= count($fragArray)) 
				$pageid = (count($fragArray) - 1);
			else
				$pageid = $pageid;					
			$newArray = $fragArray[$pageid];
		}
		return $newArray;
	}
}

function JSP_SSQL_TROLL ($table, $recordsArray, $assoc_id, $trollType = 'DAY') 
{
	$paramArray = array($table,$recordsArray,$assoc_id,$trollType);
	$parseArray = array('LAST','DAY','WEEK','MONTH');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$trollType)) 
		return JSPIP;					
	else
	{
		if ($trollType == $parseArray[0]) //LAST
		{
			$JSP_FETCH_PREDEF = JSP_FETCH_PREDEF($table,'*',1);	
			if (!in_array($assoc_id,$JSP_FETCH_PREDEF[0]))
				return JSP_CRUD_CREATE($table,$recordsArray);
		}
		else if ($trollType == $parseArray[1]) //DAY
		{
			$JSP_FETCH_BYDATE = JSP_FETCH_BYDATE($table,'TODAY');
			if (!in_array($assoc_id,$JSP_FETCH_BYDATE[0]))
				return JSP_CRUD_CREATE($table,$recordsArray);
		}
		else if ($trollType == $parseArray[2]) //WEEK
		{
			$JSP_FETCH_BYDATE = JSP_FETCH_BYDATE($table,'THIS WEEK');
			if (!in_array($assoc_id,$JSP_FETCH_BYDATE[0]))
				return JSP_CRUD_CREATE($table,$recordsArray);
		}		
		else //MONTH
		{
			$JSP_FETCH_BYDATE = JSP_FETCH_BYDATE($table,'THIS MONTH');
			if (!in_array($assoc_id,$JSP_FETCH_BYDATE[0]))
				return JSP_CRUD_CREATE($table,$recordsArray);
		}

	}
}

function JSP_SSQL_TUPLES ($table, $field, $entry) 
{
	$paramArray = array($table,$field,JSP_TRUEPUT($entry));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$setArray = JSP_FETCH_BYCOL($table,$field);
		return _THROW(JSP_NAME_TUPLES($entry,$setArray));
	}
}

function JSP_SSQL_OCCURS ($table, $field, $rtype = 'STAT')
{
	$paramArray = array($table,$field,$rtype);
	$parseArray = array('COUNT','PERC','LIST','STAT');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else if (JSP_PARAM_PARSE($parseArray,$rtype)) 
		return JSPIP;
	else
	{
		$array = JSP_FETCH_COLUMN($table,$field);
		$total = count($array);
		$occur = array_count_values($array);
		foreach ($array as $assoc_value)
		{
			$count[$assoc_value] = $countFoobar = $occur[$assoc_value];
			$perc[$assoc_value] = $percFoobar = JSP_PERCOF($total,$countFoobar,'PERC');
			$series = '';			
			foreach ($array as $key => $value)
			{
				if ($assoc_value == $value)
					$series .= $key.',';
			}
			$list[$assoc_value] = $listFoobar = substr($series,0,-1);
			$stat[$assoc_value] = $countFoobar.'/'.$total.' '.$percFoobar.' {'.$listFoobar.'}';
		}
		if ($rtype == $parseArray[0]) //COUNT
			return $count;
		else if ($rtype == $parseArray[1]) //PERC
			return $perc;
		else if ($rtype == $parseArray[2]) //LIST
			return $list;
		else
			return $stat;
	}	
}

function JSP_SSQL_FULLSTACK ($array)
{
	$paramArray = array($array);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$array = _CSV($array);
		foreach ($array as $key => $value)
		{
			if (_ISSTR($value))
				$checked++;
		}
		if (count($array) == $checked)
			return 1;
	}
}

function JSP_SSQL_DATALIST ($table, $field, $attr)
{
	$paramArray = array($table, $field, $attr);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$listArray = JSP_SORT_UNIQUE(_BYCOL($table,$field));
		if (_THROW($listArray))
		{
			foreach ($listArray as $value)
				$option .= '<option value="'.ucwords($value).'">';
			$output = '<datalist id="'.$attr.'">'.$option.'</datalist>';
			return $output;
		}
	}	
}
?>

