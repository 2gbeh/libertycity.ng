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
                    <a href="Task-Table.php">
                        <img src="../../Media/Icon/Knob-on.png">
                        <div class="label">View Database Records</div>
                    </a>
                </div>
                            
                <form <?php echo JSP_FORM_POST; ?>>
                    <?php		
					if (IS_EXP_ADMIN)
						echo _ERROR("#Your account is not authorized to access this service.");					
					else
					{								
						echo _ERROR($err);
						echo '<label for="assign">asigned to</label>'.$example.'
						<input type="text" class="JSP_FORMS_TEXTBOX" id="assign" list="sourcelist" name="assign" value="'.$_POST['assign'].'" placeholder="" required onChange="BLN_FORMS_FOOBAR(this.value)" />'.
						JSP_SSQL_DATALIST($TABLE,'assign','sourcelist');						
                        echo _FORMS
                        (
                            'objective,deadline,resource',
                            'objective,deadline,resource'
                        ); 
						if (IS_POSTBACK())
							echo _FORMS('completed by','complete','NO','NO');
                 		echo JSP_FORMS_POSTBACK($_POST['id'],'Create Task','Update Task');
					}
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
