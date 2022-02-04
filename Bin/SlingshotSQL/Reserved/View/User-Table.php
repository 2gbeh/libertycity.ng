<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Shared/Local.php');
include_once('Action/Server/User.php');
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
            <div class="page-title">manage IHSE registrants</div>
            <div class="page-content">
            <form <?php echo JSP_FORM_POST; ?> id="myForm">  
                <?php echo _ERROR($err); ?>
                <p></p>
                <ul class="buttonWrap">
                    <li><input type='submit' class='btn-menu' value='delete selected' onClick="BLN_DIALOGUE_SUBMIT('Deleted selected?','myForm')" /></li>
                </ul>                    
				<?php
                    $th = 'full name,sex,phone number,home address,state of origin,local govt. area,P.O.BOX,email address,name of school,course of study,year,name of PPA,state code,location,date,time';
                    $predef = JSP_FETCH_PREDEF($TABLE,'id',0);
                    $td = JSP_SSQL_PAGI($predef,$_REQUEST['BLN_PAGI_CHANGE']);
                    $td = _TRANS($td,'GENDER',1);
                    $td = _TRANS($td,'STATE','4,13');					
                    $output = JSP_DISPLAY_ITABLE($th,$td,'SELECT');
					echo JSP_SPRY_SHOWING($predef[0],$extra);
					echo $output;
//                    var_dump($output);
                ?>
                <?php echo JSP_SPRY_PAGI($predef);  ?>
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
