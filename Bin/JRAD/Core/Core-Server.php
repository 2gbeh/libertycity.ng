<?php
function CORE_SERVER_ADMIN ()
{
	$array = CORE_SERVER_LOG();
	return $array['CORE_SERVER_LOG_ADMIN'];
}

function CORE_SERVER_USER ()
{
	$array = CORE_SERVER_LOG();
	return $array['CORE_SERVER_LOG_USER'];
}

function CORE_SERVER_TEMP ()
{
	$array = CORE_SERVER_LOG();
	return $array['CORE_SERVER_LOG_TEMP'];
}

function CORE_SERVER_LOG ()
{
	
	$keyArray = array('ADMIN','USER','TEMP');
	foreach ($keyArray as $pointer => $value)
	{
		if ($pointer == 0)
		{
			$CORE_SERVER_LOG = array
			(
				"IS_ADMIN" => IS_ADMIN,
				"_ADMIN" => _ADMIN,
				"IS_SUPER_ADMIN" => IS_SUPER_ADMIN,
				"IS_HISTORY_ADMIN" => IS_HISTORY_ADMIN,
				"_HISTORY_ADMIN" => _HISTORY_ADMIN,
				"GLOBALS[_ADMIN]" => $GLOBALS['_ADMIN']				
			);
		}
		if ($pointer == 1)
		{
			$CORE_SERVER_LOG = array
			(
				"IS_USER" => IS_USER,
				"_USER" => _USER,
				"IS_SUPER_USER" => IS_SUPER_USER,
				"IS_HISTORY_USER" => IS_HISTORY_USER,
				"_HISTORY_USER" => _HISTORY_USER,
				"GLOBALS[_USER]" => $GLOBALS['_USER']
			);
		}
		if ($pointer == 2)
		{
			$CORE_SERVER_LOG = array
			(
				"IS_TEMP" => IS_TEMP,
				"_TEMP" => _TEMP,
				"IS_HISTORY_TEMP" => IS_HISTORY_TEMP,
				"_HISTORY_TEMP" => _HISTORY_TEMP,				
				"GLOBALS[_TEMP]" => $GLOBALS['_TEMP']
			);
		}		
		$newArray['CORE_SERVER_LOG_'.$value] = $CORE_SERVER_LOG;
	}
	return $newArray;
}

?>
