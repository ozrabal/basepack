<?php
/**
 * Use checkbox term selection for non-hierarchical taxonomies
 *
 * @author Hugh Lashbrooke
 * @link http://www.hughlashbrooke.com/wordpress-use-checkbox-term-selection-for-non-hierarchical-taxonomies/
 *
 * use: new \Basepack\Library\Tagchecklist( $taxonomy, $post_type );
 */

namespace Basepack\Library;
class Tagchecklist {

    private $taxonomy;
    private $post_type;

	function __construct( $taxonomy, $post_type ) {
		$this->taxonomy = $taxonomy;
		$this->post_type = $post_type;

		// Remove default taxonomy meta box
		add_action( 'admin_menu', array( $this, 'remove_meta_box' ) );

		// Add new meta box
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

		// Handle AJAX call for adding new term
		add_action( 'wp_ajax_add-' . $this->taxonomy , '_wp_ajax_add_non_hierarchical_term' );

	}

	/**
	 * Remove default meta box
	 * @return void
	 */
	public function remove_meta_box() {
		remove_meta_box('tagsdiv-' . $this->taxonomy, $this->post_type, 'normal');
	}

	/**
	 * Add new metabox
	 * @return void
	 */
	public function add_meta_box() {
		$tax = get_taxonomy( $this->taxonomy );
		add_meta_box( 'taglist-' . $this->taxonomy, $tax->labels->name, array( $this, 'metabox_content' ), $this->post_type, 'side', 'core' );
	}

	/**
	 * Generate metabox content
	 * @param  obj $post Post object
	 * @return void
	 */
	public function metabox_content( $post ) {
        $taxonomy = $this->taxonomy;
        $tax = get_taxonomy( $taxonomy );
		?>
		<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">

			<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
				<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
				<li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop"><?php _e( 'Most Used' ); ?></a></li>
			</ul>

			<div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
				<ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
					<?php $popular_ids = wp_popular_terms_checklist( $taxonomy ); ?>
				</ul>
			</div>

		    <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
		    	<input type="hidden" name="tax_input[<?php echo $taxonomy; ?>][]" value="0" />
				<?php
				//if( class_exists( '\Basepack\Library\Walkertagchecklist' ) ) {
					$walker = new \Basepack\Library\Walkertagchecklist();
				//}
				?>
		       <ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:<?php echo $taxonomy; ?>" class="categorychecklist form-no-clear">
					<?php wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids , 'walker' => $walker ) ) ?>
				</ul>
		   </div>
			<?php if ( current_user_can($tax->cap->edit_terms) ) : ?>
				<div id="<?php echo $taxonomy; ?>-adder" class="wp-hidden-children">
					<h4>
						<a id="<?php echo $taxonomy; ?>-add-toggle" href="#<?php echo $taxonomy; ?>-add" class="hide-if-no-js">
							<?php
								/* translators: %s: add new taxonomy label */
								printf( __( '+ %s' ), $tax->labels->add_new_item );
							?>
						</a>
					</h4>
					<p id="<?php echo $taxonomy; ?>-add" class="category-add wp-hidden-child">
						<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>"><?php echo $tax->labels->add_new_item; ?></label>
						<input type="text" name="new<?php echo $taxonomy; ?>" id="new<?php echo $taxonomy; ?>" class="form-required form-input-tip" value="<?php echo esc_attr( $tax->labels->new_item_name ); ?>" aria-required="true"/>
						<input type="button" id="<?php echo $taxonomy; ?>-add-submit" data-wp-lists="add:<?php echo $taxonomy ?>checklist:<?php echo $taxonomy ?>-add" class="button category-add-submit" value="<?php echo esc_attr( $tax->labels->add_new_item ); ?>" />
						<?php wp_nonce_field( 'add-'.$taxonomy, '_ajax_nonce-add-'.$taxonomy, false ); ?>
						<span id="<?php echo $taxonomy; ?>-ajax-response"></span>
					</p>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
	
	/**
	 * Mod of _wp_ajax_add_hierarchical_term to handle non-hierarchical taxonomies
	 * @return void
	 */
	function _wp_ajax_add_non_hierarchical_term() {
    	//$action = $_POST['action'];
	    $action = filter_input( INPUT_POST, 'action' ); //TODO: filter all input vars
		$taxonomy = get_taxonomy( substr( $action, 4 ) );
		check_ajax_referer( $action, '_ajax_nonce-add-' . $taxonomy->name );
		if ( !current_user_can( $taxonomy->cap->edit_terms ) )
			wp_die( -1 );
		$names = explode( ',', $_POST['new'.$taxonomy->name] );
		$parent = 0;
		if ( $taxonomy->name == 'category' )
			$post_category = isset( $_POST['post_category'] ) ? (array) $_POST['post_category'] : array();
		else
			$post_category = ( isset( $_POST['tax_input'] ) && isset( $_POST['tax_input'][$taxonomy->name] ) ) ? (array) $_POST['tax_input'][$taxonomy->name] : array();
		$checked_categories = array_map( 'absint', (array) $post_category );

		foreach ( $names as $tax_name ) {
			$tax_name = trim( $tax_name );
			$category_nicename = sanitize_title( $tax_name );
			if ( '' === $category_nicename )
				continue;
			if ( ! $cat_id = term_exists( $tax_name, $taxonomy->name, $parent ) )
				$cat_id = wp_insert_term( $tax_name, $taxonomy->name, array( 'parent' => $parent ) );
			if ( is_wp_error( $cat_id ) )
				continue;
			else if ( is_array( $cat_id ) )
				$cat_id = $cat_id['term_id'];
			$checked_categories[] = $cat_id;
			if ( $parent ) // Do these all at once in a second
				continue;
			$new_term = get_term( $cat_id, $taxonomy->name );
    		$data = "\n<li id='{$taxonomy->name}-{$cat_id}'>" . '<label class="selectit"><input value="' . $new_term->slug . '" type="checkbox" name="tax_input['.$taxonomy->name.'][]" id="in-'.$taxonomy->name.'-' . $new_term->term_id . '"' . checked( in_array( $new_term->term_id, $checked_categories ), true, false ) . ' /> ' . esc_html( apply_filters('the_category', $new_term->name )) . '</label>';
			$add = array(
				'what' => $taxonomy->name,
				'id' => $cat_id,
				'data' => str_replace( array("\n", "\t"), '', $data ),
				'position' => -1
			);
		}

		$x = new WP_Ajax_Response( $add );
		$x->send();
	}

}





