<?php
if (!_DBCONN() || CORE_BOOT_APACHE()) 
{
	mysqli_query(_DBCONN('withoutDb'),"CREATE DATABASE IF NOT EXISTS "._DB);
	mysqli_select_db(_DBCONN(),_DB);
	CORE_BOOT_CREATE();
	$JSP_DISPLAY_ERROR = array('CORE_BOOT_CREATE - TRUE','SUCCESS');
}

function _DBCONN ($contype = 'withDb')
{
	if ($contype == 'withDb')
		return mysqli_connect("localhost",_USERNAME,_PASSWORD,_DB);
	else
		return mysqli_connect("localhost",_USERNAME,_PASSWORD);	
}

function CORE_BOOT_APACHE ()
{
	if (!JSP_FETCH_TABLES())
		return true;
	if (count(CORE_BOOT_SCHEMA('TABLE')) != count(JSP_FETCH_TABLES()))
		return true;
}

function CORE_BOOT_SCHEMA ($schemaType = 'MAP')
{	
	//ARRANGE
	$parseArray = array('TABLE','FIELD','DATATYPE','RECORD','MAP');	
	if ($schemaType == $parseArray[0]) //TABLE
		return $GLOBALS['CORE_START_TABLE'];
	else if ($schemaType == $parseArray[1]) //FIELD
		return $GLOBALS['CORE_START_FIELD'];
	else if ($schemaType == $parseArray[2]) //DATATYPE
		return $GLOBALS['CORE_START_DATATYPE'];
	else if ($schemaType == $parseArray[3]) //RECORD
		return $GLOBALS['CORE_START_RECORD'];
	else //MAP
		return array
		(
			'TABLE' => $GLOBALS['CORE_START_TABLE'],
			'FIELD' => $GLOBALS['CORE_START_FIELD'],
			'DATATYPE' => $GLOBALS['CORE_START_DATATYPE'],
			'RECORD' => $GLOBALS['CORE_START_RECORD']
		);
}

function CORE_BOOT_CREATE ()
{
	//RESOURCE
	$fieldArray = CORE_BOOT_SCHEMA('FIELD');
	$dataTypeArray = CORE_BOOT_SCHEMA('DATATYPE');	
	
	foreach (CORE_BOOT_SCHEMA('TABLE') as $binIndex => $tableBin)
	{
		//BUILD FIELD STRUCTURE
		$fieldBin = $fieldArray[$binIndex];
		$dataTypeBin = $dataTypeArray[$binIndex];	
		$JSP_CONCAT_ARRAY = JSP_CONCAT_ARRAY(array($fieldBin,$dataTypeBin),'Y',2);
		$fieldBuild = JSP_DROP_ARRAY($JSP_CONCAT_ARRAY,',');

		if //APACHE-SAFE
		(
			!in_array
			(
				JSP_DROP_CASE($tableBin),
				JSP_DROP_CASE(JSP_FETCH_TABLES(_DB))
			)
		)
		{
			//CREATE TABLE			
			$strSQL = "CREATE TABLE ".$tableBin."
			(
				".$fieldBuild.",".JSP_GLOB_FIELD.",
				id INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY(id)
			)";
			mysqli_query(_DBCONN(),$strSQL);
			//PREDEF INSTALLATION
			if ($binIndex < count(CORE_BOOT_SCHEMA('RECORD')))
				CORE_BOOT_INSTALL($binIndex);			
		}
	}
	return true;
}

function CORE_BOOT_INSTALL ($binIndex)
{
	//RESOURCE
	$tableArray = CORE_BOOT_SCHEMA('TABLE');
	$fieldArray = CORE_BOOT_SCHEMA('FIELD');
	$recordArray = CORE_BOOT_SCHEMA('RECORD');

	//ARANGE
	$tableBin = $tableArray[$binIndex];
	$fieldBin = JSP_PUSH_ARRAY($fieldArray[$binIndex],'date,time','END');
	$JSP_BUILD_DIMARRAY = JSP_BUILD_DIMARRAY($recordArray[$binIndex]);
	foreach ($JSP_BUILD_DIMARRAY as $assoc_array)
	{
		$JSP_GLOB_RECORD = JSP_BUILD_CSV(JSP_GLOB_RECORD);
		$recordBin[] = JSP_PUSH_ARRAY($assoc_array,$JSP_GLOB_RECORD,'END');		
	}
	//CREATE ROW
	$columns = JSP_CRUD_PREP($fieldBin,'COL');
	foreach ($recordBin as $assoc_array)
	{
		$rows = JSP_CRUD_PREP($assoc_array,'ROW');		
		$strSQL = "INSERT INTO ".$tableBin." (".$columns.") VALUES (".$rows.")";
		mysqli_query(_DBCONN(),$strSQL);
	}
	return true;
}
?>
