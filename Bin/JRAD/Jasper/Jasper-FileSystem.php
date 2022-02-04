<?php
function JSP_FILE_ISIMAGE ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fileArray = JSP_BUILD_CSV($fileArray);
		foreach ($fileArray as $key => $file)
		{
			foreach (JSP_ENUMS_PREDEF('IMAGE') as $type)
			{
				if (_THROW(_STRPOS($file,$type)))
					$report[$file] = $type; 
			}
		}
		if (count($report) == count($fileArray))
			return $report;
	}
}

function JSP_FILE_ISVIDEO ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fileArray = JSP_BUILD_CSV($fileArray);
		foreach ($fileArray as $key => $file)
		{
			foreach (JSP_ENUMS_PREDEF('VIDEO') as $type)
			{
				if (_THROW(_STRPOS($file,$type)))
					$report[$file] = $type; 
			}
		}
		if (count($report) == count($fileArray))
			return $report;
	}
}

function JSP_FILE_ISDOC ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fileArray = JSP_BUILD_CSV($fileArray);
		foreach ($fileArray as $key => $file)
		{
			foreach (JSP_ENUMS_PREDEF('DOC') as $type)
			{
				if (_THROW(_STRPOS($file,$type)))
					$report[$file] = $type; 
			}
		}
		if (count($report) == count($fileArray))
			return $report;
	}
}

function JSP_FILE_ISFILE ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fileArray = JSP_BUILD_CSV($fileArray);
		foreach ($fileArray as $key => $file)
		{
			if (substr($file,-4,1) == '.' || substr($file,-5,1) == '.')
				$found++;
		}
		if ($found == count($fileArray))
			return 1;
	}
}

function JSP_FILE_BUTCHER ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fileArray = JSP_BUILD_CSV($fileArray);
		foreach ($fileArray as $key => $file)
		{
			$newArray[$key]['URL']	= $file;
			$JSP_BUILD_ARRAY = JSP_BUILD_ARRAY($file,'/');
			foreach ($JSP_BUILD_ARRAY as $i => $each)
				$newArray[$key]['PATH'][] = $each;
			$count = count($newArray[$key]['PATH']);
			$newArray[$key]['ROOT'] = current($newArray[$key]['PATH']);
			$newArray[$key]['BASE'] = JSP_FILE_BASE($file);
			$newArray[$key]['UPROOT']	= JSP_FILE_UPROOT($file);
			$newArray[$key]['PARENT'] = $newArray[$key]['PATH'][$count - 2];
			$newArray[$key]['TMP'] = end($newArray[$key]['PATH']);
			if (!JSP_FILE_ISFILE($newArray[$key]['TMP']))
				$newArray[$key]['COUNT'] = count(_CONTENT($file,'TRIM'));
		}
		return _CRUNCH($newArray);
	}
}

function JSP_FILE_CHECK ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if (JSP_ATYPE($fileArray) == 2)
		{
			if ($fileArray['name'][0] != '')
				return 1;			
		}
		else
		{
			if ($fileArray['name'] != '')
				return 1;
		}
	}
}

function JSP_FILE_EXIST ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		file_exists($fileArray);
		if (file_exists($fileArray))
			return 1;
	}
}

function JSP_FILE_SIZE ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{		
		if ($fileArray["size"] > 500000) #500KB
			return 1;					
	}
}

function JSP_FILE_UPROOT ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fileArray = JSP_BUILD_CSV($fileArray);
		foreach ($fileArray as $key => $file)
		{
			$noroot = JSP_BUTCHER_STR($file,$_SERVER['DOCUMENT_ROOT'],'LEFT');
			if (IS_LOCALHOST)
				$newArray[$key] = JSP_BUTCHER_STR($noroot,JSP_PAGE_ROOT,'LEFT');
			else
			{
				if (substr($noroot,0,1) == '/')
					$newArray[$key] = substr($noroot,1);
			}
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_FILE_BASE ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fileArray = JSP_BUILD_CSV($fileArray);
		foreach ($fileArray as $key => $file)
		{
			$file = JSP_FILE_UPROOT($file);
			$slashArray = JSP_BUILD_ARRAY($file,'/');
			for ($i = 0; $i < (count($slashArray) - 1); $i++)
				$baseArray[$key] .= $slashArray[$i].'/';
		}
		return _CRUNCH($baseArray);
	}
}

function JSP_FILE_TMP ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fileArray = JSP_BUILD_CSV($fileArray);
		foreach ($fileArray as $key => $file)
		{
			if (substr($file,-1) == '/')
				$file = substr($file,0,-1);
			$newArray[$key] = JSP_BUTCHER_STR($file,'/','LEFT');
		}
		return JSP_CRUNCH_ARRAY($newArray);
	}
}

function JSP_FILE_COMPRESS ($fileArray, $folder) 
{
	$paramArray = array($fileArray,$folder);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if (JSP_ATYPE($fileArray) == 1)
		{
			$src = $fileArray['tmp_name'];
			$file = $fileArray['name'];
			$target = $_SERVER['DOCUMENT_ROOT'].$folder.$file;			
			$info = getimagesize ($src);
			if ($info['mime'] == 'image/jpeg')
				$image = imagecreatefromjpeg ($src);
			else if ($info['mime'] == 'image/gif')
				$image = imagecreatefromgif ($src);
			else if ($info['mime'] == 'image/png')
				$image = imagecreatefrompng ($src);			
		}
		else
		{
			$src = $_SERVER['DOCUMENT_ROOT'].$folder.$fileArray;									
			$target = $_SERVER['DOCUMENT_ROOT'].$folder.$fileArray;
			$info['mime'] = JSP_BUTCHER_STR($fileArray,'.','LEFT');
			if (strlen($info['mime']) < 3)
				return 'invalid file extension';
			else if (!JSP_FILE_EXIST($target))
				return 'file not found';
			else
			{
				if ($info['mime'] == 'jpeg' || $info['mime'] == 'jpg')
					$image = imagecreatefromjpeg ($src);
				else if ($info['mime'] == 'gif')
					$image = imagecreatefromgif ($src);
				else if ($info['mime'] == 'png')
					$image = imagecreatefrompng ($src);
			}
		}
		imagejpeg ($image, $target, 75);
		return 'file compressed';
	}
}

function JSP_FILE_CONVERT ($fileArray, $format, $folder) 
{
	$paramArray = array($fileArray,$format,$folder);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_CTYPE($format) == '1' || 
		strlen($format) < 3
	)
		return JSPIP;
	else
	{
		if (count($fileArray) > 1)
		{
			$file = $fileArray['name'];
			$tmp = $fileArray["tmp_name"];
		}
		else
		{
			$file = $fileArray;
			$tmp = $_SERVER['DOCUMENT_ROOT'].$folder.$file;	
		}

		$justName = JSP_BUTCHER_STR($file,'.','RIGHT');
		$_file = $justName.'.'.$format;
		$prev = $_SERVER['DOCUMENT_ROOT'].$folder.$file;
		$next = $_SERVER['DOCUMENT_ROOT'].$folder.$_file;					
		
		if (JSP_FILE_EXIST($next))
			return 'file already exist';
		else
		{
			if (count($fileArray) > 1)
			{						
				if ($format == 'jpg' || $format == 'jpeg')
					imagejpeg(imagecreatefromstring(file_get_contents($tmp)), $next);
				else if ($format == 'gif')
					imagegif(imagecreatefromstring(file_get_contents($tmp)), $next);									
				else if ($format == 'png')
					imagepng(imagecreatefromstring(file_get_contents($tmp)), $next);
				else
					move_uploaded_file($tmp,$next);
			}
			else
			{
				if (JSP_FILE_EXIST($prev))			
					rename($tmp,$next);
				else
					return 'file not found';	
			}
			return 'file converted';			
		}
	}
}

function JSP_FILE_ORDER ($folder)
{
	$paramArray = array($folder);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$tmp = $_SERVER['DOCUMENT_ROOT'].$folder;				
		$fileArray = JSP_FOLDER_CONTENT($folder,'FILE');
		$i = 1;		
		foreach ($fileArray as $old_file)
		{
			$ext = JSP_BUTCHER_STR($old_file,'.','LEFT');			
			$new_file = $tmp.$i.'.'.$ext;
			rename ($old_file, $new_file);				
			$i++;
		}
		return 1;
	}
}

function JSP_FILE_ASSORT ($dimArray)
{
	$paramArray = array($dimArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		return JSP_CONFIG_ARRAY($dimArray);
	}
}

function JSP_FILE_UPLOAD ($fileArray, $folder, $ntype = 0)
{
	$paramArray = array($fileArray,$folder,JSP_TRUEPUT($ntype));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (is_numeric($ntype) && $ntype > 1) 
		return JSPIP;		
	else
	{
		$fileExt = '.'.JSP_BUTCHER_STR($fileArray["name"],'.','LEFT');
		$targetDir = $_SERVER['DOCUMENT_ROOT'].$folder;
		if ($ntype == '0')
			$targetFile = $targetDir.basename(JSP_NAME_SPACE($fileArray["name"]));
		else if ($ntype == '1')
			$targetFile = $targetDir.JSP_DATE_STAMP.$fileExt;
		else
			$targetFile = $targetDir.JSP_NAME_SPACE($ntype).$fileExt;
		$imageFileType = pathinfo($targetFile,PATHINFO_EXTENSION);
		$validFileType = JSP_ENUMS_PREDEF('IMAGE');
		$check = getimagesize($fileArray["tmp_name"]);
		if ($check !== false)
		{
			if (!in_array(strtolower($imageFileType),$validFileType))
				return JSPIL; //'unknown file extension';
			else
			{
				if (move_uploaded_file($fileArray["tmp_name"],$targetFile))
				{
					if ($ntype == '1')
						return array(1,JSP_BUTCHER_STR($targetFile,$targetDir,'LEFT'));
					return 1;
				}
			}						
		}
		else
			return JSPON; //'image file not selected';
	}
}

function JSP_FILE_RENAME ($oldPath, $newPath, $pathType = 'FOLDER')
{
	$paramArray = array($oldPath,$newPath,$pathType);	
	$parseArray = array('ROOT','FOLDER');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$pathType)) 
		return JSPIP;
	else
	{
		if ($pathType == $parseArray[1]) //FOLDER
		{
			$oldPath = $_SERVER['DOCUMENT_ROOT'].$oldPath;
			$newPath = $_SERVER['DOCUMENT_ROOT'].$newPath;
		}
//		return array($oldPath,$newPath);
		if (rename($oldPath,$newPath))
			return 1;
	}
}

function JSP_FILE_UPDATE ($oldname, $newname, $folder)
{
	$paramArray = array($oldname,$newname,$folder);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		JSP_FILE_DELETE($folder.$oldname);
		return JSP_FILE_UPLOAD($newname,$folder);
	}
}

function JSP_FILE_PRESET ($tableArray, $baseArray)
{
	$paramArray = array($tableArray,$baseArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$tableArray = _CSV($tableArray);		
		$baseArray = _CSV($baseArray);
		
		$table = $tableArray[0];
		$field = $tableArray[1];
		$base = $baseArray[0];
		$oldname = $baseArray[1]['name'];
		$newname = JSP_DATE_STAMP.'.gif';
		
//		return array($table,$field,$base,$oldname,$newname);
		
		if (JSP_FILE_RENAME($base.$oldname,$base.$newname) == 1)
			return _UPDATE_ASSOC($table,$field,$newname,array($field,$oldname));
	}
}

function JSP_FILE_DELETE ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$tmp = $_SERVER['DOCUMENT_ROOT'].$fileArray;
		if (JSP_FILE_EXIST($tmp) == 1)
		{
			unlink($tmp);
			return 1;
		}
		else
			return JSPON; //'file does not exist';
	}
}

function JSP_FILE_STAT ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$markFwd = '/';
		$markBwd = '\ ';
		$markDot = '.';
		$markBwd = substr($markBwd,0,1);		
		$_fileArray = JSP_BUILD_STR($fileArray);
		if 
		(
			(
				in_array($markFwd,$_fileArray) || 
				in_array($markBwd,$_fileArray)
			) && 			
			in_array($markDot,$_fileArray)			
		)
		{
			foreach ($_fileArray as $key => $value)
			{
				if ($value == '/')
					$hotKeys[] = $key;
			}
			$count = count($hotKeys);
			$lastKey = $hotKeys[$count - 1];
			$nlastKey = $hotKeys[$count - 2];
			foreach ($_fileArray as $key => $value)
			{
				if ($key > $nlastKey && $key < $lastKey)
					$folderArray[] = $value;
				if ($key <= $lastKey)
					$tmpFolderArray[] = $value;
			}
			$path = $fileArray;
			$root = $_SERVER['DOCUMENT_ROOT'];
			$location = $root.$path;			
			$basename = JSP_BUTCHER_STR($path,'/','LEFT');
			$name = JSP_BUTCHER_STR($basename,'.','RIGHT');
			$type = JSP_BUTCHER_STR($basename,'.','LEFT');		
			$_size = filesize($location);
			$size = JSP_BUILD_DENOM($_size,'BASIC').' bytes';			
			$folder = JSP_DROP_ARRAY($folderArray,'');		
			$tmp_folder = JSP_DROP_ARRAY($tmpFolderArray,'');
			if (file_exists($location))
				$status = true;			
			else
				$status = false;				
			if ($status)
			{
				$content = JSP_FOLDER_CONTENT($tmp_folder,'TRIM');
				foreach ($content as $key => $value)
				{
					$value = strtolower($value);
					$location = strtolower($location);					
					if ($value == $location)
					{
						$index = $key;
						$indexof = ($index + 1).'/'.count($content);						
					}
				}
			}
			else
				$index = $indexof = 'n/a';
			$c_date = date("F d, Y H:i:s",filemtime($location));
			$a_date = date("F d, Y H:i:s",filectime($location));
									
			$statArray = array 
			(
				'path' => $path,					
				'root' => $root,								
				'location' => $location,						
				'basename' => $basename,
				'name' => $name,
				'type' => $type,
				'size' => $size,
				'folder' => $folder,
				'tmp_folder' => $tmp_folder,
				'status' => $status,
				'index' => $index,
				'index_of' => $indexof,
				'c_date' => $c_date,
				'a_date' => $a_date
			);
			return $statArray;			
		}
		else
		{
			return JSPIP;
		}
	}
}

function JSP_FOLDER_REPAIR ($folder = JSP_BASE_GALLERY, $returnType = 'FOLDER')
{
	$paramArray = array($folder,$returnType);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$_folder = JSP_NAME_SPACE($folder); //new parent folder name
		JSP_FILE_RENAME($folder,$_folder); //rename parent folder
		$content = JSP_FOLDER_CONTENT($_folder,'TRIM'); //get parent folder content
		foreach ($content as $file)
		{
			$_file = JSP_NAME_SPACE($file); //new child folder name
			JSP_FILE_RENAME($file,$_file,'ROOT'); //rename child folder
			if (!JSP_FILE_ISFILE($_file))
			{
				$__folder = JSP_BUTCHER_STR($_file,$_SERVER['DOCUMENT_ROOT'],'LEFT'); //get grand child folder
				$_content = JSP_FOLDER_CONTENT($__folder.'/','TRIM'); //get grand child folder content
				foreach ($_content as $__file)
				{
					$___file = JSP_NAME_SPACE($__file); //new grand child folder name					
					JSP_FILE_RENAME($__file,$___file,'ROOT'); //rename grand child folder
				}
			}	
		}
		return JSP_FOLDER_CONTENT($_folder,$returnType);
	}
}

function JSP_FOLDER_CONTENT ($folder = JSP_BASE_GALLERY, $type = 'IMAGE')
{
	$paramArray = array($folder,$type);
	$parseArray = array('ALL','TRIM','FOLDER','FILE','IMAGE','LIVE','VIDEO','DOC');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;		
	else
	{
		//IF FULL PATH PARSED
		if (!_STRPOS($folder,$_SERVER['DOCUMENT_ROOT']))
			$tmp = $_SERVER['DOCUMENT_ROOT'].$folder;
		else
			$tmp = $folder;
		//IF PATH END OPEN
		if (substr($tmp,-1) != '/')
			$tmp .= '/';
		$GLOB_BRACE = glob($tmp.'{,.}*',GLOB_BRACE);									
		$GLOB = glob($tmp.'*');				
		if ($type == $parseArray[0]) //ALL
		{
			foreach ($GLOB_BRACE as $files)
				$newArray[] = $files;	
		}
		else if ($type == $parseArray[1]) //TRIM
		{				
			foreach ($GLOB_BRACE as $files)
			{
				if (substr($files,-1,1) != '.' && substr($files,-1,1) != '..')
					$newArray[] = $files;	
			}
		}				
		else if ($type == $parseArray[2]) //FOLDER
		{
			foreach ($GLOB as $files)
			{
				if (!JSP_FILE_ISFILE($files) && substr($files,-4,4) != '.ini')
					$newArray[] = $files;	
			}
		}		
		else if ($type == $parseArray[3]) //FILE
		{
			foreach ($GLOB as $files)
			{
				if (JSP_FILE_ISFILE($files) && substr($files,-4,4) != '.ini')
					$newArray[] = $files;	
			}				
		}
		else if ($type == $parseArray[5]) //LIVE
		{
			$GLOB = _CONTENT($folder,'TRIM');
			foreach ($GLOB as $files)
			{
				if (JSP_FILE_ISFILE($files))
					$newArray[] = $files;
				else
				{
					if (_CONTENT($files,'TRIM'))
						$newArray[] = $files;
				}
			}
		}
		else if ($type == $parseArray[6]) //VIDEO
		{
			$GLOB = _CONTENT($folder,'TRIM');
			foreach ($GLOB as $files)
			{
				if (JSP_FILE_ISVIDEO($files))
					$newArray[] = $files;
			}
		}
		else if ($type == $parseArray[7]) //DOC
		{
			$GLOB = _CONTENT($folder,'TRIM');
			foreach ($GLOB as $files)
			{
				if (JSP_FILE_ISDOC($files))
					$newArray[] = $files;
			}
		}				
		else
		{
			foreach ($GLOB as $files)
			{
				if (JSP_FILE_ISIMAGE($files))
					$newArray[] = $files;	
			}					

		}
		return $newArray;
	}
}

function JSP_FOLDER_HAYSTACK ($folder, $name)
{
	$paramArray = array($folder,$name);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$upper = strtoupper($name);
		$space = JSP_BUILD_ARRAY($upper,' ');
		$underscore = JSP_DROP_ARRAY($space,'_');
		$tmp = $_SERVER['DOCUMENT_ROOT'].$folder;				
		$fileArray = JSP_FOLDER_CONTENT($folder,'FILE');
		$i = 1;		
		foreach ($fileArray as $old_file)
		{
			$ext = JSP_BUTCHER_STR($old_file,'.','LEFT');			
			if ($ext == 'ini') //desktop.ini
			{
				unlink($old_file);
			}
			else
			{
				$new_file = $tmp.$underscore.'_'.$i.'.'.$ext;
				rename ($old_file, $new_file);				
				$i++;
			}						
		}
		return 1;
	}
}

function JSP_FOLDER_CREATE ($name, $folder)
{
	$paramArray = array($name,$folder);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$tmp = $_SERVER['DOCUMENT_ROOT'].$folder.$name;
		if (mkdir($tmp))
			return 1;
		else
			return 'folder already exists';
	}
}

function JSP_FOLDER_RENAME ($oldPath, $newPath, $pathType = 'BASE')
{
	$paramArray = array($oldPath,$newPath,$pathType);	
	$parseArray = array('ROOT','BASE');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$pathType)) 
		return JSPIP;
	else
	{
		if ($pathType == $parseArray[1]) //BASE
		{
			$oldPath = $_SERVER['DOCUMENT_ROOT'].$oldPath;
			$newPath = $_SERVER['DOCUMENT_ROOT'].$newPath;
		}
//		return array($oldPath,$newPath);
		if (rename($oldPath,$newPath))
			return 1;
	}
}

function JSP_FOLDER_DELETE ($folder)
{
	$paramArray = array($folder);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if (JSP_FOLDER_EMPTY($folder))
		{
			$tmp = $_SERVER['DOCUMENT_ROOT'].$folder;
			if (substr($tmp,-1) == '/')
				$tmp = substr($tmp,0,-1);
			if (rmdir($tmp))
				return 1;
		}
	}
}

function JSP_FOLDER_EMPTY ($folder)
{
	$paramArray = array($folder);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$tmp = $_SERVER['DOCUMENT_ROOT'].$folder;
		if (JSP_FILE_EXIST($tmp))
		{
			$content = JSP_FOLDER_CONTENT($folder,'ALL');
			foreach ($content as $files)
				unlink($files);
			return 1;
		}
	}
}

function JSP_FOLDER_STAT ($fileArray)
{
	$paramArray = array($fileArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$markFwd = '/';
		$markBwd = '\ ';
		$markBwd = substr($markBwd,0,1);		
		$_fileArray = JSP_BUILD_STR($fileArray);
		if 
		(
			in_array($markFwd,$_fileArray) || 
			in_array($markBwd,$_fileArray)
		)		
		{
			foreach ($_fileArray as $key => $value)
			{
				if ($value == '/')
					$hotKeys[] = $key;
			}
			$count = count($hotKeys);
			$lastKey = $hotKeys[$count - 1];
			$nlastKey = $hotKeys[$count - 2];
			foreach ($_fileArray as $key => $value)
			{
				if ($key > $nlastKey && $key < $lastKey)
					$folderArray[] = $value;
				if ($key <= $nlastKey)
					$tmpFolderArray[] = $value;
			}
			$path = $fileArray;
			$root = $_SERVER['DOCUMENT_ROOT'];
			$location = $root.$path;
			$name = JSP_DROP_ARRAY($folderArray,'');
			$parent = JSP_DROP_ARRAY($tmpFolderArray,'');					
			$tmp_parent = $root.$parent.$name;
			$size = filesize($location).' bytes';	
			$_t_space = disk_total_space($tmp_parent);
			$t_space = JSP_BUILD_DENOM($_t_space,'BASIC').' bytes';											
			$_f_space = disk_free_space($tmp_parent);
			$f_space = JSP_BUILD_DENOM($_f_space,'BASIC').' bytes';			
			$_u_space = ($_f_space * 100) / $_t_space;
			$u_space = round(100 - $_u_space).'%';			
			if (file_exists($location))
				$status = true;			
			else
				$status = false;				
			if ($status)
			{
				$content = JSP_FOLDER_CONTENT($parent,'TRIM');
				foreach ($content as $key => $value)
				{
					$value = strtolower($value);
					$tmp_parent = strtolower($tmp_parent);
					if ($value == $tmp_parent)
					{
						$index = $key;
						$indexof = ($key + 1).'/'.count($content);
					}
				}		
			}
			else
				$index = $indexof = 'n/a';
			$content = JSP_FOLDER_CONTENT($path,'ALL');				
			$props = count($content);
			$c_date = date("F d, Y H:i:s",filectime($tmp_parent));				
			$a_date = date("F d, Y H:i:s",filemtime($tmp_parent));
			$statArray = array 
			(
				'path' => $path,					
				'root' => $root,								
				'location' => $location,						
				'name' => $name,
				't_space' => $t_space,
				'f_space' => $f_space, 		
				'u_space' => $u_space, 						
				'status' => $status,
				'index' => $index,
				'index_of' => $indexof,									
				'content' => $content,
				'content_count' => $props,				
				'c_date' => $c_date,
				'a_date' => $a_date		
			);
			return $statArray;			
		}
		else
		{
			return JSP_ERROR_LOG('regex');
		}
	}	
}

?>






