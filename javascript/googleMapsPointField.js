(function($) {

	$('#ComplexTableField_Popup_DetailForm_Address, #ComplexTableField_Popup_AddForm_Address').entwine({
		onkeyup: function() {
			if(this.val().length > 3) $('#suggestionsAddress').loadSuggestions(this);
		}
	});

})(jQuery);