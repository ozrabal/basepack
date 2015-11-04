<?php
/*
 * Gallery Name: Kafelki z podpisem
 * Description: Dwie kolumny zdjęć z podpisami zarząd)
 */

class Tileswithcaptions{

    private $params;
    private $defaults = array(
	'files' => array(
	    
	),
	'settings' => array(
	    'wrapper_class' => 'gallery-slideshow col-md-12 clearfix',
	    'item_class' => '',
	    'image_class' => 'img-responsive ',
	    'size' => 'slide-large',
	    'timeout' => 0,
	    'pager' => true,
	    'prevnext' => true,
	    'image_caption' => true,
	    'fx'=>'fade',
	    'auto_height' => 'container',
	    'loader' => '"wait"'


	)
    );

    function __construct(Modules\Gallery\Gallery $gallery = null, Array $params = null ) {
	if($gallery instanceof Modules\Gallery\Gallery){
	    //$gallery->include_files( $this->defaults['files']['scripts'] );
	    $this->setup($gallery->params);
	    $gallery->output = $this->create_gallery();
	}
    }

     public function setup($params){
	$this->params = array_merge( $this->defaults['settings'], $params );
    }

    function create_gallery() {
	$attr =  $this->params;
	$post = get_post();
	$this->instance = 0;
	$this->instance = uniqid();
	if ( ! empty( $attr['ids'] ) ) {
	    if ( empty( $attr['orderby'] ) )
		$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	    }
	$output = apply_filters('post_gallery', '', $attr);
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'columns'    => 1,
		'size'       => $this->params['size'],
		'include'    => '',
		'exclude'    => '',
		'timeout'   => $this->params['timeout'],
		'navigation'   => $this->params['pager'],
	    'prevnext'	=>  $this->params['prevnext'],
	    'loader' =>$this->params['loader']
	), $attr));


	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
		$img = wp_get_attachment_image_src($att_id, $size);

			$output .= '<img src="'. $img[0] .'" alt="" />\n';
		return $output;
	}
	$this->selector = "gallery-{$this->instance}";
	//if ( apply_filters( 'use_default_gallery_style', true ) )




	$output = '';
	$i = 0;
	//$pager = '<div id="slide-navi'.$this->selector.'" class="gallery-slide-navi thumbnail-pager">';
$lr = 'fl';
	foreach ( $attachments as $id => $attachment ) {
		$img = wp_get_attachment_image_src($id, $size);
		$link = '<img src="'. $img[0] .'" alt="" />';
		//$pager .= '<img src="'. $img[0] .'" alt="" />';
		$output .= '<figure class="'.$lr.'">'.$link.'';

		//if ( $this->params['image_caption'] && trim($attachment->post_excerpt) ) {
			$output .= "<figcaption>
			<p>" . wptexturize($attachment->post_excerpt) . "</p>
			</figcaption>";
		//}

		$output .= '</figure>';

		if($lr == 'fl'){
		    $lr = 'fr';
		}else{
		    $lr = 'fl';
		}

	}

	$output .= '';
	return '<section class="bg">'.$output.'</section>';
    }
}