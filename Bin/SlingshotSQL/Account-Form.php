<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Shared/Local.php');
include_once('Action/Server/Account.php');
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
		<?php include_once('Action/Shared/Menu.php');  ?>        	
    </li>
    
    <li class="right-pane">
	    <div class="STEM_OVERFLOW">
            <div class="page-title">account settings</div>
            <ul class="page-menu">
            	<li><a href="Account-Table.php">records</a></li>
            	<li><a href="Account-Form.php" id="selected">add/ modify</a></li>                
            </ul>
            <div class="page-content">            
            <form <?php echo JSP_FORM_POST; ?>>
				<?php echo _ERROR($err); ?>
                <label for="email">email address</label>
                <?PHP echo _TEXTBOX('email'); ?> 

                <label for="username">username</label>
                <?PHP echo _TEXTBOX('username'); ?>

                <label for="password">password <?php echo JSP_SPRY_PASSWORD(); ?></label>
                <?PHP echo _TEXTBOX('password'); ?>

                <label for="control">control module</label>
                <?php echo _SELECT('control',JSP_GLOBAL_RECORDS('map','control')); ?>

                <label for="status">account status</label>
                <?php echo _SELECT('status',JSP_GLOBAL_RECORDS('map','status')); ?>                

                <?php echo JSP_FORMS_POSTBACK($_POST['id'],'create','update'); ?>
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
