(function( $ ) {
    $(function() {
        $('.color-field').wpColorPicker({
	    palettes: jQuery.parseJSON( palettes ),
	});
    });
})( jQuery );