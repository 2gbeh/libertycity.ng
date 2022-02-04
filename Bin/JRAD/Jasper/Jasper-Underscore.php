<?php
define('_NULL','0');
define('_DATE',JSP_DATE_LONG);
define('_TIME',JSP_TIME_LONG);
define('_VERCODE',JSP_SSQL_PSWGEN(6,'NUMERIC'));
define('_IP',JSP_SSQL_IPGET());
define('_PAGE',JSP_PAGE_NAME());

function _ISDATE ($str)
{
	if (strlen($str))
	{
		$strArray = JSP_BUILD_STR($str);
		$occur = JSP_SORT_OCCUR($strArray,'/','REAL');
		if 
		(
			($occur == 4 && strlen($str) <= 16) || 
			($occur == 2 && strlen($str) <= 10)
		)
			return $str;
	}
}

function _ISTIME ($str)
{
	if (strlen($str))
	{
		$strArray = JSP_BUILD_STR($str);
		$occur = JSP_SORT_OCCUR($strArray,':','REAL');
		if ($occur == 2 && strlen($str) <= 8)
			return $str;
	}	
}

function _ISSTR ($str)
{
	if (strlen($str) && JSP_CTYPE($str) != 5)
		return 1;
}

function _ISCHAR ($str)
{
	if (strlen($str) && !is_numeric($str))
		return 1;
}

function _ISLIN ($array)
{
	if (JSP_ATYPE($array) == 1)
		return 1;
}

function _ISDIM ($array)
{
	if (JSP_ATYPE($array) == 2)
		return 1;
}

function _ISLINK ($str)
{
	$parseArray = array('https:','http:','www.','.com','.org','.ng','.gov','.uk');
	if (_ISSTR($str))
	{
		foreach ($parseArray as $each)
		{
			if (_STRPOS($str,$each))
				return 1;
		}
	}
}

function _DUMP ($parseArray)
{
	return JSP_DISPLAY_DUMP($parseArray);
}

function _FILTER ($postArray)
{
	return JSP_FILTER_POST($postArray);	
}

function _SANITIZE ($throwArray, $postArray)
{
	return JSP_SANITIZE_POST($throwArray,$postArray);
}

function _VALIDATE ($table, $fieldArray, $throwArray, $postArray)
{
	return JSP_VALIDATE_POST($table,$fieldArray,$throwArray,$postArray);
}

function _DUPLICATE ($table, $fieldArray, $postArray)
{
	return JSP_DUPLICATE_POST($table,$fieldArray,$postArray);
}

function _CATCH ($parse)
{
	return JSP_ERROR_CATCH($parse);
}

function _THROW ($parse)
{
	return JSP_ERROR_THROW($parse);
}

function _ERROR ($parse)
{
	if ($parse || IS_ERROR)
	{		
		if (IS_ERROR)
			$parse = IS_ERROR;
		
		if (substr($parse,0,1) == '!')
		{
			$parse = substr($parse,1);
			$errcol = 'DANGER';
		}
		else if (substr($parse,0,1) == '#')
		{
			$parse = substr($parse,1);
			$errcol = 'PRESET';
		}		
		else 
		{
			$_POST = array();
			$errcol = 'SUCCESS';
			if (IS_ERROR)
				$errcol = 'INFO';
		}
		return JSP_DISPLAY_ERROR($parse,$errcol);
	}
}

function _REDIR ($url, $key, $value)
{
	if ($key && $value)
	{
		$key = JSP_BUILD_CSV($key);
		$value = JSP_BUILD_CSV($value);
		$url .= "?".JSP_PREP_STR(array($key,$value),'REQUEST');
	}		
	if (!IS_LOCALHOST)
	{
		$url = JSP_BUTCHER_STR($url,'../','LEFT');		
		$url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/".$url;	
	}
	echo '
	<script type="text/javascript">
		document.location.href="'.$url.'";
	</script>';
}

function _EXIST ($table, $field, $entry)
{
	return JSP_SSQL_EXIST(array($table,$field),$entry);
}

function _VALID ($table, $prikey)
{
	return JSP_SSQL_VALID($table,$prikey);
}

function _ENTRY ($postArray)
{
	if (!strlen($postArray))
		return JSP_PUSH_ARRAY($postArray,array(JSP_DATE_LONG,JSP_TIME_LONG));
	else
		return $postArray .= ','._DATE.','._TIME;
}

function _MAILTO ($subject)
{
	if (!$subject)
		$subject = 'Prospective Customer from '.DOMAIN;
	return JSP_SPAM_MAILTO(EMAIL,$subject);
}

function _MKFORMAT ($dateArray)
{
	return JSP_CAL_MKFORMAT($dateArray);
}

function _MKSALUTE ($time)
{
	if (!$time)
		$time = _TIME;
	return JSP_CAL_MKSALUTE($time);
}

function _STABLE ($tharray, $tdarray, $action)
{	
	//ARRANGE
	$tharray = JSP_TITLE_CASE(_CSV($tharray));
	$tdarray = JSP_TITLE_CASE(_CSV($tdarray));
		
	if (_ISLIN($tdarray))
		$tdarray = JSP_CONFIG_ARRAY($tdarray);
	$keyArray = array_keys($tdarray[0]);
	$key = $keyArray[0];
	$proArray = _CRUNCH(JSP_CONFIG_ARRAY($tdarray));
	for ($x = 0; $x < count($proArray); $x++)
	{
		if (_THROW($tharray))
			$tr = '<td>'.$tharray[$x].'</td>';
		else
			$tr = '<td>'.($x + 1).'</td>';
		$tr .= '<td>'.JSP_TRANS_TELLER($proArray[$x]).'</td>';
		$tbody .= '<tr ondblclick=BLN_HEADER_ANCHOR("nav_down")>'.$tr.'<tr>';			
	}
	
	if ($action && $tbody)
	{
		$prompt = JSP_PREP_STR('Delete record?','SCRIPT');			
		$append = '<tr class="action" ondblclick=BLN_HEADER_ANCHOR("nav_up") id="nav_down">
			<td>&nbsp;</td><td>
				<a href="#" class="t_btn t_btn_sec" onClick=BLN_ACTION_DELETE("'.$prompt.'","'.$key.'")>delete</a>				
				<a href="#" class="t_btn t_btn_pri" onClick=BLN_ACTION_EDIT("'.$key.'")>edit</a>			
			</td>';
		'</tr>';
	}
			
	$table = '<table class="BLN_DISPLAY_TABLE BLN_DISPLAY_OTABLE" id="nav_up">'
		.$tbody.$append.'
	</table>';
	return $table;
}

function _TABLES ($labelArray, $fieldArray)
{
	$labelArray = _CSV($labelArray);
	$fieldArray = _CSV($fieldArray);
	for ($i = 0; $i < count($labelArray); $i++)
	{
		$label = '<td>'.$labelArray[$i].'</td>';
		$field = '<td>'.$fieldArray[$i].'</td>';
		$row .= '<tr>'.$label.$field.'</tr>'; 
	}
	return '<table class="STEM_TCOMPACT">'.$row.'</table>';
}

function _FORMS ($labelArray, $fieldArray, $placeholder = 'NO', $required = 'YES')
{
	$labelArray = _CSV($labelArray);
	$fieldArray = _CSV($fieldArray);
	if (count($labelArray) != count($fieldArray))
		return JSPIL;
	foreach ($fieldArray as $i => $name)
	{
		//LABEL
		if ($placeholder == 'NO')
			$label = '<label for="'.$name.'">'.$labelArray[$i].'</label>';
		else		
			$placeholder = $labelArray[$i];
		
		if (JSP_SORT_GATE($name,JSP_DTYPE_LONG(),'OR'))
		{
			//TEXTAREA
			$input = JSP_FORMS_TEXTAREA($name,$required);
		}
		else if (JSP_SORT_GATE($name,JSP_DTYPE_LIST(),'OR'))
		{		
			//SELECT
			if ($name == 'gender')
				$array = JSP_ENUMS_GENERIC('GENDER');
			else if ($name == 'age_range')
				$array = JSP_ENUMS_GENERIC('AGE_RANGE');
			else if ($name == 'yob' || $name == 'year')
				$array = JSP_ENUMS_DATE('YEAR');
			else if ($name == 'month')
				$array = JSP_ENUMS_DATE('MONTH');
			else if ($name == 'day')
				$array = JSP_ENUMS_DATE('DAY');			
			else if (JSP_SORT_GATE($name,'soo,state,location,ppa_state','OR'))
				$array = JSP_ENUMS_GENERIC('STATE');
			else if ($name == 'bank')
				$array = JSP_ENUMS_GENERIC('BANK');			
			else if ($name == 'acct_type')
				$array = JSP_ENUMS_PREDEF('ACCT_TYPE');			
			else if ($name == 'trans_type')
				$array = JSP_ENUMS_PREDEF('TRANS_TYPE');
			else if ($name == 'answer')
				$array = JSP_ENUMS_GENERIC('ANSWER');
			else if ($name == 'control')
				$array = JSP_GLOBAL_RECORDS('map','control');					
			else if ($name == 'status')
				$array = JSP_ENUMS_GENERIC('STATUS');
			$input = JSP_FORMS_SELECT($name,$array,'KEY',$required);
			
			if ($name == 'dob')
			{
				$input = JSP_FORMS_SELECT($name.'_day',JSP_ENUMS_DATE('DAY'),'KEY',$required);
				$input .= JSP_FORMS_SELECT($name.'_month',JSP_ENUMS_DATE('MONTH'),'KEY',$required);
				$input .= JSP_FORMS_SELECT($name.'_year',JSP_ENUMS_DATE('YEAR'),'VALUE',$required);
			}
		}
		else if (JSP_SORT_GATE($name,JSP_DTYPE_FILE(),'OR'))
		{
			//FILE
			$input = JSP_FORMS_FILE($name,'YES',$required);						
		}
		else if (JSP_SORT_GATE($name,JSP_DTYPE_DATE(),'OR'))
		{
			//DATE
			$input = JSP_FORMS_DATE($name,$required);						
		}
		else
		{			
			//TEXTBOX			
			if ($name == 'password' && $placeholder == 'NO')
				$label .= ' '.JSP_SPRY_PASSWORD();
			$input = JSP_FORMS_TEXTBOX($name,$placeholder,$required);
		}
		//COMPILE
		$legend  .= $label.$input;	
	}
	//PRINT
	return $legend;
}

function _SEARCHBOX ($placeholder)
{
	return JSP_FORMS_SEARCH($placeholder);
}

function _TEXTBOX ($value)
{
	return JSP_FORMS_TEXTBOX($value);
}

function _FILE ($name)
{
	return JSP_FORMS_FILE($name);
}

function _SELECT ($name, $array)
{
	return JSP_FORMS_SELECT($name,$array);
}

function _TEXTAREA ($name)
{
	return JSP_FORMS_TEXTAREA($name);
}

function _CHECKBOX ($message)
{
	return JSP_FORMS_CHECKBOX($message);
}

function _BUTTON ($value)
{
	return JSP_FORMS_BUTTON($value);
}

function _IBUTTON ($label, $value)
{
	return JSP_FORMS_IBUTTON($label,$value);
}

function _LOGIN ($entryArray)
{
	return JSP_SSQL_SIGNIN(JSP_TABLE_USER,'email,password',$entryArray);
}

function _DUMMY ($table)
{
	return JSP_FOOBAR_CLONE($table);
}

function _CREATE ($table, $entryArray)
{
	$strSQL = JSP_CRUD_CREATE($table,$entryArray);
	if ($strSQL == 1)
	{
		foreach ($entryArray as $cell)
		{
			if (JSP_SPAM_ISEMAIL($cell))
				return _BYEMAIL($table,$cell);
		}
	}
	else
		return $strSQL;
}

function _CREATE_IF ($table, $entryArray, $assoc_array)
{
	$assoc_array = JSP_BUILD_CSV($assoc_array);
	$field = $assoc_array[0];
	$record = $assoc_array[1];
	if (!_EXIST($table,$field,$record))
		return JSP_CRUD_CREATE($table,$entryArray);
}

function _CREATE_LIMIT ($table, $entryArray, $limit)
{
	$array = JSP_FETCH_BYCOL($table,'PRIKEY');
	if ($limit == 1)
		_DELETE($table,'*');
	else if (count($array) >= $limit)
	{
		$limitArray = JSP_SORT_ARITH($array,($limit - 1),'LNTH');
		JSP_CRUD_DELETE($table,array('PRIKEY',$limitArray,0));
	}
	return JSP_CRUD_CREATE($table,$entryArray);
}

function _FILE_LIMIT ($table, $baseArray, $entryArray, $limit)
{
	//$baseArray = array('dir','field');
	$baseArray = _CSV($baseArray);
	$base = $baseArray[0];
	$field = $baseArray[1];
	$fileArray = _BYCOL($table,$field);
	
	if ($limit == 1)
	{
		foreach ($fileArray as $file)
			JSP_FILE_DELETE($base.$file);
		_DELETE($table,'*');
	}
	else if (count($fileArray) >= $limit)
	{
		$descArray = JSP_FETCH_LIMIT($table,($limit - 1));
		$hotkeys = array_keys($descArray);
		foreach (array_keys($fileArray) as $id)
		{
			if (!in_array($id,$hotkeys))
			{
				JSP_FILE_DELETE($base.$fileArray[$id]);
				_DELETE($table,$id);
			}
		}
	}
	JSP_FILE_UPLOAD($_FILES[$field],$base);
	return JSP_CRUD_CREATE($table,$entryArray);
}

function _UPDATE ($table, $fieldArray, $recordsArray, $prikey)
{
	if ($prikey == '*')
		return JSP_CRUD_UPDATE($table,$fieldArray,$recordsArray,array('PRIKEY',0,0));
	else
	{
		$prikey = _CSV($prikey);
		foreach ($prikey as $id)
			$strSQL = JSP_CRUD_UPDATE($table,$fieldArray,$recordsArray,array('PRIKEY',$id,1));
		if ($strSQL == 1)
			return 1;
		else
			return $strSQL;
	}
}

function _UPDATE_ASSOC ($table, $fieldArray, $recordsArray, $assoc_array)
{
	$whereArray = array($assoc_array[0],$assoc_array[1],1);
	return JSP_CRUD_UPDATE($table,$fieldArray,$recordsArray,$whereArray);
}

function _UPDATE_TAG ($table, $field, $record, $prikey)
{
	$row = _BYID($table,$prikey);
	$tagArray = _CSV($row[$field]);
	if (_THROW($tagArray))
	{
		if (!in_array($record,$tagArray))
		{
			$tagArray[] = $record;
			$record = JSP_DROP_ARRAY($tagArray,',');
		}
		else
			return 0;	
	}
	return JSP_CRUD_UPDATE($table,$field,$record,array('PRIKEY',$prikey,1));
}

function _UPDATE_BUT ($table, $fieldArray, $recordsArray, $prikey)
{
	if ($fieldArray != '*')
	{
		$JSP_FETCH_PRIKEY = JSP_FETCH_PRIKEY($table);
		$fieldArray = JSP_SORT_EXCLUDE($JSP_FETCH_PRIKEY,$fieldArray);
	}
	return JSP_CRUD_UPDATE($table,$fieldArray,$recordsArray,array('PRIKEY',$prikey,1));
}

function _DELETE ($table, $assoc_id)
{
	if ($assoc_id == '*')
	{
		$strSQL = "TRUNCATE TABLE ".$table;
		mysqli_query(_DBCONN(),$strSQL);
		mysqli_close(_DBCONN());
		return 1;
	}
	else
	{
		$assoc_id = _CSV($assoc_id);
		foreach ($assoc_id as $id)
			$strSQL = JSP_CRUD_DELETE($table,array('PRIKEY',$id,1));
		if ($strSQL == 1)
			return 1;
		else
			return $strSQL;
	}
}

function _NUMROWS ($table)
{
	return JSP_FETCH_NUMROWS($table);
}

function _KEYLOG ($table, $assoc_id)
{
	return JSP_SSQL_KEYLOG($table,$assoc_id);
}

function _IPLOG ($table, $assoc_array)
{
	return JSP_SSQL_IPLOG($table,$assoc_array);
}

function _PRIKEY ($table, $rtype)
{
	return JSP_FETCH_PRIKEY($table,$rtype);
}

function _SWITCH ($table, $field, $record)
{
	return JSP_FETCH_SWITCH(array($table,$field,$record));
}

function _CELLOF ($table, $cell, $assoc_id)
{
	return JSP_FETCH_CELLOF($table,$cell,$assoc_id);
}

function _BYID ($table, $id)
{
	return JSP_FETCH_BYID($table,$id);
}

function _BYCOL ($table, $field)
{
	return JSP_FETCH_BYCOL($table,$field);
}

function _BYROW ($table, $row)
{
	return JSP_FETCH_BYROW($table,$row);
}

function _BYEMAIL ($table, $email)
{
	return JSP_FETCH_BYEMAIL($table,$email);
}

function _BYDATE ($table, $dateLogic)
{
	return JSP_FETCH_BYDATE($table,$dateLogic);
}

function _STATUS ($table, $assoc_id)
{
	return JSP_FETCH_CELLOF($table,'status',$assoc_id);
}

function _ROLLBACK ($table, $assoc_id)
{
	return JSP_SSQL_ROLLBACK ($table, $assoc_id);
}

function _ROLLFWD ($table, $assoc_id)
{
	return JSP_SSQL_ROLLFWD ($table, $assoc_id);
}

function _RESTORE ($table, $assoc_id)
{
	return _UPDATE($table,'status',0,$assoc_id);
}

function _DISABLE ($table, $assoc_id)
{
	return _UPDATE($table,'status',4,$assoc_id);
}

function _DISABLED ($table, $assoc_id)
{
	if (JSP_SSQL_APPSTATE(array($table,'status',4),$assoc_id))
		return 1;
}

function _CRUNCH ($array)
{
	return JSP_CRUNCH_ARRAY($array);	
}

function _JUMBO ($number)
{
	return _THROW(JSP_BUILD_JUMBO($number));
}

function _DENOM ($number)
{
	return _THROW(JSP_BUILD_DENOM($number));
}

function _RICHJUMBO ($number)
{
	$JUMBO = _JUMBO($number);
	if (is_numeric($JUMBO))
		$output = _DENOM($JUMBO);
	else
		$output = $JUMBO;
	return 'N'.$output;
}

function _RICHDENOM ($number)
{
	$DENOM = JSP_BUILD_DENOM($number);
	if (!_THROW($DENOM))
		$DENOM = 0;
	return '<cur>ngn</cur> '.$DENOM.'.00';		
}

function _DIMARRAY ($array)
{
	return JSP_BUILD_DIMARRAY($array);
}

function _CSV ($array)
{
	return JSP_BUILD_CSV($array);
}

function _CXV ($array)
{
	if (_ISSTR($array))
		return _REPLACE(',',', ',$array);
	else if (_ISLIN($array))
		return JSP_DROP_ARRAY($array,', ');
	else
		return $array;
}

function _WSP ($array)
{
	return JSP_CRUNCH_WHITESPACE($array);
}

function _AIRTIGHT ($textarea)
{
	return JSP_CRUNCH_TEXTAREA($textarea);
}

function _GENERIC ($param)
{
	return JSP_ENUMS_GENERIC($param);
}

function _ENUMS ($param, $index)
{
	return JSP_CRUNCH_ENUMS('GENERIC',$param,$index);
}

function _TRANS ($array, $param, $pointer)
{
	//ARRANGE
	$array = JSP_BUILD_CSV($array);
	$pointer = JSP_BUILD_CSV($pointer);
	$JSP_ENUMS = JSP_ENUMS_GENERIC($param);
	if (JSP_ATYPE($array) == 2)
	{
		foreach ($pointer as $_pointer)
		{		
			foreach ($array[$_pointer] as $key => $value)
				$array[$_pointer][$key] = $JSP_ENUMS[$value];
		}
	}
	else
	{
		$ARRAY_KEYS = array_keys($array);		
		foreach ($pointer as $_pointer)
		{				
			$key = $ARRAY_KEYS[$_pointer];
			$array[$key] = $JSP_ENUMS[$array[$key]];
		}
	}
	return $array;		
}

function _UPROOT ($fileArray)
{
	return JSP_FILE_UPROOT($fileArray);
}

function _UPLOAD ($fileArray, $folder, $ntype)
{
	return JSP_FILE_UPLOAD($fileArray,$folder,$ntype);
}

function _CONTENT ($folder, $type)
{
	return JSP_FOLDER_CONTENT($folder,$type);
}

function _PROFILE ($param)
{
	return JSP_ENUMS_PROFILE($param);
}

function _STRPOS ($haystack, $neddle)
{
	return JSP_FIND_STR($haystack,$neddle);
}

function _REPLACE ($former, $latter, $str)
{
	return str_replace($former,$latter,$str);
}

function _ESCAPE ($keyword)
{
	return mysqli_real_escape_string(_DBCONN(),$keyword);
}

function _ABS ($keyword)
{
	$_S = _SEARCH(JSP_TABLE_USER,$keyword);
	if ($_S)
	{
		foreach ($_S as $assoc_array)
			$lastArray = $assoc_array;
		return $lastArray;
	}
}

function _SEARCH ($table, $keyword)
{
	$fieldArray = JSP_FETCH_FIELDS($table);
	$prikey = JSP_FETCH_PRIKEY($table,'VALUE');
	$keyword = _ESCAPE($keyword);
	//GET PRIKEYS IN EACH FOUND FIELD
	foreach ($fieldArray as $field)
	{
		$strSQL = "SELECT * FROM $table WHERE $field LIKE '%".$keyword."%'";
		$query = mysqli_query(_DBCONN(),$strSQL);
		$pointer = 0;
		while ($array = mysqli_fetch_array($query,MYSQLI_ASSOC))
		{
			foreach ($array as $key => $value)
			{
				if (!is_numeric($key))
					$prikeyArray[$field][$pointer] = $array[$prikey];
			}
			$pointer++;			
		}		
	}
	
	if ($prikeyArray)
	{
		//MERGE PRIKEYS			
		foreach ($prikeyArray as $index => $assoc_array)
		{
			foreach ($assoc_array as $key => $value)
				$mergeArray[$value] = $index;
		}
		//RETURN ROWS OF MERGED PRIKEYS
		foreach ($mergeArray as $key => $value)
		{
			$newArray[] = JSP_FETCH_BYID($table,$key);
		}
		return $newArray;
	}
}

?>
