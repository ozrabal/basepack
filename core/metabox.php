<?php

/**
   * Metabox class
   * 
   * @package    Basepack
   * @subpackage Core
   * @author     Piotr Łepkowski <piotr@webkowski.com>
   */
namespace Basepack\Core;


class Metabox extends Form {
    private
	$callback,
	$post_type,
	$context,
	$priority
    ;
    
    /**
     * 
     * @param array $box
     * @return null
     */
    public function __construct( $box ) {

        if( !is_admin() ){
	    return;
	}
       
        parent::__construct( $box );
        //parent::set_params( $box );
        
        $this->config( $box );
        
        add_action( 'add_meta_boxes', array( $this, 'add_box' ) );

        if( !defined( 'DOING_AJAX' ) && filter_input( INPUT_POST, 'post_type' ) && in_array( filter_input( INPUT_POST, 'post_type' ), $box['post_type'] ) ) {
            add_action( 'save_post', array( $this, 'save' ) );
	    if( isset( $_SESSION['p_' . filter_input( INPUT_POST, 'post' )] ) ) {
		unset( $_SESSION['p_' . filter_input( INPUT_POST, 'post' )] );
	    }
	}
    }

    /**
     * ustawia parametry startowe
     * @param array $config
     */
    private function config( $config ) {
	$defaults = array(
	    'name'          => 'pwp_meta',
	    'title'         => __( 'Meta parameters', 'pwp' ),
	    'callback'      => 'render',
	    'post_type'     => 'post',
            'allow_posts'   => array(
                'rule'      => null,
                'params'    => null
            ),
	    'context'       => 'normal',
	    'priority'      => 'high',
	);
	
	foreach( $defaults as $param => $value ) {
	    if ( isset( $config[$param] ) ) {
                $this->{ 'set_' . $param }( $config[$param] );
	    } else {
		$this->{ 'set_' . $param }( $value );
	    }
	}
    }
    
    /**
     * ustawia typy postow lub id dozwolone dla metaboxu
     * @param type $allow_posts
     */
    public function set_allow_posts( $allow_posts ) {
        $this->allow_box = $allow_posts;
    }

    /**
     * ustawia funkcje renderujaca
     * @param string $callback
     */
    public function set_callback( $callback  = 'render' ) {
	$this->callback = sanitize_key( $callback );
    }
    
    /**
     * zwraca nazwe funkcji renderujacej
     * @return string
     */
    public function get_callback() {
	return $this->callback;
    }
    
    /**
     * ustawia typ postu dla metaboxu
     * @param string $post_type
     */
    public function set_post_type( $post_type ) {
	$this->post_type = $post_type;
    }
    
    /**
     * ustawia context
     * @param string $context
     */
    public function set_context( $context ) {
	$this->context = sanitize_key( $context );
    }
    
    /**
     * zwraca context
     * @return string
     */
    public function get_context() {
	return $this->context;
    }
    
    /**
     * ustawia priorytet metaboxu
     * @param int $priority
     */
    public function set_priority( $priority ) {
	$this->priority = $priority;
    }
    /**
     * zwraca priorytet boxu
     * @return int
     */
    public function get_priority() {
	return $this->priority;
    }

    /**
     * pobiera dane z post po przeslaniu formularza i filtruje
     * w zaleznosci czy to array (dla powtarzalnych) czy nie (dla zwyklych pol)
     * @param string $element_name
     * @return mixed
     */
    private function get_input_data( $element_name ) {
        if( filter_input( INPUT_POST, $element_name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY ) ) {
            return filter_input( INPUT_POST, $element_name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
        }
        if ( filter_input( INPUT_POST, $element_name ) ) {
            return filter_input( INPUT_POST, $element_name );
        }
        return false;
    }

    /**
     * zapisuje dane z metaboxu do meta postu
     * @global object $current_screen
     * @param int $post_id
     */
//    public function asave( $post_id ) {
//
//        global $current_screen;
//        foreach( $this->elements as $element ) {
//            $old = get_post_meta( $post_id, $element->get_name(), true );
//	    $save[$element->get_name()] = $this->get_input_data( $element->get_name() );
//            $_SESSION['p_'.$post_id][$element->get_name()] = $save[$element->get_name()];
//	    //dump($save);
//            if ( isset( $current_screen ) && $current_screen->action != 'add' && $element->get_validator() ) {
//                $error = $this->is_error( $element, $save );
//            }
//        }
//        if( !isset( $error ) ) {
//	    //echo $this->elements[$element];
//            if ( isset( $old ) &&  is_array( $old ) ) {
//                $meta_save = array_merge( $old, $save );
//            } else {
//                $meta_save = $save;
//	    }
//            foreach( $meta_save as $meta_name => $meta_value ) {
//                update_post_meta( $post_id,  $meta_name, $meta_value );
//            }
//        }
//    }

    /**
     * zapisuje dane z metaboxu do meta postu
     * @global object $current_screen
     * @param int $post_id
     */
    public function save( $post_id ) {

        global $current_screen;
        foreach( $this->elements as $element ) {

            $save[$element->get_name()] = $this->get_input_data( $element->get_name() );

            $_SESSION['p_'.$post_id][$element->get_name()] = $save[$element->get_name()];

            if ( isset( $current_screen ) && $current_screen->action != 'add' && $element->get_validator() ) {
                $error = $this->is_error( $element, $save );
            }
	    if( isset( $error ) ) {

		$old = get_post_meta( $post_id, $element->get_name(), true );

		if ( isset( $old ) &&  is_array( $old ) ) {
		    $meta_save[$element->get_name()] = array_merge( $save[$element->get_name()], $old );
		} else {
		    $meta_save[$element->get_name()] = $save[$element->get_name()];
		}
	    } else {

		$meta_save[$element->get_name()] = $save[$element->get_name()];
	    }
	    //$meta_save[$element->get_name()] = $element->prepare_save_data();
        }

	

        if( !isset( $error ) ) {
            foreach( $meta_save as $meta_name => $meta_value ) {
                update_post_meta( $post_id,  $meta_name, $meta_value );
            }
        }
    }

    /**
     * wykonuje walidacje i ustawia w sesji error jesli validacja nie poprawna
     * @param object $element
     * @param array $save
     * @return array
     */
    private function is_error( $element, $save ) {
        $error = $element->validate( $save[$element->get_name()], $element->get_validator() );
        if( $error ) {
            $_SESSION['metabox-error'][$this->get_name()][$element->get_name()]['message'] = array( 'error', $error );
            return $error;
        }
    }

    

    /*
     * add metabox to specified one or many post types
     */
    public function add_box() {

        if ( is_array( $this->post_type ) ) {
            foreach( $this->post_type as $post_type ) {
                $this->set_box( $post_type );
            }
        } else {
            $post_type = $this->post_type;
            $this->set_box($post_type);
        }
    }

    /**
     * dodaje metabox do strony edycji postu
     * @param string $post_type
     */
    private function set_box( $post_type ) {
        
        if ( isset( $_SESSION['metabox-error'][$this->get_name()] ) && !isset( $_SESSION['noticed'] ) ) {
	    add_action( 'admin_notices', array( $this, 'error_notice' ) );
            $_SESSION['noticed'] = true;
        }
        if ( $this->allow_box_add( $this->allow_box['rule'], $this->allow_box['params'] ) ) {
            add_meta_box( $this->name, $this->title, array( $this, $this->callback ), $post_type, $this->context, $this->priority, '' );
	}
    }
    
    /**
     * allow display metabox to specified post
     * @global type $current_screen
     * @param string $rule
     * @param array $params
     * @return boolean
     */
    private function allow_box_add( $rule, $params ) {
	
        global $current_screen;
        if ( $rule && isset( $current_screen ) && $current_screen->action != 'add' ) {
            return $this->{ 'allow_' . $rule }( $params );
        }
        return true;
    }
    
    /**
     * check specified rules allow metabox display in post edit screen
     * check if post id is in allowed set of ids
     * @global object $post
     * @param array $ids
     * @return boolean
     */
    private function allow_id( $ids ) {
        global $post;
        if ( in_array( $post->ID, $ids ) ) {
            return true;
        }
        return false;
    }
    
/**
* @todo sprawdzic takie cos
*/
private function allow_template( $template_name ){
    //dump(get_post_meta( 2, '_wp_page_template', true ));

    //global $post;
    //$id = $post->ID;
//    echo '<center>';
//    dump($id);
//    echo '</center>';
    global $post;
    if ( $template_name == get_post_meta( $post->ID, '_wp_page_template', true )){
        return false;
    }
    return true;
}

    /**
     * display error message
     */
    public function error_notice() {
        echo '<div class="error"><p>' . __( 'There were errors, not all parameters are saved.', 'pwp' ) . '</p></div>';
    }
    
    /**
     * renderuje element formularza i wypenia go wartosciami
     * @global object $post
     * @param object $element
     * @return string
     */
    private function render_element($element){
        global $post;
        if( isset($_SESSION['metabox-error'][$this->get_name()][$element->get_name()] ) ) {
            $element->set_class( 'pwp-error' );
            $element->set_message( $_SESSION['metabox-error'][$this->get_name()][$element->get_name()]['message'] );
        }
        if( isset($_SESSION['p_'.$post->ID][$element->name] ) ) {
            $element->set_value( $_SESSION['p_'.$post->ID][$element->name] );
        } else {
            $element->set_value( get_post_meta( $post->ID, $element->name, true ) );
        }
	$element->set_value( get_post_meta( $post->ID, $element->name, true ) );
        return '<tr ><td>' . $element->render() . '</tr></td>';
    }

    /**
     * renderuje metabox i wypelnia go danymi
     * @return boolean
     */
    public function render() {
	
        if( !empty( $this->elements ) ) {
            $this->body = '<table id="' . $this->get_name() . '" class="form-table pwp-metabox"><tbody>';
            foreach( $this->elements as $element ) {
                $this->body .= $this->render_element( $element );
            }
            $this->body .= '</tbody></table>';
            $this->print_form();
            unset($_SESSION['metabox-error'][$this->get_name()]);
            unset($_SESSION['noticed']);
        } else {
            dbug( 'Brak legalnych elementów w formularzu' );
            return false;
        }
    }
}