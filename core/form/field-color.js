jQuery(function(jQuery) {
    if( typeof default_color !== 'undefined' ){
	var predefined_color = default_color;
    } else {
	var predefined_color = '#ffffff';
    }
    if( typeof palettes !== 'undefined' ){
        var predefined_palettes = jQuery.parseJSON( palettes );
    } else {
        var predefined_palettes = {};
    }
    function init(){
	jQuery( '.color-field' ).wpColorPicker({
	    color: '#ffffff',
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