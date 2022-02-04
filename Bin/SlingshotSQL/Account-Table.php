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
                <li><a href="Account-Table.php" id="selected">records</a></li>            
                <li><a href="Account-Form.php">add/ modify</a></li>
            </ul>
            <div class="page-content">            
				<?php echo _ERROR($err); ?>
				<?php
                    $th = array('email address','username','password','control module','status','date','time');
                    $predef = JSP_FETCH_PREDEF($TABLE,'id',0);
					$td = JSP_SSQL_PAGI($predef,$_REQUEST['BLN_PAGI_CHANGE']);					
                    $td = JSP_TRANS_GLOB($td,'control',3);
                    $td = JSP_TRANS_GLOB($td,'status',4);	
					echo JSP_SPRY_SHOWING($td[0],$extra);					
                    echo JSP_DISPLAY_ITABLE($th,$td,'ACTION');
                	echo JSP_SPRY_PAGI($predef);					
                ?>
            </div>
        </div>
    </li>
</ul>
    
</body>
</html>
<script type="text/javascript">
//alert(window.innerWidth);
</script>
