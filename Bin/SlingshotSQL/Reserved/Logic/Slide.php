<?php
//GLOB VAR
$TABLE = JSP_TABLE_SLIDE;
$BASE = JSP_BASE_SLIDE;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if ($_FILES['wallpaper'])
	{	
		$JSP_FILE_ASSORT = JSP_FILE_ASSORT($_FILES['wallpaper']);
		foreach ($JSP_FILE_ASSORT as $_FILES['wallpaper'])
		{
			$_FILES['wallpaper']['name'] = JSP_NAME_SPACE($_FILES['wallpaper']['name'],'BUILD');
			if (_EXIST($TABLE,'image',$_FILES['wallpaper']['name']))
				$err = '!Slide image already exist.';
			else
			{
				$entryArray = _ENTRY($_FILES['wallpaper']['name']);
				$JSP_FILE = JSP_FILE_UPLOAD($_FILES['wallpaper'],$BASE,0);
				if ($JSP_FILE == 1)
				{
					$JSP_CRUD = JSP_CRUD_CREATE($TABLE,$entryArray);
					if ($JSP_CRUD == 1)
						$err = 'Slide image uploaded.';
					else
						$err = '!'.$JSP_CRUD;
				}
				else
					$err = JSP_ERROR_FILE;
			}
		}
	}
	
	if ($_POST['ITABLE_SELECT_VALUE'])	
	{
		foreach ($_POST['ITABLE_SELECT_VALUE'] as $id)
		{
			$JSP_FETCH_BYID = JSP_FETCH_BYID($TABLE,$id);
			JSP_FILE_DELETE($BASE.$JSP_FETCH_BYID['image']);
			_DELETE($TABLE,$id);
		}
		$err = 'Record deleted.';
	}
}
?>