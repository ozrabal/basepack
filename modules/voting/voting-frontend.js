( function( $ ) {

    $('#voting').on('click','button', function(e) {
	e.preventDefault();
	if($(this).data('id')) {
	    jQuery.ajax({
		type    : 'post',
		url	: ajaxurl,
		data    : {
		    action  : 'vote',
		    id	    : $(this).data('id'),
		    score   : 125
		},
		success : function( response ) {
		    $('#voting button').each(function(i,btn) {
			$(this).prop('disabled', true);
		    });
		    $('#voting').append('Dziękujemy');
		}
	    });
	}
    });

} )( jQuery );