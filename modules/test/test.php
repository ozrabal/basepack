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
<a href="<?php site_url() ?>/wp-admin/post.php?post=1&action=edit&TB_iframe=true&action=p#TB_inline" class="thickbox"></a>



<a href="<?php site_url() ?>admin-ajax.php?post=1&width=auto&action=pedit&TB_iframe=true" class="thickbox button">Thickbox ajax</a>


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

add_thickbox();
	wp_enqueue_media( array( 'post' => $post_ID ) );
    


wp_enqueue_script('editor');
        iframe_header();
//print_head_scripts();
//print_admin_styles();
//do_action( 'admin_head' );
	//global $post_type, $post_type_object, $post;
wp_enqueue_script('post');
        $post = get_post(20);
        $post_type = 'post';

	set_current_screen('post');

$is_IE = false;





if ( post_type_supports( $post_type, 'editor' ) && ! wp_is_mobile() &&
	 ! ( $is_IE && preg_match( '/MSIE [5678]/', $_SERVER['HTTP_USER_AGENT'] ) ) &&
	 apply_filters( 'wp_editor_expand', true, $post_type ) ) {

	wp_enqueue_script('editor-expand');
	$_content_editor_dfw = true;
	$_wp_editor_expand = ( get_user_setting( 'editor_expand', 'on' ) === 'on' );
}

if ( wp_is_mobile() )
	wp_enqueue_script( 'jquery-touch-punch' );





$post_type_object = get_post_type_object($post_type);

// All meta boxes should be defined and added before the first do_meta_boxes() call (or potentially during the do_meta_boxes action).
require_once( ABSPATH . 'wp-admin/includes/meta-boxes.php' );


$publish_callback_args = null;
//if ( post_type_supports($post_type, 'revisions') && 'auto-draft' != $post->post_status ) {
//	$revisions = wp_get_post_revisions( $post_ID );
//
//	// We should aim to show the revisions metabox only when there are revisions.
//	if ( count( $revisions ) > 1 ) {
//		reset( $revisions ); // Reset pointer for key()
//		$publish_callback_args = array( 'revisions_count' => count( $revisions ), 'revision_id' => key( $revisions ) );
//		add_meta_box('revisionsdiv', __('Revisions'), 'post_revisions_meta_box', null, 'normal', 'core');
//	}
//}

//if ( 'attachment' == $post_type ) {
//	wp_enqueue_script( 'image-edit' );
//	wp_enqueue_style( 'imgareaselect' );
//	add_meta_box( 'submitdiv', __('Save'), 'attachment_submit_meta_box', null, 'side', 'core' );
//	add_action( 'edit_form_after_title', 'edit_form_image_editor' );
//
//	if ( wp_attachment_is( 'audio', $post ) ) {
//		add_meta_box( 'attachment-id3', __( 'Metadata' ), 'attachment_id3_data_meta_box', null, 'normal', 'core' );
//	}
//} else {
//	add_meta_box( 'submitdiv', __( 'Publish' ), 'post_submit_meta_box', null, 'side', 'core', $publish_callback_args );
//}

//if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post_type, 'post-formats' ) )
//	add_meta_box( 'formatdiv', _x( 'Format', 'post format' ), 'post_format_meta_box', null, 'side', 'core' );

// all taxonomies
//foreach ( get_object_taxonomies( $post ) as $tax_name ) {
//	$taxonomy = get_taxonomy( $tax_name );
//	if ( ! $taxonomy->show_ui || false === $taxonomy->meta_box_cb )
//		continue;
//
//	$label = $taxonomy->labels->name;
//
//	if ( ! is_taxonomy_hierarchical( $tax_name ) )
//		$tax_meta_box_id = 'tagsdiv-' . $tax_name;
//	else
//		$tax_meta_box_id = $tax_name . 'div';
//
//	add_meta_box( $tax_meta_box_id, $label, $taxonomy->meta_box_cb, null, 'side', 'core', array( 'taxonomy' => $tax_name ) );
//}

//if ( post_type_supports($post_type, 'page-attributes') )
	//add_meta_box('pageparentdiv', 'page' == $post_type ? __('Page Attributes') : __('Attributes'), 'page_attributes_meta_box', null, 'side', 'core');

//if ( $thumbnail_support && current_user_can( 'upload_files' ) )
	//add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', null, 'side', 'low');

//if ( post_type_supports($post_type, 'excerpt') )
//	//add_meta_box('postexcerpt', __('Excerpt'), 'post_excerpt_meta_box', null, 'normal', 'core');
//
//if ( post_type_supports($post_type, 'trackbacks') )
//	//add_meta_box('trackbacksdiv', __('Send Trackbacks'), 'post_trackback_meta_box', null, 'normal', 'core');
//
//if ( post_type_supports($post_type, 'custom-fields') )
	//add_meta_box('postcustom', __('Custom Fields'), 'post_custom_meta_box', null, 'normal', 'core');

/**
 * Fires in the middle of built-in meta box registration.
 *
 * @since 2.1.0
 * @deprecated 3.7.0 Use 'add_meta_boxes' instead.
 *
 * @param WP_Post $post Post object.
 */
do_action( 'dbx_post_advanced', $post );

//if ( post_type_supports($post_type, 'comments') )
//	//add_meta_box('commentstatusdiv', __('Discussion'), 'post_comment_status_meta_box', null, 'normal', 'core');
//
//if ( ( 'publish' == get_post_status( $post ) || 'private' == get_post_status( $post ) ) && post_type_supports($post_type, 'comments') )
//	//add_meta_box('commentsdiv', __('Comments'), 'post_comment_meta_box', null, 'normal', 'core');
//
//if ( ! ( 'pending' == get_post_status( $post ) && ! current_user_can( $post_type_object->cap->publish_posts ) ) )
	//add_meta_box('slugdiv', __('Slug'), 'post_slug_meta_box', null, 'normal', 'core');
//
//if ( post_type_supports($post_type, 'author') ) {
//	if ( is_super_admin() || current_user_can( $post_type_object->cap->edit_others_posts ) )
//		add_meta_box('authordiv', __('Author'), 'post_author_meta_box', null, 'normal', 'core');
//}

/**
 * Fires after all built-in meta boxes have been added.
 *
 * @since 3.0.0
 *
 * @param string  $post_type Post type.
 * @param WP_Post $post      Post object.
 */
do_action( 'add_meta_boxes', $post_type, $post );

/**
 * Fires after all built-in meta boxes have been added, contextually for the given post type.
 *
 * The dynamic portion of the hook, `$post_type`, refers to the post type of the post.
 *
 * @since 3.0.0
 *
 * @param WP_Post $post Post object.
 */
do_action( 'add_meta_boxes_' . $post_type, $post );

/**
 * Fires after meta boxes have been added.
 *
 * Fires once for each of the default meta box contexts: normal, advanced, and side.
 *
 * @since 3.0.0
 *
 * @param string  $post_type Post type of the post.
 * @param string  $context   string  Meta box context.
 * @param WP_Post $post      Post object.
 */
//do_action( 'do_meta_boxes', $post_type, 'normal', $post );
/** This action is documented in wp-admin/edit-form-advanced.php */
do_action( 'do_meta_boxes', $post_type, 'advanced', $post );
/** This action is documented in wp-admin/edit-form-advanced.php */
//do_action( 'do_meta_boxes', $post_type, 'side', $post );

//add_screen_option('layout_columns', array('max' => 1, 'default' => 1) );
        //include_once 'wp-admin/edit-form-advanced.php';
      ?> 

<div class="wrap">


<form name="post" action="post.php" method="post" id="post"<?php
$post_ID = $post->ID;
$notice = false;
$form_extra = '';
if ( 'auto-draft' == $post->post_status ) {
	if ( 'edit' == $action )
		$post->post_title = '';
	$autosave = false;
	$form_extra .= "<input type='hidden' id='auto_draft' name='auto_draft' value='1' />";
} else {
	$autosave = wp_get_post_autosave( $post->ID );
}

$form_action = 'editpost';
$nonce_action = 'update-post_' . $post->ID;

$referer = wp_get_referer();
$nonce_action = 'update-post_' . $post->ID;



$form_extra .= "<input type='hidden' id='post_ID' name='post_ID' value='" . esc_attr($post->ID) . "' />";


?>>
<?php wp_nonce_field($nonce_action); ?>
<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />
<input type="hidden" id="hiddenaction" name="action" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="originalaction" name="originalaction" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="post_author" name="post_author" value="<?php echo esc_attr( $post->post_author ); ?>" />
<input type="hidden" id="post_type" name="post_type" value="<?php echo esc_attr( $post_type ) ?>" />
<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo esc_attr( $post->post_status) ?>" />
<input type="hidden" id="referredby" name="referredby" value="<?php echo $referer ? esc_url( $referer ) : ''; ?>" />
<?php if ( ! empty( $active_post_lock ) ) { ?>
<input type="hidden" id="active_post_lock" value="<?php echo esc_attr( implode( ':', $active_post_lock ) ); ?>" />
<?php
}
if ( 'draft' != get_post_status( $post ) )
	wp_original_referer_field(true, 'previous');


echo $form_extra;

wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
?>

<?php
/**
 * Fires at the beginning of the edit form.
 *
 * At this point, the required hidden fields and nonces have already been output.
 *
 * @since 3.7.0
 *
 * @param WP_Post $post Post object.
 */
do_action( 'edit_form_top', $post ); ?>

<div id="poststuff">
<div id="post-body" class="metabox-holder columns-1">
<div id="post-body-content">

<?php if ( post_type_supports($post_type, 'title') ) { ?>
<div id="titlediv">
<div id="titlewrap">
	<?php
	/**
	 * Filter the title field placeholder text.
	 *
	 * @since 3.1.0
	 *
	 * @param string  $text Placeholder text. Default 'Enter title here'.
	 * @param WP_Post $post Post object.
	 */
	$title_placeholder = apply_filters( 'enter_title_here', __( 'Enter title here' ), $post );
	?>
	<label class="screen-reader-text" id="title-prompt-text" for="title"><?php echo $title_placeholder; ?></label>
	<input type="text" name="post_title" size="30" value="<?php echo esc_attr( $post->post_title ); ?>" id="title" spellcheck="true" autocomplete="off" />
</div>
<?php
/**
 * Fires before the permalink field in the edit form.
 *
 * @since 4.1.0
 *
 * @param WP_Post $post Post object.
 */
do_action( 'edit_form_before_permalink', $post );
?>
<!--<div class="inside">
//<?php
//$permalink = get_permalink( $post_ID );
//if ( ! $permalink ) {
//	$permalink = '';
//}
//$post_type_object = get_post_type_object($post_type);
//
//$sample_permalink_html = $post_type_object->public ? get_sample_permalink_html($post->ID) : '';
//$shortlink = wp_get_shortlink($post->ID, 'post');
//
//if ( !empty( $shortlink ) && $shortlink !== $permalink && $permalink !== home_url('?page_id=' . $post->ID) )
//    $sample_permalink_html .= '<input id="shortlink" type="hidden" value="' . esc_attr($shortlink) . '" /><a href="#" class="button button-small" onclick="prompt(&#39;URL:&#39;, jQuery(\'#shortlink\').val()); return false;">' . __('Get Shortlink') . '</a>';
//
//if ( $post_type_object->public && ! ( 'pending' == get_post_status( $post ) && !current_user_can( $post_type_object->cap->publish_posts ) ) ) {
//	$has_sample_permalink = $sample_permalink_html && 'auto-draft' != $post->post_status;
//?>
	<div id="edit-slug-box" class="hide-if-no-js">
	//<?php
//		if ( $has_sample_permalink )
//			echo $sample_permalink_html;
//	?>
	</div>
//<?php
//}
?>
</div>-->
<?php
wp_nonce_field( 'samplepermalink', 'samplepermalinknonce', false );
?>
</div><!-- /titlediv -->
<?php
}
/**
 * Fires after the title field.
 *
 * @since 3.5.0
 *
 * @param WP_Post $post Post object.
 */
do_action( 'edit_form_after_title', $post );

if ( post_type_supports($post_type, 'editor') ) {
?>
<div id="postdivrich" class="postarea<?php if ( $_wp_editor_expand ) { echo ' wp-editor-expand'; } ?>">

<?php wp_editor( $post->post_content, 'content', array(
	'_content_editor_dfw' => $_content_editor_dfw,
	'drag_drop_upload' => true,
	'tabfocus_elements' => 'content-html,save-post',
	'editor_height' => 300,
	'tinymce' => array(
		'resize' => false,
		'wp_autoresize_on' => $_wp_editor_expand,
		'add_unload_trigger' => false,
	),
) ); ?>
<table id="post-status-info"><tbody><tr>
	<td id="wp-word-count"><?php printf( __( 'Word count: %s' ), '<span class="word-count">0</span>' ); ?></td>
	<td class="autosave-info">
	<span class="autosave-message">&nbsp;</span>
<?php
	if ( 'auto-draft' != $post->post_status ) {
		echo '<span id="last-edit">';
		if ( $last_user = get_userdata( get_post_meta( $post_ID, '_edit_last', true ) ) ) {
			printf(__('Last edited by %1$s on %2$s at %3$s'), esc_html( $last_user->display_name ), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		} else {
			printf(__('Last edited on %1$s at %2$s'), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		}
		echo '</span>';
	} ?>
	</td>
	<td id="content-resize-handle" class="hide-if-no-js"><br /></td>
</tr></tbody></table>

</div>
<?php }
/**
 * Fires after the content editor.
 *
 * @since 3.5.0
 *
 * @param WP_Post $post Post object.
 */
do_action( 'edit_form_after_editor', $post );
?>
</div><!-- /post-body-content -->

<div id="postbox-container-1" class="postbox-container">
<?php
	//post_submit_meta_box($post);
if ( 'page' == $post_type ) {
	/**
	 * Fires before meta boxes with 'side' context are output for the 'page' post type.
	 *
	 * The submitpage box is a meta box with 'side' context, so this hook fires just before it is output.
	 *
	 * @since 2.5.0
	 *
	 * @param WP_Post $post Post object.
	 */
	do_action( 'submitpage_box', $post );
}
else {
	/**
	 * Fires before meta boxes with 'side' context are output for all post types other than 'page'.
	 *
	 * The submitpost box is a meta box with 'side' context, so this hook fires just before it is output.
	 *
	 * @since 2.5.0
	 *
	 * @param WP_Post $post Post object.
	 */
	do_action( 'submitpost_box', $post );
}


//do_meta_boxes($post_type, 'side', $post);

?>
</div>
<div id="postbox-container-2" class="postbox-container">
<?php

do_meta_boxes(null, 'normal', $post);

if ( 'page' == $post_type ) {
	/**
	 * Fires after 'normal' context meta boxes have been output for the 'page' post type.
	 *
	 * @since 1.5.0
	 *
	 * @param WP_Post $post Post object.
	 */
	do_action( 'edit_page_form', $post );
}
else {
	/**
	 * Fires after 'normal' context meta boxes have been output for all post types other than 'page'.
	 *
	 * @since 1.5.0
	 *
	 * @param WP_Post $post Post object.
	 */
	do_action( 'edit_form_advanced', $post );
}


do_meta_boxes(null, 'advanced', $post);

?>
</div>
<?php
/**
 * Fires after all meta box sections have been output, before the closing #post-body div.
 *
 * @since 2.1.0
 *
 * @param WP_Post $post Post object.
 */
do_action( 'dbx_post_sidebar', $post );

?>

<?php submit_button( __( 'Save' ), 'button', 'save' ); ?>

</div><!-- /post-body -->
<br class="clear" />
</div><!-- /poststuff -->
</form>
</div>




<!--<form id="post" class="post-edit front-end-form" method="post" enctype="multipart/form-data">

    <input type="hidden" name="post_id" value="<?php the_ID(); ?>" />
    <?php wp_nonce_field( 'update_post_'. get_the_ID(), 'update_post_nonce' ); ?>

    <p><label for="post_title">Title</label>
    <input type="text" id="post_title" name="post_title" value="<?php echo $post->post_title; ?>" /></p>

    <p><?php wp_editor( $post->post_content, 'postcontent' ); ?></p>

    <p><label for="post_title">Test</label>
    <?php $value = get_post_meta(get_the_ID(), 'edit_test', true); ?>
    <input type="text" id="edit_test" name="edit_test" value="<?php echo $value; ?>" /></p>

    <p><label for="post_title">Test 2</label>
    <?php $value = get_post_meta(get_the_ID(), 'edit_test2', true); ?>
    <input type="text" id="edit_test2" name="edit_test2" value="<?php echo $value; ?>" /></p>

    <input type="submit" id="submit" value="Update" />

</form>-->




    <?php
    
//do_action('edit_page_form');

iframe_footer();

//print_footer_scripts(); ?>


	<?php
    die();
}


}