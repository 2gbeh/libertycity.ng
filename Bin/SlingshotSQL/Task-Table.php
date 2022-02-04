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
            <?php $pseudo_nav = 2; include_once('Action/Task-Menu.php'); ?>
            <div class="page-content"> 
                <div class="STEM_INSTA">
                    <a href="Task-Form.php">
                        <img src="../../Media/Icon/Knob-off.png">
                        <div class="label">Return to Form</div>
                    </a>
                </div>
                                       
				<?php
					if (IS_EXP_ADMIN)
						echo _ERROR("#Your account is not authorized to access this service.");					
					else
					{
						echo _ERROR($err);				
						$th = 'deadline,assigned to,task objective,completed by,date,time';
						$predef = JSP_FETCH_IPREDEF($TABLE,'deadline,assign,objective,complete,date,time',1);

foreach ($predef[3] as $index => $assoc_array)
{
	$admin_rid = JSP_TRANS_RID($assoc_array,JSP_TABLE_ADMIN,'username','*');							
	$predef[3][$index] = _THROW(JSP_DROP_ARRAY($admin_rid,', '));
}
//						var_dump($predef);
//						return 1;
						
						$td = JSP_SSQL_PAGI($predef,$_REQUEST['BLN_PAGI_CHANGE']);
						echo JSP_SPRY_SHOWING($td[0],$extra);
						
						if (_THROW($predef))					
							echo JSP_DISPLAY_ITABLE($th,$td);
						else
							echo JSP_DISPLAY_ITABLE($th,$predef);
						echo JSP_SPRY_PAGI($predef);
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
