<?php
define('IS_ADMIN',isset($_SESSION['CORE_APPSTATE_ADMIN']));
define('IS_USER',isset($_SESSION['CORE_APPSTATE_USER']));
define('IS_TEMP',isset($_SESSION['CORE_APPSTATE_TEMP']));

define('IS_HISTORY_ADMIN',isset($_SESSION['CORE_HISTORY_ADMIN']));
define('IS_HISTORY_USER',isset($_SESSION['CORE_HISTORY_USER']));
define('IS_HISTORY_TEMP',isset($_SESSION['CORE_HISTORY_TEMP']));

define('IS_LOGOUT',isset($_GET['CORE_APPSTATE_LOGOUT']));
define('IS_ILOGOUT',isset($_GET['CORE_APPSTATE_ILOGOUT']));

if (IS_ADMIN)
{
	define('_ADMIN',$_SESSION['CORE_APPSTATE_ADMIN']);	
	$GLOBALS['_ADMIN'] = _BYID(JSP_TABLE_ADMIN,_ADMIN);	
	$_ADMIN = $GLOBALS['_ADMIN'];
	if ($_ADMIN['email'] == JSP_SUPER_ADMIN)
		define('IS_SUPER_ADMIN',1);
	else
		define('IS_SUPER_ADMIN',0);
		
	if ($_ADMIN['control'] == '2')
	{
		define('IS_VET_ADMIN',1);
		define('IS_REC_ADMIN',0);		
		define('IS_EXP_ADMIN',0);
	}
	else if ($_ADMIN['control'] == '1')
	{
		define('IS_VET_ADMIN',0);
		define('IS_REC_ADMIN',1);		
		define('IS_EXP_ADMIN',0);
	}
	else
	{
		define('IS_VET_ADMIN',0);
		define('IS_REC_ADMIN',0);		
		define('IS_EXP_ADMIN',1);
	}
}
	
if (IS_USER)
{
	define('_USER',$_SESSION['CORE_APPSTATE_USER']);	
	$GLOBALS['_USER'] = _BYID(JSP_TABLE_USER,_USER);	
	$_USER = $GLOBALS['_USER'];
	if ($_USER['email'] == JSP_SUPER_USER)
		define('IS_SUPER_USER',1);
	else
		define('IS_SUPER_USER',0);
		
	if (JSP_SPAM_ISEMAIL($_USER['email']))
	{
		define('IS_USER',1);
		define('IS_VISITOR',0);
	}
	else
	{
		define('IS_USER',0);
		define('IS_VISITOR',1);
	}
}

if (IS_TEMP)
{
	define('_TEMP',$_SESSION['CORE_APPSTATE_TEMP']);
	if (in_array('User_tb',JSP_FETCH_TABLES()))
		$GLOBALS['_TEMP'] = _BYID(JSP_TABLE_USER,_TEMP);
	else
		$GLOBALS['_TEMP'] = _BYID(JSP_TABLE_ADMIN,_TEMP);
	$_TEMP = $GLOBALS['_TEMP'];	
}

if (IS_HISTORY_ADMIN)
	define('_HISTORY_ADMIN',$_SESSION['CORE_HISTORY_ADMIN']);
if (IS_HISTORY_USER)
	define('_HISTORY_USER',$_SESSION['CORE_HISTORY_USER']);
if (IS_HISTORY_TEMP)
	define('_HISTORY_TEMP',$_SESSION['CORE_HISTORY_TEMP']);		

if (IS_LOGOUT)
{
	$endSession = $_GET['session'];
	$goToPage = $_GET['page'];
	if (!IS_LOCALHOST && (JSP_SORT_GATE($endSession,'CORE_APPSTATE_ADMIN,CAA','OR')))
		$goToPage = JSP_BASE_SSQL.$goToPage;
	CORE_SESSION_CLEAR($endSession);
	_REDIR($goToPage);			
}

if (IS_ILOGOUT)
{
	$endSession = $_GET['session'];
	$goToPage = $_GET['page'];
	$switchTo = $_GET['CAT'];
	if (!IS_LOCALHOST && (JSP_SORT_GATE($endSession,'CORE_APPSTATE_ADMIN,CAA','OR')))
		$goToPage = JSP_BASE_SSQL.$goToPage;
	CORE_SESSION_CLEAR($endSession);
	CORE_SESSION_SET('CAT',$switchTo);
	_REDIR($goToPage);	
}

?>