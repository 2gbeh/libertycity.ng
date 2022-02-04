<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Shared/Local.php');
include_once('Action/Server/Apps-Business.php');
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
		<?php $pseudo_menu = 1; include_once('Action/Shared/Menu.php');  ?>
    </li>
    
    <li class="right-pane">
	    <div class="STEM_OVERFLOW">
            <?php $pseudo_nav = 2; include_once('Action/Apps-Menu.php'); ?>
            <div class="page-content">
                
                <div class="STEM_INSTA">
                    <a href="Apps-Business-Form.php">
                        <img src="../../Media/Icon/Knob-off.png">                    
                        <div class="label">Return to Curation Form</div>
                    </a>
                </div>
                
				<?php
					echo _ERROR($err);				
                    $th = 'category,service,cost,duration,CRT,date,time';
                    $predef = JSP_FETCH_PREDEF($TABLE,'todo,id',0);
                    $td = JSP_SSQL_PAGI($predef,$_REQUEST['BLN_PAGI_CHANGE']);
					$td = JSP_TRANS_PREDEF($td,DRA_ENUMS_SWISS('BUSINESS'),0);
					$td = JSP_TRANS_DENOM($td,2);
					$td = JSP_TRANS_RID($td,JSP_TABLE_ADMIN,'username',4);
                    echo JSP_SPRY_SHOWING($td[0],$extra);
					if (_THROW($predef))					
		                echo JSP_DISPLAY_ITABLE($th,$td);
					else
						echo JSP_DISPLAY_ITABLE($th,$predef);
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
