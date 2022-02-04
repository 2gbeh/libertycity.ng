<?php
function JSP_FORMS_DATECARD ()
{
	$ouptut = "<table class='JSP_FORMS_DATE' border='0'>
		<tr>
			<td rowspan='2' class='time'>".date('H:i')."</td>
			<td class='day'>".date('l').",</td>				
		</tr>
		<tr>
			<td class='date'>".date('F j, Y').".</td>
		</tr>		
	</table>";
	return $ouptut;
}

function JSP_FORMS_FOOBAR ()
{
	return 'onChange="BLN_FORMS_FOOBAR(this.value)"';
}

function JSP_FORMS_ADAPT ($table, $rid)
{
	$result = _SEARCH($table,$rid);
	if (_THROW($result))
	{
		if (_ISDIM($result))
			return end($result);
		else
			return $result;
	}
}

function JSP_FORMS_VALUE ($name, $placeholder)
{
	$paramArray = array($name,JSP_TRUEPUT($placeholder));
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if (isset($_POST[$name])) 
			$output = $_POST[$name]; 
		else 
			$output = $placeholder;
		echo $output;
	}
}

function JSP_FORMS_MENU ($arrayAnchor, $arrayElement, $uniqueId)
{
	$paramArray = array($arrayAnchor,$arrayElement,$uniqueId);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$arrayAnchor = JSP_BUILD_CSV($arrayAnchor);
		$arrayElement = JSP_BUILD_CSV($arrayElement);
		for ($i = 0; $i < count($arrayAnchor); $i++)
		{
			$li .= "<li><a href='".$arrayAnchor[$i]."'>".$arrayElement[$i]."</a></li>";			
		}
		$output = "<ul class='JSP_FORMS_MENU' id='".$uniqueId."'>".$li."</ul>";
		return $output;
	}
}

function JSP_FORMS_SEARCH ($placeholder, $name = 'keyword')
{
	$paramArray = array($placeholder,$name);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if (isset($_POST[$name]))
			$value = $_POST[$name];
		else if (isset($_GET[$name]))
			$value = $_GET[$name];
		else
			$value = '';
			
        $output = '<form '.JSP_FORM_GET.' class="STEM_FORM_SEARCH">';
		$output .= '<input type="search" id="'.$name.'" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" />';
		$output .= _BUTTON('Go');
		$output .= '</form>';
		return $output;
	}
}

function JSP_FORMS_DATE ($value, $required = 'YES')
{
	$paramArray = array($value,$required);
	$parseArray = array('YES','NO');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		if ($required == $parseArray[0]) //YES
			$required = 'required';
		else
			$required = '';
			
		return '<input type="date" class="JSP_FORMS_DATE" id="'.$value.'" name="'.$value.'" value="'.$_POST[$value].'" '.$required.' '.JSP_FORMS_FOOBAR().' />';
	}
}

function JSP_FORMS_TEXTBOX ($value, $placeholder = 'NO', $required = 'YES')
{
	$paramArray = array($value,$placeholder,$required);
	$parseArray = array('YES','NO');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		if ($value == 'email')
		{
			$type = $value;
			if ($placeholder == $parseArray[1]) //NO
				$placeholder = 'example@domain.com';
		}
		else if ($value == 'name')
			$placeholder = 'Surname Firstname Middlename';
		else if ($value == 'lastname')
			$placeholder = 'Surname';			
		else if ($value == 'password')
			$type = $value;
		else if (JSP_SORT_GATE($value,'website,link,url'))
		{
			$type = 'url';			
			$placeholder == $parseArray[0];
			$placeholder = 'http:// or https://';
		}
		else
		{
			if ($value == 'dob' && $placeholder == $parseArray[1]) //NO
				$placeholder = 'YYYY-MM-DD';
			$type = 'text';
		}
		
		if ($placeholder == $parseArray[1]) //NO
			$placeholder = '';
			
		if ($required == $parseArray[0]) //YES
			$required = 'required';
		else
			$required = '';
			
		return '<input type="'.$type.'" class="JSP_FORMS_TEXTBOX" id="'.$value.'" name="'.$value.'" value="'.$_POST[$value].'" placeholder="'.$placeholder.'" '.$required.' '.JSP_FORMS_FOOBAR().' />';
	}
}

function JSP_FORMS_FILE ($name = 'image', $multiple = 'NO', $required = 'YES')
{
	$paramArray = array($name,$multiple,$required);
	$parseArray = array('YES','NO');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;
	else if 
	(
		JSP_PARAM_PARSE($parseArray,$multiple) ||
		JSP_PARAM_PARSE($parseArray,$required)
	) 
		return JSPIP;			
	else
	{
		$id = $name;
		if ($multiple == $parseArray[0]) //YES
		{
			$multiple = 'multiple';
			$name .= '[]';
		}
		else
			$multiple = '';

		if ($required == $parseArray[0] && !isset($_POST['id'])) //YES
			$required = 'required';
		else
			$required = '';

		$output = '<input type="file" class="JSP_FORMS_FILE" id="'.$id.'" name="'.$name.'" '.$multiple.' '.$required.' />';
		return $output;
    }
}

function JSP_FORMS_SELECT ($name, $array, $value = 'KEY', $required = 'YES')
{
	$paramArray = array($name,$array,$value,$required);
	$parseArray = array
	(
		array('KEY','VALUE'),	
		array('YES','NO')
	);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if 
	(
		JSP_PARAM_PARSE($parseArray[0],$value) || 
		JSP_PARAM_PARSE($parseArray[1],$required)		
	) 
		return JSPIP;
	else
	{	
		if ($required == $parseArray[1][0]) //YES
			$required = 'required';
		else
			$required = '';
		
		if (isset($_POST[$name]))
			$selected = $_POST[$name];
		else
			$selected = 'NULL';
		
		$output = '<select name="'.$name.'" class="JSP_FORMS_SELECT" id="'.$name.'" '.$required.'>'.
			JSP_DISPLAY_OPTION($array,$selected,$value).
		'</select>';		
		return $output;
	}
}

function JSP_FORMS_TEXTAREA ($name, $required = 'YES')
{
	$paramArray = array($name,$required);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{	
		if ($required == 'YES')
			$required = 'required';
		else
			$required = '';
		
		if (isset($_POST[$name]))
			$placeholder = $_POST[$name];
		else
		{
			$style = 'style="color:#999;"';
			$onclick = 'onClick="BLN_SPRY_TEXTAREA()"';			
			$placeholder = 'Enter '.$name.' here..';
		}
		
		$output = '<textarea class="JSP_FORMS_TEXTAREA" id="'.$name.'" '.$style.' name="'.$name.'" '.$required.' '.$onclick.'>'.$placeholder.'</textarea>';
		return $output;
	}
}

function JSP_FORMS_CHECKBOX ($message, $checked = 'NO', $required = 'YES')
{
	$paramArray = array($message,$checked,$required);
	$parseArray = array('YES','NO');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if 
	(
		JSP_PARAM_PARSE($parseArray,$checked) ||
		JSP_PARAM_PARSE($parseArray,$required)
	) 
		return JSPIP;
	else
	{
		$value = 'checkbox';
		if ($checked == $parseArray[0] || isset($_POST['checkbox']))
			$checked = 'checked';
		else
			$checked = '';
		if ($required == $parseArray[0]) //YES
			$required = 'required';
		else
			$required = '';
		$output = '<div class="ledge">
			<span><input type="checkbox" class="JSP_FORMS_CHECKBOX" id="checkbox" name="checkbox" '.$checked.' '.$required.' /> </span>
			<span class="checkbox">'.$message.'</span>
		</div>';
		return $output;
	}
}

function JSP_FORMS_BUTTON ($value = 'Submit', $reset = 'NO')
{
	$paramArray = array($value,$reset);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		$output = "<input type='submit' class='JSP_FORMS_BUTTON' value='".$value."' />";
		if ($reset == 'YES')
			$output = "<input type='reset' class='JSP_FORMS_BUTTON' value='Cancel' />".$output;
		return $output;
	}
}

function JSP_FORMS_IBUTTON ($label, $value = IS_RFID)
{
	$paramArray = array($label,$value);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if ($value)
			return '<a href="#" class="JSP_FORMS_IBUTTON pri-btn" onClick=BLN_HEADER_APPEND("BLN_ACTION_IBUTTON","'.$value.'")>'.$label.'</a>';
	}
}

function JSP_FORMS_UPLOAD ($name, $value, $required = 'YES')
{
	$paramArray = array($name,$value,$required);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if ($required == 'YES')
			$required = 'required';
		else
			$required = '';
		$output = '<form class="JSP_FORMS_UPLOAD" id="JSP_FORMS_UPLOAD" '.JSP_FORM_FILE.'>
			<input type="file" name="'.$name.'" '.$required.' />
			<input type="submit" class="button" name="'.$name.'" value='.$value.' />
		</form>';
		return $output;
    }
}

function JSP_FORMS_SIGNIN ($label = 'Username', $name = 'email', $btn = 'Login')
{
	$paramArray = array($label,$name,$btn);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else
	{
		if ($name != 'email')
			$type = 'text';
		else
		{
			$type = $name;
			$placeholder = 'example@domain.com';
		}
		
		$output = '<form class="JSP_FORMS_SIGNIN" '.JSP_FORM_POST.'>
			<label for="'.$name.'">'.$label.'</label>
			<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$_POST[$name].'" placeholder="'.$placeholder.'" required />
			<label for="password">password '.JSP_SPRY_PASSWORD().'</label>
			<input type="password" id="password" name="password" value="'.$_POST['password'].'" required />
			<input type="submit" class="primary" value="'.$btn.'" />
		</form>';
        return $output;
    }
}

function JSP_FORMS_VERIFY ($btn = 'Verify')
{
	$output = '<form class="JSP_FORMS_VERIFY" '.JSP_FORM_POST.'>	
		<label for="vercode">enter 6-digit account verification code</label>
		<input type="text" id="vercode" name="vercode" value="'.$_POST['vercode'].'" maxlength="6" placeholder="- - - - - -" required />
		<input type="submit" class="primary" value="'.$btn.'" />';
    return $output;	
}

function JSP_FORMS_RETRIEVE ()
{
	$output = '<form class="JSP_FORMS_RETRIEVE" '.JSP_FORM_POST.'>
		<label for="email">enter your account email address</label>
		<input type="email" id="email" name="email" value="'.$_POST['email'].'" placeholder="example@domain.com" required />
		<input type="submit" class="primary" value="retrieve" />
	</form>';
	return $output;
}

function JSP_FORMS_SUPPORT ()
{
	$output = '<form class="JSP_FORMS_SUPPORT" '.JSP_FORM_POST.'>
		<label for="subject">subject</label>
		<input type="text" id="subject" name="subject" value="'.$_POST['subject'].'" placeholder="Re:" required />
		<label for="message">message</label>		
		<textarea id="message" name="message" required>'.$_POST['message'].'</textarea>		
		<input type="submit" class="primary" value="submit" />
	</form>';
	return $output;
}

function JSP_FORMS_POSTBACK ($identifier, $default, $modified)
{
	$paramArray = array(JSP_TRUEPUT($identifier),$default,$modified);
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;			
	else
	{
		if ($identifier)
		{
			$output = "<input type='hidden' name='id' value='".$identifier."' />";
			$btn = $modified;
		}
		else
		{
			$output = "<input type='reset' class='button' value='clear' />";
			$btn = $default;
		}
		$output .= "<input type='submit' class='button' value='".$btn."' />";
		return $output;
	}
}

function JSP_FORMS_LEGEND ($resource = 'SIGNIN', $page = 'Register.php')
{
	$paramArray = array($resource,$page);
	$parseArray = array('SIGNUP','SIGNIN','BOTH','RETURN');
	if (JSP_PARAM_FORMAT($paramArray)) 
		return JSPIF;	
	else if (JSP_PARAM_PARSE($parseArray,$page)) 
		return JSPIP;
	else
	{
		$resource = JSP_BUILD_CSV($resource);
		if ($page == $parseArray[0]) //SIGNUP
			$body = 'Already have an account? <a href="'.$resource[0].'">'.$resource[1].'</a>';
		else if ($page == $parseArray[1]) //SIGNIN
			$body = '<a href="Retrieve.php">Forgot password?</a>
            <p></p>
			Don\'t have an account? <a href="'.$resource[0].'">'.$resource[1].'</a>';
		else if ($page == $parseArray[2]) //BOTH
			$body = '<a href="'.$resource[0].'">Return to '.$resource[1].'</a>
            <p></p>
			Don\'t have an account? <a href="'.$resource[2].'">'.$resource[3].'</a>';		
		else //RETURN
			$body = '<a href="'.$resource[0].'">Return to '.$resource[1].'</a>';
		return '<div class="JSP_FORMS_LEGEND">'.$body.'</div>';
	}
}

function JSP_FORMS_CHANGE ()
{
	$output = '<form class="JSP_FORMS_CHANGE" '.JSP_FORM_POST.'>
		<input type="text" id="password" name="password" value="'.$_POST['password'].'" placeholder="Current Password" required /> <br/>
		<input type="password" name="password_1" value="'.$_POST['password_1'].'" placeholder="New Password" required />
		<input type="password" name="password_2" value="'.$_POST['password_2'].'" placeholder="Re-enter Password" required /> <br/>
		<input type="submit" value="change" />
	</form>';
	return $output;
}

?>
