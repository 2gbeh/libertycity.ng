<?php
//GLOB VAR
$TABLE = JSP_TABLE_USER;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{	
	if ($_POST['ITABLE_SELECT_VALUE'])	
	{
		foreach ($_POST['ITABLE_SELECT_VALUE'] as $id)
			_DELETE($TABLE,$id);
		$err = 'Records deleted.';
	}
}
?>