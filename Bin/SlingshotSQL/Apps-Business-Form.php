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
                    <a href="Apps-Business-Table.php">
                        <img src="../../Media/Icon/Knob-on.png">                    
                        <div class="label">view database records</div>
                    </a>
                </div>
                
                <form <?php echo JSP_FORM_POST; ?>>
                    <?php					
						echo _ERROR($err);					
                        echo '<label for="type">service category</label>';
                        echo _SELECT('type',DRA_ENUMS_SWISS('BUSINESS'));
						$example = '<br/><span class="STEM_FORM_NOTE">Comma-Separated-Entry: client name, client location, client certification</span>';
                        echo _FORMS
                        (
                            'name of service,cost of service',
                            'service,cost'
                        ); 						
						echo '<label for="duration">duration of service (in Days)</label>';
						echo JSP_FORMS_SELECT('duration',JSP_ENUMS_DATE('MONTH_DAYS'),'VALUE');
						echo '<label for="todo">client requirement(s)</label>'.$example;
						echo '<input type="text" class="JSP_FORMS_TEXTBOX" id="todo" name="todo" value="'.$_POST['todo'].'" placeholder="" required onChange="BLN_FORMS_FOOBAR(this.value)" />';
                		echo JSP_FORMS_POSTBACK($_POST['id'],'Post Service','Update Service');
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
