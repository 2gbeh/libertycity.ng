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
    <?php $pseudo_nav = 4; include_once('Action/Nav/Nav-Nonapp.php'); ?>
    <p></p>
</div>

<div class="mantra about container" style="padding-top:0;">
    <div class="STEM_WRAP_15">
        <ul>
            <li class="title" id="division">PRODUCT DIVISION</li>
            <li>
                <div class="name"><?php echo ALIAS; ?> Platform Dev</div>
                <div class="division">
                    <span id="each">Design Framework,</span>
                    <span id="each">Software Framework,</span>
                    <span id="each">Business Framework</span>
                </div>
            </li>                        
            <li>
                <div class="name"><?php echo ALIAS; ?> HR</div>               
                <div class="division">
                    <span id="each">Recruiting,</span>
                    <span id="each">Payroll,</span>
                    <span id="each">Team Relationships</span>
                </div>
            </li>
            <li>
                <div class="name"><?php echo ALIAS; ?> AP</div>
                <div class="division">
                    <span id="each">Politics,</span>
                    <span id="each">Entertainment,</span>
                    <span id="each">Business,</span>
                    <span id="each">Technology,</span>
                    <span id="each">International News <a>(Hello World)</a>,</span>
                    <span id="each">Editorials</span>
                </div>
            </li>              
            <li>
                <div class="name"><?php echo ALIAS; ?> B2B</div>
                <div class="division">
                    <span id="each">Software Services,</span>
                    <span id="each">Business Services,</span>
                    <span id="each">Financial Services,</span>
                    <span id="each">Legal Services,</span>
                    <span id="each">Design Services,</span>
                    <span id="each">Marketing Services,</span>                    
                    <span id="each">Labour Services,</span>
                    <span id="each">Supply &amp; Distribution Services,</span>
                    <span id="each">Mobility</span>                    
                </div>
            </li>  
            <li>
                <div class="name"><?php echo ALIAS; ?> EDU</div>
                <div class="division">
                    <span id="each">Science Courses,</span>
                    <span id="each">Management Courses,</span>
                    <span id="each">Art Courses,</span>
                    <span id="each">DIY/Life Hack Courses</span>
                </div>
            </li>  
            <li>
                <div class="name"><?php echo ALIAS; ?> Originals</div>
                <div class="division">
                <a>                
                    <span id="each">Hairvy Like Sunday,</span>
                    <span id="each">Lawyer Up Nigeria,</span>
                    <span id="each">Glam Society,</span>
                    <span id="each">Study Bay,</span>
                    <span id="each">Pond Bae,</span>
                    <span id="each">Gorilla Specs,</span>
                    <span id="each">Yiddish,</span>
                    <span id="each">Founders Gate,</span>
                    <span id="each">Smalltalk,</span>                    
                    <span id="each">Heritage,</span>   
                    <span id="each">Forex Way,</span>
                    <span id="each">Grande (Discover Lagos)</span>
                </a>
                </div>
            </li>
            <li>
                <div class="name"><?php echo ALIAS; ?> Campus</div>
                <div class="division">
                    <span id="each">Campus News,</span>
                    <span id="each">Campus Square,</span>
                    <span id="each">Campus Music <a>(Unstaged)</a>,</span>
                    <span id="each">Campus Social</span>
                </div>
            </li>              
		</ul>
            
		<ul>
            <li class="title" id="apps">APPS + FEATURED CONTENT</li>
            <li>
                <div class="name"><?php echo ALIAS; ?> News</div>
                <div class="division">
                    <span id="each"><a>Hello World</a>,</span>
                    <span id="each">Voices,</span>
                    <span id="each">Commuter</span>
                </div>
            </li>  
            <li>
                <div class="name"><?php echo ALIAS; ?> Square</div>
                <div class="division">
                    <span id="each">Upstarts <a>(O900 Inside)</a>,</span>
                    <span id="each">Classified Jobs,</span>
                    <span id="each">Classified Deals,</span>
                    <span id="each">Directories (Local Business District),</span>
                    <span id="each">Ad Vantage</span>
                </div>
            </li>                     
            <li>
                <div class="name"><?php echo ALIAS; ?> Sports</div>
                <div class="division">
                    <span id="each">Primetime,</span>
                    <span id="each">Live Commentary,</span>
                    <span id="each">Predict &amp; Win,</span>
                    <span id="each">My Club,</span>
                    <span id="each"><a>Career Mode</a>,</span>
                    <span id="each">Connect,</span>
                    <span id="each">Kit/Apparel Store</span>
                </div>
            </li>  
            <li>
                <div class="name"><?php echo ALIAS; ?> Movies</div>
                <div class="division">
                    <span id="each">Now Showing,</span>
                    <span id="each"><a>Theatre After Five</a>,</span>
                    <span id="each">Awards,</span>                    
                    <span id="each">Ticket Sales,</span>
                    <span id="each">Box Office</span>
                </div>
            </li>
            <li>
                <div class="name"><?php echo ALIAS; ?> Music</div>
                <div class="division">
                    <span id="each">Greenbox Nigeria,</span>                
                    <span id="each">Now Playing,</span>
                    <span id="each"><a>Unstaged</a>,</span>
                    <span id="each">Billboards,</span>
                    <span id="each">Awards,</span>
                    <span id="each">Radio,</span>
                    <span id="each">Turntables,</span>
                    <span id="each">My Channels,</span>
                    <span id="each">Journeymann</span>
                </div>
            </li>
            <li>
                <div class="name"><?php echo ALIAS; ?> Social</div>
                <div class="division">
                    <span id="each"><a>The Weekend</a>,</span>
                    <span id="each">Eventra,</span>
                    <span id="each">Eventra 2.0,</span>
                    <span id="each">Ticket Sales,</span>
                    <span id="each">Hanglee,</span>
                    <span id="each">Vice,</span>
                    <span id="each">Xated,</span>
                    <span id="each">Pool,</span>
                    <span id="each">QNA,</span>
                    <span id="each">Nextdoor,</span>
                    <span id="each">Couples Untold</span>
                </div>
            </li>
            <li>
                <div class="name"><?php echo ALIAS; ?> Courses</div>
                <div class="division">
                    <span id="each">101 (OCW),</span>
                    <span id="each">411 (Premium)</span>
                </div>
            </li>
            <li>
                <div class="name"><?php echo ALIAS; ?> X</div>
                <div class="division">
                    <span id="each">Way,</span>                    
                    <span id="each">Pay,</span>
                    <span id="each">Blog,</span>                    
                    <span id="each">Route,</span>
                    <span id="each">Polls,</span>
                    <span id="each">Pledge,</span>
                    <span id="each">Opinion,</span>
                    <span id="each">Churchgate,</span>
                    <span id="each">Jobcity,</span>
                    <span id="each">Utility,</span>
                    <span id="each">CV Arena,</span>
                    <span id="each">Go,</span>
                    <span id="each">Translate,</span>
                    <span id="each">Search,</span>
                    <span id="each"><a>My <?php echo ALIAS; ?></a>,</span>
                    <span id="each">LagOS,</span>
                    <span id="each">HUD/Jolt</span>                    
                </div>
            </li>
        </ul>
    </div>            
</div>

<?php include_once('Action/Shared/Footer.php'); ?>
</body>
</html>
