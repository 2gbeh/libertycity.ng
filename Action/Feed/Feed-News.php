<?php
	$feedArray = DRA_FEED_FETCH(DRA_TABLE_NEWS);
	$feedArray = DRA_FEED_INVERT($feedArray);
	foreach ($feedArray as $id => $row)
	{
		if (JSP_SSQL_FULLSTACK($row)) //SAFE CHECK
		{
			$topic = DRA_ENUMS_SWISS('TOPIC',$row['topic']);
			$file = _UPROOT(DRA_BASE_NEWS.$row['image']);	
			if (JSP_FILE_EXIST($file))
				$image = '<tr><td class="image" style="background-image:url('.$file.');">&nbsp;</td></tr>';
			else
				 $image = '';
			$headline = $row['headline'];
			$source = 'Source: '.ucwords($row['source']);
			$article = JSP_WRAP_WORD($row['article']);
			$link = 'Read full story <a href="'.$row['link'].'" target="_new">here</a>.';
			$admin_rid = DRA_SSQL_SWISS(JSP_TABLE_ADMIN,$row['admin_rid']);
			$team_rid = _SWITCH(JSP_TABLE_TEAM,'username',$admin_rid['username']);
			$crt = 'CRT '.DRA_CRUNCH_CRT($team_rid['name']);
			$time = '| '.JSP_CAL_MKFORMAT($row['time'],'TIME','FEED');
			
			$tile = '<table>
				<tr><td class="column"><a href="#">'.$topic.'</a> <span id="spanner">&rsaquo;</span></td></tr>'
				.$image.'
				<tr>
					<td class="writeup">        
						<div class="headline">'.$headline.'</div>
						<div class="meta">'.$source.'</div>					
						<div class="article">'.$article.' '.$link.'</div>
						<div class="base">
							<div class="crt">'.$crt.'</div>
							<div class="read">'.$time.'</div> 
						</div>
					</td>
				</tr>                
			</table>';
			$list .= '<li>'.$tile.'</li>';
		}
	}
	echo '<ul class="tile-news">'.$list.'</ul>';
?>