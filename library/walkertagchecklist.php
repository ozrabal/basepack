<?php
/**
 * Use checkbox term selection for non-hierarchical taxonomies
 *
 * @author Hugh Lashbrooke
 * @link http://www.hughlashbrooke.com/wordpress-use-checkbox-term-selection-for-non-hierarchical-taxonomies/
 * 
 * Mod of WP's Walker_Category_Checklist class
 */

namespace Basepack\Library;
use \Walker;

class Walkertagchecklist extends Walker {
	var $tree_type = 'tag';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $tax_term, $depth=0, $args=array(), $id = 0 ) {
		extract($args);
		if ( empty($taxonomy) )
			$taxonomy = 'tag';

		if ( $taxonomy == 'tag' )
			$name = 'post_tag';
		else
			$name = 'tax_input['.$taxonomy.']';

		$class = in_array( $tax_term->term_id, $popular_cats ) ? ' class="popular-category"' : '';
		$output .= "\n<li id='{$taxonomy}-{$tax_term->term_id}'$class>" . '<label class="selectit"><input value="' . $tax_term->slug . '" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $tax_term->term_id . '"' . checked( in_array( $tax_term->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $tax_term->name )) . '</label>';
	}

	function end_el( &$output, $tax_term, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}