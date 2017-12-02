//http://www.pamaya.com/jquery-selectors-and-attribute-selectors-reference-and-examples/

$(function() {

	triggerChange();
	
	$('#run').click(function() {
		
		//var id = $('td:first-child').attr('id').match( /_(.*)_/ );
		var snuids = $('#snuids').text();
		var start = $('#save_start').prop('checked');
		var page = (start === true) ? 'ajax/get_start_data/' : 'ajax/get_data/';
		
		$.getJSON(site_url + page + encodeURIComponent(snuids), function(data) {

			//row_558643749_dragon
			var results = data.data;	//data.msg.mice
			
			for(var i=0; i<results.length; i++) {
			
				var hunterArr = results[i],
					crowns = hunterArr.crowns,
					collectibles = hunterArr.items.collectibles,
					selector = '[id^=row-'+hunterArr.snuid+']';
				
				$(selector).each(function(index) {
					var that = this;
				    var str = $(this).attr('id');
				    var cell_id = str.slice(str.lastIndexOf('-')+1);
				    
				    for(var j=0; j<crowns.length; j++) {
				    	if(crowns[j][1] == cell_id) {
				    		var previous = parseInt( $(that).text() );
				    		var current = parseInt( crowns[j][2] );
				    		if(previous != current) {
				    			$(that).empty().append( crowns[j][2] );
				    			if(!start) $(that).css('background-color', '#95F092');
				    		}
				    	}
				    }
				    
				    if(collectibles) {
					    for(var k=0; k<collectibles.length; k++) {
					    	if(collectibles[k].type == cell_id) $(that).empty().append( collectibles[k].quantity );
					    }
				    }
				});
			}
		})
		.error(function() { alert("error"); });
		
	});
	
	//fetch start of the ajax call
	$(document).ajaxStart(function() {
		$('div#parser_container').prepend('<div id="overlay"><img src="http://bama.tirova.net//assets/css/images/loading.gif" class="loading_circle" alt="loading" /></div>');
	});
	
	$(document).ajaxStop(function() {
		$('div#overlay').empty();
	});
	
	//http://iknowkungfoo.com/blog/index.cfm/2012/4/18/Check-All-Checkboxes-with-jQuery--Revisited
	$(':checkbox.selectall').on('click', function(){
		$(':checkbox[name=' + $(this).data('checkbox-name') + ']').prop("checked", $(this).prop("checked"));
	});
	
	function triggerChange() {
	    $("#save_start").trigger("change");
	}

	$("#save_start").change(function() {
		if( $(this).prop('checked') === true ) alert('Use with caution, only once per tourney!');
	});

	
	
	/*
	$('#horn_calls').click(function(event) {
		event.preventDefault();
		
		$.get(site_url+'comp/horns_tracker', function(response) {
			$('#horns_output').html(response);
		})
		.error(function() { console.log('sranje'); });
		
	});
	*/
	
});

