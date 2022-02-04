<div class="page-title">manage team</div>
<ul class="page-menu">
<?php
    if (IS_EXP_ADMIN)
    {
        echo JSP_DISPLAY_ILIST
        (
            'team records,team division,update profile',
            'Team-Table.php,Team-Division.php,Team-Profile.php',			
            $pseudo_nav
        );
    }
    else
    {
        echo JSP_DISPLAY_ILIST
        (
            'team records,team division,create account',		
            'Team-Table.php,Team-Division.php,Team-Form.php',
            $pseudo_nav
        );			
    }
?>
</ul>
	