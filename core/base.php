<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Basepack\Core;

class Base {
    static $instance = false;


    public function __construct() {
        echo __METHOD__;
    }
    
    public static function init() {

	if( ! self::$instance ) {
	    self::$instance = new Base();
	}
	return self::$instance;
    }


    public function load_modules(){
	
    }
}