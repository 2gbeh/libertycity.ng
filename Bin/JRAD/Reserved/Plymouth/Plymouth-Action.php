<?php
function PLY_ACTION_MATCH ($PLAN, $USER)
{
	if (PLY_MATCH_TYPE == '300')
	{
		if (!PLY_LOGIC_MATCH($PLAN,$USER,6))
		{
			if (!PLY_LOGIC_MATCH($PLAN,$USER,4))
			{
				if (!PLY_LOGIC_MATCH($PLAN,$USER,2))
					return 0;
			}
		}
	}
	else
	{
		if (!PLY_LOGIC_MATCH($PLAN,$USER,4))
		{
			if (!PLY_LOGIC_MATCH($PLAN,$USER,2))
				return 0;
		}		
	}	
}

function PLY_ACTION_FORFEIT ($USER)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$matchArray = PLY_CONFIG_MATCH($USER,'MATCH');
	if (JSP_SORT_GATE($matchArray['status'],'1,3,5,7','OR'))
		_ROLLBACK($TABLE,$matchArray['id']); //ROLLBACK MATCH
	PLY_ACTION_DELTEL($USER); //DELETE TELLER	
	PLY_ACTION_SUSPEND($USER); //SUSPEND USER
	_DISABLE(JSP_TABLE_USER,$USER); //DISABLE USER
}

function PLY_ACTION_UPLOAD ($FILE, $USER)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$userArray = PLY_CONFIG_MATCH($USER,'USER');	
	$matchArray = PLY_CONFIG_MATCH($USER,'MATCH');

	PLY_ACTION_DELTEL($USER); //DELETE PREV TELLER
	$JSP_FILE = JSP_FILE_UPLOAD($FILE,PLY_BASE_TELLER,1); //UPLOAD NEW TELLER
	if ($JSP_FILE[0] == 1)
	{
		_UPDATE($TABLE,'teller',$JSP_FILE[1],$userArray['id']); //UPDATE USER
		_UPDATE($TABLE,'teller',$JSP_FILE[1],$matchArray['id']); //UPDATE MATCH
	}
}

function PLY_ACTION_REPORT ($USER)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$_U = PLY_CONFIG_MATCH($USER,'USER');	
	PLY_ACTION_SUSPEND($_U['user_rid']); //SUSPEND USER
	PLY_ACTION_SUSPEND($_U['matched']);	//SUSPEND MATCH
}

function PLY_ACTION_CONFIRM ($USER)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$userArray = PLY_CONFIG_MATCH($USER,'USER');	
	$matchArray = PLY_CONFIG_MATCH($USER,'MATCH');	

	_ROLLFWD($TABLE,$userArray['id']); //UPDATE USER
	_ROLLFWD($TABLE,$matchArray['id']); //UPDATE MATCH
	PLY_ACTION_DELTEL($USER); //DELETE TELLER
}

function PLY_ACTION_SUSPEND ($USER)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$userArray = PLY_CONFIG_MATCH($USER,'USER');
	_CREATE(PLY_TABLE_SUSPEND,array($USER,$userArray['status'],_DATE,_TIME)); //RECORD SUSPENSION
	_UPDATE($TABLE,'status',9,$userArray['id']); //SUSPEND USER	
}

function PLY_ACTION_RESTORE ($USER)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$_U = PLY_CONFIG_MATCH($USER,'USER');	
	$_S = JSP_SSQL_LAST(PLY_TABLE_SUSPEND,'user_rid',$USER);
	$nStatus = $_S['status'];
			
	//ADJUST
	if ($_S['status'] == 1)
		$nStatus = 2;
	if (JSP_SORT_GATE($_S['status'],'3,5,7','OR'))
		$nStatus--;
		
	//REPAIR
	if (PLY_MATCH_TYPE == '200' && $nStatus > 6)
		$nStatus = 6;
	if (PLY_MATCH_TYPE == '300' && $nStatus > 8)
		$nStatus = 8;
	
	//UPDATE
	$fieldArray = array('matched','teller','status','date','time');
	$recArray = array('0','NULL',$nStatus,_DATE,_TIME);
	_UPDATE($TABLE,$fieldArray,$recArray,$_U['id']); //UPDATE USER
	JSP_CRUD_DELETE(PLY_TABLE_SUSPEND,array('user_rid',$USER,1)); //DELETE SUSPEND
	_RESTORE(JSP_TABLE_USER,$USER); //RESTORE USER
}

function PLY_ACTION_DELTEL ($USER)
{
	//RESOURCE
	$TABLE = PLY_TABLE_MATCH;
	$userArray = PLY_CONFIG_MATCH($USER,'USER');
	$matchArray = PLY_CONFIG_MATCH($USER,'MATCH');	
	
	_UPDATE($TABLE,'teller','NULL',$userArray['id']); //UPDATE USER
	_UPDATE($TABLE,'teller','NULL',$matchArray['id']); //UPDATE MATCH	
	JSP_FILE_DELETE(PLY_BASE_TELLER.$userArray['teller']); //DELETE TELLER		
	
}

function PLY_ACTION_DROP ($USER)
{
	PLY_ACTION_DELTEL($USER);
	JSP_CRUD_DELETE(PLY_TABLE_MATCH,array('user_rid',$USER,1));
	JSP_CRUD_UPDATE(PLY_TABLE_MATCH,'matched',0,array('matched',$USER,1));
	JSP_CRUD_DELETE(PLY_TABLE_REF,array('user_rid',$USER,1));
	JSP_CRUD_DELETE(PLY_TABLE_SUSPEND,array('user_rid',$USER,1));
	_DELETE(JSP_TABLE_USER,$USER);
}

function PLY_ACTION_RECYCLE ($USER)
{
	$userArray = PLY_CONFIG_MATCH($USER,'USER');
	$entryArray = array($USER,$userArray['plan_id'],0,'NULL',0,_DATE,_TIME);
	_CREATE(PLY_TABLE_MATCH,$entryArray);		
}

function PLY_ACTION_REPAIR ($USER)
{
	$userArray = PLY_CONFIG_MATCH($USER,'USER');
	_UPDATE(PLY_TABLE_MATCH,'status',9,$userArray['id']);
}
?>



