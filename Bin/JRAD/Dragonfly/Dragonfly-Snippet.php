<?php
function DRA_CRUNCH_CRT ($entry)
{
	if (_THROW($entry))
		$crt = ucwords($entry);
	else
		$crt = 'Libertycity AP';
	return $crt;
}

function DRA_LOOP_MANTRA ()
{
	return '<span class="DRA_LOOP_MANTRA hidden" CURRENT="0">'.JSP_DISPLAY_LIST(DRA_ENUMS_SWISS('MANTRA')).'</span>';
}

function DRA_LOOP_OTIS ()
{
	return '<span class="DRA_LOOP_OTIS hidden" CURRENT="0" END="920920"></span>';
}

function DRA_DISPLAY_ILIST ($labelArray, $anchorArray = array(), $selected = 0) 
{
	if ($selected && $selected > 3)
	{
		$scroll = JSP_SORT_SCROLL($selected);
		if (_THROW($labelArray))
			$labelArray = DRA_DISPLAY_ILIST_SCANNER($labelArray,$scroll['BY']);
		if (_THROW($anchorArray))
			$anchorArray = DRA_DISPLAY_ILIST_SCANNER($anchorArray,$scroll['BY']);
		$selected = $scroll['TO'];
	}
		
//	return array($labelArray,$anchorArray,$selected);
	return JSP_DISPLAY_ILIST($labelArray,$anchorArray,$selected);
}

function DRA_DISPLAY_ILIST_SCANNER ($array, $lock) 
{
	$pointer = 1;
	foreach (_CSV($array) as $key => $value)
	{
		if ($pointer >= $lock)
			$firstArray[$key] = $value;
		else
			$secondArray[$key] = $value;			
		$pointer++;
	}
	if ($firstArray && $secondArray)
		$newArray = array_merge($firstArray,$secondArray);
	else
		$newArray = $firstArray;
	return $newArray;
}

?>




