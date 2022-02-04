<?php
function PLY_SPANNER_REFBY ()
{
	if ($_GET["ref"]) 
		$value = $_GET['ref']; 
	else 
		$value = $_POST['ref_by'];
	$output = '<label for="ref_by">referral ID (optional)</label>
        <input type="text" name="ref_by" value="'.$value.'" />'; 
	return $output;
}

function PLY_FILTER_REFBY ($postArray, $entryArray)
{	
	$TABLE = JSP_TABLE_USER;
	$ref = $postArray['ref_by'];
	if ($ref)
	{
		if (_EXIST($TABLE,'username',$ref))
			return JSP_REKEY_ARRAY(JSP_SORT_EXCLUDE($entryArray,9,'KEY'));
	}
	else
		return JSP_REKEY_ARRAY(JSP_SORT_EXCLUDE($entryArray,9,'KEY'));	
}

function PLY_SSQL_SANITIZE ()
{	
	//ZERO ACCOUNT
	$whereArray = array('user_rid',0,1);
	JSP_CRUD_DELETE(PLY_TABLE_MATCH,$whereArray); 
	JSP_CRUD_DELETE(PLY_TABLE_REF,$whereArray);
	JSP_CRUD_DELETE(PLY_TABLE_SUSPEND,$whereArray);

	//GHOST ACCOUNT
	$_U = JSP_FETCH_COLUMN(JSP_TABLE_USER,'PRIKEY');		
	$_M = JSP_FETCH_COLUMN(PLY_TABLE_MATCH,'user_rid');
	foreach ($_M as $key => $id)
	{	
		if (!in_array($id,$_U))
		{
			$whereArray = array('user_rid',$id,1);
			JSP_CRUD_DELETE(PLY_TABLE_MATCH,$whereArray); 
			JSP_CRUD_DELETE(PLY_TABLE_REF,$whereArray);
			JSP_CRUD_DELETE(PLY_TABLE_SUSPEND,$whereArray);
		}
		
		//CLOSED TELLERS		
		$_T = _BYID(PLY_TABLE_MATCH,$key);
		if 
		(
			JSP_SORT_GATE($_T['status'],'1,3,5,7','NOT') && 
			$_T['teller'] != 'NULL'
		)
		{
			_UPDATE(PLY_TABLE_MATCH,'teller','NULL',$key);
			JSP_FILE_DELETE(PLY_BASE_TELLER.$_T['teller']);			
		}
	}	
}
?>


