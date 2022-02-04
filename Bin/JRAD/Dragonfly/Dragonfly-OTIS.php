<?php
function DRA_OTIS_SCREEN ()
{
	return _BYCOL(JSP_TABLE_TEAM,'ip');
}

function DRA_OTIS_MANTRA ()
{
	$amp = 920915;
	if (_THROW(DRA_OTIS_SWISS()))
		$amp = $amp + DRA_OTIS_SWISS();
	return 'You and <kbd>'._DENOM($amp).'</kbd> others can now ';
}

function DRA_OTIS_VISITOR_PREP ()
{
	$TABLE = JSP_TABLE_VISITOR;	
	if (_EXIST($TABLE,'ip',_IP))
	{
		$row = _SWITCH($TABLE,'ip',_IP);
		$counter = $row['counter'] + 1;
		$whereArray = array('ip',_IP);
		_UPDATE_ASSOC($TABLE,'counter,date,time',$counter,$whereArray);
	}
	else
		_CREATE($TABLE,array(_IP,1));
}

function DRA_OTIS_VISITOR ()
{
	$screenArray = array('197.211.52.16','127.0.0.1');
	if (!in_array(_IP,$screenArray))
	{
		$TABLE = JSP_TABLE_OTIS;		
		$TABLE_2 = JSP_TABLE_VISITOR;
		$last = JSP_FETCH_LAST($TABLE_2);
		if (_THROW($last)) //NON EMPTY TABLE
		{ 
			if (_DATE == $last['date']) //TODAY
				DRA_OTIS_VISITOR_PREP();
			else //YESTERDAY
			{
				$total = JSP_FETCH_SUM($TABLE_2,'counter');
				$unique = JSP_FETCH_NUMROWS($TABLE_2);			
				
				if (_EXIST($TABLE,'date',_DATE)) //UPDATE BACK DATE
				{
					$row = _SWITCH($TABLE,'date',_DATE);
					$total = $row['total_ip'] + $total;
					$unique = $row['unique_ip'] + $unique;
					$entryArray = array($total,$unique);
					$whereArray = array('date',_DATE);
					_UPDATE_ASSOC($TABLE,'*',$entryArray,$whereArray);
				}
				else
				{
					$entryArray = array($total,$unique);
					_CREATE($TABLE,$entryArray);
				}
				_DELETE($TABLE_2,'*');
				DRA_OTIS_VISITOR_PREP();			
			}
		}
		else
			DRA_OTIS_VISITOR_PREP();
	}
}

function DRA_OTIS_SWISS ($class)
{
	$TABLE = JSP_TABLE_OTIS;		
	$TABLE_2 = JSP_TABLE_VISITOR;
	
	//TODAY
	$today_total = JSP_FETCH_SUM($TABLE_2,'counter');
	$today_unique = JSP_FETCH_NUMROWS($TABLE_2);
	$today_average = round($today_total/$today_unique);
	//NET
	$net_total = JSP_FETCH_SUM($TABLE,'total_ip') + $today_total;
	$net_unique = JSP_FETCH_SUM($TABLE,'unique_ip') + $today_unique;
	$net_average = round($net_total/$net_unique);
	//THIS MONTH
	$this_month = _BYDATE($TABLE,'THIS MONTH');
	$month_total = 	array_sum($this_month[0]) + $today_total;
	$month_unique = array_sum($this_month[1]) + $today_unique;
	$month_average = round($month_total/$month_unique);	
	//RECENT
	$recent = JSP_FETCH_LAST($TABLE_2);
	//RESOURCE
	$daily_ave = round($net_unique / (_NUMROWS($TABLE) + 1));	
	$yesterday = _BYDATE($TABLE,'YESTERDAY');	
	$last_29 = JSP_FETCH_LIMIT($TABLE,29);
	foreach ($last_29 as $id => $row)
		$last_29_unique += $row['unique_ip']; 	
	//MAP
	$map['mau'] = $daily_ave * 30; //monthly unique users
	$map['dau'] = $daily_ave; //ave unique users
	$map['yau'] = current($yesterday[1]);  //yesterday unique users
	$map['tau'] = $today_unique;  //today unique users
	$map['offset'] = $map['tau'] - $map['yau'];  //diff btw today unique and yesterday unique 
	$offset_perc = _THROW(JSP_PERCOF($map['yau'],$map['tau'])); //perc ratio btw today unique and yesterday unique
	if ($offset_perc > 100)
		$offset_status = 'UP';
	else
		$offset_status = 'DOW';
	$offset_by = abs(100 - substr($offset_perc,0,-1));
	$map['offset'] .= ' / '.$offset_perc.'&nbsp;&nbsp; ('.$offset_status.' BY '.$offset_by.'%)';
	$map['l30'] = $last_29_unique + $today_unique; //last 29 rows unique + today unique	
		$map['rrt'] = $net_average; //ave pings per user
	

	$map['net']['total'] = $net_total;
	$map['net']['unique'] = $net_unique;
	$map['net']['average'] = $net_average;
	
	$map['today']['total'] = $today_total;
	$map['today']['unique'] = $today_unique;
	$map['today']['average'] = $today_average;
	
	$map['perc']['total'] = JSP_PERCOF($net_total,$today_total);
	$map['perc']['unique'] = JSP_PERCOF($net_unique,$today_unique);
	$map['perc']['average'] = JSP_PERCOF($net_average,$today_average);
	
	$map['month']['total'] = $month_total;
	$map['month']['unique'] = $month_unique;
	$map['month']['average'] = $month_average;
	
	$map['recent'] = $recent;

	$parseArray = JSP_BUILD_CASE(array_keys($map));
	if (in_array($class,$parseArray))
		$output = $map[strtolower($class)];
	else if ($class == 'MAP') 
		$output = $map;
	else if ($class == 'METRIC') 
		$output = array($map['mau'],$map['dau'],$map['yau'],$map['tau'],$map['offset'],$map['l30'],$map['rrt']);
	else
		$output = $net_unique;
		
	return $output;
}
?>
