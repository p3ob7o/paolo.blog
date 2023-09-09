<?php
/**
 * File: block-registration.php
 * Registers the custom block for the Night & Day plugin.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the 'night-and-day/block' block on server.
 */
if ( ! function_exists( 'night_and_day_register_block' ) ) {
	function night_and_day_register_block() {

		// Check if the register function exists.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		// Attributes for the block.
		$attributes = array(
			'styleOne' => array(
				'type' => 'string',
				'default' => 'night',
			),
			'styleTwo' => array(
				'type' => 'string',
				'default' => 'day',
			),
		);

		// Register the block.
		register_block_type(
			'night-and-day/block',
			array(
				'attributes'      => $attributes,
				'render_callback' => 'night_and_day_render_block',
			)
		);
	}
	add_action( 'init', 'night_and_day_register_block' );
}

/**
 * Renders the `night-and-day/block` block on server.
 */
if ( ! function_exists( 'night_and_day_render_block' ) ) {
	function night_and_day_render_block( $attributes ) {

		// Get the selected styles.
		$style_one = $attributes['styleOne'];
		$style_two = $attributes['styleTwo'];

		// Create the button.
		$button = '<button class="night-and-day-toggle" data-style-one="' . esc_attr( $style_one ) . '" data-style-two="' . esc_attr( $style_two ) . '">Toggle Styles</button>';

		// Return the button.
		return $button;
	}
}
?>
