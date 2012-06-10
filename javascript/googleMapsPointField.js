(function($) {

	$('#ComplexTableField_Popup_DetailForm_Address, #ComplexTableField_Popup_AddForm_Address').entwine({
		onkeyup: function() {
			$('#suggestionsAddress').loadSuggestions(this);
		}
	});

})(jQuery);