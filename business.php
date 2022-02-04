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
$pseudo_title = 'For Business';
include_once('Action/Shared/Head.php');	
include_once('Bin/JRAD/Library-Blend.php'); 
include_once('Action/Shared/Media-Query.php');		
?>
<link href="Cascade/About.css" rel="stylesheet" type="text/css">
<link href="Cascade/Feed/Feed-Business.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="BLN_DJANGO()" id="top" status="on">
<div class="header-frame">
	<?php include_once('Action/Shared/Header.php'); ?>
    <?php $pseudo_nav = _SWISS(JSP_CRUNCH_REQUEST('b2b'),1,'THROW'); include_once('Action/Nav/Nav-Business.php'); ?>
</div>

<div class="mantra about container">
	<div class="STEM_WRAP_5">
        <h1><?php echo ALIAS; ?> for Business</h1>
        <h3>
            Get started with our streamlined catalogue of solutions to help you 
            achieve your business goals.
        </h3>
        <p></p>
        <div class="hr"></div>
        <a href="careers.php" class="alt-btn" id="partner">Become a Partner</a>
    </div>
</div>

<div class="feeds chassis">
	<?php include_once('Action/Feed/Feed-Business.php'); ?>
</div>

<p>&nbsp;</p>

<?php include_once('Action/Shared/Footer.php'); ?>
</body>
</html>
