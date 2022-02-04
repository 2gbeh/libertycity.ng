<?php
function CORE_SWISS_RETURN ($former, $latter, $returnType = 'LOCALHOST')
{
	if ($returnType == 'LOCALHOST')
	{
		if (IS_LOCALHOST)
			return $former;
		else
			return $latter;
	}
	if ($returnType == 'ADMIN')
	{
		if (IS_ADMIN)
			return $former;
		else
			return $latter;
	}
	if ($returnType == 'USER')
	{
		if (IS_USER)
			return $former;
		else
			return $latter;
	}
	if ($returnType == 'ISSET')
	{
		if (isset($former))
			return $latter;
	}
	if ($returnType == '!ISSET')
	{
		if (!isset($former))
			return $latter;
		else
			return $former;
	}		
	if ($returnType == 'PREFIX')
	{
		$strlen = strlen($latter);
		$substr = substr($former,0,$strlen);
		if ($substr == $latter)
			return $former;
		else
			return $latter.$former;
	}	
	if ($returnType == 'SUFFIX')
	{
		$strlen = strlen($latter);
		$substr = substr($former,-$strlen);
		if ($substr == $latter)
			return $former;
		else
			return $former.$latter;
	}
	if ($returnType == 'THROW')
	{
		if (_THROW($former))
			return $former;
		else
			return $latter;
	}	
}

?>