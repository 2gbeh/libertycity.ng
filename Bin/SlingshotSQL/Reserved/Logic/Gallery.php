<?php
//GLOB VAR
$TABLE = JSP_TABLE_GALLERY;
$BASE = JSP_BASE_GALLERY;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if ($_FILES['file'])
	{	
		$fileArray = JSP_FILE_ASSORT($_FILES['file']);
		foreach ($fileArray as $_FILES['file'])
		{
			//RESOURCE
			$image = JSP_NAME_SPACE($_FILES['file']['name']);
			$album_rid = $_POST['album'];
			$albumArray = _BYID(JSP_TABLE_ALBUM,$album_rid);
			$_base = $BASE.$albumArray['name'].'/';
			$_content = $albumArray['content'] + 1;
			$prikey = $albumArray['id'];
			
//			var_dump($_FILES['file'],$_POST,$albumArray,$_base);
//			return 0;
						
			$fieldArray = array('image','album_rid');
			$recArray = array($image,$album_rid);
			if (JSP_SSQL_CLONE($TABLE,$fieldArray,$recArray))
				$err = '!Image file already exist in selected album.';
			else
			{
				$entryArray = $recArray;
				$JSP_FILE = JSP_FILE_UPLOAD($_FILES['file'],$_base);
				if ($JSP_FILE == 1)
				{
					$JSP_CRUD = JSP_CRUD_CREATE($TABLE,$entryArray);
					if ($JSP_CRUD == 1)
					{
						_UPDATE(JSP_TABLE_ALBUM,'content',$_content,$prikey);
						$err = 'Gallery image uploaded.';
					}
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
			//RESOURCE
			$imageArray = _BYID($TABLE,$id);
			$albumArray = _BYID(JSP_TABLE_ALBUM,$imageArray['album_rid']);
			$prikey = $albumArray['id'];
			$_base = $BASE.$albumArray['name'].'/';
			$_content = $albumArray['content'] - 1;
			if ($_content < 0)
				$_content = 0;
			
//			var_dump($id,$imageArray,$albumArray,$_base,$_content);
//			return 0;
			
			JSP_FILE_DELETE($_base.$imageArray['image']);
			_DELETE($TABLE,$id);
			_UPDATE(JSP_TABLE_ALBUM,'content',$_content,$prikey);
		}
		$err = 'Record deleted.';
	}
}
?>