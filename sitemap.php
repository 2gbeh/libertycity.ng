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
<link href="Cascade/Sitemap.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="BLN_DJANGO()" id="top" status="on">
<div class="header-frame">
	<?php include_once('Action/Shared/Header.php'); ?>
    <?php $pseudo_nav = 8; include_once('Action/Nav/Nav-Nonapp.php'); ?>
    <p>&nbsp;</p>  
</div>

<div class="sitemap container">
    <div class="STEM_WRAP_10">
        <h2>Sitemap</h2>
        <div class="hr"></div>        
        <div class="article">
            Navigate the entire <a href="<?php echo SERVER; ?>"><?php echo DOMAIN; ?></a> server using our interactive sitemap portal below : <br/>
            Product names are listed alphabetically, and numbers 1 to 26 are featured contents under each product. Enjoy.
        </div>
        <p></p>        
        <ul class="tab">
            <li><a href="#apps" id="selected">Apps</a></li>
            <li><a href="#featured">Featured Content</a></li>
        </ul>
        <div class="iframe">
            <div class="label" id="apps">List of <?php echo ALIAS; ?> apps</div>
            <div class="STEM_OVERFLOW">
                <?php 
                    foreach (range(A,Z) as $letter) 
                        echo '<a href="#">'.$letter.'</a>&nbsp;&nbsp;';
                ?>
                <p></p>
                    <div class="hr"></div>
                <p></p>                
                <div class="label" id="featured">List of <?php echo ALIAS; ?> featured content</div>            
                <?php 
                    foreach (range(1,26) as $letter) 
                        echo '<a href="#">'.$letter.'</a>&nbsp;&nbsp;';
                ?>            
            </div>                
        </div>
        <div class="sitemap-footer">
            Results for: <b>axx -- zxx</b> &nbsp; &bull; &nbsp; <a href="home.php">Home</a>
        </div>            
	</div>        
</div>       

<?php include_once('Action/Shared/Footer.php'); ?>
</body>
</html>
