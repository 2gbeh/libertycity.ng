<?php
//ACTIVE TABLE
$TABLE = JSP_TABLE_TEAM;
$TABLE_2 = JSP_TABLE_ADMIN;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	//ARRANGE
	$_FILTER = _FILTER($_POST);	
		
	//CHECKS	
	$fieldArray = array('email','phone','username');
	$throwArray = array('Email Address','Phone Number','Username');
	$errorTray = _VALIDATE($TABLE,$fieldArray,$throwArray,$_FILTER);
	
	if ($errorTray)
		$err = '!'.$errorTray;
	else
	{
		if (!IS_POSTBACK()) //CREATE
		{			
			$JSP_CRUD = JSP_CRUD_CREATE($TABLE,$_FILTER);
			if ($JSP_CRUD == 1)
			{
				$_FILTER_2 = JSP_SORT_ARRAY($_FILTER,'email,username,password');
				$JSP_CRUD = JSP_CRUD_CREATE($TABLE_2,$_FILTER_2);
				if ($JSP_CRUD == 1)
				{
					$from = APPNAME.','.EMAIL;
					$to = $_FILTER['email'];
					$subject = 'Welcome to '.APPNAME;
					$message = 'Good day,
Thank you for joining The Libertycity Magic R&D Team. Your personal admin account has been created successfully, feel free to update your account details at any time using the Team > Update Profile portal.

Regards.';
					JSP_SPAM_SET($from,$to,$subject,$message);
					$status = 'Account created successfully';
				}
			}
		}
		else //UPDATE
		{
			$JSP_CRUD = _UPDATE_BUT($TABLE,'gender,username,status',$_FILTER,$_POST['id']);
			if ($JSP_CRUD == 1)
			{
				$_BYID = _BYID($TABLE,$_POST['id']);
				$_SWITCH = _SWITCH($TABLE_2,'username',$_BYID['username']);
				$_FILTER_3 = array($_FILTER['email'],$_FILTER['password']);				
				$JSP_CRUD = _UPDATE($TABLE_2,'email,password',$_FILTER_3,$_SWITCH['id']);
				if ($JSP_CRUD == 1)
					$status = 'Account updated successfully';
			}
		}
		if ($JSP_CRUD == 1)
			$err = $status;
		else
			$err = '!'.$JSP_CRUD;
	}
}

?>