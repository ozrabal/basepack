jQuery(function(jQuery) {
    
    if(typeof palettes != undefined){
        var palettes = jQuery.parseJSON( palettes );
    } else {
        var palettes = [];
    }
    
        jQuery('.color-field').wpColorPicker({
	    palettes: palettes
	});
        jQuery('.color-field').wpColorPicker( 'destroy' );
        
        jQuery('.repeatable-add').click(function(e) {
            //alert();
        
    });
    });
