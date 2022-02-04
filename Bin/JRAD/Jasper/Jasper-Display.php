<?php
function JSP_DISPLAY_ERROR ($errorMessage, $errorColor)
{
	$parseArray = JSP_ENUMS_PREDEF('ERROR');
	if (!$errorColor || !in_array($errorColor,$parseArray))
		$errorColor = $parseArray[2]; //INFO
	if ($errorMessage)
	{
		$output = "<div class='JSP_DISPLAY_ERROR $errorColor' id='JSP_DISPLAY_ERROR' style='display:block;'>
			<div class='head'>
				<span id='cancel' title='close' onclick=BLN_DISPLAY_DOM('JSP_DISPLAY_ERROR','CLOSE')>&times;</span>
			</div>		
			<div class='body'>
				$errorMessage
			</div>			
		</div>";		
		return $output;			
	}
}

function JSP_DISPLAY_BLOCK ($array)
{
	$paramArray = array($array);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$array = JSP_BUILD_CSV($array);
		foreach ($array as $value)
		{
			$body .= $value."<br/>";			
		}
		$output = "<div class='BLN_DISPLAY_BLOCK'>".$body."</div>";
		return $output;
	}
}

function JSP_DISPLAY_MACRO ($array)
{
	$paramArray = array($array);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$array = JSP_BUILD_CSV($array);
		foreach ($array as $key => $value)
		{
			$body .= "<tr>
				<td align='right'>".$key."</td>
				<td>".$value."</td>
			</tr>";
		}
		$output = "<table class='BLN_DISPLAY_MACRO'>".$body."</table>";
		return $output;
	}
}

function JSP_DISPLAY_TREE ($dimArray)
{
	$paramArray = array($dimArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if (strlen($dimArray) || count($dimArray) == 1)
			return JSPIL;
		for ($i = 0; $i < count($dimArray[0]); $i++)
		{
			$append = '<dt>'.$dimArray[0][$i].'</dt>';							
			for ($o = 1; $o < count($dimArray); $o++)
			{
				$append .= '<dd>'.$dimArray[$o][$i].'</dd>';				
			}
			$body .= $append;
		}
		$output = "<dl class='BLN_DISPLAY_TREE'>".$body."</dl>";
		return $output;
	}
}

function JSP_DISPLAY_LIST ($array, $listType = 'UL')
{
	$paramArray = array($array,$listType);
	$parseArray = array('OL','UL');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$listType)) 
		return JSPIP;			
	else
	{
		$array = JSP_BUILD_CSV($array);
		foreach ($array as $value)
		{
			$body .= "<li>".$value."</li>";			
		}
		if ($listType == $parseArray[0]) //OL
			$output = "<ol class='BLN_DISPLAY_LIST'>".$body."</ol>";
		else
			$output = "<ul class='BLN_DISPLAY_LIST'>".$body."</ul>";
		return $output;
	}
}

function JSP_DISPLAY_ILIST ($labelArray, $anchorArray, $selected)
{
	$paramArray = array($labelArray,JSP_TRUEPUT($anchorArray),JSP_TRUEPUT($selected));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$labelArray = JSP_REKEY_ARRAY($labelArray);
		$anchorArray = JSP_REKEY_ARRAY($anchorArray);
		if ($selected && is_numeric($selected))
			$_selected = $selected - 1;
		foreach ($labelArray as $key => $value)
		{
			if (_THROW($anchorArray) && $anchorArray[$key])
				$anchor = $anchorArray[$key];
			else
				$anchor = '#';
			
			if ($key === $_selected)
				$list = '<a href="'.$anchor.'" id="selected">'.$value.'</a>';
			else
				$list = '<a href="'.$anchor.'">'.$value.'</a>';
			$li .= '<li>'.$list.'</li>';
		}
		return $li;		
	}
}

function JSP_DISPLAY_DLIST ($dtArray, $ddArray)
{
	$paramArray = array($dtArray,$ddArray);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$dtArray = JSP_BUILD_CSV($dtArray);
		$ddArray = JSP_BUILD_CSV($ddArray);		
		foreach ($dtArray as $key => $value)
		{
			$dt = "<dt onclick=BLN_DISPLAY_DLIST(".$key.")><span class='sign'>+</span> ".$value."</dt>";
			$dd = "<dd>".$ddArray[$key]."</dd>";
			$body .= $dt.$dd;
		}
		$output = "<dl class='JSP_DISPLAY_DLIST'>".$body."</dl>";
		return $output;
	}
}

function JSP_DISPLAY_IDLIST ($labelArray, $anchorArray, $selected)
{
	$paramArray = array($labelArray,JSP_TRUEPUT($anchorArray),JSP_TRUEPUT($selected));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		$labelArray = JSP_REKEY_ARRAY($labelArray);
		$anchorArray = JSP_REKEY_ARRAY($anchorArray);
		if ($selected && is_numeric($selected))
			$_selected = $selected - 1;
		foreach ($labelArray as $key => $value)
		{
			if (_THROW($anchorArray) && $anchorArray[$key])
				$anchor = $anchorArray[$key];
			else
				$anchor = '#';
			
			if ($key === $_selected)
				$list = '<a href="'.$anchor.'" id="selected">'.$value.'</a>';
			else
				$list = '<a href="'.$anchor.'">'.$value.'</a>';
			$dd .= '<dd>'.$list.'</dd>';
		}
		return $dd;		
	}
}

function JSP_DISPLAY_OPTION ($array, $selected, $vtype = 'KEY')
{
	$paramArray = array($array,JSP_TRUEPUT($selected),$vtype);	
	$parseArray = array('KEY','VALUE');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$vtype))
		return JSPIP;
	else
	{
		$array = JSP_TITLE_CASE(_CSV($array));
		if ($selected == 'NULL' || !in_array($selected,array_keys($array)))
		{
			$output = "<option selected='selected'></option>";
			foreach ($array as $key => $value)
			{
				if ($vtype == $parseArray[0]) //KEY
					$output .= "<option value='".$key."'>".$value."</option>";
				else
					$output .= "<option>".$value."</option>";
			}
		}
		else
		{
			foreach ($array as $key => $value)	
			{
				if ($vtype == $parseArray[0]) //KEY
				{
					if ($key == $selected)	
						$output .= "<option value='".$key."' selected='selected'>".$value."</option>";
					else
						$output .= "<option value='".$key."'>".$value."</option>";
				}
				else
				{
					if ($value == $selected)	
						$output .= "<option selected='selected'>".$value."</option>";
					else
						$output .= "<option>".$value."</option>";
				}				
			}
		}
		return JSP_CRUNCH_DDL($output);
	}
}

function JSP_DISPLAY_IOPTION ($array, $id = 'JSP_DISPLAY_IOPTION')
{
	$paramArray = array($array,$id);	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if (_THROW($array))
		{
			//SELECTED
			$selected = JSP_CRUNCH_REQUEST($id);
			//OPTION
			$array = JSP_TITLE_CASE(_CSV($array));
			foreach ($array as $key => $value)
			{
				if ($key == $selected)
					$output .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
				else				
					$output .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		return '<select class="JSP_DISPLAY_IOPTION" id="'.$id.'" onchange=BLN_ACTION_IOPTION("'.$id.'")>'.$output.'</select>';
	}
}

function JSP_DISPLAY_TSORT ($array, $vtype)
{
	$paramArray = array($array,$vtype);	
	$parseArray = array('KEY','VALUE');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$vtype))
		return JSPIP;
	else
	{
		$default = 'ALL';
		$optArray = _CSV($array);
		$optArray = JSP_PUSH_ARRAY($optArray,$default,'CURRENT');
		$selected = $_GET['BLN_ACTION_TSORT'];
		if (!isset($selected))
		{
			if ($vtype == $parseArray[0]) //KEY
				$selected = 0;
			else
				$selected = $default;
		}
		$call = JSP_DISPLAY_IOPTION($optArray,$selected,$vtype,'BLN_ACTION_TSORT');
		$output = '<div class="JSP_DISPLAY_TSORT">
		Sort by : 
		<select style="margin-left:5px; width:auto; display:inline-block;">'
			.$call.
		'</select>
		</div>';
		return $output;
	}
}

function JSP_DISPLAY_THEAD ($array)
{
	$paramArray = array(JSP_TRUEPUT($array));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$array = JSP_TITLE_CASE(_CSV($array));
		foreach ($array as $value)
			$th .= '<th>'.$value.'</th>';
		return $tr = '<tr><th>S/N</th>'.$th.'</tr>';
	}
}

function JSP_DISPLAY_TBODY ($array)
{
	$paramArray = array(JSP_TRUEPUT($array));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$array = JSP_TITLE_CASE(_CSV($array));
		if (_THROW($array))
		{
			if (_ISLIN($array))
			{							
				foreach ($array as $value)
				{
					$counter++;
					$body = '<td>'.$counter.'</td>';
					$body .= '<td>'.$value.'</td>';
					$output .= '<tr>'.$body.'</tr>';				
				}			
			}
			else
			{
				$assoc_id = array_keys($array[0]);
				for ($x = 0; $x < count($assoc_id); $x++)
				{
					$hotkeys = $assoc_id[$x];
					$counter++;						
					$body = '<td>'.$counter.'</td>';										
					for ($y = 0; $y < count($array); $y++)
					{
						$body .= '<td>'.$array[$y][$hotkeys].'</td>';
					}
					$append .= '<tr>'.$body.'</tr>';
				}
				$output .= $append;
			}
		}
		else
			$output = '<tr><td colspan="5" style="text-align:center;">No records foun.</td</tr>';
		return $output;
	}
}

function JSP_DISPLAY_TABLE ($tdarray, $tharray = array())
{
	$paramArray = array(JSP_TRUEPUT($tdarray),$tharray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		//ARRANGE
		$tdarray = JSP_TITLE_CASE(_CSV($tdarray));
		$tharray = JSP_TITLE_CASE(_CSV($tharray));		
		
		//THEAD
		if (_THROW($tharray))
		{
			$th = '<th>S/N</th>';
			foreach ($tharray as $key => $value)
				$th .= '<th>'.$value.'</th>';
			$thead = '<tr>'.$nav_left.$th.$nav_right.'</tr>';
		}

		//TBODY
		if (_THROW($tdarray))
		{
			//PAGINATION
			if ($_REQUEST['BLN_PAGI_CHANGE'])
				$start_counter = JSP_TRANS_PAGI($_REQUEST['BLN_PAGI_CHANGE']);
			else
				$start_counter = 1;					

			//LINEAR ARRAY
			if (_ISLIN($tdarray))
				$tdarray = _DIMARRAY($tdarray);
				
			//COMPUTE			
			$assoc_id = array_keys($tdarray[0]);
			for ($x = 0; $x < count($assoc_id); $x++)
			{
				$key = $assoc_id[$x];			
				$td = '<td id="nav_left_'.$key.'">'.$start_counter.'</td>';
				//BODY
				for ($y = 0; $y < count($tdarray); $y++)
				{
					$cell = JSP_TRANS_TELLER($tdarray[$y][$key]);
					if ($y == (count($tdarray) - 1))
						$td .= '<td id="nav_right_'.$key.'">'.$cell.'</td>';
					else
						$td .= '<td>'.$cell.'</td>'; //TD
				}
				$tbody .= '<tr ondblclick=BLN_DISPLAY_ITABLE_NAV("'.$key.'")>'.$td.'</tr>';
				$start_counter++;			
			}
		}
		else
		{
			$colspan = count($tharray) + 1;
			$tbody = '<tr><td colspan="'.$colspan.'" style="text-align:center;">No records found</td></tr>';
		}
			
		return '<table class="BLN_DISPLAY_TABLE box_shadow">'.$thead.$tbody.'</table>';
	}
}

function JSP_DISPLAY_ITABLE ($tharray, $tdarray, $action = 'ACTION')
{	
	$paramArray = array($tharray,JSP_TRUEPUT($tdarray),$action);	
	$parseArray = array('SELECT','VIEW','ACTION');		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$action)) 
		return JSPIP;
	else
	{
		//ARRANGE
		$tharray = JSP_TITLE_CASE(_CSV($tharray));
		$tdarray = JSP_TITLE_CASE(_CSV($tdarray));
		
		//THEAD
		if ($action == $parseArray[0]) //SELECT	
		{
			$checkbox = '<input type="checkbox" id="BLN_ACTION_SELECT_ALL" onClick="BLN_ACTION_SELECT()">';
			$th = '<th>'.$checkbox.'</th>';
		}
		$th .= '<th>S/N</th>'; //SN
		foreach ($tharray as $key => $value) //BODY
		{
			$th .= '<th>'.$value.'</th>';
		}
		if ($action != $parseArray[0]) //ACTION
			$th .= '<th>Action</th>';
		$thead = '<tr>'.$nav_left.$th.$nav_right.'</tr>';

		//TBODY
		if (_THROW($tdarray))
		{
			//PAGINATION
			if ($_REQUEST['BLN_PAGI_CHANGE'])
				$start_counter = JSP_TRANS_PAGI($_REQUEST['BLN_PAGI_CHANGE']);
			else
				$start_counter = 1;					

			//LINEAR ARRAY
			if (_ISLIN($tdarray))
				$tdarray = _DIMARRAY($tdarray);
				
			//COMPUTE			
			$assoc_id = array_keys($tdarray[0]);
			for ($x = 0; $x < count($assoc_id); $x++)
			{
				//KEY
				$key = $assoc_id[$x];
				$td = '';
				//SELECT
				if ($action == $parseArray[0])
					$td .= JSP_DISPLAY_ITABLE_SCANNER($action,$key);
				//COUNTER					
				$td .= '<td id="nav_left_'.$key.'">'.$start_counter.'</td>';
				//BODY
				for ($y = 0; $y < count($tdarray); $y++)
				{
					$cell = JSP_TRANS_TELLER($tdarray[$y][$key]); //CELL
					if ($y == (count($tdarray) - 1))
						$td .= '<td id="nav_right_'.$key.'">'.$cell.'</td>'; //TD					
					else
						$td .= '<td>'.$cell.'</td>'; //TD
				}
				//ACTION
				if ($action != $parseArray[0])
					$td .= JSP_DISPLAY_ITABLE_SCANNER($action,$key);
				
//				return $td;
				$tbody .= '<tr ondblclick=BLN_DISPLAY_ITABLE_NAV("'.$key.'")>'.$td.'</tr>'; //TR
				$start_counter++;			
			}
		}
		else
		{
			$colspan = count($tharray) + 2;
			$tbody = '<tr><td colspan="'.$colspan.'" style="text-align:center;">No records found</td></tr>';
		}
		$table = '<table class="BLN_DISPLAY_TABLE">'.$thead.$tbody.'</table>';
		return $table;
	}
}

function JSP_DISPLAY_ITABLE_SCANNER ($action, $key)
{
	$paramArray = array($action,JSP_TRUEPUT($key));		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if ($action == 'SELECT')
		{
			$attach = '<td id="nav_left_'.$key.'">
				<input type="checkbox" class="BLN_ACTION_SELECT_EACH" name="ITABLE_SELECT_VALUE[]" value="'.$key.'">
			</td>';
		}
		else if ($action == 'VIEW')
		{
			$attach = '<td id="nav_right_'.$key.'">
				<a href="#" class="t_btn t_btn_pri" onClick=BLN_ACTION_VIEW("'.$key.'")>view</a>
			</td>';
		}
		else
		{
			$parse = "Delete record?";			
			$_parse = JSP_PREP_STR($parse,'SCRIPT');
			$attach = '<td id="nav_right_'.$key.'">
				<a href="#" class="t_btn t_btn_pri" onClick=BLN_ACTION_EDIT("'.$key.'")>edit</a>
				<a href="#" class="t_btn t_btn_sec" onClick=BLN_ACTION_DELETE("'.$_parse.'","'.$key.'")>delete</a>
			</td>';
		}
		return $attach;	
	}
}

function JSP_DISPLAY_TAROT ($tharray, $tdarray)
{	
	$paramArray = array($tharray,$tdarray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		//ARRANGE
		$tharray = JSP_TITLE_CASE(_CSV($tharray));
		$tdarray = JSP_CONFIG_ARRAY(_CSV($tdarray));
		$tdarray = _CRUNCH($tdarray);
		foreach ($tdarray as $key => $value)
		{
			$thead = '<div class="th">'.$tharray[$key].' :</div>';
			$tbody = '<div class="td">'.JSP_TRANS_TELLER($value).'</div>';
			$tpair .= $thead.$tbody;
		}
		$output = '<div class="JSP_DISPLAY_TAROT" ondblclick=BLN_HEADER_ANCHOR("nav_down") id="nav_up">'
			.$tpair.'<span id="nav_down"></span>
		</div>';
		return $output;
	}
}

function JSP_DISPLAY_CARDS ($array, $button)
{
	$paramArray = array($array,JSP_TRUEPUT($button));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$array = JSP_BUILD_CSV($array);
		$countArray = count($array);		
		if ($countArray < 3 || $countArray > 4)
			return JSPIL;
		if (_ISDIM($array))
		{
			$configArray = JSP_CONFIG_ARRAY($array);
			foreach ($configArray as $index => $assoc_array)
				$output .= JSP_DISPLAY_CARDs($assoc_array,$button);
			return $output;			
		}
		else
		{
			if ($button)
				$buttonDiv = "<td><a href='#' onClick='BLN_CARDS_VIEW(".$key.")'>".$button."</a></td>";
			$pointer = 0;
			foreach ($array as $key => $value)
			{
				if ($pointer == 0)
					$append = "<tr><th colspan='2'>".$value."</th></tr>";					
				else if ($pointer == ($countArray - 1))
					$append .= "
					<tr>
						<td class='footnote'>".$value."</td>"
						.$buttonDiv.
					"</tr>";	
				else
				{
					$article = JSP_WRAP_STR($value);
					if ($countArray == 3 && $pointer == 1)
						$append .= "<tr><td colspan='2' class='article'>".$article."</td></tr>";
					else
					{
						if ($pointer == 1)					
							$append .= "<tr><td colspan='2' class='subtitle'>".$value."</td></tr>";					
						else
							$append .= "<tr><td colspan='2' class='article'>".$article."</td></tr>";					
					}									
				}									
				$pointer++;
			}
			$body = "<li><table>".$append."</table></li>";
		}
		$output = "<ul class='JSP_DISPLAY_CARDS'>".$body."</ul>";
		return $output;
	}
}

function JSP_DISPLAY_POSTCARD ($array)
{
	$paramArray = array($array);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$array = JSP_BUILD_CSV($array);
		$countArray = count($array);			
		if (_ISDIM($array))
		{
			$configArray = JSP_CONFIG_ARRAY($array);
			foreach ($configArray as $index => $assoc_array)
				$output .= JSP_DISPLAY_POSTCARD($assoc_array);
			return $output;
		}
		else
		{
			$i = 0;			
			foreach ($array as $key => $value)			
			{
				if ($i == 0)
					$cell_1 = "<td class='thumb' style='background-image:url(".$value.");'>&nbsp;</td>";
				else if ($i == 1)
					$append = "<div class='title'>".$value."</div>";
				else
				{
					$footer = JSP_WRAP_STR($value,320);
					if (count($array) == 3)
						$append .= "<div class='article'>".$value."</div>";
					else if (count($array) == 4)
					{
						if ($i == 2)
							$append .= "<div class='subtitle'>".$value."</div>";
						else
							$append .= "<div class='article'>".$value."</div>";
					}
					else
					{
						if ($i == 2)
							$append .= "<div class='subtitle'>".$value."</div>";
						else if ($i == 3)
							$append .= "<div class='article'>".$value."</div>";
						else
							$append .= "<div class='footnote'>".$footer."</div>";
					}						
				}
				$cell_2 = "<td class='narration'>".$append."</td>";
				$i++;					
			}
			$cellAppend = "<tr>".$cell_1.$cell_2."</tr>";
			$table = "<table class='mainTable'>".$cellAppend."</table>";
			$body = "<li>".$table."</li>";
		}
		$output = "<ul class='JSP_DISPLAY_POSTCARD'>".$body."</ul>";		
		return $output;		
	}
}

function JSP_DISPLAY_ALBUM ($imageFolder = JSP_BASE_GALLERY, $transitionTime = 10)
{
	$paramArray = array($imageFolder,$transitionTime);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (!is_numeric($transitionTime)) 
		return JSPIP;					
	else
	{
		//RENAME FOLDERS
		$folderArray = JSP_FOLDER_REPAIR($imageFolder);
		foreach ($folderArray as $folder)			
		{
			$folderName = JSP_FILE_TMP($folder);
			$folderTmp = $imageFolder.$folderName.'/';
			$folderFile = JSP_FOLDER_CONTENT($folderTmp);
			$folderStat = count($folderFile);			
			//EXCLUDE EMPTY FOLDER
			if ($folderStat)
			{
				$nameArray[] = $folderName;
				$statArray[] = $folderStat;
				foreach ($folderFile as $files)
				{
					//KEEP ASSOC_KEYS
					$assoc_key = array_keys($nameArray,$folderName);
					$assoc_key = $assoc_key[0];
					$tmp_name = JSP_FILE_TMP($files);
					$uproot = _UPROOT($imageFolder.$folderName.'/'.$tmp_name);
					$fileArray[$assoc_key][] = $uproot;
				}								
			}
		}
		$newArray = array($fileArray,$nameArray,$statArray);		
		//DISPLAY SETTING
		$transitionTime = $transitionTime * 1000;		
		$assoc_array = count($newArray[0]);
		for ($i = 0; $i < $assoc_array; $i++)
		{
			$thumbnail = '';
			foreach ($newArray[0][$i] as $images)
				$thumbnail .= "<li>".$images."</li>";
			$folder = JSP_NAME_SPACE($newArray[1][$i],'DROP');
			$stat = $newArray[2][$i];
			$li .= "<li onClick=BLN_REQUEST_SET('".$i."')>
				<div class='thumbnail JSP_DISPLAY_ALBUM_TARGET'>
					<ol style='display:none;'>".$thumbnail."</ol>
				</div>
				<div class='narration'>
					<span class='folder'>".$folder."</span>
					<span class='stat'>".$stat." Photos</span>
				</div>                
			</li>";
		}
		$output = "<ul class='JSP_DISPLAY_ALBUM' transition='".$transitionTime."'>".$li."</ul>";
		return $output;
	}	
}

function JSP_DISPLAY_GALLERY ($array = JSP_BASE_GALLERY)
{
	$paramArray = array($array);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if (!JSP_FILE_ISFILE($array)) //if folder parsed
			$array = JSP_FOLDER_CONTENT($array);
		else
			$array = _CSV($array);

		foreach ($array as $key => $value)
		{
			$fileArray[] = $value = JSP_FILE_UPROOT($value);
			$body .= '<li style=background-image:url("'.$value.'"); onClick=BLN_PREVIEW_OPEN("'.$value.'")>&nbsp;</li>';
		}
//		return $fileArray;
		$output = "<ul class='JSP_DISPLAY_GALLERY'>".$body."</ul>";
		$preview = "<div class='JSP_DISPLAY_PREVIEW'>
			<div class='dim' id='JSP_DISPLAY_PREVIEW_DIM' onclick='BLN_PREVIEW_CLOSE()'></div>
			<div class='wrap' id='JSP_DISPLAY_PREVIEW_WRAP'>
				<span class='exit' title='Close' onclick='BLN_PREVIEW_CLOSE()'>&times;</span>   
				<img id='JSP_DISPLAY_PREVIEW_IMAGE' />
			</div>        
		</div>";
		return $output.$preview;		
	}
}

function JSP_DISPLAY_VIDEO ($array = JSP_BASE_VIDEO, $limit = 'ALL', $width = 250)
{
	$paramArray = array($array,$limit,$width);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if (!JSP_FILE_ISFILE($array)) //if folder parsed
			$array = JSP_FOLDER_CONTENT($array,'VIDEO');
		else
			$array = _CSV($array);

		if ($limit == 'ALL' || $limit == '*')
			$limit = count($array);
		$counter = 0;
		foreach ($array as $key => $value)
		{
			if ($counter < $limit && _THROW(_STRPOS($value,'mp4')))
			{
				$fileArray[] = $value = JSP_FILE_UPROOT($value);
				$body .= '<li>
					<video width="'.$width.'" title="Play Media" style="cursor:pointer;">
						<source src="'.$value.'" type="video/mp4">
						media unavailable at this time.            
					</video>	
				</li>';
			}
			$counter++;
		}
//		return $fileArray;
		$output = "<ul class='JSP_DISPLAY_VIDEO'>".$body."</ul>";
		return $output;		
	}
}

function JSP_DISPLAY_DOWPDF ($base = JSP_BASE_UPLOADS, $limit = 'ALL')
{
	$paramArray = array($base,$limit);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		//ARRANGE
        $doc = _CONTENT($base,'DOC');
        $pdf = JSP_SORT_FILE($doc,'pdf');
        $uproot = _UPROOT($pdf);
		//LIMIT
		if ($limit == 'ALL' || $limit == '*')
			$limit = count($uproot);				
		$counter = 0;
        foreach ($uproot as $src)
		{
			$butch = JSP_FILE_BUTCHER($src);
			$tmp = JSP_NAME_SPACE($butch['TMP'],'DROP');
			$filename = '<div class="filename">'.JSP_BUTCHER_STR($tmp,'.pdf','RIGHT').'</div>';
			$download = '<a href="'.$src.'">Download</a>';
			if ($counter < $limit)
			{				
				$icon = '<img src="Media/Icon/PDF.png" />';
				$li .= '<li>'.$icon.$filename.$download.'</li>';
			}
			$counter++;
		}
		return '<ul class="JSP_DISPLAY_DOWPDF">'.$li.'</ul>';
	}
}

function JSP_DISPLAY_DOWVID ($base = JSP_BASE_VIDEO, $limit = 'ALL')
{
	$paramArray = array($base,$limit);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		//ARRANGE
        $video = _CONTENT($base,'VIDEO');
        $mp4 = JSP_SORT_FILE($video);
        $uproot = _UPROOT($mp4);
		//LIMIT
		if ($limit == 'ALL' || $limit == '*')
			$limit = count($video);				
		$counter = 0;
        foreach ($uproot as $src)
		{
			$butch = JSP_FILE_BUTCHER($src);
			$tmp = JSP_NAME_SPACE($butch['TMP'],'DROP');
			$filename = '<div class="filename">'.JSP_BUTCHER_STR($tmp,'.mp4','RIGHT').'</div>';
			$download = '<a onClick="BLN_DISPLAY_DOWVID()">Download</a>';
			
			if ($counter < $limit)
			{				
				$video = '<video controls title="Click to play/pause media">
					<source src="'.$src.'" type="video/mp4">
					media unavailable at this time.
				</video>';
				$li .= '<li>'.$video.$filename.$download.'</li>';
			}
			$counter++;
		}
		return '<ul class="JSP_DISPLAY_DOWVID">'.$li.'</ul>';
	}
}

function JSP_DISPLAY_DUMP ($parseArray)
{
	if (!$parseArray || !JSP_ATYPE($parseArray))
		echo $parseArray;
	else
	{
		foreach ($parseArray as $key => $value)
		{
			$newArray[0][] = $key;
			if (!$value) //EMPTY
				$newArray[1][] = '- -';
			else if (strlen($value)) //STR
			{
				if (substr($value,0,1) == '#' && (strlen($value) == 4 || strlen($value) == 7)) //HEX ENTRY
				{
					$div = '<div style="background-color:'.$value.'; width:20px; height:20px; display:inline-block;">&nbsp;</div>';
					$newArray[1][] = $div.'&nbsp;&nbsp;'.$value;
				}								
				else				
					$newArray[1][] = $value;
			}
			else //ARRAY
			{
				if (_ISDIM($value)) //MULTI-DIM ARRAY
				{					
					$newArray[1][] = JSP_DISPLAY_MACRO($value);	
					foreach ($value as $key_1 => $tree_1) //FIELD->Admin_tb
					{				
						foreach ($tree_1 as $key_2 => $tree_2) //Admin_tb->username
						{
							if (_ISDIM($tree_2))
							{
								$counter = 1;
								$JSP_DISPLAY_MACRO = '';								
								foreach ($tree_2 as $key_3 => $tree_3) //RECORD->array()
								{
									$JSP_DISPLAY_MACRO .= '<span class="watermark">'.$counter.'</span>';
									$JSP_DISPLAY_MACRO .= '<div class="border-bottom";">'.JSP_DISPLAY_MACRO($tree_3).'</div>';
									$counter++;									
								}
								$newArray[1][] = $JSP_DISPLAY_MACRO;						
							}
							else
								$newArray[1][] = JSP_DISPLAY_MACRO($tree_2);								
							$newArray[0][] = $key.' ['.$key_1.'->'.$key_2.']';
						}
					}		
				}
				else
					$newArray[1][] = JSP_DISPLAY_MACRO($value);
			}
		}
//		return array($parseArray,$newArray);
		echo JSP_SPRY_SHOWING($newArray[0]); 
		echo JSP_DISPLAY_TABLE($newArray);
	}
}
?>
