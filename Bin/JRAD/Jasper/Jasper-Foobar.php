<?php
function JSP_FOOBAR_CRUD_SCANNER ()
{
	return $parseArray = array('CREATE','SELECT','MODIFY','DROP');
}
function JSP_FOOBAR_DATABASE ($dbname, $crudLogic = 'CREATE')
{
	$paramArray = array($dbname,$crudLogic);
	$parseArray = JSP_FOOBAR_CRUD_SCANNER();
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$crudLogic))
		return JSPIP;	
	else
	{
		if ($crudLogic == $parseArray[0] || $crudLogic == $parseArray[3]) //CREATE OR DROP
		{
			if ($crudLogic == $parseArray[0])
				$strSQL = 'CREATE DATABASE '.$dbname;
			else
				$strSQL = 'DROP DATABASE '.$dbname;
			if (mysqli_query(_DBCONN('withoutDb'),$strSQL))
			{
				mysqli_close(_DBCONN('withoutDb'));
				return 1;
			}			
		}
		if ($crudLogic == $parseArray[1]) //SELECT
		{
			if (mysqli_select_db(_DBCONN(),$dbname))
			{
				mysqli_close(_DBCONN());
				return 1;
			}						
		}
		if ($crudLogic == $parseArray[2]) //MODIFY
		{
			$dbname = _CSV($dbname);
			$old_db = $dbname[0];
			$new_db = $dbname[1];
			JSP_FOOBAR_DATABASE($new_db);
			foreach (JSP_FETCH_TABLES($old_db) as $table)
			{
				$strSQL .= "RENAME TABLE `".$old_db.".".$table."` TO `".$new_db.".".$table."`, ";
			}
			$strSQL = substr($strSQL,0,-2);
			if (mysqli_query(_DBCONN('withoutDb'),$strSQL))
			{
				mysqli_close(_DBCONN('withoutDb'));
				return 1;
			}			
		}
	}
}

function JSP_FOOBAR_TABLE ($tbname, $crudLogic = 'CREATE')
{
	$paramArray = array($tbname,$crudLogic);
	$parseArray = JSP_FOOBAR_CRUD_SCANNER();
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$crudLogic))
		return JSPIP;		
	else
	{
		if ($crudLogic == $parseArray[0] || $crudLogic == $parseArray[3]) //CREATE OR DROP
		{
			if ($crudLogic == $parseArray[0])
				$strSQL = "CREATE TABLE ".$tbname." (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id))";	
			else
				$strSQL = 'DROP TABLE '.$tbname;			
			if (mysqli_query(_DBCONN(),$strSQL))
			{
				mysqli_close(_DBCONN());
				return 1;
			}			
		}
		if ($crudLogic == $parseArray[1]) //SELECT
		{
			$strSQL = mysqli_query(_DBCONN(),"DESCRIBE ".$tbname);
			while ($desc = mysqli_fetch_array($strSQL,MYSQLI_ASSOC))
				$output[] = $desc;
			mysqli_close(_DBCONN());
			return $output;		
		}
		if ($crudLogic == $parseArray[2]) //MODIFY
		{
			$tbname = _CSV($tbname);
			$old_tb = $tbname[0];
			$new_tb = $tbname[1];
			
			$strSQL = "RENAME TABLE `".$old_tb."` TO `".$new_tb."`";
			if (mysqli_query(_DBCONN(),$strSQL))
			{
				mysqli_close(_DBCONN());
				return 1;
			}
		}		
			
	}
}

function JSP_FOOBAR_ITABLE ($table, $fieldArray)
{
	$paramArray = array($table,$fieldArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$fieldArray = _CXV($fieldArray);		
		$prikey = "id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id)";
		$strSQL = "CREATE TABLE ".$table." (".$fieldArray.", ".$prikey.")";
		if (mysqli_query(_DBCONN(),$strSQL))
		{
			mysqli_close(_DBCONN());
			return 1;
		}			
	}
}

function JSP_FOOBAR_FIELD ($crudArray, $crudLogic = 'CREATE')
{
	$paramArray = array($crudArray,$crudLogic);
	$parseArray = JSP_FOOBAR_CRUD_SCANNER();
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$crudLogic))
		return JSPIP;		
	else
	{
		if ($crudLogic == $parseArray[0] || $crudLogic == $parseArray[3])
		{
			/*
			$crudArray = array
			(
				'TABLE' => 'admin_tb',
				'FIELD' => array('email varchar(50)','password varchar(20)')
			)
			*/
			$table = $crudArray['TABLE'];
			$fieldArray = _CXV($crudArray['FIELD']);
			if ($crudLogic == $parseArray[0])
				$strSQL = "ALTER TABLE ".$table." ADD (".$fieldArray.")";
			else
			{
				if (_STRPOS($fieldArray,','))
				{
					foreach (_CSV($fieldArray) as $value)
						$_fieldArray .= 'DROP '.$value.', ';
					$_fieldArray = substr($_fieldArray,0,-2);
				}
				else
					$_fieldArray = 'DROP '.$fieldArray;
				$strSQL = "ALTER TABLE ".$table." ".$_fieldArray;
			}
			if (mysqli_query(_DBCONN(),$strSQL))
			{
				mysqli_close(_DBCONN());
				return 1;
			}			
		}
		if ($crudLogic == $parseArray[1]) //SELECT
		{
			$table = $crudArray['TABLE'];
			$fieldArray = _CSV($crudArray['FIELD']);			
			$query = mysqli_query(_DBCONN(),"SHOW COLUMNS FROM ".$table);
			while ($result = mysqli_fetch_array($query,MYSQLI_ASSOC))
			{
				if (in_array($result['Field'],$fieldArray))
					$output[] = $result;
			}
			mysqli_close(_DBCONN());
			return _CRUNCH($output);
		}
		if ($crudLogic == $parseArray[2]) //MODIFY
		{
			$table = $crudArray['TABLE'];
			$fieldArray = _CXV($crudArray['FIELD']);
			if (_STRPOS($fieldArray,','))
			{
				foreach (_CSV($fieldArray) as $value)
					$_fieldArray .= 'MODIFY '.$value.', ';
				$_fieldArray = substr($_fieldArray,0,-2);
			}
			else
				$_fieldArray = 'MODIFY '.$fieldArray;			
			
			$strSQL = "ALTER TABLE ".$table." ".$_fieldArray;
			if (mysqli_query(_DBCONN(),$strSQL))
			{
				mysqli_close(_DBCONN());
				return 1;
			}				
		}

	}
}

function JSP_FOOBAR_ROW ($fieldArray, $type = 'CREATE')
{
	$paramArray = array($fieldArray,$type);
	$parseArray = array('RETURN','CREATE');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$type))
		return JSPIP;
	else
	{	
		//GET ENUMS
		$treeArray = JSP_ENUMS_PROFILE('MAP');
		//IF TABLE PARSED INSTEAD OF FIELD ARRAY
		if (strlen($fieldArray))
		{
			$table = $fieldArray;
			$fieldArray = JSP_FETCH_PRIKEY($table,'FILTER');
		}
		//LOOP FIELDS
		foreach ($fieldArray as $field)
		{
			$field = JSP_BUILD_CASE($field);
			if (in_array($field,array_keys($treeArray)))
				$newArray[] = $treeArray[$field];
			else
				$newArray[] = 'NULL';
		}
		//CRUD
		if ($table && $type == $parseArray[1]) //CREATE
		{
			if (in_array('email',$fieldArray))
			{ 
				if (!_EXIST($table,'email',$treeArray['EMAIL']))
					return JSP_CRUD_CREATE($table,$newArray);
			}
			else
				return JSP_CRUD_CREATE($table,$newArray);
		}
		else
			return $newArray;
	}
}

function JSP_FOOBAR_BANK ($uArray, $returnType = 'DATATYPE', $position = 'END')
{
	$paramArray = array($uArray,$returnType,$position);
	$parseArray = array
	(
		array('FIELD','DATATYPE','ROW'),
		array('CURRENT','END')
	);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$returnType) ||
		(
			JSP_PARAM_PARSE($parseArray[1],$position) &&
			!is_numeric($position)
		)
	) 
		return JSPIP;	
	else
	{
		$fieldArray = array('bank','acct_name','acct_number','acct_type','status');
		if ($position == $parseArray[1][0]) //CURRENT
			$position = 1;
		else if ($position == $parseArray[1][1] || $position > count($uArray)) //END OR >
			$position = count($uArray) + 1;
		
		if ($returnType == $parseArray[0][1]) //DATATYPE
			$pushArray = array('INT (2)','VARCHAR (50)','VARCHAR (10)','INT (1)','INT (1)');		
		else if ($returnType == $parseArray[0][2]) //ROW
			$pushArray = JSP_FOOBAR_ROW($fieldArray,'RETURN');
		else //FIELD
			$pushArray = $fieldArray;
//		return $position;
		return JSP_SHIFT_ARRAY($uArray,$pushArray,$position);
	}
}

function JSP_FOOBAR_EVENT ($returnType = 'DATATYPE')
{
	$paramArray = array($returnType);
	$parseArray = array('FIELD','DATATYPE','ROW');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$returnType)) 
		return JSPIP;	
	else
	{
		$fieldArray = array('image','name','event_date','event_time','venue','about');
		if ($returnType == $parseArray[1]) //DATATYPE
			$pushArray = array('VARCHAR (100)','VARCHAR (80)','VARCHAR (50)','VARCHAR (50)','VARCHAR (80)','LONGTEXT');
		else if ($returnType == $parseArray[2]) //ROW
			$pushArray = JSP_FOOBAR_ROW($fieldArray,'RETURN');
		else //FIELD
			$pushArray = $fieldArray;
		return $pushArray;
	}
}

function JSP_FOOBAR_CLONE ($table, $numrows = 20)
{
	$paramArray = array($table,$numrows);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$RECORDS = JSP_FETCH_RECORDS($table);
		if (_THROW($RECORDS))
		{
			$PRIKEY = JSP_FETCH_PRIKEY($table,'KEY');					
			foreach ($RECORDS as $index => $assoc_array)
				$newArray[] = JSP_SORT_EXCLUDE($assoc_array,$PRIKEY,'KEY');
		}
		else //EMPTY DB
		{
			$FIELDS = JSP_FETCH_PRIKEY($table,'FILTER');
			$newArray[0] = JSP_FOOBAR_ROW($FIELDS,'RETURN');
		}
		
		$real = round($numrows/count($newArray));
		do
		{
			foreach ($newArray as $assoc_array)
				_CREATE($table,$assoc_array);
			$count++;
		}
		while ($count < $real);
		return 1;
	}
}

function JSP_FOOBAR_MOVE ($table_1, $table_2, $numrows = '*')
{
	$paramArray = array($table_1,$table_2,$numrows);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$numrows = JSP_BUILD_CSV($numrows);
		$RECORDS = JSP_FETCH_RECORDS($table_1);
		$PRIKEY = JSP_FETCH_PRIKEY($table_1,'KEY');			
		$fieldArray = JSP_FETCH_FIELDS($table_2);
		foreach ($RECORDS as $index => $assoc_array)
			$newArray[] = JSP_SORT_EXCLUDE($assoc_array,$PRIKEY,'KEY');
		if (count($numrows) == 1 && $numrows[0] == '*') //CLONE ALL
		{
			foreach ($newArray as $entryArray)
				_CREATE_IF($table_2,$entryArray,array($fieldArray[0],$entryArray[0]));
		}
		else if ($numrows[0] == '<' && is_numeric($numrows[1])) //CLONE RANGE
		{
			foreach ($newArray as $index => $entryArray)
			{
				if ($index < $numrows[1])
					_CREATE_IF($table_2,$entryArray,array($fieldArray[0],$entryArray[0]));
			}
		}
		else //CLONE SELECT
		{
			$PRIKEY = JSP_FETCH_PRIKEY($table_1,'VALUE');			
			foreach ($numrows as $id)
				$newerArray[] = JSP_FETCH_BYID($table_1,$id);
			foreach ($newerArray as $assoc_array)
			{
				$exclude = JSP_SORT_EXCLUDE($assoc_array,$PRIKEY,'KEY');
				$entryArray = JSP_REKEY_ARRAY($exclude);
				_CREATE_IF($table_2,$entryArray,array($fieldArray[0],$entryArray[0]));
			}
		}
		return 1;
	}
}

function JSP_FOOBAR_SWAP ($table, $field_1, $field_2, $numrows = '*')
{
	$paramArray = array($table,$field_1,$field_2,$numrows);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$numrows = JSP_BUILD_CSV($numrows);
		$field_1Array = JSP_FETCH_BYCOL($table,$field_1);
		$field_2Array = JSP_FETCH_BYCOL($table,$field_2);
		$idArray = array_keys($field_1Array);
		$counter = 1;		
		if ($numrows[0] == '*') //CLONE ALL
			$array = JSP_SORT_ARITH($idArray,'NULL',$numrows[0]);
		else if ($numrows[0] == '<') //BEFORE NUMROW
			$array = JSP_SORT_ARITH($idArray,$numrows[1],$numrows[0]);
		else if ($numrows[0] == '>') //AFTER NUMROW
			$array = JSP_SORT_ARITH($idArray,$numrows[1],$numrows[0]);
		else if ($numrows[0] == '{}') //BETWEEN NUMROW
			$array = JSP_SORT_ARITH($idArray,array($numrows[1],$numrows[2]),$numrows[0]);
		else if ($numrows[0] == '><') //WITHIN NUMROW
			$array = JSP_SORT_ARITH($idArray,array($numrows[1],$numrows[2]),$numrows[0]);
		else if ($numrows[0] == 'i') //SWAP SELECT BY NUMROW
		{
			$numrow = JSP_POP_ARRAY($numrows,'CURRENT');
			$array = JSP_SORT_ARITH($idArray,$numrows,'INDEX');
		}					
		else //SWAP SELECT BY ID
		{
			$numrow = JSP_POP_ARRAY($numrows,'CURRENT');
			$array = JSP_SORT_ARITH($idArray,$numrows,'VALUE');		
		}
		foreach ($array as $value)
		{
			$former = _CELLOF($table,$field_1,$value);
			$latter = _CELLOF($table,$field_2,$value);
			$strSQL = _UPDATE($table,array($field_1,$field_2),array($latter,$former),$value);
//			return array($array,$strSQL);
		}
		return 1;
	}
}

function JSP_FOOBAR_EMAIL ($table, $field)
{
	$paramArray = array($table,$field);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$JSP_FETCH_PREDEF = JSP_CRUNCH_ARRAY(JSP_FETCH_PREDEF($table,'name',1));		
		foreach ($JSP_FETCH_PREDEF as $key => $value)
		{
			$JSP_NAME_SPACE = JSP_DROP_CASE(JSP_NAME_SPACE($value)).'@yahoo.com';
			JSP_CRUD_UPDATE($table,'email',$JSP_NAME_SPACE,array('PRIKEY',$key,1));
		}
		return 1;
	}
}

function JSP_FOOBAR_SEATFIL ()
{	
	foreach (JSP_FETCH_TABLES(_DB) as $table)
	{
		JSP_FOOBAR_ROW($table);	
		JSP_FOOBAR_CLONE($table,10);
	}
	return 1;
}

function JSP_FOOBAR_FORMFIL ()
{
	if (isset($_GET['BLN_FORMS_FOOBAR']))	
	{
		if ($_GET['BLN_FORMS_FOOBAR'] == 'user')
		{
			foreach (JSP_ENUMS_PROFILE() as $key => $value)
			{
				$key = JSP_DROP_CASE($key);
				$postArray[$key] = $value;
			}
		}
		else
		{
			if ($_GET['BLN_FORMS_FOOBAR'] == 'admin')
				$x = array(JSP_SSQL_USER,JSP_SSQL_PASSWORD);
			if ($_GET['BLN_FORMS_FOOBAR'] == 'ssql')
				$x = array(PSEUDO,JSP_SUPER_PASSWORD);
			if ($_GET['BLN_FORMS_FOOBAR'] == 'temp')
				$x = array(JSP_SUPER_USER,JSP_SUPER_PASSWORD);
			if ($_GET['BLN_FORMS_FOOBAR'] == '2gbeh')
				$x = array('2gbeh','4444');
			$postArray['username'] = $x[0];
			$postArray['password'] = $x[1];
		}
		return $postArray;
	}
	else
		return $_POST;
}

function JSP_FOOBAR_LOOP ($entry, $loop)
{
	$paramArray = array($entry,$loop);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	if (!is_numeric($loop))
		return JSPIP;	
	else
	{
		for ($i = 0; $i < $loop; $i++)
			$output .= $entry;
		return $output;
	}
}

function JSP_FOOBAR_FNLOOP ($function, $loop)
{
	$paramArray = array(JSP_TRUEPUT($function),$loop);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	if (!is_numeric($loop))
		return JSPIP;	
	else
	{
		for ($i = 0; $i < $loop; $i++)
			$function;
		return 1;
	}
}

function JSP_FOOBAR_ARTICLE ($param = 'ALL')
{
	$paramArray = array($param);
	$parseArray = array('ALL','INTRO','SERVICE','CULTURE','CLIENT','CONTACT','LISTING','SLOGAN');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_FORMAT($parseArray,$param)) 
		return JSPIP;		
	else
	{
		if ($param == $parseArray[0]) //ALL
			$output = "Founded in November 2011, HWP Labs is a consulting firm specialised in Software Engineering and Business R&D. Our services include; Website & Web Applications Development, Product Design & UX, Digital Advertising & Analytics, Corporate Branding & HR, and Computer/ICT Training. Our work culture is inspired by Productivity and Efficiency. Our clients believe in the quality of our products and we always welcome new opportunities to partner with Entrepreneurs and Startup Companies.";
		else if ($param == $parseArray[1]) //INTRO
			$output = substr(JSP_FOOBAR_ARTICLE('ALL'),0,109);
		else if ($param == $parseArray[2]) //SERVICE
			$output = substr(JSP_FOOBAR_ARTICLE('ALL'),132,145);
		else if ($param ==  $parseArray[3]) //CULTURE
			$output = substr(JSP_FOOBAR_ARTICLE('ALL'),278,60);
		else if ($param ==  $parseArray[4]) //CLIENT
			$output = substr(JSP_FOOBAR_ARTICLE('ALL'),339,143);			
		else if ($param ==  $parseArray[5]) //CONTACT
			$output = '+234(0) 81 6996 0927 (Whatsapp only)';
		else if ($param ==  $parseArray[6]) //LISTING
			$output = 'Website & Blog Development, SME Business Solutions (Mosone), Project MGT/CRM Solutions, Inventory, Sales & Audit Systems, School Portal Development, Corporate Branding & HR, Digital Advertising & Analytics, Network Marketing, Computer & ICT Training, Product UI/UX Design.';
		else if ($param ==  $parseArray[7]) //SLOGAN
			$output = 'Why save the magic';			
		else
			JSPIP;
		return $output;
	}
}

function JSP_FOOBAR_OCCUPY ()
{
	$output = "THE HELLO WORLD PROJECT
	OVERVIEW
	Type:			Technology
	Genre:		Application Development and 
				I.C.T Workshop
	Founded:		November 14TH 2011
	Founder:		Tugbeh Emmanuel (Product Manager)
	Co. Founder:	Okougbo Lexity (Technical Analyst)
	Developers:	Esimaje Benedict (Developer, Lead)
				Oboro Oizamisi (Technical Writer)
	Okechukwu Anderson (Developer, UX Content)
				Obi Sopuluchukwu (Developer, UI/UX Content)
	Services:		Workshop, HWP Devx Café (online/weekly hangout)
	Magazine, Smalltalk (includes online periodical)
	Hackathon (Hack-the-Herald and Return Zero)
	Mission:	[HWP Labs] To enrich lives with technology and business solutions. [HWP Devx Team] To provide convenient utilities for users by building 'tool-ish' applications. [HWP Devx Cafe] To share information on how various new and developing technologies should affect the lives of I.C.T enthusiasts. 
	Publications:	12 opsfiles (6 product, 2 algorithm, 0 cascade, 4 k++, 0 event) 
	26 products  -- 12 home, 17 away (8 Live, 2 PL, 1 T, 18 PD) 
	see hwp product portfolio\>
			20 quotes -- 16 home, 4 away (HWP QWeek)
			5 social media utilities (HWP SMUX)
			8 workshop extensions -- 6 home, 2 away
	Original Run:	90 minutes, Weekly (Sunday)
	Country:		Nigeria
	Initial Release:	HWP/CAF001 SU1603:2014 (PastQ. product launch)
	Stable Release:	HWP/CAF004 SU1105:2014 (User I/O)
	Tagline:		Occupy your minds accordingly (y)
	Motto:		Stand I.T. Proud
	Phylosophy:	“difficulty made easy, but a lazy man’s conception”
	Email:		standitproud@gmail.com , standitproud@yahoo.com
	External Links:	^ www.standitproud.com (official)
	^ facebook.com/standitproud
	^ standitproud.blogspot.com
	^ Hello World Project (Google Plus)
	Partners:	TTNG Workgroup | Chroma Media | GSA BIU 2012-2014 | Proception 
	Innovation Week | PastQ. Workgroup
	
	SYNOPSIS
	The Hello World Project is an I.T. workshop held at Benson Idahosa University as the first of its institutional openings. Its objective is to share information on how various new and developing technologies should affect the lives of I.C.T enthusiasts. The forum  kicks-off with a keynote presentation by the Product Manager -Tugbeh Emmanuel, introducing the HWP concept and the selected dialogue module for the event tailed by a series of interactive sessions on the nerve methodology and realistic importance of various I.C.T endeavors. This event alternatively gives audience to similar start-ups and individual developers unboxing their respective product leads, user features/utilities and stable extensions.
	The name Hello World Project is diminutive of a computer program to display hello world! supposedly performed as an introductory insight to the basic syntax of system input/output stream. Implied on the 14th of November, 2011 and remodeled in Q4 2012; the initial launch of the project to a large audience is currently under development at Benson Idahosa University.
	
	Dream interview::
	CNN: Ok, so most of the world's innovations these days are coming out of HWP Labs at Studygate University, what do you feel is the motivation behind these exponential growth? 
	Me: Well, i've been around the world and uhm...(0.0) 
	
	DIALOGUE MODULE
	•	Stand I.T. Proud, SIP (development circle SDLC)
	The SIP dialogue module is HWP’s native and original event content, this entails a discussion tailored around the software development life circle of HWP exclusive portofolios, HWP partners and other interested parties.
	•	A Programmer’s Mind, APM (syntax paradigm and semantics)
	The APM series is a break down of complex alorithms for optimized build and the structuring of application utilities similar to Microsoft Windows’ user friendly product model. Discussions would also be made upon HWP exclusive portofolios, HWP partners and other interested parties.
	•	Predictive Algorithm, PAL (event driven program analysis EDPA)
	Predictive  algorithm is basically what a programmer/developer anticipates on various user choices thereby providing a variety of utility options. This module is both theoretical discussions and practical analysis on event driven processes, call triggers and conditional operations. Although discussions would also be made upon HWP exclusive portofolios, HWP partners and other interested parties; HWP exclusively intends on focusing this module on virtual gaming examples such as EA Sports’ FIFA 2012 with its near-independent player kinetics. Obi Sopuluchukwu would oversee this session as he claims to know an awful lot about this typa shit.
	
	HWP Devx Café workshop (treating)
	Original Run: 90mins
	
	INTRODUCTION TO HWP
	The conference kicks off with an introductory speech made by the Product Manager, Tugbeh Emmanuel following a descriptive overview on a selected dialogue module (e.g predictive Algorithm, program development circle e.t.c) of the event. Prior to this introduction, a series of media presentation on the dialogue module would be projected to entertain and enlighten the present audience whilst waiting for more attendees to show up. An on-screen countdown begins the event.
	
	INTRODUCTION TO HWP DEVX TEAM
	An introductory reference to present individuals that work with the organisation, external representatives of the organisation and other keynote speakers who would later showcase similar start-ups, initial products, new user features or product add-on utilities amidst the  duration of the conference.
	
	KEYNOTE 1
	Product Introduction (phrastem): The first keynote speaker would be introduced by name and skillset at the conclusion of prior activities. Keynote speech should be relation to the selected dialogue module.
	
	KEYNOTE 2
	Product Hands-on:The second keynote speaker would be introduced by name and skillset at the conclusion of Keynote 1. Keynote speech should be relation to the selected dialogue module. For products still under development, this session would be used to explore under-referenced computer science glossaries.
	
	REFRESH
	Tech updates: This session is simply based on informing the audience about new and developing technologies around the world referenced from CNN Tech News, WIRED, CNNMONEY and the likes. (written by HWP Technical Analyst).
	
	BONUS ARENA
	The bonus arena is designed mainly to tackle HWP Devx Café workshop extensions referenced to below.
	
	CONCLUSION
	The event is concluded with a recap on the selected dialogue module and an end note outlining keynote references and future HWP Devx Café schedules.
	
	
	
	HWP Devx Café workshop extensions (bonus arena)
	
	1.	Hack-the-Herald, HWP Exclusives (comparative application development) -160114
	2.	Return Zero, HWP Exclusives (comparative algorithm development) -260114
	3.	Highscore, HWP Exclusives (Real time virtual gaming expo) -281012
	4.	Wad App, HWP Exclusives (general project showcase by volunteers) -080113
	5.	WWJD- What Would Java Do, Proception Exclusives (Java program development marathon) -100113
	6.	Google Products and Services, GSA/GDG Exclusives
	7.	I.T. application themed video presentation (k++)
	8.	Technical Q&A/FAQs (Under-ref glossaries)
	
	Under-referenced computer science glossaries (keynote 2)
	
	1.	API mapping
	2.	Motherboard
	3.	Software utility (basic)
	4.	Programming Languages
	5.	Building Viruses and Firewall (Sandbox)*
	6.	Concept of hacking (ref; Jon Erickson)
	7.	OOP
	8.	Ad hoc
	9.	OS overview: Linux OS *, iOS, Mac OS, Android OS, Kernel OS (GNU, Unix)
	10.	Public Key Encryption
	11.	Operating Systems
	12.	Digital signature and digital certificate
	13.	Optical Fibre (a long thin thead of glass or plastic along which information can be sent through a phone of computer system, using light.)
	14.	Data capture *
	15.	Keyboard  pulse (pulse train) *
	
	17.	Web terms:  RSS Feed, Atom 1.0, Beta, Meta element, URL, proxy, Popup blocker, Plug-in and add-on, I.P address
	18.	Wireless radio/bluetooth
	19.	Virus/types of virus
	20.	Incognito * 
	
	
	HWP QWeek 270813
	1.	Quite handy, these little ones #Fn
	2.	With great artistry comes great responsibility, less is more*
	3.	What matters now is what we anticipate for the future at present*
	4.	Content over matter
	5.	Creative playfulness is a key to sharing information*
	6.	Everything in existence is a replicate of things that exist
	7.	difficulty made easy, but a lazy man’s conception
	8.	technology, ease the culture*
	9.	it all begins with a column #SQL
	10.	knowledge, to worth use
	11.	experience begets speed, practice
	12.	damn, these arrays #C++
	13.	this very jargon works magic #PHP
	14.	choice, be it made
	15.	Fewers things work better, FOCUS - Brett Wallace (Director of sales, LinkedIn)
	16.	Rush is flaw, tread with ease
	17.	Necessity is the mother Invention - Plato
	18.	Competition breeds Innovation - Thomas G. Robinson (Exec VP, CBG Communications)
	19.	Do the thing that you love and do it well, and you would be absolutely successful - Jacqueline D. Reses (Chief Development Officer, Yahoo!) 
	20.	“For as many as can read, so as many as can write (HWP/QWK020 TH1809:2014).
	21.	Live an Object Oriented Life (HWP/QWK021 TH2512:2014, 2015 Year Mantra)
	
	SOCIAL MEDIA Utilities 130413
	1.	Holy Script!
	As opposed to the amazement exclamation “holy shit”, this is a publication of  the ‘wow effect’ on softwares, games, websites, applications and the whole-ten-yards of technology inventions including hardware products.
	2.	K++ 
	Knowledge with the traditional increment operator “++”, formerly called readers obsession this is the publication of reader materials developers can gain insights from. Also released in video format.
	3.	Devcon of the month
	The Devcon of the month utility publishes slight history and acheivemrnts of renouned developers or group of developers every month.
	4.	Wad App
	The Wad App utility just as the Devcon utility publishes a feature/ utility run-down of proudcts developed by renouned developers or group of developers. Kicked off with HTC’s First Mobile Phone called ‘Facebook HOME’.
	5.	DUK?>
	“DID U KNW?” Simply stipulates  facts and theories.
	6.	HWP Exclusive (GOT IT/open talk now HWP OPIP)
	
	Disclaimer: All product guides, algorithms, cascade techniques, k++ materials and event opsfiles watermarked with the HWP trademark logo and the HWP copyright impressum are right protected intellectual properties of the HWP DEVX TEAM. Unauthorized redistribution and/or reproduction of publication content in any form is punishable by copyright infringement laws. Occupy your minds accordingly (y)
	Disclaimer: All algorithms and cascade techniques used in our publications have been tested by the HWP Devx Team and have been applied in real-time applications currently existing in our product portfolio or Labs extension programme. However, if after using these materials you do not achieve your required results then you’re either fucking blind, a retard with no recognition for clearly typed text, you’re using Microsoft IE as a test browser and/or you need to check out Wiley’s ‘For Dummies’ collection and shits instead. Occupy your minds accordingly (y)";
	return $output;
}
?>