 <?php
function JSP_GLOBAL_FIELDS ($type = 'all')
{
	$fieldArray = array 
	(
		'all' => array('id','device','ip','page','date','time','status','access','control','tags','assoc_id'),
		'default' => array(0,4,5,6),
		'account' => array(0,2,4,5,6,7),
		'records' => array(0,4,5,6,9,10),
		'activity' => array(0,1,2,3,4,5,6,8,10)
	);
	$fieldKeys = array_keys($fieldArray);
	$paramArray = array($type);	
	$parseArray = $fieldKeys;
	$parseArray[] = 'all';	
	$parseArray[] = 'map';	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type) || is_numeric($type))
		return JSPIP;				
	else
	{
		if ($type == 'map')
		{
			foreach ($fieldKeys as $keyIndex => $keyName)
			{
				if ($keyIndex != 0)
				{
					foreach ($fieldArray[$keyName] as $mockid)
						$newArray[$keyName][$mockid] = $fieldArray['all'][$mockid];
				}
			}
		}
		else if ($type == 'all')
		{
			$newArray = $fieldArray[$type];			
		}
		else
		{
			foreach ($fieldArray[$type] as $mockid)
				$newArray[$mockid] = $fieldArray['all'][$mockid];
		}
		return $newArray;		
	}
}

function JSP_GLOBAL_RECORDS ($field = 'map', $value = 'all')
{
	$recordArray = array 
	(
		'status' => array ('default','verified','subscribed','premium','disabled','archived'),
		'access' => array ('global','user','admin'),
		'control' => array ('explorer','recon','veteran'),
		'package' => array ('economy','startup','deluxe','unicorn')
	);
	$recordKeys = array_keys($recordArray);	
	$paramArray = array($field,JSP_TRUEPUT($value));	
	$parseArray = $recordKeys;
	$parseArray[] = 'map';
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$field))
		return JSPIP;	
	else 
	{
		if ($field == 'map')
		{
			if ($value == 'all')
				return $recordArray;
			else if ($value == 'fields')
				return $recordKeys;				
			else if (in_array($value,$recordKeys))
				return $recordArray[$value];
			else
				return JSPON;
		}
		else
		{
			if (!is_numeric($value))
			{
				if (in_array($value,$recordArray[$field]))
					return array_search($value,$recordArray[$field]);
				else
					return JSPON;
			}
			else
			{
				if ($value >= count($recordArray[$field]))
					return JSPIL;
				else
					return $recordArray[$field][$value];
			}
		}
	}
}
?>






