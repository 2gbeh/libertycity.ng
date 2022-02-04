<?php
function CORE_CONFIG_ARCHI ($returnType = 'BOOT')
{
	if ($returnType == 'BOOT')
	{
		$array = CORE_START();
		$SCHEMA = $array['SCHEMA']['FIELD'];
	}
	if ($returnType == 'LIVE')
	{
		$tableArray = JSP_FETCH_TABLES(_DB);
		foreach ($tableArray as $table)
			$SCHEMA[$table] = JSP_FETCH_TDESC($table);
	}
	if ($returnType == 'ARRAY')
		return JSP_FETCH_ALL(_DB);
	return array 
	(
		'DATABASE' => _DB,
		'ARCHI' => $SCHEMA
	);
}
?>

