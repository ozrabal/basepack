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




<?php

//wp_enqueue_script('editor');
        iframe_header();
//print_head_scripts();
//print_admin_styles();
//do_action( 'admin_head' );
        $post = get_post(20);
        $post_type = 'post';
        //include_once 'wp-admin/edit-form-advanced.php';
      ?> 

<div class="wrap">
<h1><?php
echo esc_html( $title );
if ( isset( $post_new_file ) && current_user_can( $post_type_object->cap->create_posts ) )
	echo ' <a href="' . esc_url( admin_url( $post_new_file ) ) . '" class="page-title-action">' . esc_html( $post_type_object->labels->add_new ) . '</a>';
?></h1>
<?php if ( $notice ) : ?>
<div id="notice" class="notice notice-warning"><p id="has-newer-autosave"><?php echo $notice ?></p></div>
<?php endif; ?>
<?php if ( $message ) : ?>
<div id="message" class="updated notice notice-success is-dismissible"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<div id="lost-connection-notice" class="error hidden">
	<p><span class="spinner"></span> <?php _e( '<strong>Connection lost.</strong> Saving has been disabled until you&#8217;re reconnected.' ); ?>
	<span class="hide-if-no-sessionstorage"><?php _e( 'We&#8217;re backing up this post in your browser, just in case.' ); ?></span>
	</p>
</div>
<form name="post" action="post.php" method="post" id="post"<?php
/**
 * Fires inside the post editor form tag.
 *
 * @since 3.0.0
 *
 * @param WP_Post $post Post object.
 */
do_action( 'post_edit_form_tag', $post );

$referer = wp_get_referer();
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
<div id="post-body" class="metabox-holder columns-2">
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
<div class="inside">
<?php
$sample_permalink_html = $post_type_object->public ? get_sample_permalink_html($post->ID) : '';
$shortlink = wp_get_shortlink($post->ID, 'post');

if ( !empty( $shortlink ) && $shortlink !== $permalink && $permalink !== home_url('?page_id=' . $post->ID) )
    $sample_permalink_html .= '<input id="shortlink" type="hidden" value="' . esc_attr($shortlink) . '" /><a href="#" class="button button-small" onclick="prompt(&#39;URL:&#39;, jQuery(\'#shortlink\').val()); return false;">' . __('Get Shortlink') . '</a>';

if ( $post_type_object->public && ! ( 'pending' == get_post_status( $post ) && !current_user_can( $post_type_object->cap->publish_posts ) ) ) {
	$has_sample_permalink = $sample_permalink_html && 'auto-draft' != $post->post_status;
?>
	<div id="edit-slug-box" class="hide-if-no-js">
	<?php
		if ( $has_sample_permalink )
			echo $sample_permalink_html;
	?>
	</div>
<?php
}
?>
</div>
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


do_meta_boxes($post_type, 'side', $post);

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
</div><!-- /post-body -->
<br class="clear" />
</div><!-- /poststuff -->
</form>
</div>

?>


<form id="post" class="post-edit front-end-form" method="post" enctype="multipart/form-data">

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

</form>




    <?php
    
//do_action('edit_page_form');

iframe_footer();

//print_footer_scripts(); ?>


	<?php
    die();
}


}