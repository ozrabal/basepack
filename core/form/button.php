<?php
/**
   * Button class
   *
   * @package    Basepack
   * @subpackage Core
   * @author     Piotr Łepkowski <piotr@webkowski.com>
   */
namespace Basepack\Core\Form;

class Button extends Formelement {
    protected $type = 'button';

    /**
     * renderuje button
     * @return string
     */
    public function render() {
        
	return $this->get_before() . $this->get_label() . '<button ' . $this->type() . $this->cssclass() . $this->name() . $this->value() . '>' . $this->get_value() . '</button>' . $this->get_message() . $this->get_comment( '<p class="description">%s</p>' ) . $this->get_after();
    }
}