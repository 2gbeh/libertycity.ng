<?php
CORE_CONTROL_ADMIN(SLI_PAGE_LANDING); 

//ACTIVE TABLE
$TABLE = JSP_TABLE_ADMIN;
$TABLE_2 = JSP_TABLE_TEAM;
$L_PAGE = 'Account-Form.php';
$R_PAGE = JSP_BASE_SSQL.$L_PAGE;
$FORM_PAGE = _SWISS($L_PAGE,$R_PAGE,'LOCALHOST');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	//ARRANGE
	$_FILTER = _FILTER($_POST);	
		
	//CHECKS	
	$fieldArray = array('email','username','password');
	$throwArray = array('Email Address','Username','Password');
	$errorTray = _VALIDATE($TABLE,$fieldArray,$throwArray,$_FILTER);
	
	if ($errorTray)
		$err = '!'.$errorTray;
	else
	{
		if (!IS_POSTBACK()) //CREATE
		{
			$JSP_CRUD = JSP_CRUD_CREATE($TABLE,$_FILTER);
			$status = 'Account created.';
		}
		else //UPDATE
		{
			$_FILTER_2 = JSP_SORT_ARRAY($_FILTER,'email,username,password,status');
			_UPDATE($TABLE_2,'email,username,password,status',$_FILTER_2,array('username',$_FILTER['username'],1));			
			$JSP_CRUD = _UPDATE_BUT($TABLE,'date,time',$_FILTER,IS_POSTBACK());			
			if ($JSP_CRUD == 1)				
				$status = 'Account updated.';
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
		$row = _BYID($TABLE,$_GET['BLN_ACTION_DELETE']);
		JSP_CRUD_DELETE($TABLE_2,array('username',$row['username'],1));
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