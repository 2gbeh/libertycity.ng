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
						_REDIR('Team-Profile.php');
					else
					{
						echo _ERROR($err);
						echo _FORMS
						(
							'full name,select gender,email address,phone number (WhatsApp),your preferred username,your preferred password,resident location',
							'name,gender,email,phone,username,password,location'							
						); 
						echo JSP_FORMS_BUTTON('Create Account','YES');
					}
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
