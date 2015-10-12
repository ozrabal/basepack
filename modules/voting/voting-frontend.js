( function( $ ) {

    $( document ).ready(function() {
	get_voting();
    });

    var get_voting = function(){
	jQuery.ajax({
	    type    : 'post',
	    url	: ajaxurl,
	    data    : {
		action  : 'get_voting'
	    },
	    success : function( response ) {
	        response = $.parseJSON(response);
	        for( var i=0; i < response.buttons.length; i++){
		    $('#voting #'+response.buttons[i].id+' .score').html(response.buttons[i].score);
	        }
	    }
	});
    };

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
		    get_voting();
		    $('#voting').append('Dziękujemy');
		}
	    });
	}
    });

} )( jQuery );