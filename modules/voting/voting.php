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
	if(is_admin()){
	    //add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_scripts' ) );
	    remove_action( 'welcome_panel', 'wp_welcome_panel' );
	    add_action( 'welcome_panel', array( $this, 'setup_dashboard_panel' ) );
	}
	//get_template_directory_uri() ."/js/voting-frontend.js
	add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
	add_action( 'enqueue_voting', array( $this, 'voting_buttons' ) );
	add_action( 'wp_ajax_vote', array( $this, 'vote' ) );
	add_action( 'wp_ajax_nopriv_vote', array( $this, 'vote' ) );
	add_action( 'wp_ajax_get_voting', array( $this, 'get_voting' ) );
	add_action( 'wp_ajax_nopriv_get_voting', array( $this, 'get_voting' ) );
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
		'supports'           => array( 'title', 'editor','custom-fields' )
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
		),
		
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
     * enqueue scripts in frontend
     */
    public function enqueue_frontend_scripts() {
	wp_enqueue_script( 'voting.frontend', BASEPACK_PLUGIN_URL . 'modules/voting/voting-frontend.js', array( 'jquery' ), true, true );
    }

    /**
     * Creates a dashboard panel showing the results of voting
     */
    public function setup_dashboard_panel() {
	$this->enqueue_backend_scripts();
	$args = array( 'post_type' => 'candidate' );
	$args = apply_filters( 'voting_get_candidates_dashboard', $args);
	$candidates = get_posts( $args );
	if( $candidates ) {
	    $html = '<div class="welcome-panel-content"><h3>' . __( 'Voting results', 'pwp' ) . '</h3>';
	    foreach( $candidates as $candidate ) {
		$data[] = array( $candidate->post_title, intval( get_post_meta( $candidate->ID, 'score', true ) ) );
	    }
	    wp_localize_script( 'd3.voting.admin', 'data', $data );
	    $html .= '<div id="chart"></div> </div>';
	    echo $html;
	}
    }

    /**
     * add voting buttons to sidebar in page theme
     */
    public function voting_buttons() {
	$candidates = get_posts( array( 'post_type' => 'candidate' ) );
	if( $candidates ) {
	    $html = '<div id="voting" class="panel">';
	    foreach ($candidates as $candidate){
		//$candidate->post_title;
		$html .= '<div class="candidate"><button data-id="' . $candidate->ID . '" class="btn btn-default ">głosuj na:  ' . $candidate->post_title . '</button>';
		$html .= '<div class="description>' . apply_filters( 'the_content', $candidate->post_content ) . '</div>'
			. '</div>';
	    }
	    $html .= '</div>';
	    echo $html;
	}
    }

    /**
     * get buttons for ajax
     */
    public function get_voting(){
	$action = filter_input( INPUT_POST, 'action' );
	if( $action == 'get_voting' ) {
	    $candidates = get_posts( array( 'post_type' => 'candidate' ) );
	    $i = 0;
	    foreach ( $candidates as $candidate ){
		$voting['buttons'][$i]['name'] = $candidate->post_title;
		$voting['buttons'][$i]['id'] = $candidate->ID;
		$voting['buttons'][$i]['score'] = get_post_meta( $candidate->ID, 'score', TRUE );
		$i++;
	    }
	    echo wp_json_encode( $voting );
	    die();
	}
    }

    /**
     * ajax voting
     */
    public function vote() {
	$action = filter_input( INPUT_POST, 'action' );
	$id = intval( filter_input( INPUT_POST, 'id' ) );
	$score = filter_input( INPUT_POST, 'score' );
	if( $action && $id && $score && $action == 'vote' ) {
	    $total_score = get_post_meta( $id, 'score', TRUE );
	    $total_score = $score + $total_score;
	    update_post_meta( $id, 'score', $total_score );
	    echo 'ok';
	    do_action( 'voting_post_update_score', $id, $total_score );
	    
	}
	die();
    }
}

/* hacks
if(function_exists('pll_default_language') && is_admin()){
    add_filter('voting_get_candidates_dashboard', 'pp');
    function pp($args){
	return array( 'post_type' => 'candidate', 'lang'=> pll_default_language() );
    }
}
add_action('voting_post_update_score', function($candidate_id, $total_score ) {
    $languages = pll_languages_list();
    foreach ( $languages as $l){
	$post_lang = pll_get_post($candidate_id, $l);
	if($post_lang != $candidate_id){
	    update_post_meta($post_lang, 'score', $total_score);
	}
    }
}, 1, 2 );

add_action('save_post_candidate', function( $post_id, $post ){
    if(filter_input(INPUT_POST, 'score')){
        $languages = pll_languages_list();
	foreach ( $languages as $l){
	    $post_lang = pll_get_post($post_id, $l);
	    //if($post_lang != $post_id){
		update_post_meta($post_lang, 'score', filter_input(INPUT_POST, 'score'));
	    //}
	}
    }
}, 10, 2 );
 */