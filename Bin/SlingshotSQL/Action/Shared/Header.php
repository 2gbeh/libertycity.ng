<div class="appname"><?php echo SLI_TYPEFACE; ?></div>
<div class="menu">
    <div class="support" id="support">
        <div class="cancel">
        	<span class="version"><?php echo SLI_VERSION; ?></span>
            <span class="support-icon" title="Cancel" onClick="BLN_DISPLAY_DOM('support','CLOSE')">&times;</span>
        </div>	
        <div class="title">Welcome to <?php echo SLI_TYPEFACE; ?></div>    
        <div class="message">
            For complaints and technical support, contact :
             <?php echo SLI_CONTACT; ?>
        </div>         
    </div>     
    <div class="menu-icon">
    	<img src="../../Media/Icon/Settings.png" alt="Help" title="Tech Support" onClick="BLN_DISPLAY_DOM('support','OPEN')" />
	</div>               
</div>  