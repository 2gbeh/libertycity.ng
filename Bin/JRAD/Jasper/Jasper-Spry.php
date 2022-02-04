<?php
function JSP_SPRY_PIN ()
{
	return "<span class='JSP_SPRY_PIN'>*</span>";
}

function JSP_SPRY_LOAD ()
{
	return '<div class="JSP_SPRY_LOAD" id="JSP_SPRY_LOAD_TARGET">...</div>';
}

function JSP_SPRY_KNOB ($pri_id, $sec_id)
{
	$paramArray = array($pri_id,$sec_id);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		$div = $pri_id.$sec_id;
       $output = '<div class="JSP_SPRY_KNOB" id="BLN_SPRY_KNOB_'.$div.'" onClick=BLN_SPRY_KNOB("'.$pri_id.'","'.$sec_id.'")>
	   		<img src="Media/Icon/Knob-On.png" id="BLN_SPRY_KNOB_'.$pri_id.'" />
	   		<img src="Media/Icon/Knob-Off.png" id="BLN_SPRY_KNOB_'.$sec_id.'" />			
	   </div>';
	   return $output;
	}
}

function JSP_SPRY_CANCEL ($dom)
{
	$paramArray = array($dom);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		return "<div class='JSP_SPRY_CANCEL' title='Close' onClick=BLN_DISPLAY_DOM('".$dom."','CLOSE')>&times;</div>";
	}
}

function JSP_SPRY_RIBBON ($productName, $anchor, $innerHtml)
{
	$paramArray = array($productName,$anchor,$innerHtml);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$salute = JSP_CONSTRUCT("The ".$productName." sales team will contact you shortly. Thank you.",'SCRIPT');
		$output = "<div class='JSP_SPRY_RIBBON' id='JSP_SPRY_RIBBON'>
		<div class='cancel' title='Close' onClick=BLN_DISPLAY_DOM('JSP_SPRY_RIBBON','CLOSE')>&times;</div>".$innerHtml."
		<a href='".$anchor."' onClick=BLN_DIALOGUE_CONTACT('".$salute."')>Learn more</a>		
		</div>";
		return $output;
	}
}

function JSP_SPRY_IRIBBON ($writeup, $anchor)
{
	$paramArray = array($writeup,$anchor);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$output = '<div class="JSP_SPRY_IRIBBON" id="JSP_SPRY_IRIBBON">
			<div class="container">
				'.$writeup.'
				<div>
					<a class="pri-btn" onClick=BLN_DISPLAY_DOM("JSP_SPRY_IRIBBON","CLOSE")>
						'.$anchor.'
					</a>
				</div>        
			</div>        
		</div>';
		return $output;
	}
}

function JSP_SPRY_DRAWER ($position = 'RIGHT', $estate = 'TABLET')
{
	$paramArray = array($position,$estate);
	$parseArray = array
	(
		array('LEFT','RIGHT','CENTER'),
		array('MOBILE','TABLET')
	);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$position) || 
		JSP_PARAM_PARSE($parseArray[1],$estate)		
	) 
		return JSPIP;			
	else
	{
		if ($estate == $parseArray[1][0]) //MOBILE
			$estate = 320;
		else //TABLET
			$estate = 768;
		$output = 
		"<div class='JSP_SPRY_DRAWER' ESTATE='".$estate."' style='text-align:".$position.";'>
			<input id='JSP_SPRY_DRAWER_CHECKBOX' type='checkbox' disabled />					
			<span id='JSP_SPRY_DRAWER_ICON' onClick=BLN_SPRY_DRAWER('onClick')>
				&equiv;
			</span>                
		</div>";
		return $output;
	}
}

function JSP_SPRY_DOCKET ($session, $page, $table, $field, $base, $anchor)
{
	$paramArray = array($session,$page,$table,$field,$base,$anchor);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$current_user = _GET($session);
		$up = JSP_ASCII('UP');
		$down = JSP_ASCII('DOWN');	
		$up = 'x';
		$down = '+';
		//GET ACCOUNTS
		$array = JSP_FETCH_BYCOL($table,$field);
		foreach ($array as $key => $value)
		{
			$img = $selected = '';
			$onclick = 'BLN_ACTION_ILOGOUT("session='.$session.',page='.$page.',CAT='.$key.'")';
			//GET PROFILE IMAGE
			$row = JSP_FETCH_BYID($table,$key);
			foreach ($row as $cell)
			{
				if (_THROW(JSP_FILE_ISIMAGE($cell)))
					$img = JSP_SPRY_PROFILE($base.$cell,'25px','CIRCLE');
			}
			//CALLCARD
			if (!$img)
				$img = JSP_SPRY_CALLCARD($value);
			if ($current_user == $key)
				$menu .= '<li class="selected">'.$img.$value.'</li>';
			else
				$menu .= '<li onclick='.$onclick.' class="'.$selected.'">'.$img.$value.'</li>';			
		}
		$menu .= '<li>
				<a href="'.$anchor.'"><span>+</span> add account</a>
			</li>';
		$onclick = 'BLN_SPRY_ISWITCH("JSP_SPRY_DOCKET_MENU","JSP_SPRY_DOCKET","'.$down.'","'.$up.'")';
		$output = '<div class="JSP_SPRY_DOCKET">
			<span id="JSP_SPRY_DOCKET" onclick='.$onclick.' title="Switch Account"><x class="rotate-right">&#8250;</x></span>
		</div>';
		$output .= '<ul class="JSP_SPRY_DOCKET_MENU" id="JSP_SPRY_DOCKET_MENU">'.$menu.'</ul>';	
		return $output;
	}
}

function JSP_SPRY_MENU ($arrayAnchor, $arrayElement)
{
	$paramArray = array($arrayAnchor,$arrayElement);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$arrayAnchor = JSP_BUILD_CSV($arrayAnchor);
		$arrayElement = JSP_BUILD_CSV($arrayElement);
		if (count($arrayAnchor) != count($arrayElement))	
			return JSPIL;
		else
		{
			for ($i = 0; $i < count($arrayAnchor); $i++)
			{
				$li .= "<li><a href='".$arrayAnchor[$i]."'>".$arrayElement[$i]."</a></li>";			
			}
			$output = "<ul class='JSP_SPRY_MENU' id='JSP_SPRY_MENU'>".$li."</ul>";
			return $output;
		}
	}
}

function JSP_SPRY_IMENU ($arrayAnchor, $arrayElement)
{
	$paramArray = array($arrayAnchor,$arrayElement);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$arrayAnchor = JSP_BUILD_CSV($arrayAnchor);
		$arrayElement = JSP_BUILD_CSV($arrayElement);
		if (count($arrayAnchor) != count($arrayElement))	
			return JSPIL;
		else
		{
			for ($i = 0; $i < count($arrayAnchor); $i++)
			{
				$li .= "<li><a href='".$arrayAnchor[$i]."'>".$arrayElement[$i]."</a></li>";			
			}
			$output = "<ul class='JSP_SPRY_IMENU' id='JSP_SPRY_IMENU'>".$li."</ul>";
			return $output;
		}
	}
}

function JSP_SPRY_SUBMENU ($menuArray, $bgcolor = 'transparent')
{
	$paramArray = array($menuArray,$bgcolor);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$menuArray = JSP_BUILD_CSV($menuArray);
		foreach ($menuArray as $key => $value)
			$li .= "<li onclick=BLN_SPRY_SUBMENU(".$key.")>".$value."</li>";
		$output = "<div class='STEM_OVERFLOW'>
			<ul class='JSP_SPRY_SUBMENU' id='JSP_SPRY_SUBMENU' BGCOLOR='".$bgcolor."'>".$li."</ul>
		</div>";
		return $output;
	}
}

function JSP_SPRY_SUBLINK ($menuArray, $anchorArray)
{
	$paramArray = array($menuArray,$anchorArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$menuArray = JSP_BUILD_CSV($menuArray);
		$anchorArray = JSP_BUILD_CSV($anchorArray);		
		foreach ($menuArray as $key => $value)
			$li .= "<li><a href='".$anchorArray[$key]."'>".$value."</a></li>";
		$output = "<div class='STEM_OVERFLOW'>
			<ul class='JSP_SPRY_SUBLINK' id='JSP_SPRY_SUBLINK'>".$li."</ul>
		</div>";
		return $output;
	}
}

function JSP_SPRY_PROFILE ($src, $width = '50px', $border = 'CIRCLE')
{
	$paramArray = array($src,$width,$border);
	$parseArray = array('SQUARE','CIRCLE');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$border)) 
		return JSPIP;			
	else
	{
		if ($border == $parseArray[1]) //CIRCLE
			$border = '60px';
		else
			$border = 'none';
		$output = "<div class='JSP_SPRY_PROFILE' style='background-image:url(".$src."); width:".$width."; height:".$width."; border-radius:".$border.";'>&nbsp;</div>"; 
		return $output;
	}
}

function JSP_SPRY_CAROUSEL ($fileArray = JSP_BASE_SLIDE, $selectionType = 'RANDOM', $transitionTime = '10')
{
	$paramArray = array($fileArray,$selectionType,$transitionTime);
	$parseArray = array('SERIES','RANDOM');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$selectionType) || !is_numeric($transitionTime)) 
		return JSPIP;			
	else
	{
		if (strlen($fileArray)) //FOLDER ENTRY
			$newArray = JSP_FOLDER_CONTENT($fileArray,'IMAGE');
		else
			$newArray = $fileArray;
		foreach ($newArray as $url)
		{
			if (strlen($fileArray)) //FOLDER ENTRY
				$url = JSP_FILE_UPROOT($url); #Media/Image/Slide/*.img
			$li .= '<li>'.$url.'</li>';
		}
		$transitionTime = $transitionTime * 1000;		
		$ul = "<ol class='JSP_SPRY_CAROUSEL' SELECTION='".$selectionType."' TRANSITION='".$transitionTime."' CURRENT='0' style='display:none;'>".$li."</ol>";
		return $ul;
	}
}

function JSP_SPRY_COUNTDOWN ($endDate, $endTime)
{
	$paramArray = array($endDate,$endTime);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else 
	{
		//CONVERT ENTRY TO 	Apr 16, 2017 19:00:00
		$endDate = JSP_CAL_MKFORMAT($endDate,'DATE','PRESET');
		if ($endTime == 'NULL')
			$endTime = '00:00:00';
		$mkdate = $endDate.' '.$endTime;
		$output = '<div class="JSP_SPRY_COUNTDOWN" MKDATE="'.$mkdate.'" style="display:none;">&nbsp;</div>';
		return $output;
	}
}

function JSP_SPRY_POSTCARD ($src, $width, $height)
{
	$paramArray = array($src,$width,$height);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$output = "<div class='JSP_SPRY_POSTCARD' style='background-image:url(".$src."); width:".$width."; height:".$height.";'>&nbsp;</div>"; 
		return $output;
	}
}

function JSP_SPRY_CALLCARD ($nameArray)
{
	$paramArray = array($nameArray);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$array = JSP_BUILD_ARRAY($nameArray,' ');
		foreach ($array as $key => $value)
		{
			if ($key < 2)
				$substr .= substr($value,0,1);
		}
		$output = "<div class='JSP_SPRY_CALLCARD'><div class='print'>".$substr."</div></div>";
		return $output;
	}
}

function JSP_SPRY_BADGE ($image, $username, $email, $href)
{
	$paramArray = array($image,$username,$email,$href);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if ($image == 'NULL')
			$icon = JSP_SPRY_CALLCARD($username);
		else
			$icon = "<div class='image' style='background-image:url(".$image.");'>&nbsp;</div>";
		$output = "<div class='JSP_SPRY_BADGE'>
			<div class='anchor'><a href=".$href." title='Edit Profile'>Edit</a></div>
			<div class='icon'>".$icon."</div>
			<div class='name'>".$username."</div>
			<div class='email'>".$email."</div>			
		</div>";
		return $output;
	}
}

function JSP_SPRY_CALLOUT ($article)
{
	$paramArray = array($article);		
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$output = "<div class='JSP_SPRY_CALLOUT' id='JSP_SPRY_CALLOUT'>
			<div class='header'>
				<span id='cancel' title='Close' onclick=BLN_SPRY_SWITCH('JSP_SPRY_CALLOUT')>&times;</span>
			</div>
			<div class='body'>".$article."</div>
		</div>";		
		return $output;
	}
}

function JSP_SPRY_SHOWING ($array, $extra)
{
	$count = count($array);
	if ($count)
		$output = 'Showing rows 0 - '.($count - 1).' ( ~'.$count.' total , Query took 0.00'.date('s').' sec)';	
	else	
		$output = 'No records available at this time ( ~'.$count.' total , Query took 0.00'.date('s').' sec)';		
	return '<div class="JSP_SPRY_SHOWING">'.$output.' '.$extra.'</div>';
}

function JSP_SPRY_LOGIN ($prihex, $err)
{
	$paramArray = array($prihex,JSP_TRUEPUT($err));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if ($prihex == '#')
			$prihex = '#0093DD';
		if (isset($err))
		{
			$script = '<script type="text/javascript">
				BLN_MODAL_OPEN("JSP_SPRY_LOGIN");
			</script>';		
		}
		if (isset($_POST['checkbox'])) 
			$checked = 'checked';		
			
		$header = '<div class="JSP_SPRY_LOGIN" id="JSP_SPRY_LOGIN">
		<div class="btn" id="facebook">
			<a href="#">
				<img src="../../Media/Icon/Glyph-Facebook.png" alt="" />
				Log in with Facebook
			</a>
		</div>
		<div class="btn" id="google">
			<a href="#">
				<img src="../../Media/Icon/Glyph-Gmail.png" alt="" />
				Log in with Google
			</a>
		</div>
		<div class="ihr"></div> 
		<span class="or">OR</span>
		<div class="ihr"></div>';
		
		$form = _ERROR($err).
		'<form '.JSP_FORM_POST.'>
		<input type="email" name="email" value="'.$_POST['email'].'" placeholder="Email Address" required />
		<input type="password" name="password" value="'.$_POST['password'].'" placeholder="Password" required />
		<div class="legend" id="first-child">    
			<div class="float-left label">
				<input type="checkbox" name="checkbox" '.$checked.' />            
				Remember me
			</div>
			<div class="float-right">
				<a class="float-right anchor" href="Register.php">Forgot password?</a>
			</div>
		</div>    
		<input type="submit" value="Log in" style="background-color:'.$prihex.';" />
		</form>
		<div class="hr"></div>
		<div class="legend">    
			<div class="float-left label">Don\'t have an account?</div>
			<div class="float-right">
				<a class="float-right sec-btn" href="Register.php" style="color:'.$prihex.'; border-color:'.$prihex.';">Sign up</a>
			</div>
		</div>
	</div>';
		return $script.$header.$form;
	}
}

function JSP_SPRY_PASSWORD ()
{
	$output = "<span class='JSP_SPRY_PASSWORD' id='JSP_SPRY_PASSWORD' title='Show Password' onclick='BLN_SPRY_PASSWORD()'>(&bull;)</span>";		
	return $output;
}

function JSP_SPRY_PAGI ($array)
{
	if (JSP_ATYPE($array) == 2)
		$array = $array[0];
	$countArray = count($array);
	if ($countArray > 10)
	{
		//fragArray
		$fragArray = JSP_FRAG_ARRAY($array,10);
		$length = count($fragArray);
						
		//set selected page
		if ($_REQUEST['BLN_PAGI_CHANGE'] <= 1)
			$idle = 1;
		else if ($_REQUEST['BLN_PAGI_CHANGE'] >= $length)
			$idle = $length;
		else
			$idle = $_REQUEST['BLN_PAGI_CHANGE'];
			
		//set pages
		for ($i = 1; $i <= $length; $i++)
		{
			if ($i == $idle)
				$body .= "<li onClick='BLN_PAGI_CHANGE(".$i.")' id='selected'>".$i."</li>";
			else
				$body .= "<li onClick='BLN_PAGI_CHANGE(".$i.")'>".$i."</li>";					
		}
						
		//build pagination
		$prev = '<li onClick="BLN_PAGI_PREV()">previous</li>';
		$next = '<li onClick="BLN_PAGI_NEXT()">next</li>';
		$current = '<li class="JSP_SPRY_PAGI_HIDDEN">'.$idle.'</li>';
		$li = $prev.$body.$next.$current;
		$ul = "<ol class='JSP_SPRY_PAGI'>".$li."</ol>";
		
		//build showing
		$newArray = $fragArray[$idle - 1];
		$firstKey = JSP_SORT_FIRST($newArray,'KEY');
		$lastKey = JSP_SORT_LAST($newArray,'KEY');			
		$from = JSP_SORT_REALINDEX($array,$firstKey,'KEY');
		$to = JSP_SORT_REALINDEX($array,$lastKey,'KEY');			
		$showing = "<div class='JSP_SPRY_PAGI_SHOWING'>Showing ".$from." to ".$to." of ".$countArray." records.</div>";
		
		//output		
		return $ul.$showing;
	}
}

function JSP_SPRY_AFFILIX ($folder = JSP_BASE_LOGO)
{
	$paramArray = array($folder);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$fileArray = _CONTENT($folder,'IMAGE');
		foreach ($fileArray as $logo)
		{
			$src = JSP_FILE_UPROOT($logo);
			$alt = JSP_BUTCHER_STR($logo,'/');
			$li .= "<li><img src=".$src." title=".$alt." /></li>";
		}
		$output = "<ol class='JSP_SPRY_AFFILIX'>".$li."</ol>";
		return $output;
	}
}
	
function JSP_SPRY_TOP ()
{
	$output = '<a href="#top" class="JSP_SPRY_TOP" title="Back to top">'.
		JSP_ASCII('UP').
		'</a>
	</div>';
	return $output;
}

function JSP_SPRY_SOCIAL ($facebook = 'https://www.facebook.com/', $twitter = 'https://www.twitter.com/', $instagram = 'https://www.instagram.com/')
{
	$paramArray = array($facebook,$twitter,$instagram);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$output = "<ul class='JSP_SPRY_SOCIAL'>
			<li><a href='".$facebook."' target='_blank'><img src='Media/Icon/Facebook.png' title='Like us on Facebook' alt='Facebook' /></a></li>
			<li><a href='".$twitter."' target='_blank'><img src='Media/Icon/Twitter.png' title='Follow us on Twitter' alt='Twitter' /></a></li>
			<li><a href='".$instagram."' target='_blank'><img src='Media/Icon/Instagram.png' title='Follow us Instagram' alt='Instagram' /></a></li>                
		</ul>";
		return $output;
	}
}

function JSP_SPRY_APPS ($appStore = 'https://itunes.apple.com/app/', $googlePlay = 'https://play.google.com/store/')
{
	$paramArray = array($appStore,$googlePlay);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$output = "<ul class='JSP_SPRY_APPS'>
			<li><a href='".$appStore."' target='_blank'><img src='Media/Icon/AppStore.png' title='Download on the App Store' alt='App Store' /></a></li>
			<li><a href='".$googlePlay."' target='_blank'><img src='Media/Icon/GooglePlay.png' title='Get it on Google Play' alt='Google Play' /></a></li>
		</ul>";
		return $output;
	}
}

function JSP_SPRY_IAPPS ($anchorArray, $titleArray, $subtitleArray)
{
	$paramArray = array($anchorArray,$titleArray,$subtitleArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$anchorArray = JSP_BUILD_CSV($anchorArray);
		$titleArray = JSP_BUILD_CSV($titleArray);
		$subtitleArray = JSP_BUILD_CSV($subtitleArray);
		
    	$output = '<ol class="JSP_SPRY_IAPPS">
            	<li>
                	<a href="'.$anchorArray[0].'" target="_new">
                    	<div class="title">'.$titleArray[0].'</div>
                        <div class="subtitle">'.$subtitleArray[0].'</div>
                    </a>
                </li>
            	<li>
                	<a href="'.$anchorArray[1].'" target="_new">
                    	<div class="title">'.$titleArray[1].'</div>
                        <div class="subtitle">'.$subtitleArray[1].'</div>
                    </a>
                </li>				
            </ol>';
		return $output;
	}
}

function JSP_SPRY_COPY ($appname = MASTHEAD, $framework = API)
{
	$paramArray = array($appname,$framework);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
//		Copyright (C) 2017 Empire Group. Plymouth(TM) HWP Labs.		
		$output = "<div class='JSP_SPRY_COPY' id='Masthead'>Copyright &copy; ".$appname.". <b>".$framework."</b>&trade; <a href='http://www.hwplabs.com/' target='_blank'>HWP Labs.</a>
		</div>";
		return $output;
	}
}

function JSP_SPRY_ICOPY ($impressum = MASTHEAD, $links = '#', $social = '#')
{
	$paramArray = array($impressum,$links,$social);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
//		Copyright (C) 2011 HWP Labs. 
//		One Lbs way, Uwasota, BC 300283. [F] [T] [I].
		if ($impressum == '#')
			$impressum = MASTHEAD;

		if ($links == '#')
			$links = '<li><a href="#">terms</li><li><a href="#">privacy</li><li><a href="#">sitemap</li>';
		if ($links == 'NULL')
			$links = '';
		if ($links == 'ADDR')
			$links = '<li>'._PROFILE('HQ').'</li>';
		if ($links == 'JOIN')
			$links = '<li>Join the conversation:</li>';					
			
		if ($social == '#')
		{
			$facebook = 'https://www.facebook.com/';
			$twitter = 'https://www.twitter.com/';
			$instagram = 'https://www.instagram.com/';
		}
		else
		{
			$social = _CSV($social);
			$facebook = $social[0];
			$twitter = $social[1];
			$instagram = $social[2];
		}
		
		$append = "<li><a href='".$facebook."' target='_blank'><img src='Media/Icon/Facebook.png' title='Like us on Facebook' alt='Facebook' /></a></li>
		<li><a href='".$twitter."' target='_blank'><img src='Media/Icon/Twitter.png' title='Follow us on Twitter' alt='Twitter' /></a></li>
		<li><a href='".$instagram."' target='_blank'><img src='Media/Icon/Instagram.png' title='Follow us Instagram' alt='Instagram' /></a></li>";
		
		$output = "<div class='JSP_SPRY_ICOPY' id='Masthead'>
			<div class='float-left'>Copyright &copy; ".$impressum.".</div>
			<div class='float-right'>
				<ul>".$links."</ul>
				<ul>".$append."</ul>
			</div>
			<p>&nbsp;</p>
		</div>";
		return $output;
	}
}

function JSP_SPRY_TRADE ($appname, $company, $division)
{
	$paramArray = array($appname,$company,$division);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$output = "<div class='JSP_SPRY_TRADE'>
			".$appname."&trade; is the intellectual property and a registered trademark of ".$company.", the ".$division." subsidiary of HWP Lbs&reg RC111114. HWP Labs in an SSA-based IT consulting firm specialised in Software Engineering and Business R&amp;D. All rights reserved.
		</div>";
		return $output;
	}
}

function JSP_SPRY_POBOX ($address)
{
	$paramArray = array($address);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$output = "<div class='JSP_SPRY_POBOX'>".$address."</div>";
		return $output;
	}
}

function JSP_SPRY_SEAL ($src)
{
	$paramArray = array($src);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
	    $output = '<div class="JSP_SPRY_SEAL"><img src="Media/Icon/'.$src.'" /></div>';
		return $output;
	}
}

function JSP_SPRY_LIVECHAT ($width = '50px')
{
	$paramArray = array($width);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if ($_POST['chat'])
		{
			$dialogue = '<div class="user">
				<div class="time">'.JSP_TIME_SHORT.'</div>
				'.$_POST['chat'].'
			</div>
			<div class="admin">
				<div class="time">'.JSP_TIME_SHORT.'</div>
				Please hold.
			</div>';		
		}
		$badge = '<div class="JSP_SPRY_LIVECHAT_BADGE bottom-right" onclick=BLN_SPRY_SWITCH("JSP_SPRY_LIVECHAT")>
			<img src="Media/Icon/Chat.png" style="width:'.$width.';" alt="Live Chat" title="Live Chat"/>
		</div>';
		$chat = '<div class="JSP_SPRY_LIVECHAT" id="JSP_SPRY_LIVECHAT">
			<div class="header">
				Hi, i\'m Neigel.'.JSP_SPRY_CANCEL('JSP_SPRY_LIVECHAT').'
			</div>
			<div class="body">
				<div class="admin">
					<div class="time">09:00</div>
					Hello there, having some challenges on our platform? We are at your 
					service from 09:00 to 17:00 on weekdays. Feel free to call us on 
					<b>01-'.JSP_CIPHER_USSD(APPNAME).'</b>.
				</div>
				'.$dialogue.'								             
			</div>
			<div class="form">
				<form '.JSP_FORM_POST.'>
					<input type="text" name="chat" placeholder="Say something..." required />
					<input type="submit" />
				</form>
			</div>
			<div class="footer">Powered by <b>jRAD</b> HWP Labs.</div>    
		</div>
		
		';
		return $badge.$chat;
	}
}

function JSP_SPRY_FLASHCARD ($fileArray, $selectionType = 'RANDOM')
{
	$paramArray = array($fileArray,$selectionType);
	$parseArray = array('SERIES','RANDOM');	
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$selectionType)) 
		return JSPIP;			
	else
	{
		//IF FOLDER ENTRY
		if (strlen($fileArray))
			$newArray = JSP_FOLDER_CONTENT(JSP_PAGE_ROOT.$fileArray,'IMAGE');
		else
			$newArray = $fileArray;
		foreach ($newArray as $url)
		{
			//IF FOLDER ENTRY
			if (strlen($fileArray))
				$url = $fileArray.JSP_FILE_TMP($url);
			$li .= '<li>'.$url.'</li>';
		}
		$ul = "<ol class='JSP_SPRY_FLASHCARD' SELECTION='".$selectionType."' CURRENT='0' style='display:none;'>".$li."</ol>";
		return $ul;
	}
}

function JSP_SPRY_FIREFLY ($fileArray, $targetId)
{
	$paramArray = array($fileArray,$targetId);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		$newArray = JSP_FOLDER_CONTENT(JSP_PAGE_ROOT.$fileArray,'IMAGE');
		foreach ($newArray as $url)
		{
			$url = $fileArray.JSP_FILE_TMP($url);
			$li .= '<li>'.$url.'</li>';
		}
		$ul = "<ol class='JSP_SPRY_FIREFLY' style='display:none;'>".$li."</ol>";
		$popup = "<div class='JSP_SPRY_FIREFLY_POPUP' id='".$targetId."'>
					<span id='cancel' title='Close'>&times;</span>
					<div class='wrap'>
						<h1>advertise here?</h1>								
						Buy and sell ads with <b>F<i>!</i>refly</b>, HWP Labs' Digital Advertising & Analytics Agency.					
						<div class='footer'>
							For enquries, contact: <br/>
							+234(0) <b>81 6996 0927</b> (Whatsapp only)
						</div>
					</div>
				</div>";	
		$output = "<div class='JSP_SPRY_FIREFLY_TARGET' onclick=BLN_SPRY_SWITCH('".$targetId."')>".$ul.$popup."</div>";
		return $output;
	}
}

function JSP_SPRY_WIDGETS ($dataArray)
{
	$paramArray = array($dataArray);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$dataArray = JSP_BUILD_CSV($dataArray);
		if (JSP_ATYPE($dataArray) == 1)
		{
			$pointer = 1;
			foreach ($dataArray as $value)					
			{
				if ($pointer == 1)
					$append = "<div class='title'>".$value."</div>";
				else if ($pointer == 2)				
					$append .= "<div class='title-key'>".$value."</div>";
				else
				{
					if (count($dataArray) == 3)
						$append .= "<div class='footer'><span id='footer-note'>".$value."</span></div>";
					else
					{		
						if ($pointer == 3)							
							$append .= "<div class='footer'><span id='footer-note'>".$value."</span> ";
						else
							$append .= "<span id='footer-key'>".$value."</span></div>";
					}
				}
				$pointer++;
			}
			$li .= "<li>".$append."</li>";		
		}
		else
		{
			foreach ($dataArray as $assoc_array)
			{
				$pointer = 1;
				foreach ($assoc_array as $value)					
				{
					if ($pointer == 1)
						$append = "<div class='title'>".$value."</div>";
					else if ($pointer == 2)				
						$append .= "<div class='title-key'>".$value."</div>";
					else
					{
						if (count($assoc_array) == 3)
							$append .= "<div class='footer'><span id='footer-note'>".$value."</span></div>";	
						else
						{		
							if ($pointer == 3)							
								$append .= "<div class='footer'><span id='footer-note'>".$value."</span> ";
							else
								$append .= "<span id='footer-key'>".$value."</span></div>";
						}
					}
					$pointer++;
				}
				$li .= "<li>".$append."</li>";
			}
		}		
		$ul = "<ul class='JSP_SPRY_WIDGETS'>".$li."</ul>";
		return $ul;
	}
}

?>
