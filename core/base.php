<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Basepack\Core;

class Base {
    static  $instance = false;
    private $loader;
    public  $name, $modules;

    /**
     *
     * @param \Basepack\Core\Autoloader $loader
     */
    public function __construct( Autoloader $loader ) {
	
	$this->loader = $loader;
	add_action( 'admin_init', function() {
	    wp_enqueue_style( 'basepack', BASEPACK_PLUGIN_URL . 'assets/css/basepack.css' );    
	} );
	add_action( 'init', function() {
	    do_action( 'basepack_pre_load_modules' );
	    $this->load_modules();
	    do_action( 'basepack_post_load_modules' );
	} );
    }

    /**
     *
     * @param Autoloader $loader
     * @return Base
     */
//    public static function init($loader) {
//	if( ! self::$instance ) {
//	    self::$instance = new Base($loader);
//	}
//	return self::$instance;
//    }

    private function get_modules() {
	if( is_dir( BASEPACK_PLUGIN_DIR . '/modules' ) ) {
	    $modules = array_diff( scandir( BASEPACK_PLUGIN_DIR . '/modules' ), array( '..', '.', '.DS_Store', 'index.php' ) );
	}
	if (!empty( $modules ) ){
	    return $modules;
	}
    }

    //moduly rozpoczynajace sie od _ sa nieaktywne
    /**
     * 
     * @param array $modules
     * @return boolean|array
     */
    private function get_active_modules( Array $modules ) {
	if( empty( $modules ) ){
	    return false;
	}
	foreach( $modules as $module ) {
	    if( substr( $module, 0, 1 ) != '_' ) {
		$active_modules[] = $module;
	    }
	}
	if( !empty( $active_modules ) ) {
	    return $active_modules;
	}
    }

    /**
     * 
     * @param string $module_name
     * @return array
     */
    private function setup_module( $module_name ) {
	return array(
	    'name'	=> $module_name,
	    'namespace'	=> 'Modules\\' . ucfirst( $module_name ),
	    'path'	=> BASEPACK_PLUGIN_DIR . 'modules/' . $module_name
	);
    }
    
    /**
     * 
     * @param array $module
     */
    public function load_module( Array $module ) {
	 $this->loader->addNamespace( $module['namespace'], $module['path'] );
            //require_once BASEPACK_PLUGIN_DIR . '/modules/' . $module['name']. '/module_' . $module['name'] . '.php';
	    //do_action( 'pwp_init_' . $module['name'], array( $this->loader ) );
         
         $m = $module['namespace'] . '\\' . ucfirst( $module['name'] );
	    $this->modules[$module['name']] = new $m( $this->loader );
            
            
            
    }

    public function load_modules() {
        $modules = $this->get_active_modules( $this->get_modules() );
	foreach( $modules as $module_name ) {
	    $module = $this->setup_module( $module_name );
            $this->load_module( $module );
	   
	//$this->loader->addNamespace('Modules\Cookie', '/srv/www/wordpress-default/wp-content/plugins/basepack/modules/cookie/');
	//$this->modules['cookie'] = new \Modules\Cookie\Cookie();
//dump($this);
	}
    }
}