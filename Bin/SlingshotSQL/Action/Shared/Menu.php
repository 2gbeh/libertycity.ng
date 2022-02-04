<div class="badge">
<?php 
	if ($_ADMIN['control'] == 2)
		$image = '../../Media/Icon/Logo-Lbs.png';
	else
		$image = '../../Media/Icon/Logo.png';
	$badgeBase = $_ADMIN['email'];
	$badgeBase .= JSP_SPRY_DOCKET('CAA',SLI_PAGE_LOGIN,JSP_TABLE_ADMIN,'username','../../Media/Image/Profile/','#');
	echo JSP_SPRY_BADGE($image,$_ADMIN['username'],$badgeBase,'#');  	
?>  
</div>        	
<dl class="menu">
    <dt>manage</dt>
    <?php
		echo JSP_DISPLAY_IDLIST
		(
			'apps,analytics,team,task,ledger,payroll',		
			'Apps-News-Form.php,#,Team-Table.php,Task-Record.php',
			$pseudo_menu
		);
		if (!IS_VET_ADMIN)
			$adminlink = '#';
		else
			$adminlink = 'Account-Table.php';
	?>    
    <dt>settings</dt>
        <dd><a onClick="BLN_DISPLAY_DOM('support','OPEN')">tech support</a></dd>
        <dd><a href="<?php echo $adminlink; ?>">account</a></dd>
        <dd><a href="<?php echo SLI_PAGE_WEBSITE; ?>" target="_blank">visit website</a></dd>                
        <dd><a onclick="BLN_ACTION_LOGOUT('session=CAA,page=Login.php')">logout</a></dd>
</dl>
<div class="package">
	<?php echo JSP_CHART_PACKAGE(SLI_PACKAGE); ?>
</div>
<div class="impressum">
	&copy; 2011 <b>Dexter</b>&trade; HWP Labs.
</div>