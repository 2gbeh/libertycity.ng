// JavaScript Document
//alert("Server request recieved!");
window.addEventListener 
(	
	"resize", function ()
	{
		BLN_DJANGO();
	}
);

function BLN_ONLOAD ()
{
//	BLN_SPRY_CAROUSEL(); 
//	BLN_SPRY_FLASHCARD();	
//	BLN_SPRY_FIREFLY();		
}

function BLN_DJANGO ()
{
	BLN_SPRY_DRAWER('onResize');
	var leftpane = document.getElementsByClassName('left-pane'),
	rightpane = document.getElementsByClassName('right-pane'),	
	drawer = document.getElementsByClassName('JSP_SPRY_DRAWER');		
	if (window.innerWidth <= BLN_SPRY_DRAWER('Estate'))//450
	{
		var leftpanePosition = 'fixed',
		rightpaneMargin = '0 10px',
		rightpaneWidth = '93%',
		leftpaneDisplay = 'none',
		drawerDisplay = 'block';		
	}
	else
	{
		var leftpanePosition = 'relative',		
		rightpaneMargin = '0 20px',
		rightpaneWidth = '78%',
		leftpaneDisplay = 'inline-block',
		drawerDisplay = 'none';
	}
	for (var i = 0; i < leftpane.length; i++)
	{
		leftpane[i].style.position = leftpanePosition;		
		leftpane[i].style.display = leftpaneDisplay;				
	}
	for (var i = 0; i < rightpane.length; i++)
	{
		rightpane[i].style.margin = rightpaneMargin;		
		rightpane[i].style.width = rightpaneWidth;			
	}
	for (var i = 0; i < drawer.length; i++)
	{
		drawer[i].style.display = drawerDisplay;		
	}	
}