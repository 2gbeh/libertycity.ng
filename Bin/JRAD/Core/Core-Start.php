<?php
if (IS_LOCALHOST)
{
	$coreDatabase = PSEUDO.'_dbl';
	$coreUsername = 'root';
	$corePassword = '';
}
else
{
	$coreDatabase = PSEUDO.'_db';
	$coreUsername = PSEUDO.'_root';
	$corePassword = '_Strongp@ssw0rd';
}

define('_DB',$coreDatabase);
define('_USERNAME',$coreUsername);
define('_PASSWORD',$corePassword);
//define('_DBCONN',mysql_connect("localhost",_USERNAME,_PASSWORD));
//define('_DBCONN',mysqli_connect("localhost",_USERNAME,_PASSWORD,_DB));

$GLOBALS['CORE_START_TABLE'] = array 
(
	JSP_TABLE_ADMIN,
	JSP_TABLE_TEAM,
	JSP_TABLE_OTIS,		
	JSP_TABLE_VISITOR,
	'news_tb',
	'business_tb',
	'task_tb'
);

$GLOBALS['CORE_START_FIELD'] = array 
(
	array('email','username','password','control','status'),
	array('name','gender','email','phone','username','password','location','ip','status'),
	array('total_ip','unique_ip'),
	array('ip','counter'),
    array('topic','image','headline','article','source','link','views','admin_rid'),
    array('type','service','cost','duration','todo','admin_rid'),
    array('assign','objective','deadline','resource','complete')	
);

$GLOBALS['CORE_START_DATATYPE'] = array
(
	array('VARCHAR (50)','VARCHAR (25)','VARCHAR (25)','INT (1)','INT (1)'),
	array('VARCHAR (50)','INT (1)','VARCHAR (50)','VARCHAR (11)','VARCHAR (25)','VARCHAR (25)','INT (2)','VARCHAR (50)','INT (1)'),	
	array('INT (7)','INT (7)'),	
	array('VARCHAR (50)','INT (2)'),
	array('INT (1)','VARCHAR (100)','VARCHAR (160)','LONGTEXT','VARCHAR (50)','VARCHAR (255)','INT (7)','INT (3)'),
	array('INT (2)','VARCHAR (50)','INT (7)','VARCHAR (7)','LONGTEXT','INT (3)'),
	array('VARCHAR (25)','VARCHAR (160)','VARCHAR (10)','LONGTEXT','VARCHAR (160)')
);	

$GLOBALS['CORE_START_RECORD'] = array 
(
	array
	(
		array(JSP_SUPER_ADMIN,JSP_SSQL_USER,JSP_SSQL_PASSWORD,2,0),
		array(EMAIL,PSEUDO,JSP_SUPER_PASSWORD,1,0)
	)
);	

function CORE_START ()
{
	$tableArray = $GLOBALS['CORE_START_TABLE'];
	foreach ($tableArray as $bin => $table)
	{
		//ARRANGE
		$fieldBin = $GLOBALS['CORE_START_FIELD'][$bin];
		$datatypeBin = $GLOBALS['CORE_START_DATATYPE'][$bin];
		$recordBin = $GLOBALS['CORE_START_RECORD'][$bin];		
		
		//SET FIELD ARRAY
		$JSP_CONCAT_FIELD = JSP_CONCAT_ARRAY(array($fieldBin,$datatypeBin),'Y',2);
		$JSP_GLOB_FIELD = JSP_BUILD_CSV(JSP_GLOB_FIELD);
		$fieldArray[$table] = JSP_PUSH_ARRAY($JSP_CONCAT_FIELD,$JSP_GLOB_FIELD,'END');
		
		//SET RECORD ARRAY
		$JSP_GLOB_FIELD = JSP_PUSH_ARRAY($fieldBin,array('date','time'),'END');		
		$JSP_GLOB_RECORD = JSP_BUILD_CSV(JSP_GLOB_RECORD);
		$JSP_CONCAT_RECORD = array(); //RESET ARRAY		
		if (_ISDIM($recordBin))
		{
			foreach ($recordBin as $assoc_array)
			{
				$pushRecord = JSP_PUSH_ARRAY($assoc_array,$JSP_GLOB_RECORD,'END');				
				$JSP_CONCAT_RECORD[] = JSP_DEFKEY_ARRAY($pushRecord,$JSP_GLOB_FIELD);
			}
		}
		else
		{
			if ($recordBin) //NOT EMPTY
			{
				$pushRecord = JSP_PUSH_ARRAY($recordBin,$JSP_GLOB_RECORD,'END');				
				$JSP_CONCAT_RECORD[] = JSP_DEFKEY_ARRAY($pushRecord,$JSP_GLOB_FIELD);
			}
		}
		$recordArray[$table] = $JSP_CONCAT_RECORD;
	}
	$output = array
	(
		'DATABASE' => _DB,
		'USERNAME' => _USERNAME,
		'PASSWORD' => _PASSWORD,
		'TABLE' => $tableArray,
		'SCHEMA' => array
		(
			'FIELD' => $fieldArray,
			'RECORD' => $recordArray
		)
	);
	return $output;
}
?>
