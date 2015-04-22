<?php
/**
   * Image class
   *
   * @package    Backpack
   * @subpackage Core
   * @author     Piotr Łepkowski <piotr@webkowski.com>
   */
namespace Basepack\Core\Form;

class Image extends Formelement {
    private $type = 'image';

    /**
     * dolacza skrypty js
     */
    public function enqueue_scripts() {
        wp_enqueue_script( 'field-image',  plugins_url( '/field-image.js', __FILE__ ), array( 'jquery' ), BASEPACK_VERSION );
    }

    /**
     * pobiera sciezke miniatury na podstawie id obiektu
     * @param Int $id
     * @return String
     */
    private function get_thumbnail( $id = null ) {

	if( $id ) {
	    $current_img = wp_get_attachment_image_src( intval( $id ), 'thumbnail' );
	    if( $current_img ) {
                return $current_img[0];
            }
            if( has_post_thumbnail() ) {
                return $this->get_post_thumbnail_url( get_the_ID() );
                /*
		$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
                if( $thumbnail_id ) {
                    $thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'thumbnail' );
                    return $thumbnail[0];
                }
                */
            }
        }
        return BASEPACK_PLUGIN_URL . '/assets/images/image.png';
    }
    
    /**
     * pobiera url miniaturki
     * @param int $id
     * @return string
     */
    private function get_post_thumbnail_url( $post_id ){
        $thumbnail_id = get_post_thumbnail_id( intval( $post_id ) );
        if( $thumbnail_id ) {
            $thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'thumbnail' );
            return $thumbnail[0];
        }
    }
    
    /**
     * renderuje pole obrazek
     * @return String
     */
    public function render() {

//	add_action( 'setup_theme', array( $this, 'enqueue_scripts' ) );
	$this->enqueue_scripts();
        parent::render();
        wp_enqueue_media();
	$this->set_class( 'field-box' );
        $body =  $this->get_before() . $this->get_label();
        $body .= '<div ' . $this->cssclass() . '>';
	$body .= '<a class="button button-secondary open-media-button" ' . $this->get_data() . ' id="open-media-modal' . $this->get_id() . '" ><span class="pwp-icon dashicons dashicons-admin-media"></span> ' . __( 'Add / Change image', 'pwp' ) . '</a>';
        $body .= '<a class="button button-secondary remove-media-button" id="remove-media' . $this->get_id() . '" ><span class="pwp-icon dashicons dashicons-dismiss"></span> ' . __( 'Remove image', 'pwp' ) . '</a>';
	$body .= '<div id="m_open-media-modal' . mt_rand() . $this->get_id() . '" class="attachment-fieldset open-media-modal' . $this->get_id() . '">';
        $body .= '<input type="hidden" ' . $this->set_id( 'attachment-id' )->id() . $this->name() . $this->value() . '>';
	$body .= '<div class="attachment-preview type-image"><div class="thumbnail"><div class="centered"><img class="slide-image" id="attachment-src" data-src-default="' . $this->get_thumbnail() . '" src="' . $this->get_thumbnail( $this->get_value() ) . '" />';
	$body .= '</div></div></div></div>';
        $body .= $this->get_message();
        $body .= '</div>';
        $body .= $this->get_comment( '<p class="description">%s</p>' );
        $body .= $this->get_after();
        return $body;
    }
}