<?php
function DRA_ENUMS_TABLE ()
{
	return JSP_FETCH_TABLES();
}

function DRA_ENUMS_SWISS ($param = 'APPS', $parse)
{
	$parseArray = array('APPS','MANTRA','TOPIC','BUSINESS');

	if ($param == $parseArray[0])
		$array = array('news','square','sports','movies','music','social','my libertycity');
	else if ($param == $parseArray[1])
		$array = array('stories','brands','players','actors','songs','events','apps');
	else if ($param == $parseArray[2])
		$array = array('politics','entertainment','business','technology');
	else if ($param == $parseArray[3])
		$array = array('software','design','business','legal','marketing','financial'/*,'labour','supply &amp; distribution','mobility'*/);
				
	if (is_numeric($parse))
		return $array[$parse];
	else
		return $array;
}

function DRA_ENUMS_MANTRA ($param) 
{
	$appsArray = JSP_BUILD_CASE(DRA_ENUMS_SWISS());
	$mantraArray = DRA_ENUMS_SWISS('MANTRA');	
	foreach ($appsArray as $key => $value)
		$map[$value] = $mantraArray[$key];
	if (in_array($param,$appsArray))
		return 'All the '.$map[$param].' you love';
}


?>



