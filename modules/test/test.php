<?php

namespace Modules\Test;

class Test {

    public function __construct() {

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
	    'supports'           => array( 'title', 'thumbnail', 'editor', 'page-attributes' )
	);
	register_post_type( 'test', $test_args );

	$test_meta = array(
	    'name'      => 'test_meta',
	    'title'     => 'Pola dodatkowe',
	    'post_type' => array( 'test' ),
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
	
	new \Basepack\Core\Metabox( $test_meta );
    }

}