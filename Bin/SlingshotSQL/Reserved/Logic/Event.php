<?php
//ACTIVE TABLE
$TABLE = JSP_TABLE_EVENT;
$BASE = JSP_BASE_EVENT;
$L_PAGE = 'Event-Form.php';
$R_PAGE = JSP_BASE_SSQL.$L_PAGE;
$FORM_PAGE = _SWISS($L_PAGE,$R_PAGE,'LOCALHOST');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	//ARRANGE
	$_FILTER = $entryArray = JSP_FILTER_FILE($_POST);
			
	//CHECKS	
	$fieldArray = array('name');
	$throwArray = array('Event Name');
	$errorTray = _VALIDATE($TABLE,$fieldArray,$throwArray,$_FILTER);
	
	if ($errorTray)
		$err = '!'.$errorTray;
	else
	{
//		var_dump($_POST,$entryArray,$_FILES,IS_POSTBACK,IS_FILEBACK);
//		return 0;

		if (!IS_POSTBACK) //CREATE
		{
			$row = JSP_FETCH_LAST($TABLE);
			if (!_THROW($row))
				$row['image'] = JSP_IMAGE_PRESET;
			$JSP_FILE = JSP_FILE_UPDATE($row['image'],$_FILES['image'],$BASE);			
			$JSP_CRUD = _CREATE_LIMIT($TABLE,$entryArray,1);
			$status = 'Event created.';
		}
		else //UPDATE
		{
			if (!IS_FILEBACK) //NO FILE
			{
				$JSP_FILE = 1;
				$JSP_CRUD = _UPDATE_BUT($TABLE,'image,date,time',$entryArray,IS_POSTBACK);
			}
			else
			{
				$row = _BYID($TABLE,IS_POSTBACK);			
				$JSP_FILE = JSP_FILE_UPDATE($row['image'],$_FILES['image'],$BASE);
				$JSP_CRUD = _UPDATE_BUT($TABLE,'date,time',$entryArray,IS_POSTBACK);				
			}
			$status = 'Event updated.';							
		}		
		
		if ($JSP_FILE == 1)
		{
			if ($JSP_CRUD == 1)
				$err = $status;
			else
				$err = '!'.$JSP_CRUD;					
		}
		else
			$err = JSP_ERROR_FILE;		
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if ($_GET['BLN_ACTION_EDIT'])
		_REDIR($FORM_PAGE,'RFID',$_GET['BLN_ACTION_EDIT']);
	if ($_GET['BLN_ACTION_DELETE'])
	{
		$row = _BYID($TABLE,$_GET['BLN_ACTION_DELETE']);		
		$JSP_FILE = JSP_FILE_DELETE($BASE.$row['image']);
		$JSP_CRUD_DELETE = _DELETE($TABLE,$_GET['BLN_ACTION_DELETE']);
		if ($JSP_CRUD_DELETE == 1)
			$err = 'Record deleted.';
		else
			$err = '!'.$JSP_CRUD_DELETE;	
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