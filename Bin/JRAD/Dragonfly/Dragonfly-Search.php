<?php
function DRA_SEARCH_TOGGLE ()
{
	if (isset($_GET['keyword'])) 
		return 'style="visibility:visible;"';
}

function DRA_SEARCH_GOOGLE ()
{
	$prefix = 'https://www.google.com.ng/search?q=';
	if (isset($_GET['keyword']))
	{
		$keyword = $_GET['keyword'];
		$array = JSP_BUILD_ARRAY($keyword,' ');
		$plused = JSP_DROP_ARRAY($array,'+');
		$href = $prefix.$plused;
		echo '<script type="application/javascript">
			var page = location.href;
			page = page.split("#")[0];
			page = page.split("?")[0];
			window.location.href = page;
			window.location.assign("'.$href.'");
		</script>';
	}
}

?>