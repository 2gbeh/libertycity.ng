<?php
function JSP_ENUMS_GENERIC ($param)
{
	$paramArray = array($param);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if ($param == 'GENDER')
			$output = array('male','female');
		else if ($param == 'SEX')
			$output = array('m','f');
		else if ($param == 'AGE_RANGE')
			$output = array('13 - 17','18 - 24','25 - 34','35 - 54','55+');			
		else if ($param == 'STATUS')
			$output = array('single','married','separated','divorced','widowed');		
		else if ($param == 'STATE')
			$output = array('abia','adamawa','akwa ibom','anambra','bauchi','bayelsa','benue','borno','cross river','delta','ebonyi','edo','ekiti','enugu','gombe','imo','jigawa','kaduna','kano','katsina','kebbi','kogi','kwara','lagos','nasarawa','niger','ogun','ondo','osun','oyo','plateau','rivers','sokoto','taraba','yobe','zamfara','abuja fct');
		else if ($param == 'BANK')
			$output = array('access bank','aso bank','citi bank','diamond bank','ecobank','FCMB','fidelity bank','first bank','guaranty trust bank','heritage bank','jaiz bank','jubilee bank','keystone bank','mainstreet bank','page MFB','skye bank','stanbic ibtc','standard chartered bank','sterling bank','suntrust bank','UBA','union bank','unity bank','wema bank','zenith bank');
		else if ($param == 'ANSWER')
			$output = array('yes','no');
		else
			JSPIP;
		return JSP_TITLE_CASE($output);			
	}
}

function JSP_ENUMS_DATE ($param)
{
	$paramArray = array($param);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if ($param == 'DOW_INDEX')
			$output = range(1,7);
		else if ($param == 'DOW_INDEX_UNIX')
			$output = range(0,6);
		else if ($param == 'DOW_SUBSTR')
		{
			$newArray = JSP_ENUMS_DATE('DOW_SHORT');
			foreach ($newArray as $value)
			{
				$output[] = substr($value,0,2);
			}
		}
		else if ($param == 'DOW_SUBSTR_UNIX')
		{
			$newArray = JSP_ENUMS_DATE('DOW_SHORT_UNIX');
			foreach ($newArray as $value)
			{
				$output[] = substr($value,0,2);
			}
		}
		else if ($param == 'DOW_SHORT')
			$output = array('sun','mon','tue','wed','thu','fri','sat');		
		else if ($param == 'DOW_SHORT_UNIX')
			$output = array('mon','tue','wed','thu','fri','sat','sun');
		else if ($param == 'DOW_LONG')
			$output = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
		else if ($param == 'DOW_LONG_UNIX')
			$output = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');			
		else if ($param == 'DAY' || $param == 'MONTH_DAYS')
			$output = range(1,31);				
		else if ($param == 'MONTH_INDEX')
			$output = range(1,12);
		else if ($param == 'MONTH_SUBSTR')
		{
			$newArray = JSP_ENUMS_DATE('MONTH_SHORT');
			foreach ($newArray as $value)
			{
				$output[] = substr($value,0,1);
			}
		}								
		else if ($param == 'MONTH_SHORT')
			$output = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');					
		else if ($param == 'MONTH_QUARTER')
			$output = array('jan - mar','apr - may','jul - sep','oct - dec');
		else if ($param == 'MONTH' || $param == 'MONTH_LONG')
			$output = array('january','february','march','april','may','june','july','august','september','october','november','december');		
		else if ($param == 'QUARTER_SUBSTR')
		{
			$newArray = range(1,4);
			foreach ($newArray as $value)
			{
				$output[] = 'q'.$value;
			}			
		}		
		else if ($param == 'QUARTER_SHORT')
		{
			$newArray = array('1st','2nd','3rd','4th');
			foreach ($newArray as $value)
			{
				$output[] = $value.' quarter';
			}
		}		
		else if ($param == 'QUARTER_LONG')
		{
			$newArray = array('first','second','third','fourth');			
			foreach ($newArray as $value)
			{
				$output[] = $value.' quarter';
			}
		}	
		else if ($param == 'YEAR')
			$output = range(date('Y')-99,date('Y'));
		else if ($param == 'HOURS_24')
			$output = range(0,23);		
		else if ($param == 'HOURS_12')
			$output = range(1,12);				
		else if ($param == 'MINUTES')
			$output = range(0,59);		
		else if ($param == 'SECONDS')
			$output = range(0,59);									
		else if ($param == 'MERIDIEM')
			$output = array('am','pm');
		else
			JSPIP;
		return JSP_TITLE_CASE($output);			
	}
}

function JSP_ENUMS_PREDEF ($param)
{
	$paramArray = array($param);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else
	{
		if ($param == 'IMAGE')
			$output = array('jpeg','jpg','png','gif','bmp','tif');
		else if ($param == 'VIDEO')
			$output = array('3gp','mp4','avi','ogg','flv','mkv','webm');
		else if ($param == 'DOC')
			$output = array('txt','doc','docx','pdf');
		else if ($param == 'ACCT_TYPE')
			$output = array('savings','current','others');
		else if ($param == 'TRANS_TYPE')
			$output = array('credit','debit','others');			
		else if ($param == 'FOREX')
			$output = JSP_BUILD_CASE(array('chy','eur','gbp','inr','ngn','usd'));			
		else if ($param == 'JUMBO')
			$output = array('sales','reach','clients');
		else if ($param == 'MOSONE')
			$output = array('revenue','expense','profit');			
		else if ($param == 'DEXTER')
			$output = array('sales','cost','gross');
		else if ($param == 'STARTUP')
			$output = array('expense','asset','investment','loan');
		else if ($param == 'SCALE')
			$output = range(date('Y')-4,date('Y'));		
		else if ($param == 'ERROR')			
			$output = JSP_BUILD_CASE(array('primary','success','info','warning','danger','default','preset'));
		else if ($param == 'MKDATE')			
			$output = array('today','yesterday','this week','last week','this month','last month','this year','last year');
		else if ($param == 'MKFORMAT')			
			$output = array('PRESET','LONG','SHORT','EVENT','STAMP','FORMAL','LBS','METRO','TELLER','FEED','ETA','ESSAY');
		else if ($param == 'HEXCODE')			
			$output = array('lbs blue' => '#0093DD','sea blue' => '#75C5F0',
			'dark blue' => '#007BB8','teal' => '#008080','dark teal' => '#006666',
			'call green' => '#16BC00','call dark green' => '#090','dark red' => '#EE1111','border' => '#DDD',
			'footer' => '#373435','whitish' => '#F7F7F7','android gray' => '#E0E0E0',
			'android bg' => '#EEE','watermark' => '#EDEDED');
		else 
			$output = JSPIP;
		return $output;
	}
}

function JSP_ENUMS_PROFILE ($param = 'MAP')
{
	foreach (JSP_DTYPE_ALL() as $assoc_array)
	{
		foreach ($assoc_array as $key => $value)		
			$treeArray[$key] = $value;
	}
	$array_keys = JSP_PUSH_ARRAY(array_keys($treeArray),'map','END');
	$paramArray = array($param);
	$parseArray = JSP_BUILD_CASE($array_keys);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if (JSP_PARAM_PARSE($parseArray,$param)) 
		return JSPIP;
	else
	{	
		if ($param == 'MAP')
		{
			foreach ($treeArray as $key => $value)
				$output[JSP_BUILD_CASE($key)] = $value;
		}
		else
			$output = $treeArray[JSP_DROP_CASE($param)];
		return $output;
	}
}
?>








