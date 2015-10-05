<?php

namespace Modules\Test;

class Test {

    public function __construct() {
	$this->ajax_edit();
	add_action( 'admin_enqueue_scripts', function(){
	    wp_enqueue_script( 'test', BASEPACK_PLUGIN_URL . 'modules/test/test.js', array( 'jquery',
				'backbone',
				'underscore',
				'wp-util' ), true, true );
	    wp_enqueue_style( 'test', BASEPACK_PLUGIN_URL . 'modules/test/modal.css' );

	   


	});
	

	$test_labels = array(
	    'name'               => __( 'Test', 'pwp' ),
	    'singular_name'      => __( 'Test', 'pwp' ),
	    'add_new'            => __( 'Add New', 'pwp' ),
	    'add_new_item'       => __( 'Add New test', 'pwp' ),
	    'edit_item'          => __( 'Edit test', 'pwp' ),
	    'new_item'           => __( 'New test', 'pwp' ),
	    'all_items'          => __( 'All tests', 'pwp' ),
	    'view_item'          => __( 'View test', 'pwp' ),
	    'search_items'       => __( 'Search tests', 'pwp' ),
	    'not_found'          => __( 'No tests found', 'pwp' ),
	    'not_found_in_trash' => __( 'No tests found in Trash', 'pwp' ),
	    'parent_item_colon'  => __( ':', 'pwp' ),
	    'menu_name'          => __( 'Test', 'pwp' )
	);

	$test_args = array(
	    'labels'             => $test_labels,
	    'public'             => true,
	    'publicly_queryable' => true,
	    'show_ui'            => true,
	    'show_in_menu'       => true,
	    'query_var'          => true,
	    'rewrite'            => array( 'slug' => 'test' ),
	    'capability_type'    => 'page',
	    'has_archive'        => true,
	    'hierarchical'       => false,
	    'menu_position'      => null,
	    'supports'           => array( 'title', 'page-attributes'/*, 'thumbnail', 'editor', 'page-attributes' */)
	);
	register_post_type( 'test', $test_args );

	$test_meta = array(
	    'name'      => 'test_meta',
	    'title'     => 'Pola dodatkowe',
	    'post_type' => array( 'test'/*,'page'*/ ),
        //'allow_posts'=> array('rule' => 'template','params'=>'contributors.php' ),
	    'elements'  => array(
		array(
		    'type'	=> 'repeatable',
		    'name'	=> 'repeatable',
		    'params'	=> array(
			'label'	=> 'Repeatable Label',
			'comment'   => 'Comment',
			'class'	    => '',
			'repeater'  => array(
			    array(
				'type'	=> 'text',
				'name'	=> 'repeatable_text',
				'params'=> array(
				    'label'	=> 'Repeatable Text Label',
				    'comment'   => 'Comment',
				    'class'	=> 'large-text'
				)
			    ),
                            array(
				'type'	=> 'color',
				'name'	=> 'repeatable_color',
				'params'=> array(
				    'label'	=> 'Repeatable Color Label',
				    'comment'   => 'Comment',
				    'default_color' => '#ffffff',
				    'palettes' => array('#4E567D', '#006EAB', '#8781BD', '#EB008B', '#00B38A', '#BFCCD3')
				)
			    )
			)
		    )
		),
		array(
		    'type'	=> 'color',
		    'name'	=> 'color',
		    'params'	=> array(
			'label'	    => 'Color Label',
			'comment'   => 'Comment',
			'class'	    => 'color-field',
			'default_color' => '#ffffff'
		    ),
		),
		array(
		    'type'	=> 'text',
		    'name'	=> 'text',
		    'params'	=> array(
			'label'	    => 'Text Label',
			'comment'   => 'Comment',
			'class'	    => 'large-text'
		    ),
		),
		array(
		    'type'	=> 'textarea',
		    'name'	=> 'textarea',
		    'params'	=> array(
			'label'	    => 'Textarea Label',
			'comment'   => 'Comment',
			'class'	    => 'large-text'
		    ),
		),
		array(
		    'type'	=> 'wysiwyg',
		    'name'	=> 'wysiwyg',
		    'params'	=> array(
			'label'	    => 'Wysiwyg Label',
			'comment'   => 'Comment',
			'class'	    => '',
			'options'   => array(
			    'tinymce'	=> true
			)
		    ),
		),
		array(
		    'type'	=> 'checkbox',
		    'name'	=> 'checkbox',
		    'params'	=> array(
			'label'	    => 'Checkbox Label',
			'comment'   => 'Comment',
			'class'	    => ''
		    ),
		),
		array(
		    'type'	=> 'image',
		    'name'	=> 'image',
		    'params'	=> array(
			'label'	    => 'Image Label',
			'comment'   => 'Comment',
			'class'	    => '',
                        'data'      => array(
                            'title'     => 'Image title',
                            'select'    => 'Select image',
                            'mime'      => 'image'
                        )
		    ),
		),
		array(
		    'type'	=> 'attachment',
		    'name'	=> 'attachment',
		    'params'	=> array(
			'label'	    => 'Attachment Label',
			'comment'   => 'Comment',
			'class'	    => '',
                        'data'      => array(
                            'title'     => 'File title',
                            'select'    => 'Select file',
                            'mime'      => 'multipart'
                        )
		    ),
		),
		array(
		    'type'	=> 'select',
		    'name'	=> 'select',
		    'params'	=> array(
			'label'	=> 'Select Label',
			'comment'   => 'Comment',
			'class'	    => '',
			'options'   => array(
			    'key1'  => 'value1',
			    'key2'  => 'value2'
			)
		    ),
		),
		
	    )
	);
	
	new \Basepack\Core\Metabox( $test_meta );
        
        //add taxonomy
        $labels = array(
		'name'              => _x( 'Test taxonomy', 'taxonomy general name' ),
		'singular_name'     => _x( 'Test taxonomy', 'taxonomy singular name' ),
		'search_items'      => __( 'Search terms' ),
		'all_items'         => __( 'All terms' ),
		'parent_item'       => __( 'Parent Term' ),
		'parent_item_colon' => __( 'Parent Term:' ),
		'edit_item'         => __( 'Edit Term' ),
		'update_item'       => __( 'Update Term' ),
		'add_new_item'      => __( 'Add New Term' ),
		'new_item_name'     => __( 'New Term Name' ),
		'menu_name'         => __( 'Term' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'testtaxonomy' ),
	);

	register_taxonomy( 'test_taxonomy', array( 'test' ), $args );
        
        $test_tax_meta = array(
	    'name'      => 'test_tax_meta',
	    'title'     => 'Pola dodatkowe w taxonomii',
	    'tax'       => 'test_taxonomy',
	    'elements'  => array(
		array(
		    'type'	=> 'text',
		    'name'	=> 'text',
		    'params'	=> array(
			'label'	    => 'Text Label',
			'comment'   => 'Comment',
			'class'	    => 'large-text'
		    ),
		),
                array(
		    'type'	=> 'textarea',
		    'name'	=> 'textarea',
		    'params'	=> array(
			'label'	    => 'Textarea Label',
			'comment'   => 'Comment',
			'class'	    => 'large-text'
		    ),
		),
		array(
		    'type'	=> 'wysiwyg',
		    'name'	=> 'wysiwyg',
		    'params'	=> array(
			'label'	    => 'Wysiwyg Label',
			'comment'   => 'Comment',
			'class'	    => '',
			'options'   => array(
			    'tinymce'	=> true
			)
		    ),
		),
		array(
		    'type'	=> 'checkbox',
		    'name'	=> 'checkbox',
		    'params'	=> array(
			'label'	    => 'Checkbox Label',
			'comment'   => 'Comment',
			'class'	    => ''
		    ),
		),
		array(
		    'type'	=> 'image',
		    'name'	=> 'image',
		    'params'	=> array(
			'label'	    => 'Image Label',
			'comment'   => 'Comment',
			'class'	    => ''
		    ),
		),
		array(
		    'type'	=> 'attachment',
		    'name'	=> 'attachment',
		    'params'	=> array(
			'label'	    => 'Attachment Label',
			'comment'   => 'Comment',
			'class'	    => ''
		    ),
		),
		array(
		    'type'	=> 'select',
		    'name'	=> 'select',
		    'params'	=> array(
			'label'	=> 'Select Label',
			'comment'   => 'Comment',
			'class'	    => '',
			'options'   => array(
			    'key1'  => 'value1',
			    'key2'  => 'value2'
			)
		    ),
		),
		array(
		    'type'	=> 'repeatable',
		    'name'	=> 'repeatable',
		    'params'	=> array(
			'label'	=> 'Repeatable Label',
			'comment'   => 'Comment',
			'class'	    => '',
			'repeater'  => array(
			    array(
				'type'	=> 'text',
				'name'	=> 'repeatable_text',
				'params'=> array(
				    'label'	=> 'Repeatable Text Label',
				    'comment'   => 'Comment',
				    'class'	=> 'large-text'
				)
			    )
			)
		    )
		)
            )
        );
        
        new \Basepack\Core\Taxmeta( $test_tax_meta );




//shortcode_ui_register_for_shortcode( 'xno-attributes', array(
//		'label'        => 'xhortcake With No Attributes',
//    'description' => 'ddd'
//		) );
//
//add_shortcode( 'bartag', array($this, 'bartag_func') );
add_action('media_buttons',  array($this ,'add_my_media_button'));


add_action( 'admin_footer-post-new.php',array( $this,'add_templates' ) );
add_action( 'admin_footer-post.php',array(  $this,  'add_templates' ) );

    }
//
public function add_templates() {
		include 'template-data.php';
		include 'edit-form.php';
	}


   public function add_my_media_button() {
       //dump(__METHOD__);
    //echo '<a href="#" id="modal" class="button">Modal</a>';

  ?>
<a href="<?php site_url() ?>/wp-admin/post.php?post=1&action=edit&TB_iframe=true&action=p#TB_inline" class="thickbox">Modal Me</a>



<a href="<?php site_url() ?>admin-ajax.php?post=1&action=pedit&TB_iframe=true" class="thickbox">ajax</a>


<?php


}

    	public function bartag_func( $atts ) {
    $a = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts );

    return "foo = {$a['foo']}";
}



public function ajax_edit(){
    add_action('wp_ajax_pedit', array($this, 'post_edit'));
    add_action('wp_ajax_nopriv_pedit', array($this, 'post_edit'));
}

public function post_edit(){
    
    ?>

<html <?php language_attributes(); ?> class="no-js">
<head>



<?php

//wp_enqueue_script('editor');

print_head_scripts();
print_admin_styles();
do_action( 'admin_head' );
?>
    </head>

<body>
<?php wp_editor('sss', 'ddd'); ?>

    <?php print_footer_scripts(); ?>

</body>
</html>
	<?php
    die();
}


}