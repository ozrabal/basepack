<?php

/**
 *
 * @param type $var
 * @param BOOL $echo
 */
function dump( $var, $echo = 1 ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG == TRUE ) {
        $output =  '<pre>' . print_r( $var, true ) . '</pre>';
    }
    if ( $output && $echo ) {
        echo $output;
    }
}

//define('WP_DEBUG_LOG', true);
//@todo linia i nazwa pliku
function dlog($message) {
    //if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    //}
}


function dbug($message){
    if (WP_DEBUG === true) {
        
        dump($message);
    }
    dlog($message);
}