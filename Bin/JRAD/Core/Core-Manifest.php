<?php
//MySQL, MySQLi, PDO
define('APPNAME','Libertycity Nigeria');
define('ALIAS','Libertycity');
define('ABBR','LC');
define('TYPE','Entertainment and Consumer Services');
define('ABOUT', APPNAME.' is an internet company that provides personalised content in entertainment and consumer services for startups and small businesses.');
define('VISION','To become Nigeria\'s leading provider of online entertainment and consumer services.');
define('MISSION',VISION);
define('SLOGAN','Monster Open Season');
define('COY',APPNAME);
define('MASTHEAD','&copy; 2017 '.COY);

define('DOMAIN','libertycity.ng');
//if (strlen(JSP_BUTCHER_STR(DOMAIN,'.','RIGHT')) >= 8)
//	define('PSEUDO',substr(DOMAIN,0,8));
//else
//	define('PSEUDO',JSP_BUTCHER_STR(DOMAIN,'.','RIGHT'));
define('PSEUDO','liberty4');	
define('SERVER','http://www.'.DOMAIN.'/');
define('EMAIL','contact@'.DOMAIN);
define('MAILTO','<a href="mailto:'.EMAIL.'?Subject=Prospective%20Customer" target="_new">'.EMAIL.'</a>');
define('TEL','+234(0) 81 6996 0927');
define('LANDING','home.php');

define('LOGO','<img src="Media/Icon/Logo.png" alt="'.APPNAME.'" width="50" />');
define('TYPEFACE',APPNAME);
define('SIGNAGE','<a href="'.LANDING.'">'.LOGO.' '.TYPEFACE.'</a>');


define('HEX_PRI','#0093DD');
define('HEX_SEC','#007BB8');
define('HEX_ALT','#75C5F0');

define('REP_NAME','Tugbeh Emmanuel');
define('REP_EMAIL','tugbeh.osaretin@gmail.com');
define('REP_TEL','08117390235');

define('META_COPY',"Copyright &copy; ".MASTHEAD);
define('META_INTRO','It\'s that one thing.');
define('META_DESC','Discover personalised content in entertainment and consumer services for startups and small businesses. Only on Libertycity.');
define('META_KEYWORD','News,Square,Sports,Movies,Music,Advertise,B2B,Courses,Classified,Directory,Translate,Social,Play');
define('META_AUTHOR',REP_NAME);

define('STDIO','jRAD');
define('CMS','SlingshotSQL 4.0');
define('API','Dragonfly');

define('INITIAL','2017/07/25');
define('STABLE',INITIAL);
define('REVISED',JSP_DATE_SHORT);

function CORE_MANIFEST ()
{
	$keyArray = array
	(
		'APPNAME','ALIAS','ABBR','TYPE','ABOUT','VISION','MISSION','SLOGAN','COY','MASTHEAD',
		'DOMAIN','PSEUDO','SERVER','EMAIL','MAILTO','TEL','LANDING',		
		'LOGO','TYPEFACE','SIGNAGE','HEX_PRI','HEX_SEC','HEX_ALT',
		'REP_NAME','REP_EMAIL','REP_TEL',
		'META_COPY','META_INTRO','META_DESC','META_KEYWORD','META_AUTHOR',		
		'STDIO','CMS','API',
		'INITIAL','STABLE','REVISED'
	);
	$fnArray = array
	(
		APPNAME,ALIAS,ABBR,TYPE,ABOUT,VISION,MISSION,SLOGAN,COY,MASTHEAD,
		DOMAIN,PSEUDO,SERVER,EMAIL,MAILTO,TEL,LANDING,		
		LOGO,TYPEFACE,SIGNAGE,HEX_PRI,HEX_SEC,HEX_ALT,
		REP_NAME,REP_EMAIL,REP_TEL,		
		META_COPY,META_INTRO,META_DESC,META_KEYWORD,META_AUTHOR,		
		STDIO,CMS,API,
		INITIAL,STABLE,REVISED
	);
	foreach ($keyArray as $key => $value)
		$newArray[$value] = $fnArray[$key];
	return $newArray;
}
?>