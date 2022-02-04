<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Shared/Local.php');
include_once('Action/Server/Event.php');
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
	    <div class="overflow">
            <div class="page-title">manage poster</div>
            <ul class="page-menu">
                <li><a href="Event-Table.php">records</a></li>            
                <li><a href="Event-Form.php" id="selected">add/ modify</a></li>
            </ul>            
            <div class="page-content">            
            <form <?php echo JSP_FORM_FILE; ?>>
				<?php echo _ERROR($err); ?>
                <label for="JSP_SPANNER_FILE">select poster</label>
				<?php echo _FILE('image'); ?>
                
                <label for="name">event name</label>
				<?php echo _TEXTBOX('name'); ?>
                
                <label for="event_date">event date</label>
				<?php echo _TEXTBOX('event_date'); ?>
                
                <label for="event_time">event time</label>
				<?php echo _TEXTBOX('event_time'); ?>
                
                <label for="event_venue">event venue</label>
				<?php echo _TEXTBOX('event_venue'); ?> 
                
                <label for="about">about</label>
				<?php echo _TEXTAREA('about'); ?>
                
				<?php echo JSP_SPANNER_POSTBACK($_POST['id'],'create','update'); ?>
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
