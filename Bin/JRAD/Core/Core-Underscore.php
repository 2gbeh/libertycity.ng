<?php
function _SET ($key, $value)
{
	CORE_SESSION_SET($key,$value);
}

function _GET ($key)
{
	return CORE_SESSION_GET($key);
}

function _CLEAR ($key)
{
	CORE_SESSION_CLEAR($key);
}

function _DROP ($header)
{
	CORE_SESSION_DROP($header);
}

function _LOG ()
{
	return CORE_APPSTATE_LOG ();
}

function _SWISS ($former, $latter, $returnType)
{
	return CORE_SWISS_RETURN($former,$latter,$returnType);
}

?>



