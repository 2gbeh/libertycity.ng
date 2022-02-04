<?php
function JSP_TAGS_PREP ($table, $tagArray, $assoc_id)
{
	$paramArray = array($table,$tagArray,$assoc_id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if (!strlen($tagArray))
			$tagArray = JSP_DROP_ARRAY($tagArray,',');
		$tagArray = JSP_DROP_CASE($tagArray);		
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');			
		$row = JSP_CRUD_RETRIEVE($table,$prikey,$assoc_id);
		$prevTags = $row['tags'];		
		return array($prevTags,$tagArray);
	}
}

function JSP_TAGS_MATCH ($newtagArray, $prevtagArray)
{
	$paramArray = array($newtagArray,$prevtagArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		foreach ($newtagArray as $newValue)
		{
			foreach ($prevtagArray as $prevValue)
				if ($newValue == $prevValue)
					$matchedTags[] = $newValue;
		}
		if (!$matchedTags || empty($matchedTags)) 
			$matchedTags = 0;
		return $matchedTags;
	}
}

function JSP_TAGS_UPDATE ($table, $tagArray, $assoc_id)
{
	$paramArray = array($table,JSP_TRUEPUT($tagArray),$assoc_id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');			
		$strSQL = "UPDATE $table SET tags = '$tagArray' WHERE $prikey = $assoc_id";
		mysqli_query(_DBCONN(),$strSQL);
		mysqli_close(_DBCONN());
		return 1;	
	}
}

function JSP_TAGS_SET ($table, $tagArray, $assoc_id)
{
	$paramArray = array($table,$tagArray,$assoc_id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($assoc_id))
		return JSPIP;
	else
	{
		if (!JSP_SSQL_EXIST($table,'tags','FIELD'))
		{
			$crudArray = array('TABLE' => $table,'FIELD' => 'tags LONGTEXT');
			JSP_FOOBAR_FIELD($crudArray,'CREATE');
		}
		$prepared = JSP_TAGS_PREP($table,$tagArray,$assoc_id);		
		$prevtags = $prepared[0];
		$tagArray = $prepared[1];
		if 
		(
			$prevtags && 
			strlen($prevtags) != 0 && 
			JSP_CTYPE($prevtags) != 5
		)
		{
			$newtagArray = JSP_BUILD_ARRAY($tagArray,',');
			$prevtagArray = JSP_BUILD_ARRAY($prevtags,',');			
			$matchedTags = JSP_TAGS_MATCH($newtagArray,$prevtagArray);			
			if ($matchedTags == '0') 
				$tagArray = $prevtags.','.$tagArray; //no match found
			else
			{
				foreach ($matchedTags as $match)
					$newtagArray = JSP_SORT_EXCLUDE($newtagArray,$match,'VALUE');
				if (!$newtagArray)
					$tagArray = $prevtags; //all newtags matched
				else 
					$tagArray = $prevtags.','.JSP_DROP_ARRAY($newtagArray,','); //append unmatched newtags
			}
		}
		return JSP_TAGS_UPDATE($table,$tagArray,$assoc_id);				
	}
}

function JSP_TAGS_GET ($table, $tagArray)
{
	$paramArray = array($table,$tagArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$tagArray = JSP_BUILD_CSV($tagArray);
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');
		$tagfield = JSP_FETCH_PREDEF($table,'tags',1);
		foreach ($tagfield as $key => $prevtags)
		{
			$prevtagArray = JSP_BUILD_ARRAY($prevtags,',');
			$matchedTags = JSP_TAGS_MATCH($tagArray,$prevtagArray);			
			if (!strlen($matchedTags)) 
				$mockid[] = $key + 1;
		}
		if (!$mockid)
			return JSPON;
		foreach ($mockid as $id)
		{
			$fetchArray = array($table,$prikey,$id);
			$matchedRows[] = JSP_FETCH_SWITCH($fetchArray,1);
		}
		return JSP_CRUNCH_ARRAY($matchedRows);		
	}
}

function JSP_TAGS_DELETE ($table, $tagArray, $assoc_id)
{
	$paramArray = array($table,$tagArray,$assoc_id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($assoc_id))
		return JSPIP;
	else
	{
		$prepared = JSP_TAGS_PREP($table,$tagArray,$assoc_id);		
		$prevtags = $prepared[0];
		$tagArray = $prepared[1];		
		if
		(
			$prevtags && 
			strlen($prevtags) != 0 && 
			JSP_CTYPE($prevtags) != 5
		)		
		{
			$newtagArray = JSP_BUILD_ARRAY($tagArray,',');
			$prevtagArray = JSP_BUILD_ARRAY($prevtags,',');			
			$matchedTags = JSP_TAGS_MATCH($newtagArray,$prevtagArray);			
			if ($matchedTags == '0') 
				$tagArray = $prevtags; //no match found
			else
			{
				foreach ($matchedTags as $match)
					$prevtagArray = JSP_SORT_EXCLUDE($prevtagArray,$match,'VALUE');
				if (!$prevtagArray)
					$tagArray = ''; //all prevtags removed
				else 
					$tagArray = JSP_DROP_ARRAY($prevtagArray,','); //prevtags remaining
			}
		}
		else
			$tagArray = ''; //no prevtags
		return JSP_TAGS_UPDATE($table,$tagArray,$assoc_id);					
	}
}

function JSP_TAGS_CLEAR ($table,$assoc_id)
{
	$paramArray = array($table,$assoc_id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($assoc_id))
		return JSPIP;
	else
	{
		$tagArray = '';
		return JSP_TAGS_UPDATE($table,$tagArray,$assoc_id);		
	}
}
?>
