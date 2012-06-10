(function($) {
	
	$('#suggestionsAddress').entwine({
		loadSuggestions: function(el) {
			var self = this;
			$.ajax({
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
			return false;
		}
	});

	$("ComplexTableField_Popup_AddForm").entwine({
		validate: function() {
			return true;
		}
	});

})(jQuery);