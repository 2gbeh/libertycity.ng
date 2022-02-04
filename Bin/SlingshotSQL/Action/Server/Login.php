<?php
$TABLE = JSP_TABLE_ADMIN;
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{	
	$_FILTER = _FILTER($_POST);
	$entryArray = array($_FILTER['username'],$_FILTER['password']);
	$JSP_SSQL_SIGNIN = JSP_SSQL_SIGNIN($TABLE,'username,password',$entryArray);	
	if (!JSP_ERROR_CATCH($JSP_SSQL_SIGNIN))
	{
		if (_DISABLED($TABLE,$JSP_SSQL_SIGNIN))
			$err = JSP_ERROR_ACCOUNT;
		else
		{
			_KEYLOG($TABLE,$JSP_SSQL_SIGNIN);
			_IPLOG(JSP_TABLE_TEAM,array('username',$_FILTER['username']));
			_SET('CAA',$JSP_SSQL_SIGNIN);
			_CLEAR('CAT');
			if (IS_HISTORY_ADMIN)
				_REDIR(_HISTORY_ADMIN);
			else
			{
				$L_BASE = SLI_PAGE_LANDING;
				$R_BASE = JSP_BASE_SSQL.$L_BASE;
				_REDIR(_SWISS($L_BASE,$R_BASE,'LOCALHOST'));
			}
		}
	}
	else if ($JSP_SSQL_SIGNIN == JSPON)
		$err = '!User ID not found.';
	else if ($JSP_SSQL_SIGNIN == JSPIL)
		$err = '!Password does not match.';	
	else
		$err = '!'.$JSP_SSQL_SIGNIN;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if (IS_TEMP)
	{
		$row = _BYID(JSP_TABLE_ADMIN,_TEMP);
		if ($row['control'] == 2)
			$src = '../../Media/Icon/Logo-Lbs.png';		
		else
			$src = '../../Media/Icon/Logo.png';
		$JSP_SPRY_PROFILE = JSP_SPRY_PROFILE($src,'100px','CIRCLE');
		$_POST['username'] = $row['username']; 
	}
}
?>











