<?php
/**
   * Color class
   *
   * @package    Basepack
   * @subpackage Core
   * @author     Piotr Łepkowski <piotr@webkowski.com>
   */
namespace Basepack\Core\Form;

class Color extends Formelement {
    protected $type = 'color';

    /**
     *
     * @param type $form
     * @param type $name
     */
    public function __construct( $form, $name ) {
	parent::__construct( $form, $name );
	$this->set_class( 'color-field' );
    }

    /**
     * ustawia predefiniowane kolory dla pickera
     * @todo teraz ostatni zdefiniowana paleta nadpisuje globalnie wszystkie, zmienic tak aby kazdy picker mogl miec osobna palete
     * @param array $palettes
     */
    public function set_palettes( $palettes ) {
	$this->palettes = $palettes;
    }

    /**
     * dolacza skrypty js
     */
    public function enqueue_scripts() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'field-color',  BASEPACK_PLUGIN_URL . 'core/form/field-color.js', array( 'jquery', 'wp-color-picker' ), BASEPACK_VERSION );
	if(!empty($this->palettes)){
            wp_localize_script( 'wp-color-picker', 'palettes', json_encode( $this->palettes ) );
        }
        
    }

    /**
     * renderuje pole color
     * @return string
     */
    public function render() {
	
	$this->enqueue_scripts();
        parent::render();
        if( isset( $this->callback ) ) {
	    $this->do_callback( $this->callback );
	}
        return  $this->get_before() . $this->get_label() . '<input ' . $this->get_disabled() . $this->id() . $this->type() . $this->name() . $this->value() . $this->cssclass() . '/>' . $this->get_message() . $this->get_comment( '<p class="description">%s</p>' ) . $this->get_after();
    }
}