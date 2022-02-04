<?php
function JSP_SYNC_COMBO ()
{
	if (JSP_SYNC_FOLDER())
	{
		if (JSP_SYNC_FILE())
		{
			if (JSP_SANITIZE_FOLDER())
			{
				JSP_SANITIZE_FILE();
			}
		}
	}
}

function JSP_SYNC_FOLDER ($base = JSP_BASE_GALLERY, $table = JSP_TABLE_ALBUM)
{
	$paramArray = array($base,$table);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;				
	else
	{
		$fieldArray = JSP_FETCH_PRIKEY($table,'NOGLOB');
		$prikey = JSP_FETCH_PRIKEY($table,'VALUE');	
		$folderArray = JSP_FOLDER_REPAIR($base,'FOLDER');
		if (_THROW($folderArray))
		{
			foreach ($folderArray as $content)
			{
				$butcher = JSP_FILE_BUTCHER($content);
				$entryArray = array();				
				foreach ($fieldArray as $key => $field) //SYNC ALBUM
				{
					if (JSP_SORT_GATE($field,'name,folder,album'))
					{
						$hot['name'] = $field;
						$entryArray[$key] = $butcher['TMP'];
					}
					else if ($field == 'pseudo')
						$entryArray[$key] = JSP_NAME_SPACE($butcher['TMP'],'DROP');
					else if (JSP_SORT_GATE($field,'total,content,count,files'))
					{
						$hot['count'] = $field;						
						$entryArray[$key] = $butcher['COUNT'];
					}
					else if (JSP_SORT_GATE($field,'directory,dir,tmp,url,path,base'))
						$entryArray[$key] = $butcher['BASE'];
					else
						$entryArray[$key] = '';
				}
//				return array($content,$fieldArray,$entryArray,$butcher,$hot);
				$whereArray = array($hot['name'],$butcher['TMP']);

				if (!_CREATE_IF($table,$entryArray,$whereArray))
				{
					//IS IMAGE ADDED
					$row = _SWITCH($table,$hot['name'],$butcher['TMP']);
//					return array($butcher,$hot,$row,$prikey);
					if ($row[$hot['count']] != $butcher['COUNT'])
						_UPDATE($table,$hot['count'],$butcher['COUNT'],$row[$prikey]);
				}
			}
			return 1;
		} #content
	}
}


function JSP_SYNC_FILE ($base = JSP_BASE_GALLERY, $imageTable = JSP_TABLE_GALLERY, $albumTable = JSP_TABLE_ALBUM)
{
	$paramArray = array($base,$imageTable,$albumTable);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;				
	else
	{
		$albumFields = JSP_FETCH_PRIKEY($albumTable,'NOGLOB');		
		$imageFields = JSP_FETCH_PRIKEY($imageTable,'NOGLOB');
		$prikey = JSP_FETCH_PRIKEY($albumTable,'VALUE');		
		$folderArray = JSP_FOLDER_REPAIR($base,'LIVE');
		
		if (_THROW($folderArray))
		{
			foreach ($folderArray as $content)
			{
				if (JSP_FILE_ISFILE($content))
				{
					$butcher = JSP_FILE_BUTCHER($content);
					$entryArray = array();
					foreach ($imageFields as $key => $field)
					{
						if (JSP_SORT_GATE($field,'image,name'))
							$entryArray[$key] = $butcher['TMP'];
						else if (JSP_SORT_GATE($field,'folder,album,parent'))
							$entryArray[$key] = $butcher['PARENT'];
						else if (JSP_SORT_GATE($field,'folder_rid,album_rid'))
						{
							$row = _SWITCH($albumTable,$albumFields[0],$butcher['PARENT']);
							if ($row[$prikey] === null)
								$entryArray[$key] = 0;
							else
								$entryArray[$key] = $row[$prikey];
						}
						else if (JSP_SORT_GATE($field,'directory,dir,tmp,url,path,base'))
							$entryArray[$key] = $butcher['BASE'];
						else
							$entryArray[$key] = '';
					}
//					return array($folderArray,$imageFields,$entryArray,$butcher);
					if (!JSP_SSQL_CLONE($imageTable,$imageFields,$entryArray))
						_CREATE($imageTable,$entryArray);
				}
				else
					JSP_SYNC_FILE($content);
			}
			return 1;
		} #content
	}
}

function JSP_SYNC_SLIDE ($base = JSP_BASE_SLIDE, $table = JSP_TABLE_SLIDE)
{
	$paramArray = array($base,$table);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;				
	else
	{
		$tableArray = JSP_FETCH_TABLES();
		$fieldArray = JSP_FETCH_FIELDS($table);
		if (in_array(JSP_DROP_CASE($table),JSP_DROP_CASE($tableArray)))
		{
			$array = JSP_FOLDER_REPAIR($base,'IMAGE');
			foreach ($array as $value)
			{
				$butcher = JSP_FILE_BUTCHER($value);
				$filename = $butcher['TMP'];
				_CREATE_IF($table,$filename,array($fieldArray[0],$filename));
			}
			return 1;
		}
	}
}

function JSP_SYNC_UPLOADS ($base = JSP_BASE_UPLOADS, $table = JSP_TABLE_UPLOADS, $fileType = 'png')
{
	$paramArray = array($base,$table,$fileType);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;				
	else
	{
		$tableArray = JSP_FETCH_TABLES();
		$fieldArray = JSP_FETCH_FIELDS($table);
		if (in_array(JSP_DROP_CASE($table),JSP_DROP_CASE($tableArray)))
		{
			$array = JSP_FOLDER_REPAIR($base,'TRIM');
			$sorted = JSP_SORT_FILE($array,$fileType);
			foreach ($sorted as $value)
			{
				$butcher = JSP_FILE_BUTCHER($value);
				$filename = $butcher['TMP'];
				_CREATE_IF($table,$filename,array($fieldArray[0],$filename));
			}
			return 1;
		}
	}
}

function JSP_SANITIZE_FOLDER ($table = JSP_TABLE_ALBUM, $base = JSP_BASE_GALLERY)
{
	$paramArray = array($table,$base);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;				
	else
	{
		$fieldArray = JSP_FETCH_PRIKEY($table,'NOGLOB');
		$folderArray = _CONTENT($base,'FOLDER');
		if (_THROW($folderArray))
		{
			$tmpArray = JSP_FILE_TMP($folderArray);
			if (_ISSTR($tmpArray))
			{
				$newArray[0] = $tmpArray;
				$tmpArray = $newArray;			
			}
			$recArray = _BYCOL($table,$fieldArray[0]);
			if (_THROW($recArray))
			{
				foreach ($recArray as $key => $value)
				{
					if (!in_array($value,$tmpArray))
						_DELETE($table,$key);
				}
				return 1;				
			}
		}
	}
}

function JSP_SANITIZE_FILE ($table = JSP_TABLE_GALLERY, $base = JSP_BASE_GALLERY)
{
	$paramArray = array($table,$base);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;				
	else
	{
		$fieldArray = JSP_FETCH_PRIKEY($table,'NOGLOB');
		$p_array = _CONTENT($base,'TRIM');
		if (_THROW($p_array))
		{
			foreach ($p_array as $p_content)
			{
				if (JSP_FILE_ISIMAGE($p_content))
					$haystack[] = $p_content;
				else
				{
					$c_array = _CONTENT($p_content,'TRIM');
					if (_THROW($c_array))
					{
						foreach ($c_array as $c_content)
						{
							if (JSP_FILE_ISIMAGE($c_content))
								$haystack[] = $c_content;						
						}
					}
				}
			}
		}
		$tmpArray = JSP_FILE_TMP($haystack);
		$recArray = _BYCOL($table,$fieldArray[0]);
//		return array('FOLDER' => $tmpArray,'TABLE' => $recArray);
		foreach ($recArray as $key => $value)
		{
			if (!in_array($value,$tmpArray))
				_DELETE($table,$key);
		}
		return 1;
	}
}


?>


