<div class="nav">
    <div class="STEM_OVERFLOW container">
        <ul class="nonapp">
        	<li><a href="home.php"><div class="each">Home</div></a></li>
            <?php
				$listArray = DRA_ENUMS_SWISS('BUSINESS');
				foreach ($listArray as $key => $value)
				{
					$key += 1;
					$listMenu[] = '<div class="each" onclick=BLN_HEADER_APPEND("b2b","'.$key.'")>'.$value.'</div>';
				}
                echo DRA_DISPLAY_ILIST
				(
					$listMenu,
					array(),
					$pseudo_nav
				);		
            ?>
        </ul>
    </div>
</div>
