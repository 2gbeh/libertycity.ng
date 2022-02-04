<?php
function PLY_LOGIC_MATCH ($PLAN, $USER, $STATUS)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$_U = PLY_CONFIG_MATCH($USER,'USER');	
	$_M = JSP_FETCH_AND($TABLE,'plan_id,status',array($PLAN,$STATUS),1);
	if (_THROW($_M))
	{
		$_M = JSP_BUILD_DIMARRAY($_M);
		//UPDATE MATCH
		$_M = JSP_CRUNCH_DIMARRAY($_M,'CURRENT');
		if ($_M['user_rid'] == $USER)
		{
			if (PLY_MATCH_TYPE == '200')
				_UPDATE($TABLE,'status',6,$_M['id']);
			if (PLY_MATCH_TYPE == '300')
				_UPDATE($TABLE,'status',8,$_M['id']);			
			return 1;
		}
		else
		{
			$fieldArray = 'matched,teller,status,date,time';
			$recArray = array($USER,'NULL',($_M['status'] + 1));
			_UPDATE($TABLE,$fieldArray,$recArray,$_M['id']);
	
			//UPDATE USER
			if (isset($_U['user_rid']) && $_U['plan_id'] == $PLAN && JSP_SORT_GATE($_U['status'],'6,8','NOT'))
			{
				$recArray = array($_M['user_rid'],'NULL',1);
				_UPDATE($TABLE,$fieldArray,$recArray,$_U['id']);
			}
			else
			{
				$entryArray = array($USER,$PLAN,$_M['user_rid'],'NULL',1);
				_CREATE($TABLE,$entryArray);
			}
			return 1;			
		}
	}
}

function PLY_LOGIC_COUNTDOWN ($USER)
{
	//RESOURCE
	$userArray = PLY_CONFIG_MATCH($USER,'USER');
	$JSP_CAL_MKHOUR = JSP_CAL_MKHOUR($userArray['date'],$userArray['time'],PLY_MATCH_TIME);
	return JSP_SPRY_COUNTDOWN($JSP_CAL_MKHOUR['DATE'],$JSP_CAL_MKHOUR['TIME']);
}

?>


