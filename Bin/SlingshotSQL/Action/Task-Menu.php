<div class="page-title">manage task</div>
<ul class="page-menu">
<?php
	if (IS_EXP_ADMIN)
	{
		echo JSP_DISPLAY_ILIST
		(
			'task records',		
			'Task-Record.php',
			$pseudo_nav
		);
	}
	else
	{
		echo JSP_DISPLAY_ILIST
		(
			'records,add/ modify',		
			'Task-Record.php,Task-Form.php',
			$pseudo_nav
		);		
	}
?>
</ul>
	