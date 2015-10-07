<?php

namespace Modules\Voting;


class Voting {

    /**
     *
     * @param \Basepack\Core\Autoloader $loader
     */
    public function __construct( \Basepack\Core\Autoloader $loader ) {
	if( !post_type_exists( 'candidate' ) ) {
	    $this->register_post_type();
	}
	$this->register_metaboxes();
	add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_scripts' ) );
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	add_action( 'welcome_panel', array( $this, 'setup_dashboard_panel' ) );
    }

    /**
     * setup post types
     */
    private function register_post_type(){
	
	
	    $candidate_labels = array(
		'name'               => __( 'Candidate', 'pwp' ),
		'singular_name'      => __( 'Candidate', 'pwp' ),
		'add_new'            => __( 'Add New', 'pwp' ),
		'add_new_item'       => __( 'Add New test', 'pwp' ),
		'edit_item'          => __( 'Edit candidate', 'pwp' ),
		'new_item'           => __( 'New cndidate', 'pwp' ),
		'all_items'          => __( 'All candidats', 'pwp' ),
		'view_item'          => __( 'View candidate', 'pwp' ),
		'search_items'       => __( 'Search candidates', 'pwp' ),
		'not_found'          => __( 'Not found candidates', 'pwp' ),
		'not_found_in_trash' => __( 'Not found candidates in Trash', 'pwp' ),
		'parent_item_colon'  => ':',
		'menu_name'          => __( 'Candidates', 'pwp' )
	    );

	    $candidate_args = array(
		'labels'             => $candidate_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'candidate' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor' )
	    );
	    register_post_type( 'candidate', $candidate_args );
	
    }

    /**
     * register additional fields
     */
    private function register_metaboxes() {

	$candidate_meta = array(
	    'name'      => 'candidate_meta',
	    'title'     => __( 'Total score', 'pwp' ),
	    'post_type' => array( 'candidate' ),
	    'elements'  => array(
		array(
		    'type'	=> 'text',
		    'name'	=> 'score',
		    'params'=> array(
		        'label'	    => __( 'Total', 'pwp' ),
		        'comment'   => __( 'The sum of collected points', 'pwp' ),
		        'class'	    => 'large-text'
		    )
		)
	    )
	);
	new \Basepack\Core\Metabox( $candidate_meta );
    }

    /**
     * enqueue scripts in backend
     */
    public function enqueue_backend_scripts() {
	wp_enqueue_script( 'd3', 'https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js', array( 'jquery' ), true, true );
	wp_enqueue_script( 'd3.voting.admin', BASEPACK_PLUGIN_URL . 'modules/voting/voting-backend.js', array( 'd3' ), true, true );
	wp_enqueue_style( 'd3.voting.admin', BASEPACK_PLUGIN_URL . 'modules/voting/voting-backend.css' );
    }

    /**
     * Creates a dashboard panel showing the results of voting
     */
    public function setup_dashboard_panel() {

	$candidates = get_posts( array( 'post_type' => 'candidate' ) );
	if( $candidates ) {
	    $html = '<div class="welcome-panel-content"><h3>' . __( 'Voting results', 'pwp' ) . '</h3>';
	    foreach( $candidates as $candidate ) {
		$names[] = $candidate->post_title;
		$scores[] = intval( get_post_meta( $candidate->ID, 'score', true ) );
	    }
	    $chart_data =  array( 'names' => $names, 'scores' => $scores );
	    wp_localize_script( 'd3.voting.admin', 'chart_data',$chart_data );
	    $html .= '<div id="voting-results"></div></div>';
	    echo $html;
	}
    }


}
