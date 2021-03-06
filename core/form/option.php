<?php
/**
   * Option class
   *
   * @package    PWP
   * @subpackage Core
   * @author     Piotr Łepkowski <piotr@webkowski.com>
   */
namespace Basepack\Core\Form;

class Option extends Formelement {
    protected $type = 'option', $select;

    /**
     * konstruktor
     * @param \Form $form
     * @param string $name
     * @param Formelement_Select $select
     */
    public function __construct( $form, $name, Select $select ) {
        
        parent::__construct( $form, $name );
        $this->select = $select;
    }

    /**
     * zwraca atrybut html selected
     * @return string
     */
    public function selected() {

        if( isset( $this->selected ) && $this->selected == true ) {
            return ' selected="selected" ';
        }
    }
    
    /**
     * renderuje pole option
     * @return string
     */
    public function render() {

        return '<option ' . $this->value() . $this->selected() . '>' . $this->get_name() . '</option>';
    }
}