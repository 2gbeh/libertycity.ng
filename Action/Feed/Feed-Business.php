<div class="tile-business" id="modal">
    <div class="service"><?php echo _MKSALUTE() ?>,</div>
    <div class="duration">
        Kindly forward the stated requirements, 
        your location and the service order number to
    </div>
    <div class="mailto">
        <a <?php echo _MAILTO(ALIAS.' for Business'); ?> class="alt-btn"><?php echo EMAIL; ?></a>
    </div>
    <div class="subject">    
		<a <?php echo _MAILTO(ALIAS.' for Business'); ?>>RE: <?php echo ALIAS; ?> for Business</a>
	</div>    
</div>

<?php
	$feedArray = DRA_FEED_FETCH(DRA_TABLE_BUSINESS);
	foreach ($feedArray as $id => $row)
	{
		if (JSP_SSQL_FULLSTACK($row) && $row['type'] == ($pseudo_nav - 1)) //SAFE CHECK
		{
			$cost = _RICHJUMBO($row['cost']);
			$service = $row['service'];
			$duration = $row['duration'];
			if ($duration > 1)
				$plural_duration = 's';
			else
				$plural_duration = '';
			$csv_todo = _CSV($row['todo']);
			$todo = '';
			foreach ($csv_todo as $each)
				$todo .= '<div class="each">'.$each.'</div>';
			$rfid = $row['id'];
			
			
			$tile = '<table class="tile-business">    
                <tr>
                    <td>
                        <div class="cost">'.$cost.'</div>
                        <div class="service">'.$service.'</div>
                        <div class="duration">Service Delivery within '.$duration.' day'.$plural_duration.'</div>
                        <div class="todo">'.$todo.'</div>
                        <div class="action">
                            <a class="pri-btn" onclick=BLN_MODAL_OPEN("modal")>Get Started</a>
                        </div>
                        <div class="rfid">Service Order Number: #'.$rfid.'</div>
                    </td>
                </tr>
            </table>';
			$list .= '<li>'.$tile.'</li>';
		}
		else
			$list = '<li>'.substr(JSP_ERROR_SERVICE,1).'</li>';
	}
	echo '<ul class="STEM_CHASSIS_15">'.$list.'</ul>';
?>
