<?php
//ACTIVE TABLE
$TABLE = JSP_TABLE_ALBUM;
$BASE = JSP_BASE_GALLERY;
$L_PAGE = 'Album-Form.php';
$R_PAGE = JSP_BASE_SSQL.$L_PAGE;
$FORM_PAGE = _SWISS($L_PAGE,$R_PAGE,'LOCALHOST');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	//ARRANGE
	$_FILTER = _FILTER($_POST);
	$entryArray = array(JSP_NAME_SPACE($_FILTER['pseudo']),$_FILTER['about'],0,$_FILTER['pseudo']);
			
	//CHECKS	
	$fieldArray = array('pseudo');
	$throwArray = array('Album Name');
	$errorTray = _VALIDATE($TABLE,$fieldArray,$throwArray,$_FILTER);
	
	if ($errorTray)
		$err = '!'.$errorTray;
	else
	{
//		var_dump($_POST,$entryArray,IS_POSTBACK);
//		return 0;
		
		if (!IS_POSTBACK) //CREATE
		{
			$JSP_FILE = JSP_FOLDER_CREATE($entryArray[0],$BASE);
			$JSP_CRUD = JSP_CRUD_CREATE($TABLE,$entryArray);
			$status = 'Album created.';
		}
		else //UPDATE
		{
			$row = _BYID($TABLE,IS_POSTBACK);
			$JSP_FILE = JSP_FOLDER_RENAME($BASE.$row['name'],$BASE.$entryArray[0]);
			$entryArray[2] = $row['content'];
			$JSP_CRUD = _UPDATE_BUT($TABLE,'date,time',$entryArray,$_POST['id']);
			$status = 'Album updated.';			
		}
		
		if ($JSP_FILE == 1)
		{	
			if ($JSP_CRUD == 1)
				$err = $status;
			else
				$err = '!'.$JSP_CRUD;
		}
		else
			$err = JSP_ERROR_FOLDER;		
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if ($_GET['BLN_ACTION_EDIT'])
		_REDIR($FORM_PAGE,'RFID',$_GET['BLN_ACTION_EDIT']);
	if ($_GET['BLN_ACTION_DELETE'])
	{
		$row = _BYID($TABLE,$_GET['BLN_ACTION_DELETE']);
		JSP_FOLDER_DELETE($BASE.$row['name']);
		JSP_CRUD_DELETE(JSP_TABLE_GALLERY,array('album_rid',$row['id'],1));
		$JSP_CRUD = _DELETE($TABLE,$_GET['BLN_ACTION_DELETE']);
		if ($JSP_CRUD == 1)
			$err = 'Record deleted.';
		else
			$err = '!'.$JSP_CRUD;	
	}
	if (IS_RFID)
	{
		$JSP_FETCH_BYID = JSP_FETCH_BYID($TABLE,IS_RFID);
		if (_THROW($JSP_FETCH_BYID))
			$_POST = $JSP_FETCH_BYID;			
		else
			$err = '!'.$JSP_FETCH_BYID;
	}		
}
?>