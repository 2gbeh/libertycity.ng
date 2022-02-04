<?php
function IS_LOCALHOST ()
{
	if ($_SERVER['SERVER_NAME'] == 'localhost')
		return 1;
}

function IS_POSTBACK ($prikey = 'id')
{
	if (isset($_POST[$prikey]))
		return $_POST[$prikey];
}

function IS_FILEBACK ($name = 'image')
{
	$file = $_FILES[$name]['name'];
	if (strlen($file) > 4 && JSP_FILE_ISFILE($file))
		return $_FILES[$name]['name'];
}

function IS_RFID ()
{
	if ($_REQUEST['RFID'] === '0')
		return "zero";
	else
	{	
		if (isset($_REQUEST['RFID']))
			return $_REQUEST['RFID'];
	}
}

function IS_ERROR ()
{
	if (isset($_REQUEST[JSPER]))
		return $_REQUEST[JSPER];
}

function JSP_PAGE_LOOP ()
{
	$_SESSION['JSP_PAGE_LOOP']++;
	return $_SESSION['JSP_PAGE_LOOP'];
}

function JSP_PAGE_ROOT ()
{
	if (IS_LOCALHOST)
	{
		$serverArray = JSP_BUILD_STR($_SERVER['PHP_SELF']);
		$septorArray = JSP_SORT_MATCH($serverArray,'/','VALUE');
		$septorKey = array_keys($septorArray);
		$hotkey = $septorKey[1];
		foreach ($serverArray as $key => $value)
		{
			if ($key > 0 && $key <= $hotkey)
			{
				$string .= $value;
			}
		}
	}
	else
	{
		$string = $_SERVER['DOCUMENT_ROOT'].'/';		
		$string = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/";	
		$string = '/';
	}
	return $string;
}

function JSP_PAGE_FILE ()
{
	$url = JSP_BUTCHER_STR($_SERVER['PHP_SELF'],'/','LEFT');
	$file = JSP_BUTCHER_STR($url,'?','RIGHT');	
	return $file;
}

function JSP_PAGE_NAME ()
{
	$url = JSP_BUTCHER_STR($_SERVER['PHP_SELF'],'/','LEFT');
	$file = JSP_BUTCHER_STR($url,'.','RIGHT');	
	return $file;
}

function JSP_FORM_POST ()
{
	$pageUrl = htmlspecialchars($_SERVER['PHP_SELF']);
	$formAttribute = "action = '$pageUrl' method = 'POST' autocomplete = 'off'";
	return $formAttribute;
}

function JSP_FORM_GET ()
{
	$pageUrl = htmlspecialchars($_SERVER['PHP_SELF']);
	$formAttribute = "action = '$pageUrl' method = 'GET' autocomplete = 'off'";
	return $formAttribute;
}

function JSP_FORM_FILE ()
{
	$pageUrl = htmlspecialchars($_SERVER['PHP_SELF']);
	$formAttribute = "action = '$pageUrl' method = 'POST' autocomplete = 'off'  enctype = 'multipart/form-data'";
	return $formAttribute;
}


?>






