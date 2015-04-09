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

define( 'BASEPACK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require 'core/base-autoloader.php';

$loader = new Core\Autoloader();
$loader->register();
$loader->addNamespace( 'Basepack\Core', BASEPACK_PLUGIN_DIR . 'core/' );


add_action( 'init', array( '\\Basepack\\Core\\Base', 'init' ), 2 );
add_action( 'plugins_loaded', array( '\\Basepack\\Core\\Base', 'load_modules' ), 100 );


//new \Basepack\Core\Base();
     
     
      // register the base directories for the namespace prefix
      $loader->addNamespace('Modules\Cookie', '/srv/www/wordpress-default/wp-content/plugins/basepack/modules/cookie/');


//
   
      
new Modules\Cookie\Cookie();



