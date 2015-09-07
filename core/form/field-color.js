jQuery(function(jQuery) {
    if( typeof palettes !== undefined ){
        var predefined_palettes = jQuery.parseJSON( palettes );
    } else {
        var predefined_palettes = {};
    }
    function init(){
	jQuery( '.color-field' ).wpColorPicker({
	    palettes: predefined_palettes
	});
    }
    init();
    //repetable
    jQuery( '.repeatable-add' ).click(function(e) {
	jQuery( '.repeatable-item:last-child .wp-color-result' ).remove();
	init();
    });
});