<?php
//TABLE
$TABLE = DRA_TABLE_BUSINESS;
$L_PAGE = 'Apps-Business-Form.php';
$R_PAGE = JSP_BASE_SSQL.$L_PAGE;
$FORM_PAGE = _SWISS($L_PAGE,$R_PAGE,'LOCALHOST');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	//ARRANGE
	$_FILTER = _FILTER($_POST);
	$_FILTER = JSP_FILTER_PRICE($_FILTER,3);
	$_FILTER = JSP_PUSH_ARRAY($_FILTER,$_ADMIN['id']);

	//CHECKS	
	$fieldArray = array('service');
	$throwArray = array('This Service');
	$errorTray = _VALIDATE($TABLE,$fieldArray,$throwArray,$_POST);	
	
	if ($errorTray)
		$err = '!'.$errorTray;
	else
	{
		if (!IS_POSTBACK()) //CREATE
		{
			$JSP_CRUD = JSP_CRUD_CREATE($TABLE,$_FILTER);
			if ($JSP_CRUD == 1)
				$status = 'Service created successfully';
		}
		else //UPDATE
		{	
			$JSP_CRUD = _UPDATE($TABLE,'*',$_FILTER,IS_POSTBACK());
			if ($JSP_CRUD == 1)
				$status = 'Service updated successfully';
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