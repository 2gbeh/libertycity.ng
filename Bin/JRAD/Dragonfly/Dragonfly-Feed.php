<?php
function DRA_FEED_FETCH ($table)
{
	$recArray = JSP_FETCH_RECORDS($table);
	$feedArray = JSP_FETCH_APPFIELD($table,$recArray);
	return $feedArray;
}

function DRA_FEED_INVERT ($array)
{
	return JSP_INVERT_ARRAY($array);
}

function DRA_FEED_LIMIT ($array, $limit)
{
	$counter = 0;
	foreach ($array as $key => $value)
	{
		if ($counter < $limit)
			$newArray[$key] = $value;
		$counter++;
	}
	return $newArray;
}
?>