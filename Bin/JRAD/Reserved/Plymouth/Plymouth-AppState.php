<?php
if (!PLY_MATCH_STATUS)
{
	$PLY_APPSTATE_STATUS = 'No match available at this time please try again later.';
	$PLY_APPSTATE_NOTE = 'System countdown unavailable.';
	$PLY_APPSTATE_MATCH = JSP_DISPLAY_BLOCK;
}

if (PLY_MATCH_STATUS == 1)
{
	$PLY_APPSTATE_STATUS = 'You have been matched to make an investment to the account provided below;';
	$PLY_APPSTATE_NOTE = 'You have '.PLY_MATCH_TIME.' hours to invest and upload your teller or else your account will be blocked.';
	$PLY_APPSTATE_TIMER	= true;
	$PLY_APPSTATE_COUNTDOWN = JSP_DISPLAY_INLINE;
	$PLY_APPSTATE_TABLE = JSP_DISPLAY_BLOCK;
	$PLY_APPSTATE_PH = JSP_DISPLAY_BLOCK;
}

if (JSP_SORT_GATE(PLY_MATCH_STATUS,'2,4,6','OR'))
{
	$PLY_APPSTATE_STATUS = 'Investment confirmed. Waiting to be matched.';
	$PLY_APPSTATE_NOTE = 'You will be matched to recieve an investment within 48 hours.';
}

if (JSP_SORT_GATE(PLY_MATCH_STATUS,'3,5,7','OR'))
{
	$PLY_APPSTATE_STATUS = 'You have been matched to recieve an investment from the account provided below;';
	$PLY_APPSTATE_NOTE = 'You have '.PLY_MATCH_TIME.' hours to confirm this transaction or else your account will be blocked.';
	$PLY_APPSTATE_TIMER	= true;	
	$PLY_APPSTATE_COUNTDOWN = JSP_DISPLAY_INLINE;
	$PLY_APPSTATE_TABLE = JSP_DISPLAY_BLOCK;
	$PLY_APPSTATE_GH = JSP_DISPLAY_BLOCK;
}

if (JSP_SORT_GATE(PLY_MATCH_STATUS,'1,3,5,7','OR'))
{
	$_U = PLY_CONFIG_MATCH(_USER,'USER');
	$_M = PLY_CONFIG_MATCH(_USER,'MATCH');
	if 
	(
		!_VALID(JSP_TABLE_USER,$_U['matched']) || //MATCH DOESN'T EXIST OR ZERO
		$_U['matched'] == _USER || //MATCH TO ONESELF
		$_M['matched'] != _USER //MATCH NOT MATCHED TO YOU
	)
	{
		_ROLLBACK(PLY_TABLE_MATCH,$_U['id']);
		_REDIR(PLY_PAGE_DASHBOARD);		
	}
}

if 
(
	(PLY_MATCH_TYPE == '200' && PLY_MATCH_STATUS == 6) || 
	(PLY_MATCH_TYPE == '300' && PLY_MATCH_STATUS == 8)
)
{
	$PLY_APPSTATE_STATUS = 'Investment confirmed. You have completed your bidding cycle. No match available at this time please try again later.';
	$PLY_APPSTATE_NOTE = 'You have '.PLY_MATCH_TIME.' hours to re-invest or else your account will be blocked.';
	$PLY_APPSTATE_TIMER	= true;	
	$PLY_APPSTATE_COUNTDOWN = JSP_DISPLAY_INLINE;
	$PLY_APPSTATE_MATCH = JSP_DISPLAY_BLOCK;
}

if (PLY_MATCH_TYPE == '200' && PLY_MATCH_STATUS > 6 && PLY_MATCH_STATUS != 9)
{
	_UPDATE(PLY_TABLE_MATCH,'status',6,PLY_MATCH_ID);
	_REDIR(PLY_PAGE_DASHBOARD);
}

if (PLY_MATCH_TYPE == '300' && PLY_MATCH_STATUS > 8 && PLY_MATCH_STATUS != 9)
{
	_UPDATE(PLY_TABLE_MATCH,'status',8,PLY_MATCH_ID);
	_REDIR(PLY_PAGE_DASHBOARD);
}

if (PLY_MATCH_STATUS == 9)
{
	$PLY_APPSTATE_STATUS = 'Sorry your account has been suspended due to system time-out or your account has been reported by an investor. Kindly visit our <a href="Dashboard-Support.php" class="under">Help Desk</a> to rectify this problem.';
	$PLY_APPSTATE_NOTE = 'System countdown unavailable.';
}

?>
