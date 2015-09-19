
$(document).ready(function(){
	$('.panel_item').click(function(){	
	   
	    $('.panel_item2').css('display','none')
		$('.item_bt').attr('src','images/zhankai.png');
		
		$(this).children('.item_bt').attr('src','images/shousuo.png');
		$(this).nextAll().css("display","block");

	
	});
	
	$('.panel_top').click(function(){
		$('.panel_item2').css('display','none')
		$('.item_bt').attr('src','images/zhankai.png');
	});
});
