$(function() {

	$('.close').click(function() {
		
		// get mouse name from div object
		var mouse_name = $(this).parent().data('id');
		
		// scroll through all mice divs and find the same mouse on which x was clicked
		$('.mouse').each(function(index){
			var id = $(this).data('id');
			
			// if we find it, remove that div
			if(id === mouse_name) $(this).remove();
		});
		
		$('.area_div').each(function() {
			var len = $(this).children('.mouse').length;
			if(len == 0) $(this).hide();
		});
		
		var mice = $('#count').text();
		mice = parseInt(mice) - 1;
		
		if(mice == 0) $('#num_msg').text('Congratulations, you finished the map!');
		else $('#count').text(mice);
		
		console.log('remaining mice: '+mice);
	});
	
});

