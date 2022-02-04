<?php
function JSP_CHART_LOGIC ($array, $pointer, $increment)
{
	$paramArray = array($array,JSP_TRUEPUT($pointer),JSP_TRUEPUT($increment));	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (!is_numeric($increment))
		return JSPIP;		
	else
	{
		$arrayKeys = array_keys($array);	
		$realPointer = $arrayKeys[$pointer];
		$value = $array[$realPointer];
		$peak = JSP_APEX_ARRAY($array,'HIGH') + $increment;
		$float = ($value * 100) / $peak;
		$round = round($float);
		$substr = substr($round,-1,1);
		if (in_array($substr,range(0,4)))
		{
			$real = floor($round / 10) * 10;
		}
		else
		{
			$real = ceil($round / 10) * 10;
		}
		return $real;
	}
}

function JSP_CHART_CUBE ($dataLabel, $dataValue, $keyLabel, $type)
{
	$paramArray = array($dataLabel,$dataValue,$keyLabel);
	$parseArray = array('SINGLE','PAIR');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else if (JSP_PARAM_PARSE($parseArray,$type)) 
		return JSPIP;				
	else
	{
		if ($type == $parseArray[0]) //SINGLE
			return JSP_CHART_SINGLE($dataLabel,$dataValue,$keyLabel,'JSP_CHART_CUBE');
		else
			return JSP_CHART_PAIR($dataLabel,$dataValue,$keyLabel,'JSP_CHART_CUBE');		
	}
}

function JSP_CHART_DISC ($dataLabel, $dataValue, $keyLabel, $type)
{
	$paramArray = array($dataLabel,$dataValue,$keyLabel);
	$parseArray = array('SINGLE','PAIR');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else if (JSP_PARAM_PARSE($parseArray,$type)) 
		return JSPIP;				
	else
	{
		if ($type == $parseArray[0]) //SINGLE
			return JSP_CHART_SINGLE($dataLabel,$dataValue,$keyLabel,'JSP_CHART_DISC');
		else
			return JSP_CHART_PAIR($dataLabel,$dataValue,$keyLabel,'JSP_CHART_DISC');		
	}
}

function JSP_CHART_SINGLE ($dataLabel, $dataValue, $keyLabel, $blot)
{
	$paramArray = array($dataLabel,$dataValue,$keyLabel,$blot);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		//build array
		$dataLabel = JSP_BUILD_CSV($dataLabel);
		$dataValue = JSP_BUILD_CSV($dataValue);	
		$keyLabel = JSP_BUILD_CSV($keyLabel);				

		//count array and check errors
		$dlCount = count($dataLabel);
		$dvCount = count($dataValue);
		if ($dlCount < $dvCount)
			return JSPIL;		

		//fill-in blank data values
		$arrayDiff = $dlCount - $dvCount;
		$blanks = 0;
		while ($blanks < $arrayDiff)
		{
			$dataValue[] = '';
			$blanks++;
		}
		
		//dlBuild
		foreach ($dataLabel as $value)
		{
			$dlBody .= "<td>".$value."</td>";
		}
		$dlBuild = "<tr><td>&nbsp;</td>".$dlBody."</tr>";
				
		//dvBuild
		foreach	($dataValue as $value)
		{
			$dvBody .= "<td>".$value."</td>";		
		}
		$dvBuild = "<tr class='JSP_CHART_KEY'><td>".$keyLabel."</td>".$dvBody."</tr>";	
			
		//scaleBuild
		$scale = range(100,10,10);
		for ($tr = 0; $tr < count($scale); $tr++)
		{
			for ($td = 0; $td < $dlCount + 1; $td++)
			{
				if ($td == 0)	
				{		
					$body = "<td>".$scale[$tr]."%</td>";
				}
				else
				{
					$realtd = $td - 1;
					$logic = JSP_CHART_LOGIC($dataValue,$realtd,25);
					if ($logic == $scale[$tr])
					{
						$active[$realtd] = $tr;						
						$tooltip = $dataLabel[$realtd].' '.$keyLabel.': '.$dataValue[$realtd];
						$body .= "<td class='JSP_CHART_ACTIVE' tooltip='".$tooltip."'><div class='".$blot."'>&nbsp;</div></td>";
					}
					else
					{
						$body .= "<td>&nbsp;</td>";
					}					
				}
			}
			$scaleBuild .= "<tr>".$body."</tr>";
		}
		$tbody = "<tbody>".$scaleBuild."</tbody>";
		$tfoot = "<tfoot>".$dlBuild.$dvBuild."</tfoot>";				
		return "<table class='JSP_CHART_SINGLE'>".$tbody.$tfoot."</table>";
	}
}

function JSP_CHART_PAIR ($dataLabel, $dataValue, $keyLabel, $blot)
{
	$paramArray = array($dataLabel,$dataValue,$keyLabel,$blot);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		//build array
		$dataLabel = JSP_BUILD_CSV($dataLabel);
		$dataValue = JSP_BUILD_CSV($dataValue);				
		$keyLabel = JSP_BUILD_CSV($keyLabel);			

		//count array and check errors
		$dlCount = count($dataLabel);
		$dvCount = count($dataValue);
		$klCount = count($keyLabel);					
		if ($dlCount < count($dataValue[0]) || $dvCount != $klCount)
			return JSPIL;
		if (JSP_ATYPE($dataValue) != 2)
			return JSPIP;								
		
		//fill-in blank data values
		foreach ($dataValue as $index => $assoc_array)	
		{
			$arrayDiff = $dlCount - count($assoc_array);
			$blanks = 0;
			while ($blanks < $arrayDiff)
			{
				$assoc_array[] = '';
				$blanks++;
			}
			$newArray[$index] = $assoc_array;
		}
		$dataValue = $newArray;

		//dlBuild
		foreach ($dataLabel as $value)
		{
			$dlBody .= "<td colspan='".$dvCount."'>".$value."</td>";
		}
		$dlBuild = "<tr><td>&nbsp;</td>".$dlBody."</tr>";
				
		//dvBuild
		$counter = 0;
		$colorcode = 1;
		foreach	($dataValue as $assoc_array)
		{
			$JSP_CHART_KEY = 'JSP_CHART_KEY_'.$colorcode;
			$dvBody = '';
			foreach ($assoc_array as $value)
			{
				$dvBody .= "<td colspan='".$dvCount."'>".$value."</td>";		
			}
			$dvBuild .= "<tr class='".$JSP_CHART_KEY."'><td>".$keyLabel[$counter]."</td>".$dvBody."</tr>";						
			$counter++;
			$colorcode++;
		}

		//scaleBuild
		$scale = range(100,10,10);
		for ($tr = 0; $tr < count($scale); $tr++)
		{
			for ($td = 0; $td < $dlCount + 1; $td++)
			{
				if ($td == 0)	
				{		
					$body = "<td>".$scale[$tr]."%</td>";
				}
				else
				{
					$realtd = $td - 1;
					$counter = 0;					
					$colorcode = 1;
					foreach ($dataValue as $assoc_array)
					{
						$logic = JSP_CHART_LOGIC($assoc_array,$realtd,25);
						$JSP_CHART_BLOT = 'JSP_CHART_BLOT_'.$colorcode;						
						if ($logic == $scale[$tr])
						{
							$active[$td][] = $tr;						
							$tooltip = $dataLabel[$realtd].' '.$keyLabel[$counter].': '.$assoc_array[$realtd];
							$body .= "<td class='JSP_CHART_ACTIVE' tooltip='".$tooltip."'><div class='".$blot." ".$JSP_CHART_BLOT."'>&nbsp;</div></td>";
						}
						else
						{
							$body .= "<td>&nbsp;</td>";
						}
						$counter++;
						$colorcode++;						
					}
				}
			}
			$scaleBuild .= "<tr>".$body."</tr>";
		}
		$tbody = "<tbody>".$scaleBuild."</tbody>";
		$tfoot = "<tfoot>".$dlBuild.$dvBuild."</tfoot>";				
		return "<table class='JSP_CHART_PAIR'>".$tbody.$tfoot."</table>";
	}
}

function JSP_CHART_PARALAX ($dataLabel, $dataValue, $keyLabel)
{
	$paramArray = array($dataLabel,$dataValue,$keyLabel);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		//build array
		$dataLabel = JSP_BUILD_CSV($dataLabel);
		$dataValue = JSP_BUILD_CSV($dataValue);		
		$scale = range(10,100,10);				

		//count array and check errors
		$dlCount = count($dataLabel);
		$dvCount = count($dataValue);
		
		//error check and fill-in blanks
		if (JSP_CTYPE($dataValue) != 1)
			return JSPIP;		
		if ($dlCount < $dvCount)
			return JSPIL;		
		$arrayDiff = $dlCount - $dvCount;
		$blanks = 0;
		while ($blanks < $arrayDiff)
		{
			$dataValue[] = '';
			$blanks++;
		}
		
		//dlBuild
		$index = 0;
		$length = count($scale) + 1;
		foreach ($dataLabel as $label)
		{
			for ($i = 0; $i < $length; $i++)
			{
				if ($i == 0)
				{
					$td = "<td>".$label."</td>";
					$x = "<td>&nbsp;</td>";					
				}
				else
				{
					$logic = JSP_CHART_LOGIC($dataValue,$index,25);
					$substr = substr($logic,0,-1);
					if ($substr == $i)
					{
						$active[$index + 1] = $substr;
						$tooltip = $label.' '.$keyLabel.': '.$dataValue[$index];
						$td .= "<td class='JSP_CHART_ACTIVE' tooltip='".$tooltip."'>&nbsp;</td>";
					}
					else
						$td .= "<td>&nbsp;</td>";
					$x .= "<td>&nbsp;</td>";									
				}
			}
			$dlBuild .= "<tr class='JSP_CHART_LABEL'>".$td."</tr>";
			$dlBuild .= "<tr class='JSP_CHART_LABEL'>".$x."</tr>";			
			$index++;
		}

		//scaleBuild
		foreach ($scale as $value)
		{
			$scaleBody .= "<td>".$value."%</td>";
		}
		$scaleBuild = "<tr class='JSP_CHART_SCALE'><td>&nbsp;</td>".$scaleBody."</tr>";
				
		//keyBuild
		$keyBody .= 
		"<ol>
			<li>
				<div class='JSP_CHART_RIBBON'>&nbsp;</div>
			</li>
			<li>".$keyLabel."</li>
		</ol>";
		$keyBuild = "<tr class='JSP_CHART_KEY'><td>&nbsp;</td><td colspan='10'>".$keyBody."</td></tr>";

		$tbody = "<tbody>".$dlBuild."</tbody>";
		$tfoot = "<tfoot>".$scaleBuild.$keyBuild."</tfoot>";				
		return "<table class='JSP_CHART_PARALAX'>".$tbody.$tfoot."</table>";
	}
}

function JSP_CHART_MACRO ($dataLabel, $dataValue)
{
	$paramArray = array($dataLabel,$dataValue);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$dataLabel = JSP_BUILD_CSV($dataLabel);
		$dataValue = JSP_BUILD_CSV($dataValue);
		if (JSP_ATYPE($dataLabel) != 1 || JSP_ATYPE($dataValue) != 1)
			return JSPIL;
		if (JSP_CTYPE($dataValue) != 1)
			return JSPIP;
			
		$dlKeys = array_keys($dataLabel);
		$dvKeys = array_keys($dataValue);		
		$pointer = 0;		
		foreach ($dataLabel as $label)
		{
			$logic = JSP_CHART_LOGIC($dataValue,$pointer,0);
			$colspan = substr($logic,0,-1);		
			$td = "<td class='JSP_CHART_LABEL'>".$label."</td>";
			$scale = range(1,10);
			foreach ($scale as $cell)
			{
				if ($cell <= $colspan)
				{
					$realkey = $dvKeys[$pointer];
					$tooltip = $dataValue[$realkey].' Units.';
					$td .= "<td class='JSP_CHART_VALUE JSP_CHART_ACTIVE' tooltip='".$tooltip."'>&nbsp;</td>";
					$active[$pointer] = $colspan;
				}
				else
 					$td .= "<td class='JSP_CHART_VALUE'>&nbsp;</td>";			
			}		
			$tr = "<tr>".$td."</tr>"; 
			$body .= $tr;
			$pointer++;			
		}
		$output = "<table class='JSP_CHART_MACRO'>".$body."</table>";
		return $output;		
	}
}

function JSP_CHART_STATUS ($current, $total)
{
	$paramArray = array($current,$total);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else if (!is_numeric($current) || !is_numeric($total)) 
		return JSPIP;				
	else
	{
		$array = array($current,$total);
		$logic = JSP_CHART_LOGIC($array,0,0);
		$_logic = $logic.'%';
      	$body = "<div class='JSP_CHART_ACTIVE' style='width:".$_logic.";' title='".$_logic."'>&nbsp;</div>";
        $output = "<div class='JSP_CHART_STATUS'>".$body."</div>";
		return $output;		
	}
}

function JSP_CHART_PACKAGE ($launchDate)
{
	$paramArray = array($launchDate);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		//CHART SETTING		
		$launchArray = JSP_CRUNCH_DATE($launchDate,'ARRAY');	
		$launchYear = $launchArray['year'];				
		$launchMonth = $launchArray['month'];		
		$currentArray = JSP_CRUNCH_DATE(JSP_DATE_SHORT,'ARRAY');		
		$currentMonth = $currentArray['month'];
		for ($i = 0; $i < 12; $i++)
		{
			$numberLine[] = $launchMonth;
			$launchMonth++;
			if ($launchMonth > 12)
				$launchMonth = 1;
		}
		$pointer = array_keys($numberLine,$currentMonth);
		$pointer = $pointer[0] + 1;
		$actual = JSP_CHART_LOGIC(array($pointer,12),0,0);
		if ($actual > 80)
			$color = '#EE1111';
		else
			$color = '#0093DD';
		$perc = $actual.'%';
      	$title = "<div class='title'>Domain renewal</div>";
      	$ink = "<div class='ink' style='width:".$perc."; background-color:".$color.";' title='".$perc."'>&nbsp;</div>";
		$tube = "<div class='tube'>".$ink."</div>";
		//EXPIRE DATE SETTING
		$endYear = $launchYear + 1;		
		$endMonth = $launchMonth - 1;		
		if ($endMonth < 1)
		{
			$endMonth = 12; 
			$endYear = $launchYear;
		}
		$yesterArray = JSP_CAL_MKYESTER($launchDate,'SHORT');
		$endArray = JSP_CRUNCH_DATE($yesterArray,'ARRAY');
		$endDay = $endArray['day'];
		$monthFull = JSP_BUTCHER_DATE('1992/'.$endMonth.'/15','MONTH FULL','SHORT'); 
		$mkExpire = $monthFull.' '.$endDay.', '.$endYear;
      	$footer .= "<div class='footer'>".$mkExpire.".</div>";
		//OUTPUT
		$output = "<div class='JSP_CHART_PACKAGE'>".$title.$tube.$footer."</div>";
		return $output;
	}
}

function JSP_CHART_BAR ($dataLabel, $dataValue)
{
	$paramArray = array($dataLabel,$dataValue);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$dataLabel = JSP_BUILD_CSV($dataLabel);
		$dataValue = JSP_BUILD_CSV($dataValue);
		if (JSP_ATYPE($dataLabel) != 1 || JSP_ATYPE($dataValue) != 1)
			return JSPIL;
		if (JSP_CTYPE($dataValue) != 1)
			return JSPIP;
			
		$dlKeys = array_keys($dataLabel);
		$dvKeys = array_keys($dataValue);		
		$pointer = 0;		
		foreach ($dataLabel as $label)
		{
		$current = 0;			
			$logic = JSP_CHART_LOGIC($dataValue,$pointer,50000);
			$colspan = substr($logic,0,-1);		
			$td = "<td class='JSP_CHART_LABEL'>".$label."</td>";
			$scale = range(1,10);
			foreach ($scale as $cell)
			{
				if ($cell <= $colspan)
				{
					$realkey = $dvKeys[$pointer];
					$td .= "<td class='JSP_CHART_VALUE JSP_CHART_NACTIVE'>
						<div class='JSP_CHART_INSIDE'>&nbsp;</div>
					</td>";
					$active[$pointer] = $colspan;
				}
				else
				{
					if ($current == 0)
	 					$td .= "<td class='JSP_CHART_VALUE'><div class='actual'>".JSP_BUILD_DENOM($dataValue[$pointer],'BASIC')."</td>";
					else					
 						$td .= "<td class='JSP_CHART_VALUE'>&nbsp;</td>";			
					$current++;						
				}
			}		
			$tr = "<tr>".$td."</tr>"; 
			$body .= $tr;
			$pointer++;						
		}
		$output = "<div class='JSP_CHART_BAR_WRAP'>
			<table class='JSP_CHART_BAR'>
				<tr>
					<td>&nbsp;</td>
					<td class='JSP_CHART_VALUE' colspan='10'>&nbsp;</td>
				</tr>
				".$body."
			</table>
		</div>";
		return $output;		
	}
}

function JSP_CHART_CODEPEN ($caption, $dataAxis, $dataValue, $dataKey)
{
	$paramArray = array($caption,$dataAxis,$dataValue,$dataKey);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;		
	else
	{
		$dataKey = JSP_BUILD_CSV($dataKey);
		//THEAD
		foreach ($dataKey as $key => $value)
		{
			$theadBody .= "<th class='JSP_CHART_BLOT_".$key."'>".$value."</th>";
		}
		$theadBuild = "<tr><th>&nbsp;</th>".$theadBody."</tr>";
		//Y-AXIS
		foreach ($dataAxis[0] as $value)
		{
			$yaxisBuild .= 	"<div><p>".JSP_BUILD_DENOM($value,'BASIC')."%</p></div>";
		}
		//X-AXIS
		foreach ($dataAxis[1] as $key => $value)
		{
			$th = "<th scope='row'>".$value."</th>";
			$td = '';
			foreach ($dataValue as $index => $assoc_array)
			{
				$height = $assoc_array[$key]; 
//				$height = round($height/166);			
				$td .= "<td class='JSP_CHART_BLOT_".$index." bar' style='height:".$height."px;'>
					<p style='color:#fff;'>".JSP_BUILD_DENOM($height,'BASIC')."</p>
				</td>";
			}
			$tbodyBuild .= "<tr id='JSP_CHART_ROW_".$key."'>".$th.$td."</tr>";	
		}				
		$output = "<div class='JSP_CHART_CODEPEN'>
			<table>
				<caption>".$caption."</caption>
				<thead>".$theadBuild."</thead>
				<tbody>".$tbodyBuild."</tbody>				
			</table>
			<div class='yaxis'>".$yaxisBuild."</div>
		</div>";
		return $output;		
	}
}

?>
