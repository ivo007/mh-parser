$(function() {
	
	//show services tooltip for every packet 
	$('.popup').hover(
		
		//handlerIn
		function(event) {
			
			var name = $(this).text();
			var snuid = $(this).attr('data-id');
			var	img = site_url+'assets/css/images/hunters/img_'+snuid+'.jpg';
			
			var image = new Image(); 
			image.src = img;
			if (image.width == 0) img = site_url+'assets/css/images/no-photo.jpg';
			
			var html = '<div class="popover_container">';
				html+= '<h3 class="popover-title">'+name+'</h3>';
				html+= '<div class="popover-content"><img src="'+img+'" /></div>';
				html+= '</div>';
			
			$(this).append(html);
		},
		//handlerOut
		function () {
			$(".popover_container").remove();
		}
	);	
});