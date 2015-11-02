
jQuery(function(jQuery) {

 ile = jQuery('.repeatable-item').length;


var origin = jQuery('.repeatable-item:first-child');
var origin_ed_id = jQuery(origin).find('.wp-editor-area').attr('id');
console.log(tinymce);

tinyMCE.execCommand('mceRemoveEditor',false,'repeatable_0__wysiwyg_e');


function origin_set_id(){
    
}




function set_default_inputs(field){
    jQuery(field).find('input[type=text], input[type=hidden], text, textarea, select, checkbox').val(''); // Reset the values


//console.info(t);
//
//
//
//tinyMCE.execCommand('mceRemoveEditor',false,t[0].id);
//tinymce.EditorManager.execCommand('mceRemoveEditor', false, t[0].id);
//console.log(tinyMCE);
//tinymce.remove(t[0].id);
    //def =  field.find('img').attr('data-src-default');
    jQuery(field).find('img').attr('src',function(){
	return jQuery(this).attr('data-src-default');
    });

}


jQuery('.repeatable-add').click(function(e) {
    e.preventDefault();
//tinyMCE.execCommand('mceRemoveEditor',false,'repeatable_0__wysiwyg_e');
     
    f = jQuery(this).parent().find('.repeatable-item:last-child');


    jQuery('.repeatable-remove',f).removeClass('disable');

jQuery(f).find('.repeatable-element').each(function(index,element) {
    

    renumber_helper(index,element); 
    showNameAsValue(this)
    
  });
console.log(f);

t = jQuery(f).find('textarea').attr('id');


console.log(tinyMCE.editors[t].remove());


//tinyMCE.editors;
//tinymce.remove(t);








    field = f.clone();
	//field = jQuery('.repeatable').find('.repeatable-item:last-child').clone();
	fieldLocation = jQuery(this).parent().find('.repeatable-item:last-child');
        set_default_inputs(field);


var id=1;

//field.find('.wp-editor-wrap').remove();



//	field.find('div').attr('id', function(index, id) {
//		return name.replace(/(\d+)/, function(fullMatch, n) {
//			return Number(n) + 1;
//		});
//	})
       t = jQuery(field).find('textarea');
       console.error(t);
      
       
        
        //alert(fieldLocation.length)
        
        
        //field.insertAfter('sss');
        
	field.insertAfter(fieldLocation);
        //renumber(ui.item).



 ile = jQuery(this).find('.repeatable-item').length;
//console.log(jQuery(this));
    renumber(this);
    last = jQuery('.repeatable-item:last-child textarea');
    console.log(last.attr('id'));
//tinyMCE.execCommand('mceAddEditor',false,'repeatable_1__wysiwyg_e');

tinyMCE.execCommand('mceAddEditor',false,last.attr('id'));

tinyMCE.execCommand('mceAddEditor',false,t);

//tinyMCE.execCommand('mceAddEditor',false,'repeatable_1__wysiwyg_e');


	b = '.open-media-button';
 d = jQuery(b).next();

 //jQuery(ds.media.init);



			

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





  buttons = jQuery('button, .button',element);
    var buttons = jQuery('.insert-media',element);
  for (j = 0; j < buttons.length; j++) {

     button = buttons[j];
     //console.log(button);
     var editor = jQuery(buttons[j]).attr('data-editor');
     
     console.log(editor);
     
	     //textarea.name = name.replace(/(\d+)/,index);
	     //if(editor){
	    jQuery(button).attr('data-editor',editor.replace(/(\d+)/,index));
	     //}
          
             
  //tinymce.init({ selector: '#' + editor });
    }
  //tinymce.remove('textarea'); 
// var edt = jQuery('.wp-editor-wrap');
// console.log(edt);
//   for (j = 0; j < edt.length; j++) {
//       
//       
//      
//       
//tex = edt[j];
//     id = tex.id;
//     tex.id = id.replace(/(\d+)/,index);
//     
//       tinymce.init(tex.id);
//        tinymce.execCommand('mceAddEditor', false, tex.id);
//     console.log(tex.id);
// //tinyMCE.execCommand('mceRemoveControl',false,tex.id);
// 
////jQuery(edt[j]).each('div', function(index){
////         
////         console.log(this);
////         //this.id = id.replace(/(\d+)/,index);
////         
////     });
//     
//       }
//     

var edt = jQuery('.wp-editor-wrap textarea');

console.log(edt);




for (j = 0; j < edt.length; j++) {
    //tinymce.remove(tinymce.editors[edt[j].id])
    console.log(edt[0].id);
    //tinyMCE.execCommand("mceRemoveControl", false,edt[j].id);
   // tinyMCE.execCommand("mceAddControl", false,edt[j].id);
    
    
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
	opacity: 0.8,
	revert: true,
	axis: "y",
	cursor: 'move',
	handle: '.order',
	placeholder: "ui-state-highlight",
	update: function(event,ui){ renumber(ui.item); }
});


});