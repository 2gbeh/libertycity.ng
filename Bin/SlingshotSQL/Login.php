<?php
include_once('../Kernel.php');
include_once('Action/Shared/Global.php');
include_once('Action/Server/Login.php');
var_dump
(
);
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
<body>
<div class="header">
<?php include_once('Action/Shared/Header.php');  ?>
</div>

<div class="landing">
    <form <?php echo JSP_FORM_POST; ?>>
	 	<?php 
			echo '<div class="middle">'.$JSP_SPRY_PROFILE.'</div>';
			echo _ERROR($err); 
		?>
        <label for="username">username</label>
        <input type="text" class="textbox" id="username" name="username" value="<?php echo $_POST['username']; ?>" onChange="BLN_FORMS_FOOBAR(this.value)" required />
        <label for="password">password <?php echo JSP_SPRY_PASSWORD(); ?></label>
        <input type="password" class="textbox" id="password" name="password" value="<?php echo $_POST['password']; ?>" required />
        <a href="#" onClick="BLN_DISPLAY_DOM('support','OPEN')">Forgot password?</a>
        <input type="submit" class="button" value="login" />
    </form>
</div>
    
</body>
</html>
<script type="text/javascript">
//alert(window.innerWidth);
</script>
