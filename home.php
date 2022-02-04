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
<link href="Cascade/Feed/Feed-News.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="BLN_DJANGO()" id="top" status="on">
<div class="header-frame">
	<?php include_once('Action/Shared/Header.php'); ?>
    <?php include_once('Action/Nav/Nav-Home.php'); ?>
    <p></p>
</div>

<div class="mantra chassis">
    <div class="STEM_WRAP_5">
		<?php echo DRA_LOOP_MANTRA(); ?>
        <h1 id="DRA_LOOP_MANTRA_TARGET"></h1>
        <h2>
            <?php echo DRA_OTIS_MANTRA(); ?>
            discover personalised content in <a href="#">entertainment</a> and 
            <a href="#masthead">consumer services</a>.
        </h2>
	</div>        
</div> 
        
<div class="feeds chassis">
	<?php include_once('Action/Feed/Feed-News.php'); ?>
</div> 

<div class="mantra chassis">
	<p>&nbsp;</p>
    <div class="STEM_WRAP_5">
        <h2>Loading is taking a while<?php echo JSP_SPRY_LOAD(); ?></h2>
        <a href="<?php echo SERVER; ?>">Reload page</a> or reset your network connection.
	</div>    
    <p></p>
</div>    
    
<?php include_once('Action/Shared/Footer.php'); ?>
</body>
</html>
<script type="application/javascript">
	DRA_LOOP_MANTRA();
	JSP_SPRY_LOAD();	
</script>