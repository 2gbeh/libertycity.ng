<?php
//TABLE
$TABLE = DRA_TABLE_NEWS;
$BASE = DRA_BASE_NEWS;
$L_PAGE = 'Apps-News-Form.php';
$R_PAGE = JSP_BASE_SSQL.$L_PAGE;
$FORM_PAGE = _SWISS($L_PAGE,$R_PAGE,'LOCALHOST');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	//ARRANGE
	$_POST = JSP_CRUNCH_NOLINK($_POST,4);
	$_POST_2 = JSP_FILTER_FILE($_POST,2);
	$_FILTER = JSP_PUSH_ARRAY($_POST_2,array(0,$_ADMIN['id']));	
	$_FILES['image'] = end(JSP_FILE_ASSORT($_FILES['image']));
	
	//CHECKS	
	$fieldArray = array('headline');
	$throwArray = array('This Headline');
	$errorTray = _VALIDATE($TABLE,$fieldArray,$throwArray,$_POST_2);
	$errorTray .= JSP_SANITIZE_TEXTAREA('article');		
	
	if ($errorTray)
		$err = '!'.$errorTray;
	else
	{
		if (!IS_POSTBACK()) //CREATE
		{
			$JSP_CRUD = _FILE_LIMIT($TABLE,array($BASE,'image'),$_FILTER,30);	
			$JSP_FILE = JSP_FILE_PRESET(array($TABLE,'image'),array($BASE,$_FILES['image']));			
			if ($JSP_CRUD == 1)
				$status = 'Article created successfully';
		}
		else //UPDATE
		{	
			if (!IS_FILEBACK()) //NO FILE
			{
				$JSP_FILE = 1;				
				$_FILTER = JSP_SORT_ARRAY($_FILTER,'0,1,2,3,4,6');	
				$JSP_CRUD = _UPDATE_BUT($TABLE,'image,views',$_FILTER,IS_POSTBACK());
			}
			else
			{
				$_FILTER = JSP_SORT_ARRAY($_FILTER,'0,1,2,3,4,5,7');	
				$row = _BYID($TABLE,IS_POSTBACK());			
				$JSP_FILE = JSP_FILE_UPDATE($row['image'],$_FILES['image'],$BASE);
				$JSP_CRUD = _UPDATE_BUT($TABLE,'views',$_FILTER,IS_POSTBACK());
				$JSP_FILE = JSP_FILE_PRESET(array($TABLE,'image'),array($BASE,$_FILES['image']));				
			}
			$status = 'Article updated successfully';			
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
			$err = 'Record deleted successfully';
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