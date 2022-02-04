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
				<?php
					echo _ERROR($err);				
                    $th = 'deadline,assigned to,task summary';
	                $predef = JSP_FETCH_IPREDEF($TABLE,'deadline,assign,objective',1);
                    $td = JSP_SSQL_PAGI($predef,$_REQUEST['BLN_PAGI_CHANGE']);
					$td = JSP_TRANS_WRAP($td,2,80);
                    echo JSP_SPRY_SHOWING($td[0],$extra);
					
					if (_THROW($predef))					
		                echo JSP_DISPLAY_ITABLE($th,$td,'VIEW');
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
