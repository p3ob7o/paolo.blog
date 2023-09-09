<?php
/**
 * Plugin Name: Dark/Light Mode Toggle
 * Description: This is a Gutenberg block that allows you to toggle between two different global styles, offering a light and a dark mode on your website.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue block editor JavaScript and CSS
 */
function enqueue_block_editor_assets() {
    // Make paths variables so we don't write em twice ;)
    $blockPath = '/src/block/block.js';
    $editorStylePath = '/src/block/editor.css';

    // Enqueue the bundled block JS file
    wp_enqueue_script(
        'dark-light-mode-toggle-block-js',
        plugins_url($blockPath, __FILE__),
        ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
        filemtime(plugin_dir_path(__FILE__) . $blockPath)
    );

    // Enqueue optional editor only styles
    wp_enqueue_style(
        'dark-light-mode-toggle-block-editor-css',
        plugins_url($editorStylePath, __FILE__),
        ['wp-edit-blocks'],
        filemtime(plugin_dir_path(__FILE__) . $editorStylePath)
    );
}

// Hook scripts function into block editor hook
add_action('enqueue_block_editor_assets', 'enqueue_block_editor_assets');

/**
 * Enqueue view scripts
 */
function enqueue_block_scripts() {
    $stylePath = '/src/block/style.css';

    wp_enqueue_style(
        'dark-light-mode-toggle-block-css',
        plugins_url($stylePath, __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . $stylePath)
    );
}

// Hook scripts function into frontend hook
add_action('enqueue_block_assets', 'enqueue_block_scripts');

/**
 * Register block
 */
function register_block() {
    register_block_type('darklight/dark-light-mode-toggle', [
        'render_callback' => 'render_block',
    ]);
}

// Hook block registration into 'init'
add_action('init', 'register_block');

/**
 * Render block
 */
function render_block($attributes) {
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
