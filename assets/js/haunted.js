$(function() {

	$('.close').click(function(e) {
		e.preventDefault();
		$(this).closest("tr").remove();
		
		var i = 0;
		$('.trcount').each(function() {
			i++;
		});
		
		var mice = $('#count').text();
		mice = parseInt(mice) - 1;
		
		if(mice == 0) $('#num_msg').text('Congratulations, you finished the map!');
		else $('#count').text(mice);
		
		console.log('remaining mice: '+mice);
	});
	
	/*
	$('.close').click(function() {
		var i = 0;
		$(this).parent().parent().find('.mouse').each(function() {
			i++;
		});
		
		if(i == 1) $(this).parent().parent().hide();
		
		var mice = $('#count').text();
		mice = parseInt(mice) - 1;
		
		$('#count').text(mice);
		
		console.log('remaining mice: '+mice);
	});
	*/
	
});

