<?php
/**
 * Register block for Dark/Light Mode Toggle
 *
 * @package Dark/Light Mode Toggle
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register block
 */
function register_dark_light_mode_toggle_block() {
    register_block_type('darklight/dark-light-mode-toggle', [
        'attributes' => [
            'lightStyle' => [
                'type' => 'string',
                'default' => 'light-mode',
            ],
            'darkStyle' => [
                'type' => 'string',
                'default' => 'dark-mode',
            ],
        ],
        'render_callback' => 'render_dark_light_mode_toggle_block',
    ]);
}

// Hook block registration into 'init'
add_action('init', 'register_dark_light_mode_toggle_block');

/**
 * Render block
 */
function render_dark_light_mode_toggle_block($attributes) {
    // Get the selected styles
    $lightStyle = $attributes['lightStyle'];
    $darkStyle = $attributes['darkStyle'];

    // Output the block markup
    $output = '<button class="dark-light-mode-toggle" onclick="toggleStyles()">' . __('Toggle Mode') . '</button>';

    // Output the script to toggle the styles
    $output .= '
        <script>
            function toggleStyles() {
                var body = document.body;
                if (body.className === "' . $lightStyle . '") {
                    body.className = "' . $darkStyle . '";
                } else {
                    body.className = "' . $lightStyle . '";
                }
            }
        </script>
    ';

    return $output;
}
?>
