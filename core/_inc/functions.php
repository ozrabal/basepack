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