<?php
include_once('Bin/Kernel.php');
include_once('Action/Shared/Local.php');
$table = JSP_TABLE_ADMIN;
$fieldArray = array('KEY','VALUE','FILTER','KOGLOB','NOGLOB');
$whereArray = array('PRIKEY',1,1);
$fileArray = _CONTENT(JSP_BASE_UPLOADS,'DOC');
$_POST['headline'] = 'welcome to hwp labs ';
$_FILES['image']['name'] = 'you tube.png';
$pointer = 5;
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
</head>
<body onLoad="BLN_DJANGO()" id="top" status="on">
<?php

?>


</body>
</html>
<script type="text/javascript">
//alert(window.innerWidth);
</script>