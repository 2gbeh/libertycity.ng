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
<link href="Cascade/Careers.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="BLN_DJANGO()" id="top" status="on">
<div class="header-frame">
	<?php include_once('Action/Shared/Header.php'); ?>
    <?php $pseudo_nav = 3; include_once('Action/Nav/Nav-Nonapp.php'); ?>
    <p></p>
</div>

<div class="mantra about container">
		<h1>Careers at <?php echo ALIAS; ?></h1>
        <h2><q> <qq>Calling all Autobots</qq> </q></h2>
        <h3>
        	Thank you for your interest in joining our online community of developers, editors, content curators and service providers.
		</h3>        
    <p>&nbsp;</p>
        <h3>
        	@<?php echo ucwords(DOMAIN); ?>, our consumers have the "liberty" to choose their <a href="apps.php#apps">favourite apps</a> and access 
        	only the kinds of content they love, and this tradition is also championed here at <?php echo ALIAS; ?> HR. 
            Team members and new recruits as well have the liberty to choose their path and function in multiple product divisions at will. 
        </h3>
    <p>&nbsp;</p>
        <h2>On a clear day</h2>
        <h3>
            Our work culture is centred around giving individuals the platform and opportunity to work on only the
            things they love and do naturally in their spare hours, without any form of pressure or time constraints. 
            This freedom has been an integral part of our hiring process particularly because all our talents work remotely from locations across Nigeria. 
        <p></p>
            <q> <qq>Working at <?php echo APPNAME; ?> should feel like breeze.</qq> </q>
            <div class="author">Founder &amp; CEO, Tugbeh Emmanuel</div>
        <p></p>
            We recruit amongst youngsters because millennials are our target market and we believe individuals in this age group truly understand our market and know the kinds products and services that matter to our consumers. 
            Your responsibilies at <?php echo ALIAS; ?> is fairly simple; research and develop apps and content that you love because you are an extension of our target market. 
        </h3>
    <p>&nbsp;</p>
        <h2><?php echo ALIAS; ?> and I</h2>
        <h3>
			Once part of <b>The <?php echo ALIAS; ?> Magic R&amp;D Team</b> (as we love to call it), you can pretty much work on anything you like. 
            You can join an existing product division or bring up something new and exciting for us to work on. 
            <?php echo ALIAS; ?> is the city of <b>absolute creative freedom</b>. 
            If you love it, then we love it too, and surely our consumers will digg it - for reals!
		</h3>        
    <p>&nbsp;</p>
        <h2>Get Started</h2>
        <h3>
            	Let's begin by taking off your clothes and massaging your ni... [Next Slide] Ok! Let's begin by sending a simple email. 
                Introduce yourself and your interests, you may also tell us what <a href="apps.php#division">product division</a> you will like to be part of, or hint us on something new and exciting you have always wanted to do. 
                For undecided folks, keep calm, we have a Magic Orb at  <?php echo ALIAS; ?> that can tell us exactly what your 
                interests are, what product division you will excel at, as well as who you tortorri[ed] last summer - all at the push of a button.
			<p></p>            
            	Just a simple email; no documentation, no formalities and yes, no qualifications needed. <br/>
                <b>Just be you. Just be millennial</b>. <br/>
                Ps: no CV attachments required either.
        </h3>                          
</div>
    
    
<div class="mantra careers chasis">   
    <a <?php echo _MAILTO('Careers at '.APPNAME); ?> class="pri-btn">apply now</a><br/>
    <a <?php echo _MAILTO('Careers at '.APPNAME); ?> class="email-link">RE: Careers at <?php echo APPNAME; ?></a>
    <p></p>
        <b>OR</b>
    <p></p>
        See application samples from our finest recruits, 
        <a href="#jude">Jude</a>, 
        <a href="#felicia">Felicia</a> and
        <a href="#bob">Bob</a> (no one likes Bob).
    <p></p>
    <div class="cards" id="jude">
    	<div class="STEM_WRAP_15">
            <div class="title">Yo, i'm Jude</div>
            <div class="subtitle">dj_agbalumo@yahoo.com</div>
            <div class="article">
                I think you guys are cool. Your atmosphere here is electric. I love music and DJ[ing] is my rock. 
                I will like to join <?php echo ALIAS; ?> Music and i also have an idea for something called <?php echo ALIAS; ?> Radio.
                Holla back if you guys are interested. Jah bless, Regards. #DJAgbalumoBurstMyHead
            </div>
        </div>
    </div>
    <div class="cards" id="felicia">
    	<div class="STEM_WRAP_15">    
            <div class="title">Hi, i'm Felicia by name</div>
            <div class="subtitle">felishtooslay92@rocketmail.com</div>
            <div class="article">
                I like what u guys are doing and i want to be part of it but i'm not really sure where i fall under. 
                I studied Mass Comm in school and i've always wanted to be a career blogger. 
                I also have interest in social media marketing and all these PR stuffs. Can't wait to hear from u guys LOL xoxo.
            </div>              
		</div>              
    </div>            
    <div class="cards" id="bob">
    	<div class="STEM_WRAP_15">    
            <div class="title">Dear HR,</div>
            <div class="subtitle">m.bob@gmail.com</div>
            <div class="article">
                I, kindly wish to apply for employment at <?php echo APPNAME; ?>. I have a B.Sc in Computer Engineering and M.Sc in Business Admin. 
                I have 4 years experience in Software Development. I am a certified ASP.net Developer (see attachment). 
                Below is an outlined bullet-list of my work ex ... ... ...
            </div>                    
		</div>            
    </div>                        
</div>       

<?php include_once('Action/Shared/Footer.php'); ?>
</body>
</html>
