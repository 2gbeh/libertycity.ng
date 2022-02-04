// JavaScript Document
window.addEventListener 
(	
	"resize", function ()
	{
		BLN_DJANGO();
//		document.getElementById('demo').innerHTML = window.innerWidth;				
	}
);

function BLN_DJANGO ()
{
	var container = document.getElementsByClassName('container'),
	wrap = document.getElementsByClassName('wrap'),
	STEM_WRAP_5 = document.getElementsByClassName('STEM_WRAP_5'),	
	STEM_WRAP_10 = document.getElementsByClassName('STEM_WRAP_10'),	
	STEM_WRAP_15 = document.getElementsByClassName('STEM_WRAP_15'),
	STEM_WRAP_20 = document.getElementsByClassName('STEM_WRAP_20'),	
	STEM_CHASSIS_5 = document.getElementsByClassName('STEM_CHASSIS_5'),	
	STEM_CHASSIS_10 = document.getElementsByClassName('STEM_CHASSIS_10'),	
	STEM_CHASSIS_15 = document.getElementsByClassName('STEM_CHASSIS_15'),	
	STEM_CHASSIS_20 = document.getElementsByClassName('STEM_CHASSIS_20'),		
	aboutUl = document.querySelectorAll('.about ul'),	
	feedsLi = document.querySelectorAll('.feeds li'),		
	Cards = document.getElementsByClassName('cards'),
	footer = document.getElementsByClassName('footer');	
	
	if (window.innerWidth <= 450)
	{
		var containerWidth = '98%',
		wrapWidth = '98%',
		
		STEM_WRAP_5_padding = '20px 5px',
		STEM_WRAP_10_padding = '20px 10px',
		STEM_WRAP_15_padding = '20px 15px',
		STEM_WRAP_20_padding = '20px',		
		
		STEM_CHASSIS_5_padding = '0 5px',
		STEM_CHASSIS_10_padding = '0 10px',
		STEM_CHASSIS_15_padding = '0 15px',
		STEM_CHASSIS_20_padding = '0 20px',		
		
		aboutUlMargin = '0',		
		aboutUlWidth = '98%',
		
		feedsLiMargin = '10px 0',
		feedsLiWidth = '98%',
		
		CardsMargin = '10px 0',		
		CardsWidth = '98%',
		
		footerPadding = '10px 0';
	}
	else
	{
		var containerWidth = '80%',
		wrapWidth = '95%',
		
		STEM_WRAP_5_padding = 
		STEM_WRAP_10_padding = 
		STEM_WRAP_15_padding = 
		STEM_WRAP_20_padding = '20px',		
		
		STEM_CHASSIS_5_padding = 
		STEM_CHASSIS_10_padding = 
		STEM_CHASSIS_15_padding = 
		STEM_CHASSIS_20_padding = '0',
		
		aboutUlMargin = '0 50px',		
		aboutUlWidth = '400px',
		
		feedsLiMargin = '10px',		
		feedsLiWidth = '310px',
		
		CardsMargin = '10px',				
		CardsWidth = '350px',
		
		footerPadding = '10px';				
	}
	for (var i = 0; i < container.length; i++)
		container[i].style.width = containerWidth;		
	for (var i = 0; i < wrap.length; i++)
		wrap[i].style.width = wrapWidth;		

	for (var i = 0; i < STEM_WRAP_5.length; i++)
		STEM_WRAP_5[i].style.padding = STEM_WRAP_5_padding;
	for (var i = 0; i < STEM_WRAP_10.length; i++)
		STEM_WRAP_10[i].style.padding = STEM_WRAP_10_padding;
	for (var i = 0; i < STEM_WRAP_15.length; i++)
		STEM_WRAP_15[i].style.padding = STEM_WRAP_15_padding;
	for (var i = 0; i < STEM_WRAP_20.length; i++)
		STEM_WRAP_20[i].style.padding = STEM_WRAP_20_padding;		
		
	for (var i = 0; i < STEM_CHASSIS_5.length; i++)
		STEM_CHASSIS_5[i].style.padding = STEM_CHASSIS_5_padding;
	for (var i = 0; i < STEM_CHASSIS_10.length; i++)
		STEM_CHASSIS_10[i].style.padding = STEM_CHASSIS_10_padding;
	for (var i = 0; i < STEM_CHASSIS_15.length; i++)
		STEM_CHASSIS_15[i].style.padding = STEM_CHASSIS_15_padding;
	for (var i = 0; i < STEM_CHASSIS_20.length; i++)
		STEM_CHASSIS_20[i].style.padding = STEM_CHASSIS_20_padding;				

	for (var i = 0; i < aboutUl.length; i++)
		aboutUl[i].style.margin = aboutUlMargin;		
	for (var i = 0; i < aboutUl.length; i++)
		aboutUl[i].style.width = aboutUlWidth;

	for (var i = 0; i < feedsLi.length; i++)
		feedsLi[i].style.margin = feedsLiMargin;		
	for (var i = 0; i < feedsLi.length; i++)
		feedsLi[i].style.width = feedsLiWidth;		

	for (var i = 0; i < Cards.length; i++)
		Cards[i].style.margin = CardsMargin;						
	for (var i = 0; i < Cards.length; i++)
		Cards[i].style.width = CardsWidth;				

	for (var i = 0; i < footer.length; i++)
		footer[i].style.padding = footerPadding;								
}
