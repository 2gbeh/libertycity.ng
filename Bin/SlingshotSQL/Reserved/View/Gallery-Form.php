<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Shared/Local.php');
include_once('Action/Server/Gallery.php');
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
            <div class="page-title">manage gallery</div>
            <ul class="page-menu">
                <li><a href="Gallery-Table.php">records</a></li>            
                <li><a href="Gallery-Form.php" id="selected">add/ modify</a></li>
            </ul>
            <div class="page-content">            
                <form <?php echo JSP_FORM_FILE; ?>>
                    <?php echo _ERROR($err); ?>
                    <label for="file">select image</label>
					<?php echo JSP_SPANNER_FILE('file','MULTIPLE'); ?>
                                        
                    <label for="album">select album</label>
					<?php echo _SELECT('album',_BYCOL(JSP_TABLE_ALBUM,'pseudo')); ?>
                   
                    <input type='submit' class='button' value='update' />
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
