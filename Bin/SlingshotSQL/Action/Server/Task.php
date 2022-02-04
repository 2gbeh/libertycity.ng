<?php
//TABLE
$TABLE = DRA_TABLE_TASK;
$L_PAGE = 'Task-Form.php';
$R_PAGE = JSP_BASE_SSQL.$L_PAGE;
$FORM_PAGE = _SWISS($L_PAGE,$R_PAGE,'LOCALHOST');

$L_PAGE = 'Task-View.php';
$R_PAGE = JSP_BASE_SSQL.$L_PAGE;
$VIEW_PAGE = _SWISS($L_PAGE,$R_PAGE,'LOCALHOST');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	//ARRANGE
	$_FILTER = _FILTER($_POST);

	//CHECKS	
	$errorTray = _DUPLICATE($TABLE,'assign,objective,deadline',$_FILTER);
	$errorTray .= JSP_SANITIZE_TEXTAREA('resource');			
	
	if ($errorTray)
		$err = '!'.$errorTray;
	else
	{
		if (!IS_POSTBACK()) //CREATE
		{
			$JSP_CRUD = JSP_CRUD_CREATE($TABLE,$_FILTER);
			if ($JSP_CRUD == 1)
				$status = 'Task created successfully';
		}
		else //UPDATE
		{
			$JSP_CRUD = _UPDATE($TABLE,'*',$_FILTER,IS_POSTBACK());
			if ($JSP_CRUD == 1)
				$status = 'Task updated successfully';				
		}		
		
		if ($JSP_CRUD == 1)
			$err = $status;
		else
			$err = '!'.$JSP_CRUD;					
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if ($_GET['BLN_ACTION_EDIT'])
		_REDIR($FORM_PAGE,'RFID',$_GET['BLN_ACTION_EDIT']);
	if ($_GET['BLN_ACTION_DELETE'])
	{
		$JSP_CRUD_DELETE = _DELETE($TABLE,$_GET['BLN_ACTION_DELETE']);
		if ($JSP_CRUD_DELETE == 1)
			$err = 'Record deleted successfully';
		else
			$err = '!'.$JSP_CRUD_DELETE;	
	}
	if ($_GET['BLN_ACTION_VIEW'])
		_REDIR($VIEW_PAGE,'RFID',$_GET['BLN_ACTION_VIEW']);
	if ($_GET['BLN_ACTION_IBUTTON'])
	{
		$JSP_CRUD = _UPDATE_TAG($TABLE,'complete',$_GET['BLN_ACTION_IBUTTON'],IS_RFID);
		if ($JSP_CRUD)
			$err = 'Task completed successfully';
		else
			$err = '!Task already completed';
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