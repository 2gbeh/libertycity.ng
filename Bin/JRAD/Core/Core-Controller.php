<?php
function CORE_CONTROL_ADMIN ($page)
{
	if (!IS_LOCALHOST)
		$page = JSP_BASE_SSQL.$page; #Bin/SlingshotSQL/Home.php
	if (!JSP_SSQL_APPSTATE(array(JSP_TABLE_ADMIN,'control',2),_ADMIN))
		_REDIR($page,JSPER,JSP_ERROR_PAGE);
}

function CORE_ACCESS_ADMIN ($page)
{
	if (!IS_ADMIN || !_VALID(JSP_TABLE_ADMIN,_ADMIN) || _DISABLED(JSP_TABLE_ADMIN,_ADMIN))
	{
		$url = 'Login.php';	
		if (!IS_LOCALHOST)
		{
			$page = JSP_BASE_SSQL.$page; #Bin/SlingshotSQL/Home.php
			$url = JSP_BASE_SSQL.$url; #Bin/SlingshotSQL/Login.php
		}
		_SET('CHA',$page);
		_REDIR($url,JSPER,'Login to access Admin Portal.');
	}
}

function CORE_ACCESS_USER ($page)
{
	if (!IS_USER || !_VALID(JSP_TABLE_USER,_USER) || _DISABLED(JSP_TABLE_USER,_USER))
	{
		_SET('CHU',$page);		
		_REDIR('Login.php',JSPER,'Login to access Dashboard.');
	}
}

function CORE_ACCESS_DENY ($page, $message)
{
	if (!isset($page))
		$page = $_SERVER['SERVER_NAME'];
	if (isset($message))
		_REDIR($page,JSPER,$message);	
	else
		_REDIR($page);
}

function CORE_ACCESS_SUSPEND ($directory = '*')
{
	$exception = 'Shell';
	$http = JSP_PAGE_HTTP."://";
	$domain = JSP_PAGE_DOMAIN."/";
	$root = JSP_PAGE_ROOT;
	$destination = "Bin/Landing/Suspend.html";
	
	if (IS_LOCALHOST)
	{		
		echo "
		<script type='text/javascript'>
			var _current = window.location.href;
			var _localhost = _current.split('".$root."')[0];
			var	_root = _localhost + '".$root."';
			var _url = _root + '".$destination."';
		";
		if ($directory == '*')
		{
			
			foreach (_CSV($exception) as $each)
			{
				$x = ''.$each.'';
				echo "
				var _result = _current.search('".$x."');
				if (_result == '-1') //not found
					window.location.href = _url;
				";
			}
		}
		else
		{
			foreach (_CSV($directory) as $each)
			{
				$x = '/'.$each.'/';				
				echo "
				var _result = _current.search('".$x."');
				if (_result > '-1') //found
					window.location.href = _url;
				";
			}
		}
		echo "</script>";
			
	}
	else
	{
		echo "
		<script type='text/javascript'>
			var _current = window.location.href;		
			var _shell = _current.search('".$shell."');
			var _ssql = _current.search('".$ssql."');		
			var _url = '".$http."' + '".$domain."' + '".$destination."';
			if (_shell == '-1' && _ssql == '-1')
				window.location.href = _url;
		</script>";
	}
}

?>