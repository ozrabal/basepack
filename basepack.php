<?php
/**
 * Plugin Name: basepack
 * Plugin URI: http://
 * Description: A brief description of the plugin.
 * Version: 1.0.0
 * Author: 
 * Author URI: http://webkowski.com
 * Text Domain: bpck
 * Domain Path: Optional. Plugin's relative directory path to .mo files. Example: /locale/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: A short license name. Example: GPL2
 */
defined( 'ABSPATH' ) or die();

define( 'BASEPACK_VERSION', '1.0.0');
define( 'BASEPACK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BASEPACK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
require 'core/_inc/functions.php';
require 'core/autoloader.php';

if( !session_id() ) {
	    session_start();
	}
//add_action( 'init', array( '\\Basepack\\Core\\Base', 'init' ), 2 );

//$base = \Basepack\Core\Base::init($loader);
add_action( 'plugins_loaded', function() {
    $loader = new Basepack\Core\Autoloader();
    $loader->register();
    $loader->addNamespace( 'Basepack\Core', BASEPACK_PLUGIN_DIR . 'core/' );
    $basepack = new Basepack\Core\Base($loader);
});

//add_action('basepack_pre_load_modules', 'd');
//function d(){
//    echo __FUNCTION__;
//}

      // register the base directories for the namespace prefix
      //$loader->addNamespace('Modules\Cookie', '/srv/www/wordpress-default/wp-content/plugins/basepack/modules/cookie/');


//
   
      
//new Modules\Cookie\Cookie();



