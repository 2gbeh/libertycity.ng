<?php
function JSP_CTRL_LANG ($entry, $controlType = 'CENSOR')
{
	$paramArray = array($entry,$controlType);	
	$parseArray = array('CENSOR','FILTER','BLOCK');		
	if (JSP_PARAM_FORMAT($paramArray))
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$controlType))
		return JSPIP;		
	else
	{
		$entryArray = JSP_BUILD_ARRAY($entry,' ');
		foreach ($entryArray as $key => $value)
		{
			$JSP_SORT_MATCH = JSP_SORT_MATCH(JSP_CTRL_LANG_SCANNER(),JSP_DROP_CASE($value),'VALUE');
			if (!JSP_ERROR_CATCH($JSP_SORT_MATCH))
			{
				if ($controlType == $parseArray[0]) //CENSOR
					$entryArray[$key] = '<span class="censor">'.$value.'</span>';
				else if ($controlType == $parseArray[1]) //FILTER
					$entryArray[$key] = '';				
				else
					return 1;
			}
		}
		return JSP_DROP_ARRAY($entryArray,' ');
	}
}

function JSP_CTRL_LANG_SCANNER ()
{
	return array
	(
		'shit',
		'shit!',
		'af',
		'af!',
		'fuck',
		'fuck!',		
		'fucks',		
		'fucking',
		'fucked',
		'fucker',
		'fucker!',		
		'fuckboy',
		'fuckoff',
		'fuckoff!',				
		'bs',
		'bs!',		
		'bullshit',
		'bullshit!',		
		'pussy',
		'toto',
		'tits',
		'boob',		
		'boobs',
		'tities',
		'titties',		
		'dick',
		'dick!',	
		'cock',	
		'balls',			
		'blowjob',				
		'bitch',
		'bitch!',
		'ashawo',		
		'ashewo',				
		'whore',
		'hooker',
		'hoe',		
		'slut',				
		'slut!',
		'cunt',				
		'cunt!',										
		'ass',		
		'ass!',
		'nyash',
		'yash',
		'asshole',
		'sucker',
		'bastard',
		'bastard!',		
		'crack',		
		'dope',
		'piss',
		'pissoff',		
		'pissed',
		'pissed!',
		'boner',
		'stoned',
		'pube',
		'wank',
		'jerkoff'
	);
}
?>

