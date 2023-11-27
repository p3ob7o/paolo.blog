<?php
/**
 * Plugin Name: Light/Dark Style Toggle
 * Description: Toggle between light and dark global styles.
 * Version: 1.0
 * Text Domain: light-dark-style-toggle
 * Author: Your Name
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function ldst_enqueue_scripts() {
    wp_enqueue_script( 'ldst-toggle-script', plugins_url( 'script.js', __FILE__ ), array('wp-element'), '1.0', true );
    wp_localize_script( 'ldst-toggle-script', 'ldst', array(
        'pluginUrl' => plugins_url( '', __FILE__ ),
    ));
}

function ldst_register_block() {
    wp_register_script( 'ldst-block', plugins_url( 'block.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ), '1.0', true );
    
    register_block_type( 'ldst/toggle-block', array(
        'editor_script' => 'ldst-block',
    ));
}

function ldst_load_textdomain() {
    load_plugin_textdomain( 'light-dark-style-toggle', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'init', 'ldst_load_textdomain' );
add_action( 'init', 'ldst_register_block' );
add_action( 'wp_enqueue_scripts', 'ldst_enqueue_scripts' );
?>
