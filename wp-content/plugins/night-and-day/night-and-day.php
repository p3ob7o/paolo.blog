<?php
/**
 * Plugin Name: Night & Day
 * Plugin URI: https://yourwebsite.com/night-and-day
 * Description: This is a WordPress plugin that creates a block allowing users to toggle between two global styles.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin directory for easier referencing.
define( 'NIGHT_AND_DAY_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Register block scripts and styles.
 */
function night_and_day_register_block() {
	// Register block editor script.
	wp_register_script(
		'night-and-day-editor-script',
		plugins_url( 'includes/block-editor-script.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element', 'wp-editor' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'includes/block-editor-script.js' )
	);

	// Register block script.
	wp_register_script(
		'night-and-day-block-script',
		plugins_url( 'includes/block-script.js', __FILE__ ),
		array( 'jquery' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'includes/block-script.js' )
	);

	// Register block style.
	wp_register_style(
		'night-and-day-block-style',
		plugins_url( 'includes/block-style.css', __FILE__ ),
		array(),
		filemtime( plugin_dir_path( __FILE__ ) . 'includes/block-style.css' )
	);

	// Register block.
	register_block_type( 'night-and-day/block', array(
		'editor_script' => 'night-and-day-editor-script',
		'script'        => 'night-and-day-block-script',
		'style'         => 'night-and-day-block-style',
	) );
}
add_action( 'init', 'night_and_day_register_block' );

/**
 * Include block registration file.
 */
require_once( NIGHT_AND_DAY_DIR . 'includes/block-registration.php' );
?>
