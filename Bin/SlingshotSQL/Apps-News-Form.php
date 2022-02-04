<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Shared/Local.php');
include_once('Action/Server/Apps-News.php');
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
            <?php $pseudo_nav = 1; include_once('Action/Apps-Menu.php'); ?>
            <div class="page-content">
            	
                <div class="STEM_INSTA">
                    <a href="Apps-News-Table.php">
                        <img src="../../Media/Icon/Knob-on.png">                    
                        <div class="label">View Database Records</div>
                    </a>
                </div>
                
                <form <?php echo JSP_FORM_FILE; ?>>
                    <?php					
						echo _ERROR($err);					
                        echo '<label for="topic">select topic</label>';
                        echo _SELECT('topic',DRA_ENUMS_SWISS('TOPIC'));
						$example = '<br/><span class="STEM_FORM_NOTE">Example: Channels TV not www.channelstv.com</span>';
                        echo _FORMS
                        (
                            'attach image,enter headline,paste article',
                            'image,headline,article'
                        ); 
						echo '<label for="source">enter source (Website name)</label>'.$example.'
						<input type="text" class="JSP_FORMS_TEXTBOX" id="source" list="sourcelist" name="source" value="'.$_POST['source'].'" placeholder="" required onChange="BLN_FORMS_FOOBAR(this.value)" />'.
						JSP_SSQL_DATALIST($TABLE,'source','sourcelist').'
						<label for="link">paste link (Article link)</label>
						<input type="url" class="JSP_FORMS_TEXTBOX" id="link" name="link" value="'.$_POST['link'].'" placeholder="http:// or https://" required onChange="BLN_FORMS_FOOBAR(this.value)" />';
                		echo JSP_FORMS_POSTBACK($_POST['id'],'Post Article','Update Article');
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
