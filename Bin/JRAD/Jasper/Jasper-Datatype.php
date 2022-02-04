<?php
function JSP_DTYPE_SCANNER ($array, $param)
{
	$parseArray = array('KEY','VALUE','MAP');
	if ($param == $parseArray[1]) //VALUE
		return JSP_REKEY_ARRAY($array);		
	else if ($param == $parseArray[2]) //MAP
		return $array;			
	else
		return array_keys($array);
}

function JSP_DTYPE_ALL ()
{
	return $dataArray = array
	(
		JSP_DTYPE_INT('MAP'),
		JSP_DTYPE_VARCHAR('MAP'),
		JSP_DTYPE_FILE('MAP'),
		JSP_DTYPE_LIST('MAP'),
		JSP_DTYPE_LONG('MAP'),
		JSP_DTYPE_DATE('MAP')
	);
}

function JSP_DTYPE_INT ($param)
{
	$array = array
	(		
		'yob' => '1992',
		'year' => '1992',
		'day' => 15,		
		'age' => date('Y') - 1992,
		'po_box' => '300283',		
		'postal_code' => '300283',
		'zip_code' => '300283',	
		'phone' => '08117390235',
		'pin' => '4444',
		'vercode' => '4444',
		'amount' => '2500',
		'cost' => '2500',		
		'acct_number' => '0131988214',
		'grad_yr' => '2014',
		'views' => 1992,
		'admin_rid' => 1,
		'user_rid' => 1,
	);
	return JSP_DTYPE_SCANNER($array,$param);
}

function JSP_DTYPE_VARCHAR ($param)
{
	$array = array
	(		
		'name' => 'Tugbeh Emmanuel Osaretin',	
		'firstname' => 'Emmanuel',
		'lastname' => 'Tugbeh',
		'middlename' => 'Osaretin',
		'lga' => 'Uhunmwode',
		'area' => 'Ugbowo',
		'address' => 'No. 39b Uwasota road, off Eagle Furniture junc, Ugbowo, B/c.',
		'email' => JSP_SUPER_USER,			
		'hq' => 'One Lbs way, Uwasota, BC 300283.',
		'venue' => 'One Lbs way, Uwasota, BC 300283.',
		'username' => '2gbeh',
		'userid' => '2gbeh',
		'password' => '4444',
		'topic' => 'Welcome to HWP Labs',
		'headline' => 'Welcome to HWP Labs',
		'title' => 'Welcome to HWP Labs',
		'subtitle' => 'Software Engineering and Business R&amp;D',
		'subject' => 'Software Engineering and Business R&amp;D',		
		'slogan' => JSP_FOOBAR_ARTICLE('SLOGAN'),
		'motto' => JSP_FOOBAR_ARTICLE('SLOGAN'),		
		'tagline' => JSP_FOOBAR_ARTICLE('SLOGAN'),
		'acct_name' => 'Tugbeh Emmanuel Osaretin',
		'narration' => JSP_FOOBAR_ARTICLE('INTRO'),
		'objective' => JSP_FOOBAR_ARTICLE('INTRO'),		
		'listing' => JSP_FOOBAR_ARTICLE('LISTING'),
		'skill' => JSP_FOOBAR_ARTICLE('LISTING'),
		'source' => 'Libertycity AP',		
		'event_venue' => 'One Lbs way, Uwasota, BC 300283.',
		'website' => 'http://www.hwplabs.com/',
		'link' => 'http://www.hwplabs.com/',
		'url' => 'http://www.hwplabs.com/',
		'school' => 'Benson Idahosa University',
		'course' => 'Computer Science',
		'degree' => 'B.Sc in Computer Science',		
		'qualification' => 'B.Sc in Computer Science',
		'ppa' => 'Government Girls Secondary School',
		'ppa_lga' => 'Ahoada',		
		'state_code' => 'RV/14C/0247',			
		'ip' => '127.0.0.1',		
		'month' => 'september',
		'dob' => '1992-9-15'		
	);
	return JSP_DTYPE_SCANNER($array,$param);
}

function JSP_DTYPE_FILE ($param)
{
	$array = array
	(		
		'file' => 'default.png',
		'upload' => 'default.png',
		'profile' => 'default.png',		
		'image' => 'default.png',			
		'wallpaper' => 'default.png',	
	);
	return JSP_DTYPE_SCANNER($array,$param);
}

function JSP_DTYPE_LIST ($param)
{
	$array = array
	(		
		'gender' => 0,			
		'soo' => 11,
		'state' => 11,
		'location' => 11,
		'ppa_state' => 31,				
		'age_range' => 3,	
		'yob' => '1992',		
		'dob' => '',
		'year' => '1992',
		'month' => 9,
		'day' => 15,
		'dob_year' => '1992',
		'dob_month' => 8,
		'dob_day' => 14,
		'answer' => 0,
		'bank' => 8,
		'acct_type' => 0,
		'trans_type' => 0,
		'control' => 0,		
		'status' => 0,
	);
	return JSP_DTYPE_SCANNER($array,$param);
}

function JSP_DTYPE_LONG ($param)
{
	$array = array
	(		
		'about' => JSP_FOOBAR_ARTICLE(),
		'article' => JSP_FOOBAR_ARTICLE(),		
		'content' => JSP_FOOBAR_ARTICLE(),
		'essay' => JSP_FOOBAR_ARTICLE(),
		'message' => JSP_FOOBAR_ARTICLE('SERVICE'),
		'comment' => JSP_FOOBAR_ARTICLE('SERVICE'),
		'summary' => JSP_FOOBAR_ARTICLE('CLIENT'),
		'feedback' => JSP_FOOBAR_ARTICLE('CLIENT'),
		'resource' => JSP_FOOBAR_ARTICLE()		
	);
	return JSP_DTYPE_SCANNER($array,$param);
}


function JSP_DTYPE_DATE ($param)
{
	$array = array
	(		
		'dob' => '1992-9-15',
		'deadline' => JSP_DATE_SHORT,	
		'event_date' => JSP_DATE_EVENT,
		'event_time' => JSP_TIME_EVENT,					
		'date' => JSP_DATE_SHORT,
		'time' => JSP_TIME_SHORT,
		'reg' => JSP_DATE_ETA,
		'eta' => JSP_DATE_STAMP
	);
	return JSP_DTYPE_SCANNER($array,$param);
}


?>








