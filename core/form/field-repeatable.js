jQuery(function(jQuery) {

 ile = jQuery('.repeatable-item').length;
	   

function set_default_inputs(field){
    jQuery(field).find('input[type=text], input[type=hidden], text, textarea, select, checkbox').val(''); // Reset the values

    //def =  field.find('img').attr('data-src-default');
    jQuery(field).find('img').attr('src',function(){
	return jQuery(this).attr('data-src-default');
    });

}


jQuery('.repeatable-add').click(function(e) {
    e.preventDefault();

    f = jQuery(this).parent().find('.repeatable-item:last-child');


    jQuery('.repeatable-remove',f).removeClass('disable');

    field = f.clone();
	//field = jQuery('.repeatable').find('.repeatable-item:last-child').clone();
	fieldLocation = jQuery(this).parent().find('.repeatable-item:last-child');
        set_default_inputs(field);


var id=1;


//	field.find('div').attr('id', function(index, id) {
//		return name.replace(/(\d+)/, function(fullMatch, n) {
//			return Number(n) + 1;
//		});
//	})
        
        
        
        //alert(fieldLocation.length)
        
        
        //field.insertAfter('sss');
        
	field.insertAfter(fieldLocation);
        //renumber(ui.item).




 ile = jQuery(this).find('.repeatable-item').length;
//console.log(jQuery(this));
    renumber(this);


	b = '.open-media-button';
 d = jQuery(b).next();

 jQuery(ds.media.init);



			

			//console.log(jQuery('.repeatable-item:last-child .wp-color-result'));





	return false;
});




	// Remove repeatable row
	jQuery(document).on('click','.repeatable-remove',function(e){
	    e.preventDefault();
	     ile = jQuery(this).parent().parent().parent().find('.repeatable-item').length;
            //console.log(ile);
            //alert(ile);
            //exit;
if(ile >1){
	    //jQuery('.ui-sortable').closest('.ui-sortable').find('.row:last-child').remove();
            
            var v = jQuery(this).closest('table');
            
                jQuery(this).closest('.repeatable-item').remove();
                
                //jQuery(v).addClass('this')
		//console.log(jQuery(this).closest('table').addClass('this'));
                renumber(v);






		return false;
}else{
    //jQuery('.repeatable-item').find('input[type=text], input[type=hidden], text, textarea, select, checkbox').val(''); // Reset the values
       // jQuery('.repeatable-item').find('img').attr('src','');
jQuery(this).addClass('disable');
		set_default_inputs('.repeatable-item')
		return false;
}



	    });
        
       //var list = jQuery('.ui-sortable'); 
//function updateNames(list) {
//    list.each(function (idx) {
//        console.log(idx);
//        var inp = jQuery(this).find('input, textarea');
//        inp.each(function () {
//            this.name = this.name.replace(/(\[\d\])/, '[' + idx + ']');     
//            showNameAsValue(this)
//        })
//    });
//}
function showNameAsValue(el) {
    jQuery(el).html(el.name);
}


function renumber(item) {
  //tr = item[0].parentNode;
  
    //console.log(jQuery(item).parent());
  
  jQuery(item).parent().find('.repeatable-item').each(function(index,element) {
    renumber_helper(index,element); 
    showNameAsValue(this)
  });
}

function renumber_helper(index,element) {
  inputs = jQuery('input', element);
  for (j = 0; j < inputs.length; j++) {
    input = inputs[j];
    name = input.name;
    input.name = name.replace(/(\d+)/,index);
  }

  for (j = 0; j < inputs.length; j++) {
    input = inputs[j];
    id = input.id;
    input.id = id.replace(/(\d+)/,index);
  }

  textareas = jQuery('textarea',element);
  for (j = 0; j < textareas.length; j++) {
     textarea = textareas[j];
     name = textarea.name;
     textarea.name = name.replace(/(\d+)/,index);
  }
  

  for (j = 0; j < textareas.length; j++) {
     textarea = textareas[j];
     id = textarea.id;
     textarea.id = id.replace(/(\d+)/,index);
  }

  buttons = jQuery('button',element);
  for (j = 0; j < buttons.length; j++) {

     button = buttons[j];
     //console.log(jQuery(button).data('editor'));
     editor = jQuery(button).data('editor');
	     //textarea.name = name.replace(/(\d+)/,index);
	    jQuery(button).data('editor',editor.replace(/(\d+)/,index));
  }

  selects = jQuery('select',element);
  for (j = 0; j < selects.length; j++) {
    select = selects[j];
    name = select.name;
    select.name = name.replace(/(\d+)/,index);
  }



  

  as = jQuery('a', element);
  for (j = 0; j < as.length; j++) {
    a = as[j];
    id = a.id;
    
    a.id = id.replace(/(\d+$)/,index);

    //console.log(id);
  }
  
  ass = jQuery('.attachment-fieldset', element);

  for (j = 0; j < ass.length; j++) {
    ab = ass[j];
    id = ab.id;

    ab.id = id.replace(/(\d+$)/,index);
    //console.log(id);
  }


//jQuery('.color-field').wpColorPicker('destroy');

//jQuery('.color-field').wpColorPicker({
//	    //palettes: palettes
//	});


}


jQuery('.ui-sortable-container').sortable({
	opacity: 0.6,
	revert: false,
	cursor: 'move',
	handle: '.order',
        update: function(event,ui){ renumber(ui.item); }
//        update: function (event, ui) {
//        updateNames(jQuery(this))
//    }
});


});