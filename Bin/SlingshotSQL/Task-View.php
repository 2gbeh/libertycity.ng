<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Shared/Local.php');
include_once('Action/Server/Task.php');
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
		<?php $pseudo_menu = 4; include_once('Action/Shared/Menu.php');  ?>
    </li>
    
    <li class="right-pane">
	    <div class="STEM_OVERFLOW">
            <?php $pseudo_nav = 1; include_once('Action/Task-Menu.php'); ?>
            <div class="page-content">            
                <div class="STEM_INSTA">
                    <a href="Task-Record.php">
                        <img src="../../Media/Icon/Knob-off.png">                    
                        <div class="label">Return to Task Records</div>
                    </a>
                </div>
                            
				<?php
					if (IS_RFID && in_array(IS_RFID,_BYCOL($TABLE,'PRIKEY')))		
					{
						echo _ERROR($err);
						$th = 'assigned to,objective,resource,deadline,completed by,date assigned,time assigned';
						$whereArray = array('id','==',IS_RFID);
						$td = JSP_FETCH_PRELOG($TABLE,'assign,objective,resource,deadline,complete,date,time',1,$whereArray);
						$td = JSP_TRANS_TEXTAREA($td,2);
$admin_rid = JSP_TRANS_RID($td[4][IS_RFID],JSP_TABLE_ADMIN,'username','*');
$td[4][IS_RFID] = _THROW(JSP_DROP_ARRAY($admin_rid,', '));

						echo JSP_DISPLAY_TAROT($th,$td);
						echo _IBUTTON("Mark as Done",_ADMIN);
					}
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
