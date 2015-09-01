<?php
/*
 * Gallery Name: Pokaz slajdów w pionie
 * Description: Tworzy z obrazów w galerii pokaz slajdów z nawigacją
 */

class Cyclevertical{

    private $params;
    private $defaults = array(
	'files' => array(
	    'scripts' => array( 'jquery.cycle2.js', 'jquery.cycle2.center.js' ,'jquery.cycle2.autoheight.min.js', 'jquery.cycle2.carousel.min.js')
	),
	'settings' => array(
	    'wrapper_class' => 'gallery-slideshow clearfix',
	    'item_class' => '',
	    'image_class' => 'img-responsive ',
	    'size' => 'thumbnail',
	    'timeout' => 100,
	    'pager' => true,
	    'prevnext' => true,
	    'image_caption' => true,
	    'fx'=>'fade',
	    'visible' => 2,
	    'auto_height' => 'scontainer',
	    'loader' => '"wait"'


	)
    );
    
    function __construct(Modules\Gallery\Gallery $gallery = null, Array $params = null ) {
	if($gallery instanceof Modules\Gallery\Gallery){
	    $gallery->include_files( $this->defaults['files']['scripts'] );
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
		'visible'	    => $this->params['visible'],
		'fx'		=> $this->params['fx'],
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
$pager = null;
	if($navigation){

	$pagers = '<div class="row text-center cycle-nav" id="slide-navi'.$this->selector.'">
                                <div class="col-xs-3 col-sm-4 text-left">
                                    <a id="prev'.$this->selector.'"><span class="glyphicon glyphicon-chevron-left pull-left"> </span> <span class="hidden-xs pull-left">'.__('Previous', 'pwp').'</span></a>
                                </div>
                                <div class="col-xs-6 col-sm-4 cycle-pager text-center">
                                </div>
                                <div class="col-xs-3 col-sm-4 text-right">
                                    <a id="next'.$this->selector.'"><span class="glyphicon glyphicon-chevron-right pull-right"> </span> <span class="hidden-xs pull-right">'.__('Next','pwp').'</span></a>
                                </div>
                            </div>';
	}
$prev_next = null;
if($prevnext){
    $prev_next = '<div class="row"><div id="prev'.$this->selector.'" class="col-sm-6 zcarousel-control aleft btn btn-primary">p</div>
            <div id="next'.$this->selector.'" class="col-sm-6 zcarousel-control aright btn btn-primary">n</div></div>';
}


	$output = '<div id="'.$this->selector.'" class="row cycle-slideshow clearfix vertical '.$this->params['wrapper_class'].'"
								data-cycle-fx='.$this->params['fx'].'
								data-cycle-carousel-visible='.$this->params['visible'].'
								data-cycle-loader='.$this->params['loader'].'
								data-cycle-timeout='.$timeout.'
								data-cycle-carousel-vertical=true
								data-cycle-pager="#slide-navi'.$this->selector.'"
								data-cycle-slides=".gallery-slide"
								zdata-cycle-auto-height="4:3"
								data-cycle-prev="#prev'.$this->selector.'"
                                        data-cycle-next="#next'.$this->selector.'"
					    
>';
	$i = 0;
	//$pager = '<div id="slide-navi'.$this->selector.'" class="gallery-slide-navi thumbnail-pager">';

	foreach ( $attachments as $id => $attachment ) {
		$img = wp_get_attachment_image_src($id, $size);
		$link = '<img src="'. $img[0] .'" alt="" class="'.$this->params['image_class'].'"/>';
		//$pager .= '<img src="'. $img[0] .'" alt="" />';
		$output .= '<div class="gallery-slide">'.$link.'</div>';
		
		if ( $this->params['image_caption'] && trim($attachment->post_excerpt) ) {
			$output .= "<div class='wp-caption-text gallery-caption'>
			" . wptexturize($attachment->post_excerpt) . "
			</div>";
		}
	}
	//$pager .= "</div>";
	//$output .= '</div> ';
	//$output .= $pager;
	//$output .= '<div id="slide-navi'.$this->selector.'" class="gallery-slide-navi"></div>';
	$output .= ''.$pager.'</div>'.$prev_next.' ';
	return $output;
    }
}