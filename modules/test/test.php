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
	    'post_type' => array( 'slide' ),
	    'elements'  => array(
		array(
		    'type'	=> 'text',
		    'name'	=> 'subtitle',
		    'params'	=> array(
			'label'	=> 'Tytuł',
			'comment'   => 'Tytuł slajdu wyświetlany nad jego treścią na stronie głównej',
			'class'	=> 'large-text'
		    ),
		),


	    )
	);
	new Metabox( $test_meta );

    }

}