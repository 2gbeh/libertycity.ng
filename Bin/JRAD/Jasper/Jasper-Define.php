<?php
/* CALL JSP_DICTIONARY() TO SEE ALL */
function JSP_DEFINE ()
{
	$keyArray = array
	(
		'JSPIF','JSPIP','JSPIL','JSPON','JSPAS','JSPER',
		'IS_LOCALHOST','IS_POSTBACK','IS_FILEBACK','IS_RFID','IS_ERROR',
		'JSP_ERROR_ACCOUNT','JSP_ERROR_FILE','JSP_ERROR_FOLDER','JSP_ERROR_MAIL','JSP_ERROR_PAGE','JSP_ERROR_SERVICE',
		'JSP_PAGE_URL','JSP_PAGE_HTTP','JSP_PAGE_DOMAIN','JSP_PAGE_ROOT','JSP_PAGE_FILE','JSP_PAGE_NAME','JSP_PAGE_LOOP',
		'JSP_FORM_POST','JSP_FORM_GET','JSP_FORM_FILE',
		'JSP_TIME_PRESET','JSP_TIME_LONG','JSP_TIME_SHORT','JSP_TIME_EVENT',
		'JSP_DATE_PRESET','JSP_DATE_LONG','JSP_DATE_SHORT','JSP_DATE_EVENT',
		'JSP_DATE_STAMP','JSP_DATE_FORMAL','JSP_DATE_LBS','JSP_DATE_METRO','JSP_DATE_TELLER','JSP_DATE_FEED','JSP_DATE_ETA','JSP_DATE_ESSAY',
		'JSP_SUPER_ADMIN','JSP_SUPER_USER','JSP_SUPER_PASSWORD','JSP_SSQL_USER','JSP_SSQL_PASSWORD',
		'JSP_TABLE_ADMIN','JSP_TABLE_USER','JSP_TABLE_TEAM','JSP_TABLE_ALBUM','JSP_TABLE_SLIDE','JSP_TABLE_GALLERY','JSP_TABLE_EVENT','JSP_TABLE_PDF','JSP_TABLE_VIDEO','JSP_TABLE_UPLOADS','JSP_TABLE_KEYLOG','JSP_TABLE_VISITOR','JSP_TABLE_OTIS',
		'JSP_GLOB_NULL','JSP_GLOB_FIELD','JSP_GLOB_RECORD',
		'JSP_DISPLAY_BLOCK','JSP_DISPLAY_INLINE','JSP_DISPLAY_NONE',
		'JSP_BASE_SHELL','JSP_BASE_SSQL','JSP_BASE_IMAGE','JSP_BASE_SLIDE','JSP_BASE_GALLERY','JSP_BASE_EVENT','JSP_BASE_LOGO','JSP_BASE_VIDEO','JSP_BASE_UPLOADS',
		'JSP_IMAGE_PRESET','JSP_IMAGE_STAMP'
	);
	$fnArray = array
	(
		JSPIF,JSPIP,JSPIL,JSPON,JSPAS,JSPER,
		IS_LOCALHOST,IS_POSTBACK,IS_FILEBACK,IS_RFID,IS_ERROR,
		JSP_ERROR_ACCOUNT,JSP_ERROR_FILE,JSP_ERROR_FOLDER,JSP_ERROR_MAIL,JSP_ERROR_PAGE,JSP_ERROR_SERVICE,		
		JSP_PAGE_URL,JSP_PAGE_HTTP,JSP_PAGE_DOMAIN,JSP_PAGE_ROOT,JSP_PAGE_FILE,JSP_PAGE_NAME,JSP_PAGE_LOOP,
		JSP_FORM_POST,JSP_FORM_GET,JSP_FORM_FILE,
		JSP_TIME_PRESET,JSP_TIME_LONG,JSP_TIME_SHORT,JSP_TIME_EVENT,
		JSP_DATE_PRESET,JSP_DATE_LONG,JSP_DATE_SHORT,JSP_DATE_EVENT,
		JSP_DATE_STAMP,JSP_DATE_FORMAL,JSP_DATE_LBS,JSP_DATE_METRO,JSP_DATE_TELLER,JSP_DATE_FEED,JSP_DATE_ETA,JSP_DATE_ESSAY,
		JSP_SUPER_ADMIN,JSP_SUPER_USER,JSP_SUPER_PASSWORD,JSP_SSQL_USER,JSP_SSQL_PASSWORD,
		JSP_TABLE_ADMIN,JSP_TABLE_USER,JSP_TABLE_TEAM,JSP_TABLE_ALBUM,JSP_TABLE_SLIDE,JSP_TABLE_GALLERY,JSP_TABLE_EVENT,JSP_TABLE_PDF,JSP_TABLE_VIDEO,JSP_TABLE_UPLOADS,JSP_TABLE_KEYLOG,JSP_TABLE_VISITOR,JSP_TABLE_OTIS,
		JSP_GLOB_NULL,JSP_GLOB_FIELD,JSP_GLOB_RECORD,
		JSP_DISPLAY_BLOCK,JSP_DISPLAY_INLINE,JSP_DISPLAY_NONE,
		JSP_BASE_SHELL,JSP_BASE_SSQL,JSP_BASE_IMAGE,JSP_BASE_SLIDE,JSP_BASE_GALLERY,JSP_BASE_EVENT,JSP_BASE_LOGO,JSP_BASE_VIDEO,JSP_BASE_UPLOADS,
		JSP_IMAGE_PRESET,JSP_IMAGE_STAMP
	);
	foreach ($keyArray as $key => $value)
		$newArray[$value] = $fnArray[$key];
	return $newArray;
}

define('JSPIF', 'JSP_INVALID_FORMAT');
define('JSPIP', 'JSP_INVALID_PARSE');
define('JSPIL', 'JSP_INVALID_LOGIC');
define('JSPON', 'JSP_OBJECT_NOT_FOUND');
define('JSPAS', 'JSP_ACTIVE_SOURCE_LINE');
define('JSPER', 'JSP_DISPLAY_ERROR');

define('IS_LOCALHOST', IS_LOCALHOST());
define('IS_POSTBACK', IS_POSTBACK());
define('IS_FILEBACK', IS_FILEBACK());
define('IS_RFID', IS_RFID());
define('IS_ERROR', IS_ERROR());

define('JSP_ERROR_ACCOUNT', '!ACCOUNT ERROR: Account disabled, kindly contact service provider.');
define('JSP_ERROR_FILE', '!FILE ERROR: Image file not selected and/or unknown file extension.');
define('JSP_ERROR_FOLDER', '!FOLDER ERROR: Folder not found and/or folder path conflict.');
define('JSP_ERROR_MAIL', '!MAIL ERROR: Mail delivery failed, message cound not be delivered to one or more of its recipients.');
define('JSP_ERROR_PAGE', '!PAGE ERROR: Unauthorized page access, kindly contact service provider.');
define('JSP_ERROR_SERVICE', '#Service unavailable at this time.');

define('JSP_PAGE_URL', $_SERVER['PHP_SELF']);
define('JSP_PAGE_HTTP', $_SERVER['REQUEST_SCHEME']);
define('JSP_PAGE_DOMAIN', $_SERVER['HTTP_HOST']);
define('JSP_PAGE_ROOT', JSP_PAGE_ROOT());
define('JSP_PAGE_FILE', JSP_PAGE_FILE());
define('JSP_PAGE_NAME', JSP_PAGE_NAME());
define('JSP_PAGE_LOOP', JSP_PAGE_LOOP());

define('JSP_FORM_POST', JSP_FORM_POST());
define('JSP_FORM_GET', JSP_FORM_GET());
define('JSP_FORM_FILE', JSP_FORM_FILE());

define('JSP_TIME_PRESET', date('h:i A'));
define('JSP_TIME_LONG', date('H:i:s'));
define('JSP_TIME_SHORT', date('H:i'));
define('JSP_TIME_EVENT', date('g A'));

define('JSP_DATE_PRESET', date('F j, Y'));
define('JSP_DATE_LONG', date('Y/n/j/w/z'));
define('JSP_DATE_SHORT', date('Y/n/j'));
define('JSP_DATE_EVENT', date('l, jS \of F Y'));

define('JSP_DATE_STAMP', date('YmdHis'));
define('JSP_DATE_FORMAL', date('d/m/y'));
define('JSP_DATE_LBS', strtoupper(substr(date('D'),0,2)).date('dmy'));
define('JSP_DATE_METRO', date('l, F j, Y'));
define('JSP_DATE_TELLER', date('D, M d, Y'));
define('JSP_DATE_FEED', date('j M'));
define('JSP_DATE_ETA', date('Y/n/j H:i'));
define('JSP_DATE_ESSAY', date('l, F j, Y \a\t h:i A'));

define('JSP_SUPER_ADMIN', 'contact@hwplabs.com');
define('JSP_SUPER_USER', 'dehphantom@yahoo.com');
define('JSP_SUPER_PASSWORD', '_Strongp@ssw0rd');
define('JSP_SSQL_USER', 'admin-ssql');
define('JSP_SSQL_PASSWORD', '_Thatssqlb0y');

define('JSP_TABLE_ADMIN', 'admin_tb');
define('JSP_TABLE_USER', 'user_tb');
define('JSP_TABLE_TEAM', 'team_tb');
define('JSP_TABLE_ALBUM', 'album_tb');
define('JSP_TABLE_SLIDE', 'slide_tb');
define('JSP_TABLE_GALLERY', 'gallery_tb');
define('JSP_TABLE_EVENT', 'event_tb');
define('JSP_TABLE_PDF', 'pdf_tb');
define('JSP_TABLE_VIDEO', 'video_tb');
define('JSP_TABLE_UPLOADS', 'uploads_tb');
define('JSP_TABLE_KEYLOG', 'keylog_tb');
define('JSP_TABLE_VISITOR', 'visitor_tb');
define('JSP_TABLE_OTIS', 'otis_tb');

define('JSP_GLOB_NULL', 0);
define('JSP_GLOB_FIELD', 'date VARCHAR (16),time VARCHAR (8)');
define('JSP_GLOB_RECORD', JSP_DATE_LONG.','.JSP_TIME_LONG);

define('JSP_DISPLAY_BLOCK', 'style="display:block;"');
define('JSP_DISPLAY_INLINE', 'style="display:inline-block;"');
define('JSP_DISPLAY_NONE', 'style="display:none;"');

define('JSP_BASE_SHELL', 'Bin/Shell/');
define('JSP_BASE_SSQL', 'Bin/SlingshotSQL/');
define('JSP_BASE_IMAGE', JSP_PAGE_ROOT.'Media/Image/');
define('JSP_BASE_SLIDE', JSP_PAGE_ROOT.'Media/Image/Slide/');
define('JSP_BASE_GALLERY', JSP_PAGE_ROOT.'Media/Image/Gallery/');
define('JSP_BASE_EVENT', JSP_PAGE_ROOT.'Media/Image/Event/');
define('JSP_BASE_LOGO', JSP_PAGE_ROOT.'Media/Image/Logo/');
define('JSP_BASE_VIDEO', JSP_PAGE_ROOT.'Media/Video/');
define('JSP_BASE_UPLOADS', JSP_PAGE_ROOT.'Media/Uploads/');

define('JSP_IMAGE_PRESET', 'default.png');
define('JSP_IMAGE_STAMP', JSP_DATE_STAMP.'.png'); 	
?>
