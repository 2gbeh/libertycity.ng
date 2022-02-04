<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Shared/Local.php');
include_once('Action/Server/Team.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<?php 
include_once('Action/Shared/Head.php');	
include_once('../JRAD/Library-Blend.php'); 
include_once('Action/Shared/Media-Query.php');		
?>
</head>
<body onLoad="BLN_ONLOAD(); BLN_DJANGO()" id="top" status="on">
<div class="header">
<?php include_once('Action/Shared/Header.php');  ?>
</div>

<?php echo JSP_SPRY_DRAWER('LEFT','TABLET'); ?>        

<ul class="main-container">
    <li class="left-pane JSP_SPRY_DRAWER_TARGET">    
		<?php $pseudo_menu = 3; include_once('Action/Shared/Menu.php');  ?>        	
    </li>
    
    <li class="right-pane">
	    <div class="STEM_OVERFLOW">
            <?php $pseudo_nav = 3; include_once('Action/Team-Menu.php'); ?>
            <div class="page-content">
            <form <?php echo JSP_FORM_POST; ?>>
				<?php 
					if (IS_EXP_ADMIN)
					{
						echo _ERROR($err); 
						$_POST = JSP_FORMS_ADAPT($TABLE,$_ADMIN['username']);
						echo _FORMS
						(
							'full name,email address,phone number (WhatsApp),password,resident location',
							'name,email,phone,password,location'
							
						); 
		                echo '<p></p>'.JSP_FORMS_POSTBACK($_POST['id'],'Update Profile','Update Profile');
					}
					else
						echo _ERROR("#Your account is not authorized to access this service.");
				?>                
            </form>
            </div>
        </div>
    </li>
</ul>
    
</body>
</html>
<script type="text/javascript">
//alert(window.innerWidth);
</script>
