(function($) {
	var xhr;
	$('#suggestionsAddress').entwine({
		loadSuggestions: function(el) {
			var self = this;
			if(typeof xhr == 'object') xhr.abort();
			this.html('loading...');
			xhr = $.ajax({
				url: 'googleapi/getSuggestions',
				type: 'POST',
				data: 'address=' + el.val(), 
				success: function(data){
					if(data){
						self.html(data);
					}
				}
			});
		}
	});

	$('#suggestionsAddress ul li a').entwine({
		onclick: function() {

			$('#Address').find('input[name=Address]').val(this.text());
			var self = this;
			$.ajax({
				url: 'googleapi/getCoordinates',
				type: 'POST',
				data: 'reference=' + self.attr('id'), 
				success: function(data){
					if(data){
						var obj = jQuery.parseJSON(data);
						$('input[name=Lat]').val(obj.lat);
						$('input[name=Lon]').val(obj.lng);
					}
				}
			});
			$('#suggestionsAddress').html('Point has been added!');
			return false;
		}
	});

	$("ComplexTableField_Popup_AddForm").entwine({
		validate: function() {
			return true;
		}
	});

})(jQuery);