<?php
include_once('Bin/Kernel.php');
include_once('Action/Shared/Local.php');
var_dump
(
);
?>
<!DOCTYPE HTML>
<html>
<head>
<?php
include_once('Action/Shared/Head.php');	
include_once('Bin/JRAD/Library-Blend.php'); 
include_once('Action/Shared/Media-Query.php');		
?>
<link href="Cascade/About.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="BLN_DJANGO()" id="top" status="on">
<div class="header-frame">
	<?php include_once('Action/Shared/Header.php'); ?>
    <?php $pseudo_nav = 2; include_once('Action/Nav/Nav-Nonapp.php'); ?>
    <p></p>
</div>

<div class="mantra about container">
		<img src="Media/Icon/Logo-Alt-2.png" alt=" " />
        <h2>
           	<q> <qq><?php echo SLOGAN; ?></qq> </q>
        </h2>
        <h3><?php echo ABOUT; ?></h3>        
    <p>&nbsp;</p>
        <h2>The Mission</h2>
        <h3><?php echo MISSION; ?></h3>
    <p>&nbsp;</p>
        <h2>The Target</h2>
        <h3>Millennial generation of Nigerian-based online consumers.</h3>        
    <p>&nbsp;</p>
        <h2>The Company</h2>
        <h3><?php echo ALIAS; ?> is owned and developed by HWP Labs, a Nigerian-based software company specialised in software engineering and business R&amp;D.</h3>    
    <p>&nbsp;</p>
        <h2>The Team</h2>
        <div class="hr"></div>
        <div class="STEM_WRAP_15">
            <ul>
                <li class="title">LEADERSHIP + MANAGEMENT TEAM</li>    
                <li>
                    <div class="name">Tugbeh Emmanuel</div>
                    <div class="position">Founder, CEO</div>                
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> B2B,</span>
                        <span id="each"><?php echo ALIAS; ?> Square</span>
                    </div>
                </li>
                <li>
                    <div class="name">Obi Sopuluchukwu</div>
                    <div class="position">Co-founder, CTO</div>                
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> Music,</span>
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>
                <li>
                    <div class="name">Ndolo Chima</div>
                    <div class="position">CFO</div>                
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>
                <li>
                    <div class="name">Daniel Ugonna</div>
                    <div class="position">HR</div>                
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> Sports,</span>
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>        
                </li>                                              
            </ul>
            
            <ul>
                <li class="title"><?php echo strtoupper(ALIAS); ?> MAGIC R&amp;D TEAM</li>    
                <li>
                    <div class="name">Ogbeomoide James</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> B2B,</span>
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>
                <li>
                    <div class="name">Nisakpo Joshua</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>           
                <li>
                    <div class="name">Molokwu Chijioke</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>            
                <li>
                    <div class="name">Oiboh Peter</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>            
                <li>
                    <div class="name">Osagie Eseosa</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> Originals,</span>               
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li> 
                <li>
                    <div class="name">Nwokejiobi Wisdom</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> Sports,</span>                
                        <span id="each"><?php echo ALIAS; ?> AP</span>                    
                    </div>
                </li>                        
                <li>
                    <div class="name">Tugbeh Roosevelt</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> B2B,</span>
                        <span id="each"><?php echo ALIAS; ?> Social,</span>
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>
                <li>
                    <div class="name">Okosun Deborah</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>     
                <li>
                    <div class="name">Olasinde Morolake</div>
                    <div class="division">
                        <span id="each"><?php echo ALIAS; ?> AP</span>
                    </div>
                </li>                   
            </ul>    
		</div>            
</div>

<?php include_once('Action/Shared/Footer.php'); ?>
</body>
</html>
